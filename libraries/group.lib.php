<?php
/**
 * Functions required for Group creation page.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Generate Html for create group form.
 *
 * @return string $retval Html containing Create group form
 */
function HAA_getHtmlGroupForm()
{
    $retval = '';
    $retval .= '<form method="POST" action="group.php" class="gray_grad box group_form">'
        . '<input type="hidden" name="create_group" value="true">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<table id="password_table">'
        . '<caption>Create Group</caption>'
        . '<tr>'
        . '<td><label for="input_size">Number of members<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectGroupSize() . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>';

    return $retval;
}

/**
 * Generates Html for Group size select list.
 *
 * @return string $retval Html containing select list
 */
function HAA_getHtmlSelectGroupSize()
{
    $retval = '<select id="input_size" name="group_size" class="required"'
        . ' title="Please select the number of members in your Group">'
        . '<option>...</option>';
    for ($i=2;$i<=11;$i++) {
        $retval .= '<option>' . $i . '</option>';
    }
    $retval .= '</select>';

    return $retval;
}

/**
 * Parses received form data.
 *
 * @param array Array of variable-value pair.
 *
 * @return bool|array Returns array if everything fine else 'false'
 */
function HAA_parseFormData($form_data)
{
    // Array containing parsed form parameters.
    $form_params = array();
    // List of valid column names.
    $column_whitelist = array(
        'group_size'
        , 'password'
        , 'confirm_password'
        , 'roll_no'
        , 'unique_id'
    );

    // Name of corresponding fields.
    $fields = array(
        'group_size' => 'Group Size'
        , 'password' => 'Password'
        , 'confirm_password' => 'Confirm Password'
    );

    //List of fields to be validated for passwords.
    $password_fields = array(
        'password'
        , 'confirm_password'
    );

    //List of fields to be validated for integers only.
    $integers = array(
        'group_size'
        , 'roll_no'
        , 'unique_id'
    );

    //Validate and get the total number of students
    if (! HAA_validateValue($form_data["group_size"], 'integer')) {
        HAA_inValidField($fields["group_size"]);
    } else {
        $size = $form_data["group_size"];
    }

    //Check if the group size is valid
    if ($size<2 || $size>11) {
        HAA_gotError(
            'Invalid number of members.'
        );
        return false;
    }

    //Check if the number of roll numbers is equal to group size
    if (count($form_data['roll_no']) != $size) {
        HAA_gotError(
            'Invalid data received.'
        );
        return false;
    }

    //Check if any duplicate roll number was entered
    $temp = $form_data['roll_no'];
    $temp = array_unique($temp);
    if (count($temp) != $size) {
        HAA_gotError(
            'Number of Roll numbers entered is invalid.'
        );
        return false;
    }

    foreach ($form_data as $column => $value) {
        if (! empty($column) && in_array($column, $column_whitelist)) {
            if (is_array($value)) {
                foreach ($value as $column1 => $value1) {
                    if (! HAA_validateValue($value1,'integer')) {
                        HAA_inValidField($fields[$column1]);
                    } else {
                        $form_params[$column1][':' . $column] = $value1;
                    }
                }
            } elseif (in_array($column, $password_fields)) {
                if (! HAA_validateValue($value, 'password')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[$size][':' . $column] = $value;
                }
            } elseif (in_array($column, $integers)) {
                if (! HAA_validateValue($value, 'integer')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[$size][':' . $column] = $value;
                }
            } else {
                //Nothing
            }

            // Remove matched element from white list.
            $column_whitelist = array_diff($column_whitelist, array($column));
        }
    }

    // If $column_whitelist still contains any value, then form was incomplete.
    if (count($column_whitelist) > 0) {
        $GLOBALS['error'] = array();
        HAA_gotError('Form submitted with incomplete data.');
        return false;
    }

    // If faced any error.
    if (! empty($GLOBALS['error'])) {
        return false;
    }

    return $form_params;
}

/**
 * Saves group information into database.
 *
 * @param array Form parameters.
 * @return bool Success or failure
 */
function HAA_saveGroupRecord($form_params)
{
    //Parsed form data
    $parsed_form_data = HAA_parseFormData($form_params);

    if (is_array($parsed_form_data) && $parsed_form_data != false) {
        // Get the group_size
        foreach ($parsed_form_data as $column => $value) {
            if (is_array($value)) {
                foreach ($value as $column1 => $value1) {
                    if (strcmp($column1, ":group_size") == 0) {
                        $size = intval($value1);
                    }
                }
            }
        }

        // Check the records for already group registered,
        // wrong unique id and not registered.
        $error = false;
        foreach ( $parsed_form_data as $column => $value) {
            if (is_array($value)) {
                foreach ($value as $column1 => $value1) {
                    if (strcmp($column1, ":roll_no") == 0) {
                        // Check if student is registered individually.
                        if (! HAA_isStudentRecordExists($value1)) {
                            HAA_gotError('<span class="blue">'
                                . $value1
                                . '</span> is not registered.'
                                . ' In case of any discrepency, please contact'
                                . ' administration immediately.'
                            );
                            $error = true;
                            // No need to check next conditions.
                            continue;
                        }

                        //Check if the given unique_id for roll_no is correct
                        if (! HAA_isUniqueIdCorrect($value1,
                            $parsed_form_data[$column][":unique_id"])) {
                            HAA_gotError('Unique ID for Roll Number '
                                . '<span class="blue">'
                                . $value1
                                . '</span>'
                                . ' is incorrect. In case of any discrepency,'
                                . ' please contact administration immediately.'
                            );
                            $error = true;
                            // No need to disclose group information
                            // if student is in another group if ID is incorrect.
                            continue;
                        }

                        //Check if student has already registered in another group
                        if (HAA_isStudentGroupRecordExists($value1)) {
                            HAA_gotError('Roll number '
                                . '<span class="blue">'
                                . $value1
                                . '</span> is already registered as part of another group.'
                                . ' In case of any discrepency, please contact administration'
                                . ' immediately.'
                            );
                            $error = true;
                        }
                    }
                }
            }
        }

        // Atleast one error exists, so return.
        if ($error == true) {
            return false;
        }

        // Generate Group ID for group
        $group_id = HAA_generateUniqueId();
        if (! $group_id) {
            return false;
        }

        // Add newly generated unique Group ID to $parsed_form_data.
        // Will have to add group id to each member of the group's record

        for ($i=0;$i<=$size;$i++) {
            $parsed_form_data[$i][':group_id'] = $group_id;
        }

        // Insert group record.
        $result = HAA_insertGroupRecord($parsed_form_data);

        // If fails to insert record.
        if (! $result) {
            HAA_gotError(
                'Failed to save the group record.'
            );
            return false;
        }

        // Add the password for the corressponding group_id.
        $result = HAA_insertGroupPassword($parsed_form_data);

        if(! $result) {
            HAA_gotError(
                'Failed to save the group record.'
            );
            return false;
        }

        //@TODO: Send email to all the members of the group

        // Create a success message.
        $success_msg = '<div class="response_dialog success">'
            . '<h1>CONGRATULATIONS !</h1>'
            . '<div>Successfully received the details of :</div>'
            . '<div class="blue" style="text-align: center;">'
            .  HAA_getHtmlMemberList($parsed_form_data)
            . '</div>'
            . '<p>This is your Group ID : <span class="blue">'
            . $parsed_form_data[$size][':group_id'] . '</span><br>'
            . '<strong>Please note it down at a safe place.</strong><br>'
            . '<strong>It will be required during the Room Allotment process.</strong></p>'
            . '</div>';
        $GLOBALS['message'] = $success_msg;

        return true;
    } else {
        return false;
    }
}

/**
 * Returns the html containing list of members of recent group
 * @param array $params Parsed form data array
 * @return string Html
 */
function HAA_getHtmlMemberList($params)
{
    $retval = '';

    foreach ( $params as $column => $value) {
        if (array_key_exists(':roll_no', $value)) {
            $retval .= '<div>' . $value[':roll_no'] . '</div>';
        }
    }

    return $retval;
}
?>
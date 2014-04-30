<?php
/**
 * Functions required for User registration page.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Generates Html for User registration form.
 *
 * @return string $retval Form Html
 */
function HAA_getHtmlRegisterForm()
{
    $retval = '<form method="POST" action="register.php"'
        . ' enctype="multipart/form-data"'
        . ' class="register_form gray_grad box">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<input type="hidden" name="MAX_FILE_SIZE" value="2097152">'
        . '<table>'
        . '<caption>Registration Form</caption>'
        . '<tr>'
        . '<td><label for="input_roll_no">Roll No<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_roll_no" name="roll_no"'
        . ' title="Please provide your University Roll Number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_name">Name<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_name" name="full_name"'
        . ' title="Please provide your Full Name"></td>'
        . '</tr>'
        . '<td><label for="input_photo">Photo<sup class="req">*</sup> :</label></td>'
        . '<td><input type="file" class="required" id="input_photo" name="photo" accept="image/*"'
        . ' title="Please provide your latest Passport size photograph (< 2MB)"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_class">Class<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectClass() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_branch">Branch<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_branch" name="branch"'
        . ' title="Please provide your Branch"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_year">Current Year<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectYear() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_dob">Date Of Birth<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_dob" class="datefield required" name="dob"'
        . ' title="Please provide your Date Of Birth (YYYY-MM-DD)"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_category">Category<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectCategory() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_blood">Blood Group<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectBloodGroup() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_stud_mob">Student Mobile<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_stud_mob" class="mobilefield required" name="student_mobile"'
        . ' title="Please provide your Mobile number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_email">E-mail<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_email" name="email"'
        . ' title="Please provide your valid Email address"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_father_name">Father&apos;s Name<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_father_name" name="father_name"'
        . ' title="Please provide your Father&apos;s Name (excluding Title)"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_father_mob">Father&apos;s Mobile<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_father_mob" class="mobilefield required" name="father_mobile"'
        . ' title="Please provide your Father&apos;s Mobile number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_mother_name">Mother&apos;s Name<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_mother_name" name="mother_name"'
        . ' title="Please provide your Mother&apos;s Name (excluding Title)"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_mother_mob">Mother&apos;s Mobile :</label></td>'
        . '<td><input type="text" id="input_mother_mob" class="mobilefield" name="mother_mobile"'
        . ' title="Please provide your Mother&apos;s Mobile number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_addr">Permanent Address<sup class="req">*</sup> :</label></td>'
        . '<td><textarea class="required" id="input_addr" name="permanent_address"'
        . ' title="Please provide your Permanent Address"></textarea></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_alt_addr">Alternate Address :</label></td>'
        . '<td><textarea id="input_alt_addr" name="alternate_address"'
        . ' title="Please provide your Alternate Address (if any)"></textarea></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_landline">Landline :</label></td>'
        . '<td><input type="text" id="input_landline" name="landline"'
        . ' title="Please provide your Home Landline number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_type">Want room as<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectRoomType() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2"><input type="checkbox" id="input_agreement" name="agreement">'
        . '<label for="input_agreement">I have read all <a href="jrules.html" target="_blank">Hostel Rules &amp; Regulations</a>. I will abide by all of them failing which authorities can take punitive action.</label>'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2" style="text-align: center;">'
        . '<input type="submit" name="submit" value="Register">'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>';

    return $retval;
}

/**
 * Generates Html for Select class list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectClass()
{
    // @todo: Classes can be saved and fetched from DB.
    $retval = '<select name="class" class="required" id="input_class"'
        .' title="Please provide your Class">'
        . '<option>...</option>'
        . '<option>BTech</option>'
        . '<option>MBA</option>'
        . '<option>MSc</option>'
        . '<option>MTech</option>'
        . '<option>MCA</option>'
        . '<option>PHD</option>'
        . '</select>';

    return $retval;
}

/**
 * Generates Html for Select year list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectYear()
{
    $retval = '<select name="current_year" class="required" id="input_year"'
        .' title="Please provide your current Year of study">'
        . '<option>...</option>';
    for ($i=1;$i<=5;$i++) {
        $retval .= '<option>' . $i . '</option>';
    }
    $retval .= '</select>';

    return $retval;
}

/**
 * Generates Html for Select category list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectCategory()
{
    $retval = '<select name="category" class="required" id="input_category"'
        .' title="Please provide your Category">'
        . '<option>...</option>'
        . '<option>GEN</option>'
        . '<option>SC</option>'
        . '<option>ST</option>'
        . '<option>BC</option>'
        . '<option>NRI</option>'
        . '</select>';

    return $retval;
}

/**
 * Generates Html for Select blood group list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectBloodGroup()
{
    $retval = '<select name="blood_group" class="required" id="input_blood"'
        .' title="Please provide your Blood Group">'
        . '<option>...</option>'
        . '<option>A+</option>'
        . '<option>A-</option>'
        . '<option>B+</option>'
        . '<option>B-</option>'
        . '<option>O+</option>'
        . '<option>O-</option>'
        . '<option>AB+</option>'
        . '<option>AB-</option>'
        . '</select>';

    return $retval;
}

/**
 * Generates Html for Select room type list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectRoomType()
{
    $retval = '<select name="room_type" class="required" id="input_type"'
        .' title="Please select whether you want to take room as an Individual or as a part of a Group">'
        . '<option>...</option>'
        . '<option value="individual">an Individual</option>'
        . '<option value="group">a part of a Group</option>'
        . '</select>';

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
        'roll_no'
        , 'full_name'
        , 'class'
        , 'branch'
        , 'current_year'
        , 'dob'
        , 'category'
        , 'blood_group'
        , 'student_mobile'
        , 'email'
        , 'father_name'
        , 'father_mobile'
        , 'mother_name'
        , 'mother_mobile'
        , 'landline'
    );

    // Name of corresponding fields.
    $fields = array(
        'roll_no' => 'Roll No'
        , 'full_name' => 'Full Name'
        , 'class' => 'Class'
        , 'branch' => 'Branch'
        , 'current_year' => 'Current Year'
        , 'dob' => 'Date Of Birth'
        , 'category' => 'Category'
        , 'blood_group' => 'Blood Group'
        , 'student_mobile' => 'Student Mobile'
        , 'email' => 'Email'
        , 'father_name' => 'Father Name'
        , 'father_mobile' => 'Father Mobile'
        , 'mother_name' => 'Mother Name'
        , 'mother_mobile' => 'Mother Mobile'
        , 'permanent_address' => 'Permanent Address'
        , 'alternate_address' => 'Alternate Address'
        , 'landline' => 'Landline'
    );

    // List of columns to be validated for alphabets only.
    $names = array(
        'full_name'
        , 'class'
        , 'branch'
        , 'category'
        , 'father_name'
        , 'mother_name'
    );
    //List of columns to be validated for mobile number.
    $mobile_numbers = array(
        'student_mobile'
        , 'father_mobile'
        , 'mother_mobile'
    );
    // List of columns to be validated for email.
    $emails = array(
        'email'
    );
    //List of columns to be validated for Blood Group.
    $blood_groups = array(
        'blood_group'
    );
    //List of columns to be validated for integers only.
    $integers = array(
        'roll_no'
        , 'current_year'
        , 'landline'
    );
    // List of columns to validated for dates.
    $dates = array(
        'dob'
    );

    // If landline, mother_mobile empty, then they need not to be validated.
    if (empty($form_data['landline'])) {
        unset($column_whitelist[array_search('landline', $column_whitelist)]);
        $form_params[':landline'] = '';
    }
    if (empty($form_data['mother_mobile'])) {
        unset($column_whitelist[array_search('mother_mobile', $column_whitelist)]);
        $form_params[':mother_mobile'] = '';
    }

    // Push addresses, as they need not to be validated.
    $form_params[':permanent_address'] = $_REQUEST['permanent_address'];
    $form_params[':alternate_address'] = $_REQUEST['alternate_address'];

    $i=0;
    foreach ($form_data as $column => $value) {
        if (! empty($column) && in_array($column, $column_whitelist)) {
            if (in_array($column, $names)) {
                if (! HAA_validateValue($value, 'name')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } elseif (in_array($column, $mobile_numbers)) {
                if (! HAA_validateValue($value, 'mobile')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } elseif (in_array($column, $emails)) {
                if (! HAA_validateValue($value, 'email')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } elseif (in_array($column, $blood_groups)) {
                if (! HAA_validateValue($value, 'blood_group')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } elseif (in_array($column, $integers)) {
                if (! HAA_validateValue($value, 'integer')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } elseif (in_array($column, $dates)) {
                if (! HAA_validateValue($value, 'date')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } else {
                // Nothing
            }

            // Remove matched element from white list.
            unset($column_whitelist[$i++]);
        }
    }

    // Validate uploaded photo.
    $photo = HAA_validatePhoto($form_params[':roll_no']);
    if ($photo == false) {
        return false;
    }

    // Add photo to form_params
    $form_params[':photo'] = $photo;

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
 * Saves user information into database.
 *
 * @param array Form parameters.
 * @return bool Success or failure
 */
function HAA_saveStudentRecord($form_params)
{
    // Parse form data.
    $parsed_form_data = HAA_parseFormData($form_params);

    if (is_array($parsed_form_data) && $parsed_form_data != false) {

        // Check if record already exists.
        if (HAA_isStudentRecordExists($parsed_form_data[':roll_no'])) {
            HAA_gotError( '<span class="blue">'
                . $parsed_form_data[':full_name'] . '(' . $parsed_form_data[':roll_no'] . ')'
                . '</span> is already registered. In case of any discrepency, please immediately'
                . ' contact administration.'
            );
            return false;
        }
        // Check if student is eligible for hostel or not.
        if (! HAA_isEligible($parsed_form_data[':roll_no'])) {
            HAA_gotError(
                $parsed_form_data[':full_name'] . '(' . $parsed_form_data[':roll_no'] . ')'
                . ' has not been allotted Hostel-J. Check your Web Kiosk.'
            );
            return false;
        }

        // Generate Unique ID.
        $unique_id = HAA_generateUniqueId();
        if (! $unique_id) {
            return false;
        }

        // Add newly generated unique ID to $parsed_form_data.
        $parsed_form_data[':unique_id'] = $unique_id;

        // Insert student record.
        $result = HAA_insertStudentRecord($parsed_form_data);

        // If fails to insert record.
        if (! $result) {
            HAA_gotError(
                'Failed to save record.'
            );
            return false;
        }

        // Save uploaded photo.
        if (! move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            $parsed_form_data[':photo']
        )) {
            // If failed to save photo, then remove the newly saved DB record.
            if (HAA_isStudentRecordExists($parsed_form_data[':roll_no'])) {
                HAA_deleteStudentRecord($parsed_form_data[':roll_no']);
            }
            HAA_gotError(
                'Failed to save photo. Please retry.'
            );
            return false;
        }

        // If user wants individual room, create his login ID.

        // Send an email.
        $to = array($parsed_form_data[':email'] => $parsed_form_data[':full_name']);
        $from = array(smtpFromEmail => smtpFromName);
        $subject = 'Hostel-J Registraion';
        $message = 'Dear' . $parsed_form_data[':full_name'] .'\n\n'
            . '\tYour Personal details have been successfully received.\n'
            . '\tYour Unique ID is :' . $parsed_form_data[':unique_id'] . '\n\n\n'
            . 'Regards,\n'
            . smtpFromName . ', Hostel-J\n'
            . 'Thapar University';
        $mail = HAA_sendMail($subject, $to, $from, $message);
        $mail_message = ($mail == false) ? ('')
            : ('<p>An email has also been sent to : <span class="blue">'
                . $parsed_form_data[':email'] . '</span><br>');

        // Create a success message.
        $success_msg = '<div class="response_dialog success">'
            . '<h1>CONGRATULATIONS !</h1>'
            . '<div>Successfully received the details of :</div>'
            . '<div class="blue" style="text-align: center;">'
            . '<p>' . $parsed_form_data[':full_name'] . '</p>'
            . '<p>' . $parsed_form_data[':roll_no'] . '</p>'
            . '</div>'
            . '<p>This is your Unique ID : <span class="blue">'
            . $parsed_form_data[':unique_id'] . '</span><br>'
            . '<strong>Please note it down at a safe place.</strong><br>'
            . '<strong>It will be required during the Group Creation process.</strong></p>'
            . $mail_message
            . '</div>';
        $GLOBALS['message'] = $success_msg;

        return true;
    } else {
        return false;
    }
}

/**
 * Validates uploaded photo.
 *
 * @param string $roll_no Roll number of student for file naming.
 * @return bool|string If valid, returns filename else false
 */
function HAA_validatePhoto($roll_no)
{
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (! isset($_FILES['photo']['error'])
        || is_array($_FILES['photo']['error'])
    ) {
        HAA_gotError(
            'Invalid Photo uploaded.'
        );
        return false;
    }

    // Check $_FILES['photo']['error'] value for type of error.
    $err_msg = '';
    switch ($_FILES['photo']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            $err_msg = 'No photo sent.';
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $err_msg = 'Image file size limit execeeded.';
            break;
        default:
            $err_msg = 'Something went wrong with photo.';
            break;
    }

    if (!empty($err_msg)) {
        HAA_gotError(
            $err_msg
        );
        return false;
    }

    // Checking file size. (< 2MB)
    if ($_FILES['photo']['size'] > 2097152) {
        HAA_gotError(
            'Image file size limit execeeded.'
        );
        return false;
    }

    // DO NOT TRUST $_FILES['photo']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['photo']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'bmp' => 'image/bmp',
        ),
        true
    )) {
        HAA_gotError(
            'Invalid image format.'
        );
        return false;
    }

    // Give unique name.
    $filename = './student_photos/' . $roll_no . '.' . $ext;

    return $filename;
}
?>
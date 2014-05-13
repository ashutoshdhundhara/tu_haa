<?php
/**
 * Functions required for Error Reporting.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Generates Html for Error reporting form.
 *
 * @return string $retval Form Html
 */
function HAA_getHtmlErrorReportForm()
{
    $retval = '<form method="POST" action="complaint.php"'
        . ' enctype="multipart/form-data"'
        . ' class="report_complaint gray_grad box">'
        . '<input type="hidden" name="MAX_FILE_SIZE" value="2097152">'
        . '<input type="hidden" name="submitted" value="true">'
        . '<table>'
        . '<caption>Report Issue</caption>'
        . '<tr>'
        . '<td><label for="input_name">Name<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_name" name="full_name"'
        . ' title="Please provide your Full Name"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_email">E-mail<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_email" name="email"'
        . ' title="Please provide your valid Email address"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_addr">Error Description<sup class="req">*</sup> :</label></td>'
        . '<td><textarea class="required" id="complaint_desc" name="complaint_description"'
        . ' title="Please provide a detailed description of the complaint or problem"></textarea></td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2" style="text-align: center;">'
        . '<input type="submit" name="submit" value="Report">'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>';

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
        'full_name'
        , 'email'
    );

    // Name of corresponding fields.
    $fields = array(
        'full_name' => 'Full Name'
        , 'email' => 'Email'
        , 'complaint_description' => 'Complaint Description'
    );

    // List of columns to be validated for email.
    $emails = array(
        'email'
    );
    
    // List of columns to be validated for alphabets only.
    $names = array(
        'full_name'
    );

    //Check that email and complaint are filled
    $error = false;
    if (! isset($form_data['complaint_description']) || empty($form_data['complaint_description'])) {
        HAA_gotError(
            'Complaint description was left blank.'
        );
        $error = true;
    }

    foreach ($form_data as $column => $value) {
        if (! empty($column) && in_array($column, $column_whitelist)) {
            if (in_array($column, $emails)) {
                if (! HAA_validateValue($value, 'email')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } elseif (in_array($column, $names)) {
                if (! HAA_validateValue($value, 'name')) {
                    HAA_inValidField($fields[$column]);
                } else {
                    $form_params[':' . $column] = $value;
                }
            } else {
                //Nothing
            }

            // Remove matched element from white list.
            $column_whitelist = array_diff($column_whitelist, array($column));
        }
    }
    
    //If any error, exit
    if ($error==true) {
        return false;
    }
    
    $form_params[':complaint_description'] = $form_data['complaint_description'];

    // If faced any error.
    if (! empty($GLOBALS['error'])) {
        return false;
    }

    return $form_params;
}

/**
 * Saves complaint information into database.
 *
 * @param array Form parameters.
 * @return bool Success or failure
 */
function HAA_saveErrorReport($form_params)
{
    //Parsed form data
    $parsed_form_data = HAA_parseFormData($form_params);

    if (is_array($parsed_form_data) && $parsed_form_data != false) {
        // Generate Complaint ID
        $complaint_id = HAA_generateComplaintId();
        if (! $complaint_id) {
            return false;
        }

        // Add newly generated unique Complaint ID to $parsed_form_data.
        $parsed_form_data[':complaint_id'] = $complaint_id;
        
        // Insert complaint record.
        $result = HAA_insertComplaintRecord($parsed_form_data);

        // If fails to insert record.
        if (! $result) {
            HAA_gotError(
                'Failed to save the Complaint record.'
            );
            return false;
        }

        // Send an email.
        $mail_id = $parsed_form_data[':email'];
        $name = 'Student';
        $to = array($mail_id => $name);
        $from = array(smtpFromEmail => smtpFromName);
        $subject = 'Hostel-J Complaint Registration';
        $message = 'Dear ' . $name . ",\n\n"
            . "\tYour Complaint has been successfully received.\n"
            . "\tYour Complaint ID is : " . $parsed_form_data[':complaint_id'] . "\n\n\n"
            . "Regards,\n"
            . smtpFromName . ", Hostel-J\n"
            . 'Thapar University';
        $mail = HAA_sendMail($subject, $to, $from, $message);
        $mail_notify = ($mail == false) ? ('')
            : ('<p>An email has also been sent to : <span class="blue"> '
            . $parsed_form_data[':email']
            . '. </span></p>');

        // Create a success message.
        $success_msg = '<div class="report_complaint gray_grad box success">'
            . '<table>'
            . '<caption><h1>CONGRATULATIONS !</h1></caption>'
            . '</td>'
            . '</tr>'
            . '<tr>'
            . '<td colspan="2">'
            . 'Successfully received the complaint!'
            . '</td>'
            . '</tr>'
            . '<tr>'
            . '<td>'
            . 'This is your Complaint ID : '
            . '</td>'
            . '<td><span class="blue">'
            . $parsed_form_data[':complaint_id'] . '</span><br>'
            . '</td>'
            . '<tr>'
            . '<td colspan="2">'
            . '<strong><center>Thank you.</center></strong><br>'
            . '</td>'
            . '</tr>'
            . '<tr>'
            . '<td colspan="2">'
            . $mail_notify
            . '</td>'
            . '</tr>'
            . '</table>'
            . '</div>';
        $GLOBALS['message'] = $success_msg;

        return true;
    } else {
        return false;
    }
}

/**
 * Generates a Complaint ID.
 *
 * @return string $unique_id Unique ID.
 */
function HAA_generateComplaintId() {

    // SQL query to check if unique id already exists.
    $sql_query = 'SELECT complaint_id FROM ' . tblComplaint . ' '
        . 'WHERE complaint_id = :complaint_id';
    $unique_id = '';

    do {
        $unique_id = (string) mt_rand(1000,9999);
        $temp_result = $GLOBALS['dbi']->executeQuery(
            $sql_query, array(':complaint_id' => $unique_id)
        );
        
        //Must not be present in the table
        if (! $temp_result->fetch()) {
                break;
            }
    }
    while(true);

    return $unique_id;
}
?>
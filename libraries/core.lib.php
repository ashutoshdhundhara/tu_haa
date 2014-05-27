<?php
/**
 * Contains functions which are common to all php scripts.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Validates a value to corresponding type i.e. name,date etc.
 *
 * @param string Value to be checked
 * @param string type of value
 *
 * @return bool Valid or Invalid
 */
function HAA_validateValue($value, $type)
{
    $isValid = true;
    $regEx = '';

    switch($type) {
        case 'name':
            $regEx = '/^[A-Za-z\s]+$/';
            break;
        case 'mobile':
            $regEx = '/^[0-9\+\-]{10,}$/';
            break;
        case 'integer':
            $regEx = '/^[0-9]+$/';
            break;
        case 'blood_group':
            $regEx = '/^[ABO][\+\-]$|^[A][B][\+\-]$/';
            break;
        case 'email':
            $regEx = '/^[a-zA-Z][a-z0-9]*[\_\.]{0,1}[a-z0-9]+[\@][a-z0-9]+[\.][a-z]+[\.]{0,1}[a-z]+$/';
            break;
        case 'date':
            $regEx = '/^[0-9]{4}[\-][0-9]{2}[\-][0-9]{2}$/';
            break;
        case 'password':
            $regEx = '/^[a-zA-Z0-9\~\!\@\#\$\%\^\&\*]{8,}$/';
            break;
        case 'wing':
            $regEx = '/^[wWeE]$/';
            break;
        case 'cluster':
            $regEx = '/^[a-fA-F]$/';
            break;
        case 'room':
            $regEx = '/^[0-9]$|^[1][10]$/';
            break;
        case 'room_no':
            $regEx = '/^[wWeE][a-fA-F][\-][1-8][0][1-9]$|^[wWeE][a-fA-F][\-][1-8][1][10]$/';
            break;
        case 'unique_id':
            $regEx = '/^[A-Za-z0-9]{6}$/';
            break;
    }

    if (! preg_match($regEx, $value)) {
        $isValid = false;
    }

    return $isValid;
}

/**
 * Adds error message to $GLOBALS['error'] for invalid field.
 *
 * @param string Field name.
 *
 * @return void
 */
function HAA_inValidField($field_name)
{
    HAA_gotError(
        $field_name . ' field is empty or contains invalid characters.'
    );
}

/**
 * Adds error message to $GLOBALS['error'].
 *
 * @param string $message Error message
 *
 * @return void
 */
function HAA_gotError($message)
{
    array_push($GLOBALS['error'],
        $message
    );
}

/**
 * Create error message to be sent via Ajax.
 *
 * @param array Array containing error messages.
 *
 * @return string $retval String with formatted error messages.
 */
function HAA_generateErrorMessage($messages)
{
    $retval = '<div class="response_dialog error">';
    $retval .= '<h1>ERROR</h1>';
    $retval .= '<strong>Following error(s) occurred : </strong>';
    $retval .= '<ul>';
    foreach ($messages as $message) {
        $retval .= '<li>' . $message . '</li>';
    }
    $retval .= '</ul></div>';

    return $retval;
}

/**
 * Creates and sends email.
 *
 * @param string $subject Subject of the message
 * @param array $recepient Array containing recepient emais
 * @param array $sender Array containing sender emails
 * @param string $message Body of message
 *
 * @return bool|int Successful recepients or false
 */
function HAA_sendMail($subject, $recepient, $sender, $message)
{
    // Load mail constants.
    require_once 'libraries/mailConstants.inc.php';

    try {
         // Create a Transport for sending mail.
        $transport = Swift_SmtpTransport::newInstance(smtpServer, smtpPort);
        // Set Username.
        $transport->setUsername(smtpUsername);
        // Set Password.
        $transport->setPassword(smtpPassword);

        // Create a SwiftMailer instance.
        $mailer = Swift_Mailer::newInstance($transport);

        // Create message instance with subject.
        $mail = Swift_Message::newInstance($subject);
        // Set recepients.
        $mail->setTo($recepient);
        // Set sender.
        $mail->setFrom($sender);
        // Set message body.
        $mail->setBody($message, 'text/plain');

        // Send message.
        return $mailer->send($mail);
    } catch (Exception $excp) {
        return false;
    }
}

/**
 * Inserts record into `tblStudent`.
 *
 * @param array $params Query parameters
 *
 * @return PDO object
 */
function HAA_insertStudentRecord($params)
{
    // Create SQL query.
    $sql_query = 'INSERT INTO `' . dbName . '`.`' . tblStudent . '`'
        . ' (`unique_id`, `roll_no`, `full_name`, `class`, `branch`, `current_year`'
        . ', `dob`, `category`, `blood_group`, `student_mobile`, `email`'
        . ', `father_name`, `father_mobile`, `mother_name`, `mother_mobile`'
        . ', `permanent_address`, `alternate_address`, `landline`, `photo`) '
        . 'VALUES (:unique_id'
        . ', :roll_no'
        . ', UPPER(TRIM(:full_name))'
        . ', :class'
        . ', UPPER(TRIM(:branch))'
        . ', :current_year'
        . ', :dob'
        . ', :category'
        . ', :blood_group'
        . ', :student_mobile'
        . ', TRIM(:email)'
        . ', UPPER(TRIM(:father_name))'
        . ', :father_mobile'
        . ', UPPER(TRIM(:mother_name))'
        . ', :mother_mobile'
        . ', UPPER(TRIM(:permanent_address))'
        . ', UPPER(TRIM(:alternate_address))'
        . ', :landline'
        . ', :photo'
        .')';

    // Execute the query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);

    return $result;
}

/**
 * Inserts record into `tblGroup`.
 *
 * @param array $params Query parameters
 *
 * @return PDO object
 */
function HAA_insertGroupRecord($params)
{
    // Create SQL query.
    $sql_query = 'INSERT INTO `' . dbName . '`.`' . tblGroup . '`'
        . ' (`unique_id`, `roll_no`, `group_id`) '
        . 'VALUES (:unique_id'
        . ', :roll_no'
        . ', :group_id'
        .')';

    // Execute the query.
    foreach ( $params as $column => $value) {
        if (array_key_exists(':roll_no',$value)) {
            $result = $GLOBALS['dbi']->executeQuery($sql_query, $value);
            if (! $result )
                return false;
        }
    }

    return true;
}


/**
 * Deletes a record from `tblStudent`.
 *
 * @param string $roll_no Roll number
 *
 * @return PDO object
 */
function HAA_deleteStudentRecord($roll_no)
{
    // Create SQL query.
    $sql_query = 'DELETE FROM `' . dbName . '`.`' . tblStudent . '`'
        . ' WHERE roll_no = :roll_no';

    $result = $GLOBALS['dbi']->executeQuery($sql_query,
        array(':roll_no' => $roll_no));

    return $result;
}

/**
 * Generates a Unique ID.
 *
 * @return string $unique_id Unique ID.
 */
function HAA_generateUniqueId() {

    // SQL query to check if unique id already exists.
    $sql_query_tblStudent = 'SELECT unique_id FROM ' . tblStudent . ' '
        . 'WHERE unique_id = :unique_id';
    $unique_id = '';

    $sql_query_tblGroupId = 'SELECT group_id FROM ' . tblGroupId . ' '
        . 'WHERE group_id = :group_id';

    do {
        $unique_id = (string) mt_rand(1000, 9999);
        $temp_result_tblStudent = $GLOBALS['dbi']->executeQuery(
            $sql_query_tblStudent, array(':unique_id' => $unique_id)
        );
        $temp_result_tblGroupId = $GLOBALS['dbi']->executeQuery(
            $sql_query_tblGroupId, array(':group_id' => $unique_id)
        );

        //Must not be present in both the tables
        if (! $temp_result_tblStudent->fetch()) {
            if (! $temp_result_tblGroupId->fetch()) {
                break;
            }
        }
    }
    while(true);

    return $unique_id;
}

/**
 * Checks if student has been allocated hostel or not.
 *
 * @param string $roll_no Student's roll number.
 *
 * @return bool Allocated or not
 */
function HAA_isEligible($roll_no)
{
    // Query to check if student is eligible for hostel or not.
    $sql_query = 'SELECT roll_no FROM ' . tblEligibleStudents .' '
        . 'WHERE roll_no = :roll_no';

    // Execute query.
    $temp_result = $GLOBALS['dbi']->executeQuery(
        $sql_query, array(':roll_no' => $roll_no)
    );

    if (! $temp_result->fetch()) {
        return false;
    }

    return true;
}

/**
 * Checks if student entered the correct unique key as provided in WebKiosk.
 *
 * @param string $roll_no Student's roll number.
 * @param string $unique_id Unique ID to be checked for correctness.
 *
 * @return bool Correct or not
 */
function HAA_validateUniqueKey($roll_no, $unique_id)
{
    // Query to check if student entered the correct unique_key or not.
    $sql_query = 'SELECT `unique_id` FROM ' . tblEligibleStudents .' '
        . 'WHERE `roll_no` = :roll_no AND `unique_id` = :unique_id ';

    // Execute query.
    $temp_result = $GLOBALS['dbi']->executeQuery(
        $sql_query, array(':roll_no' => $roll_no, ':unique_id' => $unique_id)
    );

    if (! $temp_result->fetch()) {
        return false;
    }

    return true;
}

/**
 * Checks if record already exists.
 *
 * @param string $roll_no
 *
 * @return bool True|False
 */
function HAA_isStudentRecordExists($roll_no)
{
    // Query to check if record alredy exists.
    $sql_query = 'SELECT roll_no FROM ' . tblStudent . ' '
        . 'WHERE roll_no = :roll_no';

    // Execute query.
    $temp_result = $GLOBALS['dbi']->executeQuery(
        $sql_query, array(':roll_no' => $roll_no)
    );

    if ($temp_result->fetch()) {
        return true;
    }

    return false;
}

/**
 * Redirects to a page.
 *
 * @param string $location Location
 */
function HAA_redirectTo($location)
{
    // List of valid pages.
    $page_whitelist = array(
        'map.php'
        , 'register.php'
        , 'allot.php'
        , 'group.php'
        , 'index.php'
    );
    // Get page name.
    $page = explode('?', $location);
    if (is_array($page)) {
        $page = $page[0];
    }
    // If page is valid.
    if (in_array($page, $page_whitelist)) {
        // Redirect to page.
        header('Location: ' . $location);
        exit;
    }
}

/**
 * Checks if record already exists in a group.
 *
 * @param string $roll_no
 *
 * @return bool True|False
 */
function HAA_isStudentGroupRecordExists($roll_no)
{
    // Query to check if record alredy exists.
    $sql_query = 'SELECT roll_no FROM ' . tblGroup . ' '
        . 'WHERE roll_no = :roll_no';

    // Execute query.
    $temp_result = $GLOBALS['dbi']->executeQuery(
        $sql_query, array(':roll_no' => $roll_no)
    );

    if ($temp_result->fetch()) {
        return true;
    }

    return false;
}

/**
 * Checks if the unique id for given student is correct
 *
 * @param string $roll_no
 * @param string $unique_id
 *
 * @return bool True|False
 */
function HAA_isUniqueIdCorrect($roll_no, $unique_id)
{
    // Query to check if id matches.
    $sql_query = 'SELECT unique_id FROM ' . tblStudent . ' '
        . 'WHERE roll_no = :roll_no '
        . 'AND unique_id = :unique_id';

    // Execute query.
    $temp_result = $GLOBALS['dbi']->executeQuery(
        $sql_query, array(':roll_no' => $roll_no, ':unique_id' => $unique_id)
    );

    if ($temp_result->fetch()) {
        return true;
    }

    return false;
}

/**
 * Inserts record into `tblGroupId`.
 *
 * @param array $params Query parameters
 *
 * @return PDO object
 */
function HAA_insertGroupPassword($params)
{
    // Create SQL query.
    $sql_query = 'INSERT INTO `' . dbName . '`.`' . tblGroupId . '`'
        . ' (`group_id`, `password`, `group_size`, `allotment_status` ) '
        . 'VALUES (:group_id'
        . ', :password'
        . ', :group_size'
        . ', :allotment_status'
        .')';

    // Get the group size
    $size = -1;
    foreach ($params as $column => $value) {
        $size++;
    }

    // Set allotment status to "SELECT" by default.
    $params[$size]['allotment_status'] = 'SELECT';

    // Hash the password
    $params[$size][':password']= hash('sha512',$params[$size][':password']);

    // Execute the query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params[$size]);

    return true;
}

/**
 * Returns the required detail of the student from tblStudent
 *
 * @param string $field_name
 * @param string $roll_no
 *
 * @return string $field_value
 */
function HAA_getStudentDetail($field_name,$roll_no)
{
    // Query to fetch the required field value from the table.
    $sql_query = 'SELECT ' . $field_name . ' FROM ' . tblStudent . ' '
        . 'WHERE roll_no = :roll_no';

    // Execute query.
    $field_value = $GLOBALS['dbi']->executeQuery(
        $sql_query, array(':roll_no' => $roll_no)
    );

    if ($row = $field_value->fetch()) {
        return $row[$field_name];
    }

    return NULL;
}

/**
 * Inserts record into `tblComplaint`.
 *
 * @param array $params Query parameters
 *
 * @return PDO object
 */
function HAA_insertComplaintRecord($params)
{
    // Create SQL query.
    $sql_query = 'INSERT INTO `' . dbName . '`.`' . tblComplaint . '`'
        . ' (`email`, `complaint_id`, `complaint`, `name`) '
        . 'VALUES (:email'
        . ', :complaint_id'
        . ', :complaint_description'
        . ', :full_name'
        .')';

    // Execute the query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);
    if (! $result )
        return false;

    return true;
}
?>
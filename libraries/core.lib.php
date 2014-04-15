<?php
/**
 * Contains functions which are common to all php scripts.
 */

/**
 * Validates a value to corresponding type i.e. name,date etc.
 *
 * @param string Value to be checked
 * @param string type of value
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
            $regEx = '/^[ABO][AB]{0,1}[\+\-]$/';
            break;
        case 'email':
            $regEx = '/^[a-zA-Z][a-z0-9]*[\_\.]{0,1}[a-z0-9]+[\@][a-z0-9]+[\.][a-z]+[\.]{0,1}[a-z]+$/';
            break;
        case 'date':
            $regEx = '/^[0-9]{4}[\-][0-9]{2}[\-][0-9]{2}$/';
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
 * @return void
 */
function HAA_inValidField($field_name)
{
    array_push($GLOBALS['error'],
        $field_name
        . ' field contains invalid characters.'
    );
}

/**
 * Adds error message to $GLOBALS['error'].
 *
 * @param string $message Error message
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
 * @return string $retval String with formatted error messages.
 */
function HAA_generateErrorMessage($messages)
{
    $retval = '<ul class="error_list">';
    foreach ($messages as $message) {
        $retval .= '<li>' . $message . '</li>';
    }

    return $retval;
}

/**
 * Creates and sends email.
 *
 * @param string $subject Subject of the message
 * @param array $recepient Array containing recepient emais
 * @param array $sender Array containing sender emails
 * @param string $message Body of message
 * @return bool|int Successful recepients or false
 */
function HAA_sendMail($subject, $recepient, $sender, $message)
{
    // Load mail constants.
    require_once 'libraries/mailConstants.php';

     // Create a Transport for sending mail.
    $transport = Swift_SmtpTransport::newInstance(smtpServer, smtpPort);
    // Set Username.
    $transport->setUsername(smtpUsername);
    // Set Password.
    $transport->setPassword(smtpPassword);

    // Create a SwiftMailer instance.
    $mailer = Swift_Message::newInstance($transport);

    // Create message instance with subject.
    $mail = Swift_Message::newInstance($subject);
    // Set recepients.
    $mail->setTo($recepient);
    // Set sender.
    $mail->setFrom($sender);
    // Set message body.
    $mail->setBody($message);

    // Send message.
    return $mailer->send($mail);
}
?>
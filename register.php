<?php
/**
 * Handles user registration.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/register.lib.php';
require_once 'libraries/mailConstants.inc.php';
require_once 'libraries/swiftmailer/lib/swift_required.php';

// If Form is submitted, process it.
if (isset($_REQUEST['agreement'])) {
    $response = HAA_Response::getInstance();

    // Parse and save form data.
    $save = HAA_saveStudentRecord($_REQUEST);

    if ($save) {
        $response->addJSON('message', $GLOBALS['message']);
        $response->addJSON('save', true);
    } else {
        $response->addJSON('save', false);
        $response->addJSON('message'
            , HAA_generateErrorMessage($GLOBALS['error'])
        );
    }
    $response->response();
    exit;
}

// Display User Registration form.
$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('register.js', 'js');
$header->addFile('register.css', 'css');
$header->setTitle('Register');
$html_output = '';

$html_output .= HAA_getHtmlRegisterForm();

$response->addHTML($html_output);
$response->response();
?>
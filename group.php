<?php
/**
 * Handles Group creation process.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/group.lib.php';
require_once 'libraries/swiftmailer/lib/swift_required.php';
require_once 'libraries/mailConstants.inc.php';

//Process the form if submitted
if (isset($_POST['create_group'])) {
    $response = HAA_Response::getInstance();
    if(! HAA_saveGroupRecord($_POST)) {
        $response->addJSON('message', HAA_generateErrorMessage($GLOBALS['error']));
        $response->addJSON('save', false);
    } else {
        $response->addJSON('message', $GLOBALS['message']);
        $response->addJSON('redirect_url', 'index.php');
        $response->addJSON('save', true);
    }
    $response->response();
    exit;
}

// Display Group creation form.
$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('minified/group.js', 'js');
$header->addFile('jquery/jquery-uniform.js', 'js');
$header->addFile('jquery/jquery.maskedinput.min.js', 'js');
$header->addFile('minified/group.css', 'css');
$header->setTitle('Group');
$html_output = '';

$html_output .= HAA_getHtmlGroupForm();

$response->addHTML($html_output);
$response->response();
?>
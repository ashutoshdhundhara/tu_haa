<?php
/**
 * Handles user registration.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/register.lib.php';

// If Form is submitted, process it.
if (isset($_REQUEST['agreement'])) {
    $response = HAA_Response::getInstance();
    $response->addJSON('message', 'Hello');
    $response->response();
    exit();
}

// Display User Registration form.
$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('register.js', 'js');
$header->addFile('register.css', 'css');
$header->setTitle('');
$html_output = '';

$html_output .= HAA_getHtmlRegisterForm();

$response->addHTML($html_output);
$response->response();
?>
<?php
/**
 * Handles user registration.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/register.lib.php';

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
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

// Display Group creation form.
$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('group.js', 'js');
$header->addFile('group.css', 'css');
$header->setTitle('');
$html_output = '';

$html_output .= HAA_getHtmlGroupForm();

$response->addHTML($html_output);
$response->response();
?>
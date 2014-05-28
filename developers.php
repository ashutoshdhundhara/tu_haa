<?php
/**
 * Developer page.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/developers.lib.php';

$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->disableGlobalMessage();
$header->addFile('minified/developers.css', 'css');
$header->setTitle('Developers');

$html_output = HAA_getHtmlDevelopers();

$response->addHTML($html_output);
$response->response();
?>
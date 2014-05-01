<?php
/**
 * Shows hostel map and handles users rooms choices.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/map.lib.php';

// Start a secure session.
HAA_secureSession();

// If there is an Ajax request for Wing map.
if (isset($_REQUEST['wing_map']) && $_REQUEST['wing_map'] == true
    && isset($_REQUEST['wing'])) {
    $response = HAA_Response::getInstance();
    $response->disable();
    if (! HAA_checkLoginStatus()) {
        HAA_gotError(
            'Either your are not logged in or your session has expired'
        );
        $response->addHTML(HAA_generateErrorMessage($GLOBALS['error']));
    } else {
        $response->addHTML(HAA_getHtmlWingMap($_REQUEST['wing']));
    }

    $response->response();
    exit;
}

// Check if user is logged in or not.
if (! HAA_checkLoginStatus()) {
    HAA_redirectTo('index.php');
}
// Redirect user to correct page.
HAA_pageCheck();

// Display Hostel map.
$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('map.js', 'js');
$header->addFile('map.css', 'css');
$header->setTitle('');
$html_output = '';

$html_output .= HAA_getHtmlHostelMap(true);

$response->addHTML($html_output);
$response->response();
?>
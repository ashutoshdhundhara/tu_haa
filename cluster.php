<?php
/**
 * Generates Cluster map.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/cluster.lib.php';

// Start a secure session.
HAA_secureSession();

// Generate cluster map.
$response = HAA_Response::getInstance();
$html_output = '';

// Check if user is logged in or not.
if (! HAA_checkLoginStatus()) {
    HAA_gotError(
        'Either your are not logged in or your session has expired'
    );
    $response->addJSON('not_logged_in', true);
    $response->addJSON(
        'message', HAA_generateErrorMessage($GLOBALS['error'])
    );
    $response->addJSON('is_map', false);
    $response->response();
    exit;
}
$html_output = HAA_getHtmlClusterMap(
    $_REQUEST['wing'], $_REQUEST['floor'], $_REQUEST['cluster']
);

if ($html_output != false) {
    $response->addJSON('message', $html_output);
    $response->addJSON('is_map', true);
} else {
    $response->addJSON(
        'message', HAA_generateErrorMessage($GLOBALS['error'])
    );
    $response->addJSON('is_map', false);
}
$response->response();
?>
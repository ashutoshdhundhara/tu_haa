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

if (isset($_SESSION['is_admin'])) {
    $is_admin = true;
} else {
    $is_admin = false;
}

// Generate cluster map.
$response = HAA_Response::getInstance();
$html_output = '';

// Check if user is logged in or not.
if (! HAA_checkLoginStatus($is_admin)) {
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

if ($_SESSION['allotment_status'] != 'SELECT' && ! $is_admin) {
    HAA_gotError(
        'You have already submitted room choice(s). Kindly refresh your page.'
    );
    $response->addHTML(HAA_generateErrorMessage($GLOBALS['error']));
    $response->addJSON(
        'message', HAA_generateErrorMessage($GLOBALS['error'])
    );
    $response->addJSON('not_logged_in', true);
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
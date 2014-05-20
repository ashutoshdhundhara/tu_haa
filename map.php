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
            'Either your are not logged in or your session has expired.'
        );
        $response->addHTML(HAA_generateErrorMessage($GLOBALS['error']));
    } else {
        if ($_SESSION['allotment_status'] != 'SELECT') {
            HAA_gotError(
                'You have already submitted room choice(s). Kindly refresh your page.'
            );
            $response->addHTML(HAA_generateErrorMessage($GLOBALS['error']));
        } else {
            $response->addHTML(HAA_getHtmlWingMap($_REQUEST['wing']));
        }
    }

    $response->response();
    exit;
}

// If there is an Ajax request to update wing map.
if (isset($_REQUEST['update_map']) && $_REQUEST['update_map'] == true
    && isset($_REQUEST['wing'])) {
    $response = HAA_Response::getInstance();
    // Validate wing name.
    if (! HAA_validateValue($_REQUEST['wing'], 'wing')
        || ! HAA_checkLoginStatus() || ! $_SESSION['allotment_status'] != 'SELECT') {
        $response->addJSON('cluster_data', false);
    } else {
        $wing_data = HAA_getWingData($_REQUEST['wing']);
        $cluster_data = array();
        while ($row = $wing_data->fetch()) {
            $cluster = $row['wing'] . $row['cluster'] . '-' . $row['floor'];
            $vacant_rooms = $row['vacant_rooms'];
            array_push($cluster_data,
                array('cluster' => $cluster, 'vacant_rooms' => $vacant_rooms)
            );
        }
        $response->addJSON('cluster_data', json_encode($cluster_data));
        $response->addJSON('update_time', date('F j, Y, g:i:s a', time()));
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
$header->setTitle('Map');
$html_output = '';

// Get the allotment status.
$process_status = ($_SESSION['process_status'] == 'DISABLED') ? false : true;
$html_output .= HAA_getHtmlHostelMap($process_status);

$response->addHTML($html_output);
$response->response();
?>
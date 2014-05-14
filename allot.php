<?php
/**
 * Handles two things:
 * 1) Verifies and allots rooms to a particular group.
 * 2) Handles final allocation of selected rooms to corresponding group members.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/allot.lib.php';

// Securely start session.
HAA_secureSession();

$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('allot.css', 'css');

// If user has submitted rooms choices.
if (isset($_POST['rooms_selected']) && $_POST['rooms_selected'] == true) {
    // Check if user is logged in or not.
    if (! HAA_checkLoginStatus()
        || ! isset($_POST['group_id'])
        || $_POST['group_id'] != $_SESSION['login_id']
        ) {
        HAA_gotError(
            'Either your are not logged in or your session has expired.'
        );
        $response->addJSON('not_logged_in', true);
        $response->addJSON(
            'message', HAA_generateErrorMessage($GLOBALS['error'])
        );
        $response->response();
        exit;
    }
    // Check allotment process status.
    if ($_SESSION['process_status'] != 'ENABLED') {
        HAA_gotError(
            $GLOBALS['allotment_process_status']['message']
        );
        $response->addJSON(
            'message', HAA_generateErrorMessage($GLOBALS['error'])
        );
        $response->response();
        exit;
    }
    // Verify if group has not already taken rooms.
    if ($_SESSION['allotment_status'] != 'SELECT') {
        HAA_gotError(
            'Your group has already taken rooms.'
        );
        $response->addJSON(
            'message', HAA_generateErrorMessage($GLOBALS['error'])
        );
        $response->response();
        exit;
    }
    // Validate room numbers.
    if (! HAA_validateRoomNumbers($_POST['selected_rooms'])) {
        $response->addJSON(
            'message', HAA_generateErrorMessage($GLOBALS['error'])
        );
        $response->response();
        exit;
    }
    // Everything fine upto now, book the rooms.
    $group_id = $_SESSION['login_id'];
    if (HAA_bookRooms($_POST['selected_rooms'], $group_id)) {
        $response->addJSON('book_success', true);
        $response->addJSON('message'
            , '<div class="success">'
            . '<h1 style="margin-top: 5em;">Successfully got the selected rooms.</h1>'
            . '</div>'
        );
    } else {
        $response->addJSON('book_success', false);
        $response->addJSON(
            'message', HAA_generateErrorMessage($GLOBALS['error'])
        );
    }
    $response->response();
    exit;
}

// If user has submitted final member-room mapping.
if (isset($_REQUEST['rooms_allocated']) && $_REQUEST['rooms_allocated'] == true) {
    if (! HAA_checkLoginStatus()) {
        HAA_gotError(
            'Either your are not logged in or your session has expired.<br>'
            . 'Please <a href="index.php">Login</a> to continue.'
        );
        $response->addHTML(
            '<div class="box gray_grad" style="width: 600px;">'
            . HAA_generateErrorMessage($GLOBALS['error'])
            . '</div>'
        );
        $response->response();
        exit;
    }
    // Check if group is eligible for this step.
    if ($_SESSION['allotment_status'] != 'ALLOT') {
        HAA_redirectTo('index.php');
    }
    // Validate all received roll numbers.
    $members_order = $_REQUEST['members_order'];
    if (! HAA_validateRollNumbers($members_order)) {
        $response->addHTML(
            '<div class="box gray_grad" style="width: 600px;">'
            . HAA_generateErrorMessage($GLOBALS['error'])
            . '</div>'
        );
        $response->response();
        exit;
    }
    // Everything fine upto here, allocate the rooms.
    $group_id = $_SESSION['login_id'];
    if (! HAA_allocateRooms($members_order, $group_id)) {
        $response->addHTML(
            '<div class="box gray_grad" style="width: 600px;">'
            . HAA_generateErrorMessage($GLOBALS['error'])
            . '</div>'
        );
        $response->response();
        exit;
    }
    HAA_redirectTo('index.php');
}

// Check if user is logged in or not.
if (! HAA_checkLoginStatus()) {
    HAA_redirectTo('index.php');
}

// Get allocation_status, required to display proper page.
$allotment_status = $_SESSION['allotment_status'];
$html_output = '';
switch ($allotment_status) {
    // Display room allocation form.
    case 'ALLOT':
        // If group_size is 1, skip this step.
        $group_size = $_SESSION['group_size'];
        if ($group_size == 1) {
            $group_id = $_SESSION['login_id'];
            $member = HAA_getMembers($group_id);
            $member = $member->fetch();
            $url = 'allot.php?rooms_allocated=true'
                . '&members_order[]=' . $member['roll_no'];
            HAA_redirectTo($url);
        }

        $header->addFile('allot.js', 'js');
        $header->setTitle('');
        $html_output = HAA_getHtmlAllocationForm();
        break;
    // Display completed form.
    case 'COMPLETE':
        $header->setTitle('');
        $html_output = HAA_getHtmlCompleteForm();
        break;
}

$response->addHTML($html_output);
$response->response();
?>
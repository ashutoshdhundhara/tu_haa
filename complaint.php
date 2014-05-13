<?php
/**
 * Handles Error Reporting.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/complaint.lib.php';
require_once 'libraries/mailConstants.inc.php';
require_once 'libraries/swiftmailer/lib/swift_required.php';

// If Form is submitted, process it.
if (isset($_REQUEST['submitted'])) {
    $response = HAA_Response::getInstance();
    
    $header = $response->getHeader();
    $header->addFile('complaint.css', 'css');

    // Parse and save form data.
    $save = HAA_saveErrorReport($_REQUEST);

    if ($save) {
        $response->addHTML($GLOBALS['message']);
    } else {
        $response->addHTML(
            '<div class="report_complaint gray_grad box">'
            . HAA_generateErrorMessage($GLOBALS['error'])
            . '</div>'
        );
    }
    $response->response();
    exit;
}

// Display Error Reporting form.
$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('complaint.css', 'css');
$header->setTitle('');
$html_output = '';

$html_output .= HAA_getHtmlErrorReportForm();

$response->addHTML($html_output);
$response->response();
?>
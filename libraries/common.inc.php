<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/**
 * Common stuff required by all scripts.
 * MUST be included in every script.
 */

/**
 * Block attempts to directly run this script
 */
if (getcwd() == dirname(__FILE__)) {
    die('Attack stopped');
}

/**
 * Protect against possible exploits - there is no need to have so much variables
 */
if (count($_REQUEST) > 1000) {
    die('Possible exploit');
}

/**
 * For verification in every script.
 */
define('TU_HAA', true);

/**
 * Used to messages.
 */
require_once 'libraries/Message.class.php';
/**
 * Used to generate the page
 */
require_once 'libraries/Response.class.php';
/**
 * Contains functions common to all scripts.
 */
require_once 'libraries/core.lib.php';
/**
 * Main interface class for all database interactions.
 */
require_once 'libraries/DatabaseInterface.class.php';
/**
 * Library for all authentication and authorization tasks.
 */
require_once 'libraries/security.lib.php';

/**
 * Set default timezone.
 */
date_default_timezone_set('Asia/Calcutta');

/**
 * Global DBI class instance.
 */
$GLOBALS['dbi'] = new HAA_DatabaseInterface();
/**
 * Global array to store errors
 */
$GLOBALS['error'] = array();
/**
 * Global array to store success messages.
 */
$GLOBALS['message'] = array();

/**
 * Allotment process status.
 */
$GLOBALS['allotment_process_status'] = HAA_getAllotmentProcessStatus();
?>
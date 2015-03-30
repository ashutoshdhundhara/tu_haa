<?php
/**
 * Logout process script.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

// Securely start session.
HAA_secureSession();

// Check if admin.
$is_admin = (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) ? true : false;

// Unset all session variables.
$_SESSION = array();

// Get session parameters.
$params = session_get_cookie_params();

// Delete the actual cookie.
setcookie(
    session_name(),
    '',
    time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
);

// Destroy session
session_destroy();

// Redirect back to login page.
if ($is_admin) {
    HAA_redirectTo('jadmin.php');
} else {
    HAA_redirectTo('index.php');
}
?>
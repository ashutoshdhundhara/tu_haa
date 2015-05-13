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

HAA_logout();

// Redirect back to login page.
if ($is_admin) {
    HAA_redirectTo('jadmin.php');
} else {
    HAA_redirectTo('index.php');
}
?>
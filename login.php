<?php
/**
 * Login process script.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/recaptcha/recaptchalib.php';

// Start a secure session.
HAA_secureSession();

// Validate captcha, if set.
if (isset($_SESSION['show_captcha'])) {
    $captcha_verify = recaptcha_check_answer(
        captchaPrivateKey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]
    );
    // If entered captcha is invalid.
    if (! $captcha_verify->is_valid) {
        $_SESSION['login_error'] = 'Entered captcha is invalid.';
        HAA_redirectTo('index.php');
    }
}

// Check if all request parameters set.
if (
    isset($_POST['haa_username'])
    && isset($_POST['haa_password'])
    && HAA_isLoginEnabled() == 'ENABLED'
) {
    $group_id = $_POST['haa_username'];
    $password = $_POST['haa_password'];
    // Validate credentials.
    if (HAA_secureLogin($group_id, $password)) {
        HAA_pageCheck();
    } else {
        HAA_redirectTo('index.php');
    }
} else {
    HAA_redirectTo('index.php');
}
?>
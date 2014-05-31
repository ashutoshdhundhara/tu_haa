<?php
/**
 * Default script.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/recaptcha/recaptchalib.php';

// Start a secure session.
HAA_secureSession();
// Redirect user to correct page.
HAA_pageCheck();

$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('minified/login.js', 'js');
$header->addFile('minified/login.css', 'css');
$header->setTitle('Home');
$html_output = '';
$login_error = '';
$recaptcha = '';

// If to show captcha error message.
if (isset($_GET['captcha_error']) && $_GET['captcha_error'] == true) {
    $login_error = '<tr>'
        . '<td colspan="2" class="red">'
        . 'Entered captcha is invalid.'
        . '</td>'
        . '</tr>';
}

// If to show login error message.
if (isset($_GET['login_error']) && $_GET['login_error'] == true) {
    $login_error = '<tr>'
        . '<td colspan="2" class="red">'
        . 'Invalid Login ID or Password.'
        . '</td>'
        . '</tr>';
}

// If to show Captcha.
if (isset($_SESSION['show_captcha'])) {
    $recaptcha = '<tr>'
        . '<td colspan="2">'
        . recaptcha_get_html(captchaPublicKey)
        . '</td>'
        . '</tr>';
}

// Check if login is enabled or not.
if (HAA_isloginEnabled() != 'ENABLED') {
    $login_error = '<tr>'
        . '<td colspan="2" class="red">'
        . HAA_getLoginStatusMessage()
        . '</td>'
        . '</tr>';
}

// Build login form. --START--
$html_output .= '<form id="login_form" class="login_form gray_grad box"'
    . ' action="login.php" method="POST">'
    . '<table>'
    . '<caption>LOGIN</caption>'
    . '<tbody>'
    . $login_error
    . '<tr><td><label for="input_username">Login ID:</label></td>'
    . '<td>'
    . '<input type="text" name="haa_username" id="input_username"'
    . ' title="Please provide your Group ID/Login ID">'
    . '</td></tr>'
    . '<tr><td><label for="input_password">Password:</label></td>'
    . '<td>'
    . '<input type="password" name="haa_password" id="input_password"'
    . ' title="Please provide your password">'
    . '</td></tr>'
    . $recaptcha
    . '<tr><td colspan="2">'
    . '<input class="submitBtn" type="submit" name="submit" value="Login">'
    . '</td></tr>'
    . '<tr><td colspan="2"><a href="register.php">Register</a></td></tr>'
    . '<tr><td colspan="2"><a href="group.php">Create Group</a></td></tr>'
    . '</tbody>'
    . '</table>'
    . '</form>';
// Build login form. --END--

$response->addHTML($html_output);
$response->response();
?>
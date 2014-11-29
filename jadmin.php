<?php
/**
 * Admin page.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/jadmin.lib.php';
require_once 'libraries/recaptcha/recaptchalib.php';

// Start a secure session.
HAA_secureSession();

$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->disableGlobalMessage();
$header->addFile('jquery/jquery-uniform.js', 'js');
$header->addFile('jquery/jquery.maskedinput.min.js', 'js');
$header->addFile('jadmin.js', 'js');
$header->addFile('jadmin.css', 'css');
$header->setTitle('Admin');
$html_output = '';


// Request for login.
if (isset($_POST['haa_username'])
    && isset($_POST['haa_password'])
) {

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
            HAA_redirectTo('jadmin.php?captcha_error=true');
        }
    }

    $admin_id = $_POST['haa_username'];
    $password = $_POST['haa_password'];
    // Validate credentials.
    if (! HAA_secureLogin($admin_id, $password, true)) {
        HAA_redirectTo('jadmin.php?login_error=true');
    }
}

// If admin is not logged in, display login form.
if (! HAA_checkLoginStatus(true)) {
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
            . 'Invalid Admin ID or Password.'
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

    // Build login form. --START--
    $html_output .= '<form id="login_form" class="login_form gray_grad box"'
        . ' action="jadmin.php" method="POST">'
        . '<table>'
        . '<caption>LOGIN</caption>'
        . '<tbody>'
        . $login_error
        . '<tr><td><label for="input_username">Admin ID:</label></td>'
        . '<td>'
        . '<input type="text" name="haa_username" id="input_username"'
        . ' title="Please provide your Admin ID">'
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
        . '</tbody>'
        . '</table>'
        . '</form>';
    // Build login form. --END--

    $response->addHTML($html_output);
    $response->response();
    exit;
}

// Admin form submitted.
if (isset($_POST['submit_type'])) {
    switch ($_POST['submit_type']) {
    default:
        break;
    }

    exit;
}

$html_output .= '<div class="admin_page gray_grad box">'
    . '<h2>Hostel Administration</h2>'
    . '<div class="admin_content">';


$html_output .= '</div></div>';

$response->addHTML($html_output);
$response->response();

?>
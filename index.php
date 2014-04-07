<?php
/**
 * Default script.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->addFile('login.js', 'js');
$header->addFile('login.css', 'css');
$header->setTitle('');
$html_output = '';

// Build login form. --START--
$html_output .= '<form id="login_form" class="login_form gray_grad box"'
    . ' action="login.php" method="POST">'
    . '<table>'
    . '<caption>LOGIN</caption>'
    . '<tbody>'
    . '<tr><td><label for="input_username">Login ID:</label></td>'
    . '<td>'
    . '<input type="text" name="haa_username" id="input_username"'
    . ' title="Please provide your Group ID">'
    . '</td></tr>'
    . '<tr><td><label for="input_password">Password:</label></td>'
    . '<td>'
    . '<input type="password" name="haa_password" id="input_password"'
    . ' title="Please provide your password">'
    . '</td></tr>'
    . '<tr><td colspan="2">'
    . '<input class="submitBtn" type="submit" name="submit" value="Login">'
    . '</td></tr>'
    . '<tr><td colspan="2"><a href="#">Register</a></td></tr>'
    . '<tr><td colspan="2"><a href="#">Create Group</a></td></tr>'
    . '</tbody>'
    . '</table>'
    . '</form>';
// Build login form. --END--

$response->addHTML($html_output);
$response->response();
?>
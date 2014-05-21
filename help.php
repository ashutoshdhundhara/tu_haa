<?php
/**
 * Help page.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->disableGlobalMessage();
$header->addFile('jquery/jquery.tools.min.js', 'js');
$header->addFile('help.js', 'js');
$header->addFile('help.css', 'css');
$header->addFile('simple_overlay.css', 'css');
$header->setTitle('Help');

$html_output = '<div class="help_content gray_grad box">'
    . '<h2>Instructions</h2>'
    . '<h2>Step-1 : Registration :</h2>'
    . '<ul style="list-style-type: disc;">'
    . '<li>Goto <a href="register.php" class="blue" target="_blank">Register</a>'
    . ' page and fill in your Personal details.<br>'
    . '<strong>NOTE : </strong>You will be able'
    . ' to register only if you have been allotted Hostel-J on Web Kiosk.'
    . '</li>'
    . '<li>Now, you must decide whether you want to take Rooms in a <strong>Group</strong>'
    . ' (of 2-11 students) or <strong>Individually</strong>.</li>'
    . '<li>After successful registration, you will receive a '
    . '<a href="#" class="blue" rel="#simple_overlay" data-file="snapshot_uid.png">Unique ID</a>. Keep it'
    . ' safe. The ID will also be emailed to you.</li>'
    . '<li>If you choose to take a room <strong>Individually</strong> '
    . 'then you have to choose a password and you will get a <strong>Login ID</strong>.</li>'
    . '</ul>'
    . '<h2>Step-2 : Group Formation :</h2>'
    . '<ul style="list-style-type: disc;">'
    . '<li>If you have registered to take room <strong>Individually</strong>'
    . ' in the <strong>Step-1</strong>, then skip this step.</li>'
    . '<li>After all members have registered, goto '
    . '<a href="group.php" class="blue" target="_blank">Create Group</a> page.'
    . '</li>'
    . '<li>Select the group size and fill out the Roll Numbers and the respective'
    . ' Unique IDs of the members. Choose a password for the group Login ID.</li>'
    . '<li>On successful submission, a group <strong>Login ID</strong> '
    . 'will be created.</li>'
    . '</ul>'
    . '<h2>Step-3 : Room Allotment :</h2>'
    . '<ul style="list-style-type: disc;">'
    . '<li>Now, when Room Allotment starts, you have to login into the system '
    . 'using corresponding Login ID.'
    . '</li>'
    . '<li>Choose a Cluster from <a href="#" class="blue" rel="#simple_overlay"'
    . ' data-file="snapshot_uid.png">Wing-Map</a>.'
    . '</li>'
    . '<li>Choose room(s) from <a href="#" class="blue" rel="#simple_overlay"'
    . ' data-file="snapshot_uid.png">Cluster-Map</a> '
    . 'and submit choices.'
    . '</li>'
    . '</ul>';

// Overlay container.
$html_output .= '<div class="simple_overlay" id="simple_overlay">'
    . '<img id="overlay_image" src="" />'
    . '<div class="details">'
    . '<h2></h2>'
    . '<p></p>'
    . '</div>'
    . '</div>'
    . '</div>';

$response->addHTML($html_output);
$response->response();
?>
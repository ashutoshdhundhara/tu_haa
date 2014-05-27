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
$header->addFile('minified/help.js', 'js');
$header->addFile('minified/help.css', 'css');
$header->addFile('minified/simple_overlay.css', 'css');
$header->setTitle('Instructions');

$html_output = '<div class="help_content gray_grad box">'
    . '<h2>Instructions</h2>'
    . '<h2>Step-1 : Registration :</h2>'
    . '<ul style="list-style-type: disc;">'
    . '<li>Go to <a href="register.php" class="blue" target="_blank">Register</a>'
    . ' page and fill in your Personal details.<br>'
    . '<strong>NOTE : </strong>You will be able'
    . ' to register only if you have been allotted Hostel-J on Web Kiosk.'
    . '</li>'
    . '<li>For registration, use the '
    . '<a href="#" class="blue" rel="#simple_overlay" data-file="snapshot_unique_ID.png">Passkey</a>'
    . ' you received on Web-Kiosk.</li>'
    . '<li>Now, you must decide whether you want to take Rooms in a '
    . '<a href="#" class="blue" rel="#simple_overlay" data-file="snapshot_group.png">Group</a>'
    . ' (of 2-11 students) or '
    . '<a href="#" class="blue" rel="#simple_overlay" data-file="snapshot_individual.png">Individually</a>.</li>'
    . '<li>If you choose to take a room <strong>Individually</strong> '
    . 'then you have to choose a password. In this case, your Unique ID generated on Web-Kiosk '
    . 'will be used as your Login ID to take rooms.</li>'
    . '</ul>'
    . '<h2>Step-2 : Group Formation :</h2>'
    . '<ul style="list-style-type: disc;">'
    . '<li>If you have registered to take room <strong>Individually</strong>'
    . ' in the <strong>Step-1</strong>, then skip this step.</li>'
    . '<li>After all members have registered, go to '
    . '<a href="group.php" class="blue" target="_blank">Create Group</a> page.'
    . '</li>'
    . '<li>Select the group size and fill out the necessary details.'
    . ' </li>'
    . '<li>On successful submission, a group '
    . '<a href="#" class="blue" rel="#simple_overlay" data-file="snapshot_groupID.png">Login ID</a> '
    . 'will be created. Use this Login ID to take rooms for the entire group.</li>'
    . '</ul>'
    . '<h2>Step-3 : Room Allotment :</h2>'
    . '<ul style="list-style-type: disc;">'
    . '<li>Now, when Room Allotment starts, you have to login into the system '
    . 'using corresponding Login ID.'
    . '</li>'
    . '<li>Choose a Cluster from <a href="#" class="blue" rel="#simple_overlay"'
    . ' data-file="snapshot_wingmap.png">Wing-Map</a>.'
    . '</li>'
    . '<li>Choose room(s) from <a href="#" class="blue" rel="#simple_overlay"'
    . ' data-file="snapshot_clustermap.png">Cluster-Map</a> '
    . 'and submit choices.'
    . '</li>'
    . '<li>You will get the selected rooms based on availability.'
    . '</li>'
    . '<li>After getting the rooms, you can '
    . '<a href="#" class="blue" rel="#simple_overlay" data-file="snapshot_reorder.png">reorder</a> '
    . 'them to assign rooms to members of the group.'
    . '</li>'
    . '</ul>'
    . '<strong>NOTE</strong>: In case of any further issues, you can report them on our'
    . ' <a href="complaint.php" class="blue" target="_blank">Support</a> page.';

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
<?php
/**
 * Functions required for admin page.
 */

if (! defined('TU_HAA')) {
    exit;
}

function HAA_getHtmlPrintForm()
{
    $retval = '<h3>Print Registration Form(s)</h3>';
    $retval .= '<div>'
        . '<form method="POST" action="jadmin.php">'
        . '<input type="hidden" name="submit_type" value="print_form">'
        . '<table class="admin_form">'
        . '<tr>'
        . '<td><lablel for="print_roll_no">By Roll No :</lablel></td>'
        . '<td><input type="text" class="roll_no" id="print_roll_no" name="roll_no" ></td>'
        . '</tr>'
        . '<tr>'
        . '<tr>'
        . '<td><lablel for="print_wing">By Wing :</lablel></td>'
        . '<td>'
        . '<lablel for="print_west_wing">West Wing</lablel>'
        . '<input type="radio" name="wing" value="W" id="print_west_wing">'
        . '<lablel for="print_east_wing">East Wing</lablel>'
        . '<input type="radio" name="wing" value="E" id="print_east_wing">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><lablel for="print_cluster">By Cluster :</lablel></td>'
        . '<td><input type="text" class="cluster" id="print_cluster" name="cluster" ></td>'
        . '</tr>'
        . '<tr>'
        . '<tr>'
        . '<td colspan="2">'
        . '<input type="submit" name="submit" value="Print">'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form></div>';

    return $retval;
}

/**
 * 
 */
function HAA_getHtmlShowMap()
{
    $html_output = '<h3>Hostel Map</h3>'
        . '<div>'
        . '<center>'
        . '<a href="map.php" target="_blank"><button>Show Map</button></a>'
        . '</center>'
        . '</div>';

    return $html_output;
}

function HAA_getHtmlResidentDetails()
{
    $html_output = '<h3>Resident(s) Details</h3>'
        . '<div>'
        . '<form action="" method="POST" id="resident_details">'
        . '<input type="hidden" name="submit_type" value="resident_details">'
        . '<table>'
        . '<tr>'
        . '<td>'
        . '<label for="input_room_no">Room No. : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_room_no" name="room_no" class="room_no">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_cluster">Cluster : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_cluster" name="cluster" class="cluster">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2">'
        . '<center><input type="submit" name="submit" value="Show"></center>'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>'
        . '</div>';

    return $html_output;
}

function HAA_getHtmlSearchResidents()
{
    $html_output = '<h3>Search Resident(s)</h3>'
        . '<div>'
        . '<form action="" method="POST" id="resident_search">'
        . '<input type="hidden" name="submit_type" value="resident_search">'
        . '<table>'
        . '<tr>'
        . '<td>'
        . '<label for="input_name">Name : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_name" name="name">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_roll_no">Roll No. : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_roll_no" name="roll_no" class="roll_no">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_class">Class : </label>'
        . '</td>'
        . '<td>'
        . HAA_getHtmlSelectClass()
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_year">Year : </label>'
        . '</td>'
        . '<td>'
        . HAA_getHtmlSelectYear()
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_branch">Branch : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_branch" name="branch">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_blood">Blood Group : </label>'
        . '</td>'
        . '<td>'
        . HAA_getHtmlSelectBloodGroup()
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2">'
        . '<center><input type="submit" name="submit" value="Search"></center>'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>'
        . '</div>';

    return $html_output;
}
?>
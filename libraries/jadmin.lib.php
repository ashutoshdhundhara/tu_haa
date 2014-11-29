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


?>
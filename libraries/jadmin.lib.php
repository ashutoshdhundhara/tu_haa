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
        . '<form action="jadmin.php" method="POST" id="resident_details">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<input type="hidden" name="submit_type" value="resident_details">'
        . '<table>'
        . '<tr>'
        . '<td>'
        . '<label for="input_find_room_no">Room No. : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_find_room_no" name="room_no" class="room_no">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_find_cluster">Cluster : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_find_cluster" name="cluster" class="cluster">'
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
        . '<form action="jadmin.php" method="POST" id="resident_search">'
        . '<input type="hidden" name="ajax_request" value="true">'
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
        . '<label for="input_search_roll_no">Roll No. : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_search_roll_no" name="roll_no" class="roll_no">'
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

function HAA_getHtmlFillRoom()
{
    $html_output = '<h3>Fill Room</h3>'
        . '<div>'
        . '<form action="jadmin.php" method="POST" id="fill_room">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<input type="hidden" name="submit_type" value="fill_room">'
        . '<table>'
        . '<tr>'
        . '<td>'
        . '<label for="input_fill_room_no">Room No : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_fill_room_no" name="room_no" class="room_no">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_fill_roll_no">Roll No : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_fill_roll_no" name="roll_no" class="roll_no">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2">'
        . '<center><input type="submit" name="submit" value="Fill"></center>'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>'
        . '</div>';

    return $html_output;
}

function HAA_getHtmlVacateRoom()
{
    $html_output = '<h3>Vacate Room(s)</h3>'
        . '<div>'
        . '<form action="jadmin.php" method="POST" id="vacate_room">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<input type="hidden" name="submit_type" value="vacate_room">'
        . '<table>'
        . '<tr>'
        . '<td>'
        . '<label for="input_vacate_room_no">Room No : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_vacate_room_no" name="room_no" class="room_no">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<input type="checkbox" id="input_vacate_all" name="vacate_all">'
        . '<label for="input_vacate_all" class="red">Vacate All</label>'
        . '</td>'
        . '<td>'
        . '<label for="input_exclusion_list">Exclude : </label>'
        . '<input disabled="disabled" type="file" class="required" id="input_exclusion_list" name="exclusion_list" accept="text/*"'
        . ' title="Provide a list of comma seprated Room numbers which are not to be vacated.">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2">'
        . '<center><input type="submit" name="submit" value="Vacate"></center>'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>'
        . '</div>';

    return $html_output;
}

function HAA_getHtmlReserveRoom()
{
    $html_output = '<h3>Reserve Room(s)</h3>'
        . '<div>'
        . '<form action="jadmin.php" method="POST" id="reserve_room">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<input type="hidden" name="submit_type" value="reserve_room">'
        . '<table>'
        . '<tr>'
        . '<td>'
        . '<label for="input_room_no">Room No : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_room_no" name="room_no" class="room_no">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_reserve_cluster">Cluster : </label>'
        . '</td>'
        . '<td>'
        . '<input type="text" id="input_reserve_cluster" name="cluster" class="cluster">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . '<label for="input_reserve_list">Rooms List : </label>'
        . '</td>'
        . '<td>'
        . '<input type="file" class="required" id="input_reserve_list" name="reserve_list" accept="text/*"'
        . ' title="Provide a list of comma seprated Room numbers which are to be reserved.">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2">'
        . '<center><input type="submit" name="submit" value="Reserve">'
        . '&nbsp;&nbsp;&nbsp;&nbsp;'
        . '<input type="submit" name="submit" value="Unreserve"></center>'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>'
        . '</div>';

    return $html_output;
}

function HAA_getHtmlAllotmentStatus()
{
    $allotment_status = HAA_getAllotmentProcessStatus();
    $process_enabled = ($allotment_status['process_status'] == 'ENABLED') ? true : false;
    $show_message = $allotment_status['show_message'];
    $checked = ' checked="checked" ';
    
    $html_output = '<h3>Allotment Staus</h3>'
        . '<div>'
        . '<form action="jadmin.php" method="POST" id="allotment_status">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<input type="hidden" name="submit_type" value="allotment_status">'
        . '<table>'
        . '<tr>'
        . '<td>'
        . 'Allotment Status : '
        . '</td>'
        . '<td class="radio">'
        . '<label for="input_allotment_enabled">Enabled</label>'
        . '<input type="radio" id="input_allotment_enabled" name="process_status"'
        . ($process_enabled ? $checked : '') . ' value="ENABLED">'
        . '<label for="input_allotment_disabled">Disabled</label>'
        . '<input type="radio" id="input_allotment_disabled" name="process_status"'
        . (!$process_enabled ? $checked : '') . ' value="DISABLED">'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>'
        . 'Global Message : '
        . '</td>'
        . '<td class="radio">'
        . '<label for="input_message_show">Show</label>'
        . '<input type="radio" id="input_message_show" name="show_message" value="SHOW"'
        . ($show_message ? $checked : '') . '>'
        . '<label for="input_message_hide">Hide</label>'
        . '<input type="radio" id="input_message_hide" name="show_message" value="HIDE"'
        . (!$show_message ? $checked : '') . '>'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td style="vertical-align: middle;">'
        . 'Message : '
        . '</td>'
        . '<td>'
        . '<textarea name="message" style="margin: 0px; width: 250px; height: 67px;">'
        . $allotment_status['message']
        . '</textarea>'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2">'
        . '<center><input type="submit" name="submit" value="Update"></center>'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>'
        . '</div>';

    return $html_output;
}

function HAA_getHtmlExportLists()
{
    $html_output = '<h3>Export lists</h3>'
        . '<div>'
        . '<center>'
        . '<a href="jadmin.php?submit_type=export_lists&list=students" target="_blank"><button>Student list</button></a>'
        . '&nbsp;&nbsp;&nbsp;&nbsp;'
        . '<a href="jadmin.php?submit_type=export_lists&list=rooms" target="_blank"><button>Rooms list</button></a>'
        . '</center>'
        . '</div>';

    return $html_output;
}

/**
 * Exports a given table to .csv file.
 * 
 * @param string $table_name Name of the table to export
 */
function HAA_exportCSV($table_name)
{
    $file_name = $table_name . '_' . date('d_m_Y', time()) . '.csv';
    $content = HAA_getTableData($table_name);
    
    // Send file download headers.
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=" . $file_name);
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $columns = implode('", "', $content['columns']);
    echo '"' . $columns . '"' . "\n";
    while ($row = $content["data"]->fetch(PDO::FETCH_NUM)) {
        echo '"' . implode('", "', $row) . '"' . "\n";
    }
    
    exit;
}

function HAA_handleChangeAllotmentStatus()
{
    global $response;
    $process_status = (isset($_REQUEST['process_status']) 
        && in_array($_REQUEST['process_status'], array('ENABLED', 'DISABLED'))
    ) ? $_REQUEST['process_status'] : 'DISABLED';

    $show_message = (isset($_REQUEST['show_message']) 
        && in_array($_REQUEST['show_message'], array('SHOW', 'HIDE'))
    ) ? $_REQUEST['show_message'] : 'HIDE';

    $message = (isset($_REQUEST['message'])) ? $_REQUEST['message'] : '';
    $allot_status = array(
        'process_status' => $process_status,
        'show_message' => $show_message,
        'message' => $message
    );
    $result = HAA_updateAllotmentStatus($allot_status);

    if ($result) {
        $response->addJSON('message', 
            '<div class="success">'
            . '<h1 style="margin-top: 5em;">Successfully updated settings.</h1>'
            . '</div>'
        );
        $response->addJSON('save', true);
    } else {
        $response->addJSON(
                'message',
                HAA_generateErrorMessage(array('An error occurred.'))
        );
        $response->addJSON('save', false);
    }
}

function HAA_handleVacateRoomRequest()
{
    /**
     * To vacate a Room:
     * In `rooms_info`:
     * 1. Change its `room_status` to 'AVAILABLE'.
     * 2. Change its `group_id` to NULL.
     * In `student_details`:
     * 1. Remove the record with the given room no.
     */
    global $respone;
}

function HAA_handleExportRequest()
{
    if (isset($_REQUEST['list'])) {
        if ($_REQUEST['list'] == 'students') {
            HAA_exportCSV(tblStudent);
        } elseif ($_REQUEST['list'] == 'rooms') {
            HAA_exportCSV(tblRoom);
        }
    }
}
?>
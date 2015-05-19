<?php
/**
 * Script to setup database.
 */

/**
 * Get all required libraries.
 */
chdir('..');
require_once 'libraries/common.inc.php';

/**
 * Creates tables.
 */
function HAA_createTables()
{
    $success = true;
    // Load SQL file contents.
    $sql_file = file_get_contents('setup/HostelJ.sql');
    // Queries.
    $sql_queries = explode(';', $sql_file);
    // Execute the queries.
    foreach ($sql_queries as $key => $sql_query) {
        $result = $GLOBALS['dbi']->executeQuery($sql_query, array());
        if ($result == false) {
            $success = false;
        }
    }

    return $success;
}

/**
 * Populates `tblRoom`.
 */
function HAA_populateTblRoom()
{
    // Wings.
    $wings = array('W', 'E');
    // Clusters.
    $clusters = array('A', 'B', 'C', 'D', 'E', 'F');
    // Floors.
    $floors = array('1', '2', '3', '4', '5', '6', '7', '8');
    // Rooms.
    $room_nos = array(
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11'
    );
    // Clusters to skip.
    $skip_clusters = array(
        'EC-1',
        'ED-1',
        'EC-2',
        'ED-2',
        'EA-7',
        'EF-7',
        'EA-8',
        'EB-8',
        'EE-8',
        'EF-8',
        'WC-1',
        'WD-1',
        'WA-7',
        'WF-7',
        'WA-8',
        'WB-8',
        'WE-8',
        'WF-8'
    );
    $query_params = array();
    foreach ($wings as $key => $wing) {
        foreach ($floors as $key => $floor) {
            foreach ($clusters as $key => $cluster) {
                if (in_array($wing . $cluster . '-' . $floor,
                    $skip_clusters)) {
                    continue;
                }
                foreach ($room_nos as $key => $room_no) {                    
                    array_push($query_params,
                        "('" . $wing . "', '" . $floor . "', '" . $cluster . "', '"
                            . $room_no . "', 'AVAILABLE', 'NULL')"
                    );
                }
            }
        }
    }
	
    // SQL query.
    $sql_query = 'INSERT IGNORE INTO `' . tblRoom . '` '
        . '(`wing`, `floor`, `cluster`, `room_no`, `room_status`, `group_id`) '
        . 'VALUES ' . implode(', ', $query_params);
	
	echo $sql_query;
    // Execute the query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query, array());

    if ($result == false) {
        echo 'Failed to populate `tblRoom`.' . '<br>';
        return false;
    } else {
        echo 'Successfully populated `tblRoom`.' . '<br>';
        return true;
    }
}

if (HAA_createTables()) {
    echo 'Successfully created tables.' . '<br>';
    HAA_populateTblRoom();
} else {
    echo 'Failed to create tables.' . '<br>';
}
?>
<?php
/**
 * Contains functions required by Hostel map page.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Generates Html for Hostel Map.
 *
 * @param string $type Type of map, selectable or not
 * @return string Html containing Map.
 */
function HAA_getHtmlHostelMap($selectable = true)
{
    $retval = '<div id="wing_tabs" class="wing_tabs gray_grad box">'
        . '<ul>'
        . '<li data-wing="E">'
        . '<a href="map.php?wing_map=true&wing=E">East Wing</a>'
        . '</li>'
        . '<li data-wing="W">'
        . '<a href="map.php?wing_map=true&wing=W">West Wing</a>'
        . '</li>'
        . '</ul>'
        . '</div>';
    // Set JS variable for group size.
    $group_size = $_SESSION['group_size'];
    $retval .= '<script>'
        . 'var group_size = ' . $group_size . '; '
        . 'var selected_rooms = 0; '
        . 'var process_status = ' . (($selectable) ? 'true' : 'false') . ';'
        . '</script>';
    $retval .= HAA_getHtmlSideBar($group_size);

    return $retval;
}

/**
 * Generates Html for Side Bar displayed on Room selection page.
 *
 * @param string $group_size Size of the group
 * @return string       Html
 */
function HAA_getHtmlSideBar($group_size = '0')
{
    $retval = '';

    $retval .= '<div class="side_bar gray_grad box">'
        . '<p>'
        . 'Rooms selected <span id="num_selected_rooms" class="blue">0</span>'
        . ' of <span class="red">' . $group_size . '</span>'
        . '</p>'
        . '<ul class="selected_rooms_list" id="selected_rooms_list">'
        . '</ul>'
        . '<form id="rooms_form" action="allot.php" method="POST">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<input type="hidden" name="rooms_selected" value="true">'
        . '<input type="hidden" name="group_id" value="'
        . $_SESSION['login_id'] . '">'
        . '</form>'
        . '</div>';

    return $retval;
}

/**
 * Generates Map of a particular wing and return Html
 *
 * @param string $wing Wing ('E' or 'W')
 * @return string Html containing Wing Map
 */
function HAA_getHtmlWingMap($wing = 'E')
{
    // Get wing data.
    $wing_data = HAA_getWingData($wing);
    // Start with current timestamp.
    date_default_timezone_set('Asia/Calcutta');
    $retval = '<div class="wing_map">'
        . '<div class="update_time">'
        . '<strong>Last Update : </strong>'
        . '<span>' . date('F j, Y, g:i:s a', time()) . '</span>'
        . '</div>';
    $retval .= '<ul><li class="red">LEVEL 1:</li>';
    // Variable to keep track of previous floor number.
    $prev_floor = '1';
    while ($row = $wing_data->fetch(PDO::FETCH_ASSOC)) {
        // If previous floor number is not equal to current, create a new list.
        if ($prev_floor != $row['floor']) {
            $retval .= '</ul><ul><li class="red">LEVEL '
                . $row['floor'] . ':</li>';
        }
        // Cluster name in 'WA-5' format.
        $cluster_name = $row['wing'] . $row['cluster'] . '-' . $row['floor'];
        // To display vacant_rooms count in red if 0 else in blue color.
        $class = ((int)$row['vacant_rooms'] == 0) ? 'red' : 'blue';
        // Create a new <li> element for each cluster.
        $retval .= '<li><a class="button_grad cluster_anchor"'
            . 'href="cluster.php?ajax_request=true'
            . '&wing=' . urlencode($row['wing'])
            . '&cluster=' . urlencode($row['cluster'])
            . '&floor=' . urlencode($row['floor'])
            . '"><strong>' . $cluster_name . '</strong><br><span class="vacant_rooms">'
            . 'Vacant rooms: <span id="' . $cluster_name
            . '" class="'. $class . '">' . $row['vacant_rooms']
            . '</span></span></a></li>';

        // Update the $prev_floor.
        $prev_floor = $row['floor'];
    }
    $retval .= '</ul></div>';

    return $retval;
}

/**
 * Fetches data for particular wing (Vacant rooms count)
 *
 * @param string $wing Wing name
 * @return PDO Object PDO result object
 */
function HAA_getWingData($wing = 'E')
{
    // Sanitize Wing name.
    if (! HAA_validateValue($wing, 'wing')) {
        $wing = 'E';
    }

    // Correlated-SQL query to fetch Clusters and their Vacant rooms count.
    $sub_query = 'SELECT COUNT(*) '
        . 'FROM ' . tblRoom . ' '
        . 'WHERE wing = outer_table.wing '
        . 'AND floor = outer_table.floor '
        . 'AND cluster = outer_table.cluster '
        . 'AND room_status = :status';

    $sql_query = 'SELECT wing'
        . ', cluster'
        . ', floor'
        . ', (' . $sub_query .') AS vacant_rooms '
        . 'FROM ' . tblRoom . ' outer_table '
        . 'WHERE wing = :wing '
        . 'GROUP BY wing'
        . ', cluster'
        . ', floor '
        . 'ORDER BY floor ASC'
        . ', cluster ASC';


    // Execute the query.
    $result = $GLOBALS['dbi']->executeQuery(
        $sql_query, array(':wing' => $wing, ':status' => 'AVAILABLE')
    );

    return $result;
}
?>
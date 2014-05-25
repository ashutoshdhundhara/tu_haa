<?php
/**
 * Contains functions required for cluster map.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Generates Html for cluster map
 *
 * @param string $wing    Wing
 * @param string $floor   Floor number
 * @param string $cluster Cluster number
 *
 * @return string Html
 */
function HAA_getHtmlClusterMap($wing, $floor, $cluster, $selectable = true)
{
    $retval = '';
    $cluster_data = HAA_getClusterData($wing, $floor, $cluster);

    if ($cluster_data == false || $cluster_data->rowCount() < 11) {
        HAA_gotError(
            'Failed to generate Cluster map.'
        );
        return false;
    }

    $skip_blocks = array(
        5,
        7,
        8,
        9,
        10,
        11,
        17
    );

    for ($block=1;$block<=18;$block++) {
        $select_class = ($selectable) ? 'selectable' : '';
        if (! in_array($block, $skip_blocks)) {
            $row = $cluster_data->fetch();
            $class = ($row['room_status'] == 'AVAILABLE')
                ? 'room_available'
                : 'room_not_available';
            $room_no = $row['wing']
                . $row['cluster']
                . '-'
                . $row['floor']
                . $row['room_no'];
            $cell = '<td class="' . $class . ' ' . $select_class . '" '
                . 'data-room="' . $room_no . '">'
                . $room_no . '</td>';
        } else {
            $cell = '<td class="empty_block"></td>';
        }

        if (preg_match('/^[eE]$/', $wing)) {
            $retval .= $cell;
            if ($block%6 == 0 && $block !== 18) {
                $retval .= '</tr><tr>';
            }
        } else {
            $retval = $cell . $retval;
            if ($block%6 == 0 && $block !== 18) {
                $retval = '</tr><tr>' . $retval;
            }
        }
    }
    $north = '<div class="north">'
        . '&#8593;<br/>N'
        . '</div>';
    $guide = '<ul class="guide">'
        . '<li><span></span>Vacant</li>'
        . '<li><span class="green_grad"></span>Selected</li>'
        . '<li><span style="background-color: #999999;"></span>Occupied</li>'
        . '</ul>';
    $retval = $north . '<table class="cluster_map"><tr>' . $retval . '</tr></table>'
        . $guide;

    return $retval;
}

/**
 * Fetches cluster data from database
 *
 * @param string $wing    Wing
 * @param string $floor   Floor number
 * @param string $cluster Cluster number
 *
 * @return resource|bool  PDO object or false
 */
function HAA_getClusterData($wing, $floor, $cluster)
{
    if (! HAA_validateValue($wing, 'wing')
        && ! HAA_validateValue($floor, 'floor')
        && ! HAA_validateValue($cluster, 'cluster')
    ) {
        return false;
    }
    // SQL query to get room numbers in following sequence:
    // 1,2,3,4,5,6,11,10,09,08,07.
    $sql_query = '( SELECT * FROM ' . tblRoom . ' '
        . 'WHERE wing = :wing '
        . 'AND floor = :floor '
        . 'AND cluster = :cluster '
        . 'AND room_no <= 6 '
        . 'ORDER BY room_no ASC '
        . 'LIMIT 6 )'
        . 'UNION ALL '
        . '( SELECT * FROM ' . tblRoom . ' '
        . 'WHERE wing = :wing '
        . 'AND floor = :floor '
        . 'AND cluster = :cluster '
        . 'AND room_no > 6 '
        . 'ORDER BY room_no DESC '
        . 'LIMIT 5 )';
    // Query parameters.
    $query_params = array(
        ':wing' => $wing
        , ':floor' => $floor
        , ':cluster' => $cluster
    );
    // Execute the query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $query_params);

    return $result;
}
?>
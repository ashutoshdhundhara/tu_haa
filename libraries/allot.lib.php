<?php
/**
 * Functions required by allot.php
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Validates room numbers.
 *
 * @param array $room_no Array of room numbers
 *
 * @return bool
 */
function HAA_validateRoomNumbers($room_no)
{
    // If $room_no is not an array, something is fishy.
    if (! is_array($room_no)) {
        HAA_gotError(
            'Invalid data received.'
        );
        return false;
    }
    // Check each room number.
    foreach ($room_no as $key => $room) {
        if (! HAA_validateValue($room, 'room_no')) {
            HAA_gotError(
                'Invalid data received.'
            );
            return false;
        }
    }

    return true;
}

/**
 * Books rooms for a given group_id.
 *
 * @param array  $room_numbers Array containing selected room numbers
 * @param string $group_id     Group ID
 *
 * @return bool
 */
function HAA_bookRooms($room_numbers, $group_id)
{
    // Get the group size.
    $group_size = $_SESSION['group_size'];
    $room_list = implode('", "', $room_numbers);
    // Link to database.
    $link = $GLOBALS['db_link'];
    if (empty($link)) {
        HAA_gotError(
            'Failed to connect to database.'
        );
        return false;
    }
    // SQL query to if selected rooms are available or not.
    $select_query = 'SELECT CONCAT(wing, cluster, "-", floor, room_no) AS `full_room_no` '
        . 'FROM ' . tblRoom . ' '
        . 'WHERE CONCAT(wing, cluster, "-", floor, room_no) '
        . 'IN ("' .$room_list . '") '
        . 'AND `room_status` = :room_status '
        . 'FOR UPDATE';
    // SQL query to update room status.
    $update_query = 'UPDATE ' . tblRoom . ' '
        . 'SET `room_status` = :room_status'
        . ', `group_id` = :group_id '
        . 'WHERE CONCAT(wing, cluster, "-", floor, room_no) '
        . 'IN ("' .$room_list . '")';
    // SQL query to update allotment_status.
    $update_allot_status_query = 'UPDATE ' . tblGroupId . ' '
        . 'SET `allotment_status` = :allotment_status '
        . 'WHERE `group_id` = :group_id';

    try {
        // Begin Transaction.
        $link->beginTransaction();
        // Execute SELECT query.
        $stmt = $link->prepare($select_query);
        $stmt->execute(array(':room_status' => 'NOT_AVAILABLE'));

        // If any selected room is now gone.
        if ($stmt->rowCount() > 0) {
            $not_avail_rooms = array();
            while ($row = $stmt->fetch()) {
                array_push($not_avail_rooms, $row['full_room_no']);
            }
            HAA_gotError(
                '<span class="blue">' . implode(', ', $not_avail_rooms) . ' </span>'
                . ' room(s) are now <span class="red"> UNAVAILABLE</span>.'
            );
            return false;
        }
        $stmt->closeCursor();

        // Execute UPDATE query.
        $stmt = $link->prepare($update_query);
        $stmt->execute(array(':room_status' => 'NOT_AVAILABLE', ':group_id' => $group_id));
        $stmt->closeCursor();

        // Execute UPDATE allotment_status query.
        $stmt = $link->prepare($update_allot_status_query);
        $stmt->execute(array(':allotment_status' => 'ALLOT', ':group_id' => $group_id));
        $stmt->closeCursor();

        // Update session variable.
        $_SESSION['allotment_status'] = 'ALLOT';

        // Commit the Transaction.
        $link->commit();

        return true;
    } catch (Exception $excp) {
        // If anything goes wrong, rollback.
        HAA_gotError(
            'Failed to book rooms.'
        );
        $stmt->rollBack();
        return false;
    }
}

/**
 * Generates Html for member-room matching form.
 *
 * @return string|bool Html or false
 */
function HAA_getHtmlAllocationForm()
{
    $retval = '';
    // Get the group_id.
    $group_id = $_SESSION['login_id'];
    // Get the selected rooms by a particular group.
    $selected_rooms = HAA_getSelectedRooms($group_id);
    // Get group members list.
    $members = HAA_getMembers($group_id);

    // Check for errors.
    if ($selected_rooms == false || $members == false) {
        return false;
    }
    // Generate Html.
    $retval .= '<form action="allot.php" method="POST" class="box gray_grad allocation_form">'
        . '<div>Drag and re-order member names to assign rooms.</div>'
        . '<input type="hidden" name="rooms_allocated" value="true">';
    $retval .= '<ul class="rooms_list">'
        . '<li class="green_grad">Room</li>';
    while ($row = $selected_rooms->fetch()) {
        $retval .= '<li>' . $row['room_no'] . '</li>';
    }
    $retval .= '</ul>'
        . '<ul id="member_list" class="member_list">'
        . '<li class="green_grad">Occupant</li>';
    while ($row = $members->fetch()) {
        $retval .= '<li class="uniform_field draggable">'
            . '<input type="hidden" name="members_order[]" value="' . $row['roll_no'] . '">'
            . $row['full_name'] . ' (' . $row['roll_no'] . ')'
            . '</li>';
    }
    $retval .= '</ul>';
    $retval .= '<div style="clear: both; text-align: center; padding-top: 1em;">'
        . '<input type="submit" name="submit" value="Submit">'
        . '</div>';
    $retval .= '</form>';

    return $retval;
}

/**
 * Fetches selected rooms of a group from DB.
 *
 * @param string $group_id Group ID
 *
 * @return PDO statement|bool PDO statement or false
 */
function HAA_getSelectedRooms($group_id)
{
    // SQL query to fetch selected rooms for a group.
    $sql_query = 'SELECT CONCAT(wing, cluster, "-", floor, room_no) AS `room_no`'
        . 'FROM ' . tblRoom . ' '
        . 'WHERE `group_id` = :group_id '
        . 'ORDER BY wing, cluster, floor, room_no';
    // Execute the query.
    $query_params = array(':group_id' => $group_id);
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $query_params);

    if ($result == false) {
        HAA_gotError(
            'Failed to get selected rooms list.'
        );
        return false;
    }

    return $result;
}

/**
 * Fetches members details of a group from DB.
 *
 * @param string $group_id Group ID
 *
 * @return PDO statement|bool PDO statement or false
 */
function HAA_getMembers($group_id)
{
    // SQL query to get group members details.
    $sql_query = 'SELECT ' . tblGroup . '.`roll_no` AS `roll_no`'
        . ', ' . tblStudent . '.`full_name` AS `full_name`, '
        . tblStudent . '.`room_no` AS `room_no`'
        . 'FROM ' . tblGroup . ', ' . tblStudent . ' '
        . 'WHERE ' . tblGroup . '.' . '`roll_no` '
        . '= '
        . tblStudent . '.' . '`roll_no` '
        . 'AND ' . tblGroup . '.' . '`group_id` = :group_id '
        . 'ORDER BY `room_no`';
    // Execute the query.
    $query_params = array(':group_id' => $group_id);
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $query_params);

    if ($result == false) {
        HAA_gotError(
            'Failed to get members details.'
        );
        return false;
    }

    return $result;
}

/**
 * Validates roll numbers.
 *
 * @param array $roll_nos Array of roll numbers
 *
 * @return bool
 */
function HAA_validateRollNumbers($roll_nos)
{
    // Get the group_id and group_size.
    $group_id = $_SESSION['login_id'];
    $group_size = $_SESSION['group_size'];
    // $roll_nos must be an array.
    if (! is_array($roll_nos) || count($roll_nos) != $group_size) {
        HAA_gotError(
            'Invalid data received.'
        );
        return false;
    }
    // Check each roll no against regEx.
    foreach ($roll_nos as $key => $roll_no) {
        if (! HAA_validateValue($roll_no, 'integer')) {
            HAA_gotError(
                'Invalid data received.'
            );
            return false;
        }
    }
    // Verify if all members are of same group or not.
    $sql_query = 'SELECT `roll_no` FROM ' . tblGroup . ' '
        . 'WHERE `roll_no` IN ("' . implode('", "', $roll_nos) . '") '
        . 'AND `group_id` = :group_id';
    // Execute the query.
    $query_params = array(':group_id' => $group_id);
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $query_params);

    if ($result == false || $result->rowCount() != $group_size) {
        HAA_gotError(
            'Invalid data received.'
        );
        return false;
    }

    return true;
}

/**
 * Allocates rooms to group members for a given group_id.
 *
 * @param array  $roll_nos     Array containing roll numbers
 * @param string $group_id     Group ID
 *
 * @return bool
 */
function HAA_allocateRooms($roll_nos, $group_id)
{
    // Get group's selected room numbers.
    $selected_rooms = HAA_getSelectedRooms($group_id);
    // Create SQL query for the same.
    $sql_query = 'UPDATE ' . tblStudent . ' '
        . 'SET `room_no` = :room_no '
        . 'WHERE `roll_no` = :roll_no';
    // SQL query to update allotment_status.
    $update_allot_status_query = 'UPDATE ' . tblGroupId . ' '
        . 'SET `allotment_status` = :allotment_status '
        . 'WHERE `group_id` = :group_id';
    // Execute query for each member.
    foreach ($roll_nos as $key => $roll_no) {
        $room_no = $selected_rooms->fetch();
        $room_no = $room_no['room_no'];
        $query_params = array(':room_no' => $room_no, ':roll_no' => $roll_no);
        $result = $GLOBALS['dbi']->executeQuery($sql_query, $query_params);
        if ($result == false) {
            HAA_gotError(
                'Failed to update database. Please retry.'
            );
            return false;
        }
    }
    // Execute query to update allotment_status.
    $query_params = array(':allotment_status' => 'COMPLETE', ':group_id' => $group_id);
    $result = $GLOBALS['dbi']->executeQuery($update_allot_status_query, $query_params);
    if ($result == false) {
        HAA_gotError(
            'Failed to update database. Please retry.'
        );
        return false;
    }
    // Update session variable.
    $_SESSION['allotment_status'] = 'COMPLETE';

    return true;
}

/**
 * Displays final group-room details
 *
 * @return string Html
 */
function HAA_getHtmlCompleteForm()
{
    $retval = '';
    // Get the group_id.
    $group_id = $_SESSION['login_id'];
    // Get members names and room numbers.
    $members = HAA_getMembers($group_id);
    $members = $members->fetchAll();
    // Generate Html.
    $retval .= '<div class="box gray_grad allocation_form">'
        . '<div>Your allotment procedure is over. Below are the final details.</div>';
    $retval .= '<ul class="rooms_list">'
        . '<li class="green_grad">Room</li>';
    foreach ($members as $key => $row) {
        $retval .= '<li>' . $row['room_no'] . '</li>';
    }
    $retval .= '</ul>'
        . '<ul id="member_list" class="member_list">'
        . '<li class="green_grad">Occupant</li>';
    foreach ($members as $key => $row) {
        $retval .= '<li class="uniform_field">'
            . $row['full_name'] . ' (' . $row['roll_no'] . ')'
            . '</li>';
    }
    $retval .= '</ul><div style="clear: both;"></div>'
        . '<div style="margin-top: 2em;">'
        . '<strong>NOTE: </strong>'
        . 'Now all have to show the Hostel-Fee proof and collect the room keys from '
        . 'Hostel Administration anytime once the college re-opens.'
        . '</div>'
        . '</div>';

    return $retval;
}
?>
<?php
/**
 * Contains functions related to Authentication and Authorization.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Securely starts a session.
 */
function HAA_secureSession()
{
    // Custom session name.
    $session_name = 'TU_HAA';
    // Cookie will only be sent on Secure connections.
    $secure = false;
    // This stops JS to access session id.
    $http_only = true;
    // Force session to use only cookies.
    $use_cookies = ini_set('session.use_only_cookies', 1);
    if ($use_cookies == false) {
        echo 'Could not initiate a safe session.';
        exit;
    }
    // Get current cookies parameters.
    $cookie_params = session_get_cookie_params();
    // Set these parameters.
    session_set_cookie_params($cookie_params['lifetime']
        , $cookie_params['path']
        , $cookie_params['domain']
        , $secure
        , $http_only
    );
    // Set session name.
    session_name($session_name);
    // Start php session.
    session_start();
    // Regenerate session id.
    session_regenerate_id();
}

/**
 * Securely logs in a user with credentials.
 * @param string $group_id Group ID
 * @param string $password Password
 * @return bool true or false
 */
function HAA_secureLogin($group_id, $password)
{
    // Initialize.
    $password = hash('sha512', $password);
    $sql_query = 'SELECT * FROM ' . tblGroupId . ' '
            . 'WHERE group_id = :group_id AND password = :password '
            . 'LIMIT 1';
    $query_params = array(':group_id' => $group_id
        , ':password' => $password
    );
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $query_params);

    if ($result->rowCount() == 1) {
        // group_id and password are correct.
        // Get the fetched row.
        $group_details = $result->fetch();
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        // Get allotment process status.
        $allotment_status = HAA_getAllotmentProcessStatus();
        // Set session variables.
        $_SESSION['login_id'] = $group_id;
        $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
        $_SESSION['group_size'] = $group_details['group_size'];
        HAA_updateAllotmentProcessStatus();
        HAA_updateGroupAllotmentStatus();
        // Login successful.
        return true;

    } else {
        // Invalid credentials; check for number of invalid login attempts.
        if (isset($_SESSION['login_attempts'])) {
            if ($_SESSION['login_attempts'] < 2) {
                $_SESSION['login_attempts']++;
            } else {
                // Display captcha if number of invalid login attempts > 2.
                $_SESSION['show_captcha'] = true;
            }
        } else {
            $_SESSION['login_attempts'] = 1;
        }
        return false;
    }
}

/**
 * Checks if user is logged in or not.
 * @return bool true or false
 */
function HAA_checkLoginStatus()
{
    // Check if all session variables are set.
    if (isset($_SESSION['login_id'], $_SESSION['login_string'])) {
        // Fetch session variables for verification.
        $group_id = $_SESSION['login_id'];
        $login_string = $_SESSION['login_string'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        // SQL query to fetch password from DB.
        $sql_query = 'SELECT password FROM ' . tblGroupId . ' '
            . 'WHERE group_id = :group_id '
            . 'LIMIT 1';
        // Execute query.
        $query_params = array(':group_id' => $group_id);
        $result = $GLOBALS['dbi']->executeQuery($sql_query, $query_params);
        if ($result->rowCount() == 1) {
            // Get password saved in DB.
            $row = $result->fetch();
            $password = $row['password'];
            // Create check login_string.
            $login_check = hash('sha512', $password . $user_browser);
            if ($login_string == $login_check) {
                // Update allotment process status.
                HAA_updateAllotmentProcessStatus();
                // Update group allotment status.
                HAA_updateGroupAllotmentStatus();
                // Logged in.
                return true;
            } else {
                // Not logged in.
                return false;
            }
        } else {
            // Not logged in.
            return false;
        }
    } else {
        // Not logged in.
        return false;
    }
}

/**
 * Redirects a user to a page based on allotment_status
 */
function HAA_pageCheck()
{
    if (isset($_SESSION['allotment_status'])) {
        $allotment_status = $_SESSION['allotment_status'];
    } else {
        $allotment_status = '';
    }
    $curr_filename = basename($_SERVER['REQUEST_URI'], ".php");

    switch ($allotment_status) {
        case 'SELECT':
            if ($curr_filename != 'map') {
                HAA_redirectTo('map.php');
            }
            break;
        case 'ALLOT':
            if ($curr_filename != 'allot') {
                HAA_redirectTo('allot.php');
            }
            break;
        case 'COMPLETE':
            if ($curr_filename != 'allot') {
                HAA_redirectTo('allot.php');
            }
            break;
        default:
            //HAA_redirectTo('login.php');
            break;
    }
}

/**
 * Fetches details about allotment process from `tblAllotmentStatus`
 *
 * @return PDO object
 */
function HAA_getAllotmentProcessStatus()
{
    // SQL query.
    $sql_query = 'SELECT * FROM ' . tblAllotmentStatus . ' '
        . 'LIMIT 1';

    // Execute query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query, array());

    return $result->fetch();
}

/**
 * Fetches allotment status of group from `tblGroupId`
 *
 * @return string
 */
function HAA_getGroupAllotmentStatus($group_id)
{
    // SQL query.
    $sql_query = 'SELECT `allotment_status` FROM ' . tblGroupId . ' '
        . 'WHERE `group_id` = :group_id';

    // Execute query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query, array(':group_id' => $group_id));
    $row = $result->fetch();

    return $row['allotment_status'];
}

/**
 * Updates allotment process status.
 */
function HAA_updateAllotmentProcessStatus()
{
    // Get allotment process status.
    $status = $GLOBALS['allotment_process_status'];
    $_SESSION['process_status'] = $status['process_status'];
}

/**
 * Updates group allotment status.
 */
function HAA_updateGroupAllotmentStatus()
{
    // Get allotment status.
    $group_id = $_SESSION['login_id'];
    $status = HAA_getGroupAllotmentStatus($group_id);
    $_SESSION['allotment_status'] = $status;
}

/**
 * Checks whether to display any message in global message box or not.
 *
 * @return bool
 */
function HAA_checkToDisplayGlobalMessage()
{
    // Get allotment process status.
    $status = $GLOBALS['allotment_process_status'];

    return $status['show_message'];
}
?>
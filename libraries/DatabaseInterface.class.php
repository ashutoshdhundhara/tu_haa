<?php
/**
 * Main interface for all database interactions.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Include all DB constants.
 */
include_once 'libraries/dbConstants.php';

/**
 * Class that manages all db interactions.
 */
class HAA_DatabaseInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        if (! defined('dbHost')) {
            define('dbHost', 'localhost');
        }
        if (! defined('dbUser')) {
            define('dbUser', 'root');
        }
        if (! defined('dbPass')) {
            define('dbPass', '');
        }
        if (! defined('dbName')) {
            define('dbName', 'HostelJ');
        }

        $GLOBALS['db_link'] = $this->connect(dbHost, dbUser, dbPass, dbName);
    }

    /**
     * Connects to database.
     *
     * @param string $dbHost Hostename
     * @param string $dbUser Username
     * @param string $dbPass Password
     * @param string $dbName Database name
     *
     * @return resource $link connection object
     */
    public function connect($dbHost, $dbUser, $dbPass, $dbName)
    {
        $link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName) or
            die('Failed to connect to Database');

        return $link;
    }

    /**
     * Runs a query and returns result.
     *
     * @param string $query Query to be run
     *
     * @return resource $result Mysqli result object
     */
    public function executeQuery($query)
    {
        $link = $GLOBALS['db_link'];
        if (empty($link)) {
            return false;
        }

        $result = mysqli_query($link, $query);

        return $result;
    }

    /**
     * Returns row in form of array from $result.
     *
     * @param resource $result Mysql result object
     *
     * @return array $row Row array
     */
    public function fetchRow($result)
    {
        $row = mysqli_fetch_array($result);

        return $row;
    }

    /**
     * Counts number of rows in $result.
     *
     * @param resource $result Mysql result object
     *
     * @return int $num Number of rows.
     */
    public function countRows($result)
    {
        $num = mysqli_num_rows($result);

        return $num;
    }

    /**
     * Authenticates a user with id and password.
     *
     * @param string $id User ID
     * @param string $password Password
     *
     * @return bool
     */
    public function verifyUser($id, $password)
    {
        $link = $GLOBALS['db_link'];
        if (empty($link)) {
            return false;
        }

        $query = 'SELECT groupID FROM GROUP_ID '
            . 'WHERE groupID = ? AND password = ? '
            . 'LIMIT 1';
        // Prepare statement.
        $stmt = $link->prepare($query);
        // Bind only integers and string parameters.
        $stmt->bind_param('is', $id, $password);
        $stmt->execute();

        if($stmt->fetch()) {
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }
}

?>
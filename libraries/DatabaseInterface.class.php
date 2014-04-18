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
require_once 'libraries/dbConstants.inc.php';

/**
 * Class that manages all db interactions.
 */
class HAA_DatabaseInterface
{
    /**
     * Constructor creates a new connection.
     */
    public function __construct()
    {
        $GLOBALS['db_link'] = $this->connect(dbHost, dbUser, dbPass, dbName);
    }

    /**
     * Connects to database.
     *
     * @param string $dbHost Hostname
     * @param string $dbUser Username
     * @param string $dbPass Password
     * @param string $dbName Database name
     *
     * @return resource $link PDO object
     */
    public function connect($dbHost, $dbUser, $dbPass, $dbName)
    {
        // Database engine (vendor specific).
        $engine = 'mysql';
        $connection_string = $engine
            . ':host=' . $dbHost
            . ';dbname=' . $dbName;
        try {
            $link = new PDO($connection_string, $dbUser, $dbPass);
        } catch (PDOException $excp) {
            die($excp->getMessage());
        }

        return $link;
    }

    /**
     * Runs a query and returns result.
     *
     * @param string $query Query to be run
     * @param array $param Array containing parameter-value pairs
     * @return resource $result PDO statement
     */
    public function executeQuery($query, $params = array())
    {
        $link = $GLOBALS['db_link'];
        if (empty($link)) {
            return false;
        }
        // Prepare statement.
        $stmt = $link->prepare($query);

        // Execute statement.
        $stmt->execute($params);
        // Fetch result.
        $result = $stmt;

        return $result;
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

        $query = 'SELECT group_id FROM ' . tblGroupId . ' '
            . 'WHERE groupID = :group_id AND password = :password '
            . ' LIMIT 1';
        // Prepare statement.
        $stmt = $link->prepare($query);
        // Bind string parameters.
        $stmt->bindParam(':group_id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
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
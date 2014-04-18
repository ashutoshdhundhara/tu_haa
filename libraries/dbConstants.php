<?php
/**
 * Contains constants required for DB interactions.
 */

/**
 * Define global constants for database connection.
 */
// Define DB server.
define('dbHost', 'localhost');
// Define DB Username.
define('dbUser', 'root');
// Define DB Password.
define('dbPass', 'logMein');
// Define DB Name.
define('dbName', 'HostelJ');

/**
 * Define constants for databse tables.
 */
//Define table for storing Student details.
define('tblStudent', 'student_details');
//Define table for storing Group details.
define('tblGroup', 'group_details');
//Define table for storing Group credentials.
define('tblGroupId', 'group_id');
// Define table for storing Eligible students.
define('tblEligibleStudents', 'eligible_students');
// Define table for storing Rooms details.
define('tblRoom', 'room_info');
// Define table for Admin credentials.
define('tblAdmin', 'admin_id');

?>
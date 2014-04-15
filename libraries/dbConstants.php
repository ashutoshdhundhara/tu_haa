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
//Define `student_details` table.
define('tblStudent', 'student_details');
//Define `group_details` table.
define('tblGroup', 'group_details');
//Define `group_id` table.
define('tblGroupId', 'group_id');
// Define `eligible_students` table.
define('tblEligibleStudents', 'eligible_students');
// Define `room_info` table.
define('tblRoom', 'room_info');
// Define `admin_id` table.
define('tblAdmin', 'admin_id');

?>
<?php
/**
 * Contains constants required for DB interactions.
 */

/**
 * Define global constants for database connection.
 */
// Define DB server.
define('dbHost', '');
// Define DB Username.
define('dbUser', '');
// Define DB Password.
define('dbPass', '');
// Define DB Name.
define('dbName', '');

/**
 * Define constants for databse tables.
 */
//Define table for storing Student details.
define('tblStudent', '');
//Define table for storing Group details.
define('tblGroup', '');
//Define table for storing Group credentials.
define('tblGroupId', '');
// Define table for storing Eligible students.
define('tblEligibleStudents', '');
// Define table for storing Rooms details.
define('tblRoom', '');
// Define table for Admin credentials.
define('tblAdmin', '');
// Define table for Complaint details.
define('tblComplaint', '');

/**
 * reCaptcha constants.
 */
// reCaptcha Public key.
define('captchaPublicKey', '');
// reCaptcha Private key.
define('captchaPrivateKey', '');
?>
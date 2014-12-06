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
define('tblStudent', 'student_details');
//Define table for storing Group details.
define('tblGroup', 'group_details');
//Define table for storing Group credentials.
define('tblGroupId', 'group_id');
// Define table for storing Eligible students.
define('tblEligibleStudents', 'eligible_students');
// Define table for storing Rooms details.
define('tblRoom', 'rooms_info');
// Define table for Admin credentials.
define('tblAdmin', 'admin_id');
// Define table for Complaint details.
define('tblComplaint', 'complaint_details');
// Define table for allotment process details.
define('tblAllotmentStatus', 'allotment_status');
// Define table for the developers page.
define('tblDevelopers', 'developers');
// Define table for the feedback.
define('tblFeedback', 'feedback');

/**
 * reCaptcha constants.
 */
// reCaptcha Public key.
define('captchaPublicKey', '6Ldxz_ISAAAAAJgevE76oejMwCDiyBePSrd8wBki');
// reCaptcha Private key.
define('captchaPrivateKey', '6Ldxz_ISAAAAAHTa4ApDTQ7jG5VqsaZ6JPV-pgr5');
?>
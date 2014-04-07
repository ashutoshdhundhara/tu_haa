Thapar University, Hostel-J Allocation Automation
=================================================
An online system for Hostel-J Room Allocation.

Developer's Guide
=================

Coding Standards
----------------
Follow PEAR php Coding Standards.
http://pear.php.net/manual/en/standards.php

Directory Structure
-------------------
1) 'root'      : Contains all action scripts.
2) 'css'       : Contains all Stylesheets.
3) 'js'        : Contains all Javascripts.
4) 'img'       : Contains all Images.
5) 'libraries' : Contains all class files and files containing function definitions.
6) 'js/jquery' : Contains all jQuery related files.

File naming Standards
---------------------
1) Every file should include a brief description of the content at the top.
2) '*.class.php' : Files should contain only class definitions.
3) '*.lib.php'   : Files should contain only function definitions for corresponding action scripts.
4) '*.inc.php'   : Files should contain partial executable scripts which can be included in others.
4) '*.php'       : Files should be the actual executable action scripts.

Generating pages
----------------
Every page should be generated with 'HAA_Response' class object as follows:

<?php
$response = HAA_Response::getInstance();    // 'HAA_Response' class instance.
$header = $response->getHeader();
$header->addFile('filename', 'js');         // Add a Javascript file to page.
$header->addFile('filename', 'css');        // Add a Stylesheet to page.
$header->setTitle('TITLE');                 // Set page title.

$html_output = 'Hello World';                          // 'Content' of page.

$response->addHTML($html_output);           // 'Content' added to page.
$response->response();                      // Generates page with 'Content'
                                            // sandwiched between predefined 'Header' and 'Footer'.
?>

Contacts
--------
Ashutosh Dhundhara <ashutoshdhundhara@yahoo.com>
Vidhant Maini      <vidhant_14@hotmail.com>
Ayush Jain         <ayushjain1992@gmail.com>
Abhinav Acharya    <abhinavach28@gmail.com>
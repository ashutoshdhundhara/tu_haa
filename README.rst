Thapar University, Hostel-J Allocation Automation
=================================================
An online system for Hostel-J Room Allocation.



Developer's Guide
=================

Coding Standards
----------------
Follow `PEAR php Coding Standards.
<http://pear.php.net/manual/en/standards.php>`_


Directory Structure
-------------------
- 'root'      : Contains all action scripts.
- 'css'       : Contains all Stylesheets.
- 'js'        : Contains all Javascripts.
- 'img'       : Contains all Images.
- 'libraries' : Contains all class files and files containing function definitions.
- 'js/jquery' : Contains all jQuery related files.


File naming Standards
---------------------
- Every file should include a brief description of the content at the top.
- \'\*.class.php\' : Files should contain only class definitions.
- \'\*.lib.php\'   : Files should contain only function definitions for corresponding action scripts.
- \'\*.inc.php\'   : Files should contain partial executable scripts which can be included in others.
- \'\*.php\'       : Files should be the actual executable action scripts.


Generating pages
----------------
Every page should be generated with 'HAA_Response' class object as follows:

.. code-block:: php

    <?php
    $response = HAA_Response\:\:getInstance();  // 'HAA_Response' class instance.
    $header = $response->getHeader();
    $header->addFile('filename', 'js');         // Add a Javascript file to page.
    $header->addFile('filename', 'css');        // Add a Stylesheet to page.
    $header->setTitle('TITLE');                 // Set page title.

    $html_output = 'Hello World';               // 'Content' of page.

    $response->addHTML($html_output);           // 'Content' added to page.
    $response->response();                      // Generates page with 'Content'
                                                // sandwiched between predefined 'Header' and 'Footer'.
    ?>


Contacts
--------

| Ashutosh Dhundhara <ashutoshdhundhara@yahoo.com>
| Vidhant Maini      <vidhant_14@hotmail.com>
| Ayush Jain         <ayushjain1992@gmail.com>
| Abhinav Acharya    <abhinavach28@gmail.com>
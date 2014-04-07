<?php
/**
 * Concatenates several css files to reduce the number of
 * http requests sent to the server
 */

chdir('..');

// Send correct type
header('Content-Type: text/css; charset=UTF-8');

if (! empty($_GET['stylesheets']) && is_array($_GET['stylesheets'])) {
    foreach ($_GET['stylesheets'] as $stylesheet) {
        // Sanitise filename
        $stylesheet_name = 'css';

        $path = explode("/", $stylesheet);
        foreach ($path as $index => $filename) {
            // Allow alphanumeric, "." and "-" chars only, no files starting
            // with .
            if (preg_match("@^[\w][\w\.-]+$@", $filename)) {
                $stylesheet_name .= DIRECTORY_SEPARATOR . $filename;
            }
        }

        // Output file contents
        if (preg_match("@\.css$@", $stylesheet_name) && is_readable($stylesheet_name)) {
            readfile($stylesheet_name);
            echo "\n\n";
        }
    }
}
?>

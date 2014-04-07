<?php
/**
 * Concatenates several js files to reduce the number of
 * http requests sent to the server
 */

chdir('..');

// Send correct type
header('Content-Type: text/javascript; charset=UTF-8');

if (! empty($_GET['scripts']) && is_array($_GET['scripts'])) {
    foreach ($_GET['scripts'] as $script) {
        // Sanitise filename
        $script_name = 'js';

        $path = explode("/", $script);
        foreach ($path as $index => $filename) {
            // Allow alphanumeric, "." and "-" chars only, no files starting
            // with .
            if (preg_match("@^[\w][\w\.-]+$@", $filename)) {
                $script_name .= DIRECTORY_SEPARATOR . $filename;
            }
        }

        // Output file contents
        if (preg_match("@\.js$@", $script_name) && is_readable($script_name)) {
            readfile($script_name);
            echo "\n\n";
        }
    }
}
?>

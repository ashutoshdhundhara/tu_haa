<?php
/**
 * Functions required for minifying JS and CSS.
 */

if (! defined('TU_HAA')) {
    exit;
}

// Define directory for JS files.
define('jsDir', 'js/*.js');
// Define directory for CSS files.
define('cssDir', 'css/*.css');

/**
 * Minifies the given CSS/JS file.
 *
 * @param string $type Type of  file 'css' or 'js'
 */
function HAA_minify($type)
{
    // Get all JS/CSS files.
    switch ($type) {
    case 'js':
        $files = glob(jsDir);
        break;
    case 'css':
        $files = glob(cssDir);
        break;
    }
    // Minify each file.
    foreach ($files as $file) {
        $file = basename($file);
        // Minify it.
        $root = (isset($_SERVER['HTTPS']) ? 'https' : 'http')
            . '://'
            . $_SERVER['HTTP_HOST']
            . '/';
        $minified_js = file_get_contents(
            $root
            . 'min/?f=' . $type . '/'
            . htmlspecialchars($file)
        );

        // Open a new file for writing minified JS content.
        $new_file = fopen($type . '/minified/' . $file, 'w');
        fwrite($new_file, $minified_js);
        fclose($new_file);
    }
    // Set a flag that all files have been minified.
    $flag = '<?php $is_' . $type . '_minified = true; ?>';
    $flag_file = fopen($type . '/minified/is_' . $type . '_minified.php', 'w');
    fwrite($flag_file, $flag);
    fclose($flag_file);
}

?>
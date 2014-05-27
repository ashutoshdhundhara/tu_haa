<?php
/**
 * Functions required by developer.php
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Displays Html for Developers Page.
 *
 * @return string $retval Form Html
 */
function HAA_getHtmlDevelopers() {
    $retval = '<div class="developers_content">'
    . HAA_getHtmlDeveloperInfo()
    . '</div>';

    return $retval;
}

/**
 * Retrieves Developers Information from Database.
 */
function HAA_getDeveloperInfo() {
    $sql_query = 'SELECT * '
    . 'FROM ' . tblDevelopers;

    // Execute the query.
    $result = $GLOBALS['dbi']->executeQuery($sql_query);

    if ($result == false) {
        HAA_gotError(
            'Failed to get members details.'
        );
        return false;
    }

    return $result;
}

/**
 * Generates Html for Developers Page.
 *
 * @return string $retval Form Html
 */
function HAA_getHtmlDeveloperInfo() {
    $retval = '';
    $developers = HAA_getDeveloperInfo();
    while($row = $developers->fetch()) {
        $retval .= '<div class="developer_info">'
        . '<img src="img/developers/' . $row['photo'] . '">'
        . '<h3>' . $row['full_name'] . '</h3>'
        . '<table>'
        . '<tr>'
        . '<td>E-Mail :'
        . '<td>' . $row['email']
        . '</tr>'
        . '<tr>'
        . '<td>Mobile :'
        . '<td>' . $row['mobile']
        . '</tr>'
        . '<tr>'
        . '<td>Role :'
        . '<td>' . $row['role']
        . '</tr>'
        . '<tr>'
        . '<td>Additional Info :'
        . '<td>' . $row['other_details']
        . '</tr>'
        . '</table>'
        . '</div>';
    }
    return $retval;
}
?>
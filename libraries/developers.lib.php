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
    $retval = '<div class="developers_content gray_grad box">'
    . '<h2>Developers</h2>'
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
    $row = $developers->fetch();
    while($row) {
        $retval .= '<div class="developer_info">'
        . '<img src="img/developers/' . $row['photo'] . '" alt="'
        . $row['full_name'] . '" height="200" width="170"'
        . '>'
        . '<table>'
        . '<caption>' . $row['full_name'] . '</caption>'
        . '<tr>'
        . '<td>E-Mail :</td>'
        . '<td>' . $row['email'] . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Mobile :</td>'
        . '<td>' . $row['mobile'] . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Role :</td>'
        . '<td>' . $row['role'] . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Additional Info :</td>'
        . '<td><a target="_blank" href="http://'
        . $row['other_details'] . '">link</a>'
        . '</td></tr>'
        . '</table>'
        . '</div>';

        if ($row = $developers->fetch()) {
            $retval .= '<hr>';
        }
    }
    return $retval;
}
?>
<?php
/**
 * Functions required for Group creation page.
 */

/**
 * Generate Html for create group form.
 *
 * @return string $retval Html containing Create group form
 */
function HAA_getHtmlGroupForm()
{
    $retval = '';
    $retval .= '<form method="POST" action="group.php" class="gray_grad box group_form">'
        . '<table class="password_table">'
        . '<caption>Create Group</caption>'
        . '<tr>'
        . '<td><label for="input_size">Number of members<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectGroupSize() . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>';

    return $retval;
}

/**
 * Generates Html for Group size select list.
 *
 * @return string $retval Html containing select list
 */
function HAA_getHtmlSelectGroupSize()
{
    $retval = '<select id="input_size" name="group_size" class="required"'
        . ' title="Please select the number of members in your Group">'
        . '<option>...</option>';
    for ($i=2;$i<=11;$i++) {
        $retval .= '<option>' . $i . '</option>';
    }
    $retval .= '</select>';

    return $retval;
}
?>
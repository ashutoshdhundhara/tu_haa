<?php
/**
 * Functions required for User registration page.
 */

/**
 * Generates Html for User registration form.
 *
 * @return string $retval Form Html
 */
function HAA_getHtmlRegisterForm()
{
    $retval = '<form method="POST" action="register.php"'
        . ' class="register_form gray_grad box">'
        . '<table>'
        . '<caption>Registration Form</caption>'
        . '<tr><td><label for="input_name">Name<sup class="req">*</sup> :</label></td>'
        . '<td colspan="3"><input type="text" id="input_name" name="name" '
        . 'title="Please provide your Full Name">'
        . '</td></tr>'
        . '<tr><td><label for="input_class">Class<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectClass()
        . '</td><td><label for="input_year">Year<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectYear()
        . '</td></tr>'
        . '<tr><td><label for="input_branch">Branch<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_branch" name="branch"'
        . ' title="Please provide your Branch"></td>'
        . '<td><label for="input_rollNo">Roll No<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_rollNo" name="rollNo"'
        . ' title="Please provide your University Roll Number"></td></tr>'
        . '</table>'
        . '</form>';

    return $retval;
}

/**
 * Generates Html for Select class list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectClass()
{
    // @todo: Classes can be saved and fetched from DB.
    $retval = '<select name="class" id="input_class"'
        .' title="Please provide your Class">'
        . '<option>...</option>'
        . '<option>BTech</option>'
        . '<option>MBA</option>'
        . '<option>MSc</option>'
        . '<option>MTech</option>'
        . '<option>MCA</option>'
        . '<option>PHD</option>'
        . '</select>';

    return $retval;
}

/**
 * Generates Html for Select year list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectYear()
{
    $retval = '<select name="currentYear" id="input_year"'
        .' title="Please provide your current Year of study">'
        . '<option>...</option>';
    for ($i=1;$i<=6;$i++) {
        $retval .= '<option>' . $i . '</option>';
    }
    $retval .= '</select>';

    return $retval;
}
?>
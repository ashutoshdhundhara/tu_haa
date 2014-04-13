/**
 * Manages the main login page.
 */

/**
 * Operations to perform on page load.
 *
 * @return void
 */
$(document).ready(function () {
    HAA_setFocus();
    // Validate form on submit.
    $('.login_form').bind("submit", function (event) {
        var isValid = true;
        $('[title]').tooltip("option", "disabled", false);
        if ($('#input_username').val().length === 0) {
            isValid = false;
            $('#input_username').tooltip('open');
        }
        if ($('#input_password').val().length === 0) {
            isValid = false;
            $('#input_password').tooltip('open');
        }
        if (!isValid) {
            HAA_setFocus();
        }

        return isValid;
    });
});

/**
 * Sets focus to the first non empty field.
 *
 * @return void
 */
function HAA_setFocus()
{
    if ($('#input_username').val().length === 0) {
        $('#input_username').focus();
    } else {
        $('#input_password').focus();
    }
}
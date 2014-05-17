/**
 * Manages User registration page.
 */

$(document).ready(function () {
    $("input:file, select").uniform();
    $('.datefield').mask(date_format);
    $('.mobilefield').mask(mobile_format);
    $('#input_roll_no').focus();
    var branches = [
        'COE'
        , 'MEE'
        , 'ECE'
        , 'CIE'
        , 'EIC'
        , 'ELE'
        , 'BT'
        , 'CHE'
    ];
    $("#input_branch").autocomplete({
        source: branches
    });

    $('#input_roll_no').mask(roll_no_format);

    $('#input_type').bind('change', function () {
        HAA_togglePasswordFields($(this));
    });

    // Submit form action.
    $('.register_form').bind('submit', function (event) {
        event.preventDefault();

        // Submit the form when everything is fine.
        if (HAA_validateForm() && HAA_validatePasswords()) {
            HAA_submitForm($(this));
        }
    });
});

/**
 * Validates the user registration form.
 *
 * @return bool true|false
 */
function HAA_validateForm()
{
    isValid = HAA_validateFields();

    if (isValid) {
        if (! $('#input_agreement').is(':checked')) {
            isValid = false;
            HAA_showNotification('Please accept Hostel Rules & Regulations.'
                , 'error');
        }
    }

    return isValid;
}
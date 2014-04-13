/**
 * Manages User registration page.
 */

$(document).ready(function () {
    $('#input_roll_no').focus();
    var branches = ['COE'
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

    // Validate registration form on submit.
    $('.register_form').bind('submit', function (event) {
        event.preventDefault();
        var isValid = true;

        // Get all required fields.
        $('.required').each(function () {
            if ($(this).val() === '' || $(this).val() === '...') {
                // Set focus to first empty required field.
                if (isValid) {
                    $(this).focus();
                }
                isValid = false;
                $(this).tooltip('open');
            }
        });

        if (isValid) {
            if (! $('#input_agreement').is(':checked')) {
                isValid = false;
                HAA_showNotification('Please accept Hostel Rules & Regulations.'
                    , 'error');
            }
        }

        // Submit the form when everything is fine.
        if (isValid) {
            var form_data = $(this).serialize();
            alert(form_data);
            $.ajax({
                type: 'POST',
                url: 'register.php',
                data: form_data,
                success: function () {

                },
                error: function () {

                }
            });
        }
    });
});
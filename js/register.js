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
            $.ajax({
                type: 'POST',
                url: 'register.php',
                data: form_data,
                success: function (response) {
                    // Variable that holds the response dialog.
                    var $response_dialog = null;
                    // Dialog title.
                    var dialog_title = 'Hostel-J User Registration';
                    // Dialog Button options.
                    var buttonOptions = {};
                    // 'OK' button action.
                    buttonOptions['OK'] = function () {
                        $(this).dialog('close');
                    };

                    if (response.success) {
                        // Dialog content.
                        var dialog_content = '<div>' + response.message + '</div>';
                        $response_dialog = $(dialog_content).dialog({
                            minWidth: 340,
                            modal: true,
                            title: dialog_title,
                            buttons: buttonOptions,
                            open: function () {
                                // Focus the "OK" button after opening the dialog
                                $(this).closest('.ui-dialog')
                                    .find('.ui-dialog-buttonpane button:first')
                                    .focus();
                            },
                            close: function () {
                                $(this).remove();
                            }
                        });
                    }
                },
                error: function () {
                    var $error = HAA_showNotification(
                        'Could not contact Server ! ' +
                        'Please check your Network Settings.'
                        , 'error'
                    );
                }
            });
        }
    });
});
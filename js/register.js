/**
 * Manages User registration page.
 */

$(document).ready(function () {
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
        if (HAA_validateForm()) {
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

    return isValid;
}

/**
 * Submits form using Ajax and displays response in a dialog.
 *
 * @param jQuery Object $form Form to be submitted
 * @return void
 */
function HAA_submitForm($form)
{
    var form_data = new FormData($($form)[0]);
    $.ajax({
        type: 'POST',
        url: 'register.php',
        data: form_data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function (response) {
            // Display a dialog containing response. --START--
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
                var dialog_content = '<div class="dialog_content">' +
                    response.message + '</div>';

                // Create dialog.
                $response_dialog = $(dialog_content).dialog({
                    minWidth: 525,
                    minHeight: 250,
                    modal: true,
                    title: dialog_title,
                    resizable: true,
                    draggable: true,
                    buttons: buttonOptions,
                    open: function () {
                        $('.ui-dialog-titlebar').addClass('green_grad shadow');
                        $('.ui-dialog, .ui-dialog-buttonpane').addClass('gray_grad');
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
            // Display a dialog containing response. --ENDS--
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

/**
 * Shows password fields n case of Room as an Individual.
 *
 * @param jQuery Object $target Element after which fields to be inserted
 * @return void
 */
function HAA_togglePasswordFields($target)
{

}
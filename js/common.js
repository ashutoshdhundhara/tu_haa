/**
 * Contains functions and variables common to all Javascripts.
 */

$(document).ready(function () {
    $('input:submit').addClass('submit_button green_grad');
    $('[title]').tooltip(tooltip_right);
    $('.datefield').datepicker(datepicker_defaults);
});

/**
 * Options for reCaptcha widget.
 * @type {Object}
 */
var RecaptchaOptions = {
    theme : 'white'
 };

/**
 * Default options for tooltip widget.
 */
var tooltip_right = {
    position: {
      my: 'left center',
      at: 'right center'
    },
    disabled: false,
    tooltipClass: 'haa_tooltip'
};
var tooltip_left = {
    position: {
      my: 'right center',
      at: 'left center'
    },
    disabled: false,
    tooltipClass: 'haa_tooltip'
};

/**
 * Default options for datepicker widget.
 */
var datepicker_defaults = {
    defaultDate: new Date(1988,0,1),
    numberOfMonths: 1,
    showButtonPanel: false,
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
};

/**
 * Default date format.
 */
var date_format = '9999-99-99';

/**
 * Default Mobile number format.
 */
var mobile_format = '+99-9999999999';

/**
 * Default roll number format.
 */
var roll_no_format = '999999999';

/**
 * Default unique ID format.
 */
var unique_id_format = '9999';

/**
 * Display notification message.
 *
 * @param string message  Message to be displayed
 * @param string type     Type of message (error, success etc.)
 * @return jQuery Object
 */
function HAA_showNotification(message, type)
{
    // Whether the notification will automatically disappear
    var self_closing = true;
    // Remove any previous notification.
    $('.haa_notification').remove();

    // Initialize some variables.
    var uiClass = 'ui-state-highlight';
    var uiIcon  = 'ui-icon-info';
    var uiText  = '';
    message = (message !== undefined) ? message : 'Please wait...';
    type = (type !== undefined) ? type : 'load';

    switch(type) {
        case 'load':
            self_closing = false;
            break;
        case 'info':
            uiText = 'NOTICE: ';
            break;
        case 'error':
            uiClass = 'ui-state-error';
            uiIcon  = 'ui-icon-alert';
            uiText  = 'ERROR: ';
    }

    var $notification = $(
        '<div class="ui-widget haa_notification"' +
        'title="Click to dismiss">' +
        '<div class="ui-corner-all ' + uiClass + '" style="padding: 0.8em; font-size: 0.8em;">' +
        '<p>' +
        '<span class="ui-icon ' + uiIcon + '" style="float: left; margin-right: .3em;"></span>' +
        '<strong>' + uiText + '</strong>' +
        message +
        '</p>' +
        '</div>'
    )
    .hide()
    .appendTo('.body_content')
    .bind('click', function () {
        if (type !== 'load') {
            $(this)
            .stop(true, true)
            .fadeOut('medium', function () {
                $(this).tooltip('destroy');
                $(this).remove();
            });
        } else {
            return false;
        }
    })
    .show();

    if (self_closing) {
        $notification
        .delay(3000)
        .fadeOut('medium', function () {
            if ($(this).is(':data(tooltip)')) {
                $(this).tooltip('destroy');
            }
            // Remove the notification
            $(this).remove();
        });
    }

    if (type !== 'load') {
        $($notification).tooltip({
            tooltipClass: 'haa_tooltip',
            track: true,
            show: true
        });
    } else {
        $($notification).attr('title', '');
    }

    return $notification;
}

function HAA_validateFields()
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

    return isValid;
}

/**
 * Shows password fields in case of Room as an Individual.
 *
 * @param jQuery Object $target Element after which fields to be inserted
 * @return void
 */
function HAA_togglePasswordFields($target)
{
    if ($target.val() !== '...' && $target.val() !== 'group') {
        if ($('.password_fields').length === 0) {
            var $password_fields = $('<tr class="password_fields">' +
            '<td colspan="2">Choose Password:</td>' +
            '</tr>' +
            '<tr class="password_fields">' +
            '<td colspan="2"><strong>' +
            'Login ID will be System generated</strong></td>' +
            '</tr>' +
            '<tr class="password_fields">'+
            '<td><label for="input_password">Password<sup class="req">*</sup> :</td>' +
            '<td><input id="input_password" type="password" name="password"' +
            ' title="Please choose a password. Password must be atleast 8 characters long."' +
            ' class="required"></td>' +
            '</tr>' +
            '<tr class="password_fields">' +
            '<td><label for="input_confirm">Confirm Password<sup class="req">*</sup> :</td>' +
            '<td><input id="input_confirm" type="password" name="confirm_password"' +
            ' title="Please confirm your password." class="required"></td>' +
            '</tr>');
            $target.closest('tr').after($password_fields);
            $('#input_password, #input_confirm').tooltip(tooltip_right);
        }
    }
    else {
        $('.password_fields').remove();
    }
}

/**
 * Submits form using Ajax and displays response in a dialog.
 *
 * @param jQuery Object $form Form to be submitted
 * @return void
 */
function HAA_submitForm($form)
{
    var $notification = HAA_showNotification();
    var form_data = new FormData($($form)[0]);
    $.ajax({
        type: 'POST',
        url: $form.attr('action'),
        data: form_data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function (response) {
            // Remove notification.
            $notification.remove();
            // Display a dialog containing response. --START--
            // Variable that holds the response dialog.
            var $response_dialog = null;
            // Dialog title.
            var dialog_title = 'Hostel-J';
            // Dialog Button options.
            var buttonOptions = {};
            // 'OK' button action.
            buttonOptions['OK'] = function () {
                if (response.save) {
                    window.location.replace('index.php');
                } else {
                    document.body.style.overflow = "visible";
                    $(this).dialog('close');
                }
            };

            if (response.success) {
                // Dialog content.
                var dialog_content = '<div class="dialog_content">' +
                    response.message + '</div>';

                // Create dialog.
                $response_dialog = $(dialog_content).dialog({
                    minWidth: 525,
                    height: 300,
                    modal: true,
                    title: dialog_title,
                    resizable: true,
                    draggable: false,
                    buttons: buttonOptions,
                    open: function () {
                        document.body.style.overflow = "hidden";
                        $('.ui-dialog-titlebar').addClass('green_grad shadow');
                        $('.ui-dialog, .ui-dialog-buttonpane').addClass('gray_grad');
                        // Focus the "OK" button after opening the dialog
                        $(this).closest('.ui-dialog')
                            .find('.ui-dialog-buttonpane button:first')
                            .focus();
                    },
                    close: function () {
                        if (response.save) {
                            window.location.replace('index.php');
                        }
                        document.body.style.overflow = "visible";
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
 * Validates password fields.
 */
function HAA_validatePasswords()
{
    var isValid = true;
    if ($('#input_password').length) {
        if ($('#input_password').val() !== $('#input_confirm').val()) {
            HAA_showNotification(
                'Passwords do not match.', 'error'
            );
            isValid = false;
        }
        if ($('#input_password').val().length < 8) {
            HAA_showNotification(
                'Password must be atleast 8 characters long.', 'error'
            );
            isValid = false;
        }
        if (! isValid) {
            $('#input_password').focus();
        }
    }

    return isValid;
}
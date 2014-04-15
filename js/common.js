/**
 * Contains functions and variables common to all Javascripts.
 */

$(document).ready(function () {
    $("input:file, select").uniform();
    $('input:submit').addClass('submit_button green_grad');
    $('[title]').tooltip(tooltip_defaults);
    $('.datefield').datepicker(datepicker_defaults);
    $('.datefield').mask(date_format);
    $('.mobilefield').mask(mobile_format);
});

/**
 * Default options for tooltip widget.
 */
var tooltip_defaults = {
    position: {
      my: 'left center',
      at: 'right center'
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
 * Display notification message.
 *
 * @param string message  Message to be displayed
 * @param string type     Type of message (error, success etc.)
 * @return jQuery Object
 */
function HAA_showNotification(message, type)
{
    // Remove any previous notification.
    $('.haa_notification').remove();

    // Initialize some variables.
    var uiClass = 'ui-state-highlight';
    var uiIcon  = 'ui-icon-lightbulb';
    var uiText  = '';
    message = (message !== undefined) ? message : 'Loading...';
    type = (type !== undefined) ? type : 'load';

    switch(type) {
        case 'load':
            break;
        case 'info':
            uiText = 'INFORMATION: ';
            break;
        case 'error':
            uiClass = 'ui-state-error';
            uiIcon  = 'ui-icon-notice';
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
            $(this).fadeOut('medium', function () {
                $(this).tooltip('destroy');
                $(this).remove();
            });
        }
    })
    .show();

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

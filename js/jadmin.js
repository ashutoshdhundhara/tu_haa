/**
 * Handles Admin page.
 */

$(document).ready(function () {
    $('.admin_content').accordion({ heightStyle: "content" });
    $('.roll_no').mask(roll_no_format);
    $('.cluster').mask(cluster_format);
    $('.room_no').mask(room_no_format);
    $('.ui-accordion-content').addClass('gray_grad');
    $("input:file, select").uniform();
    $("#input_branch").autocomplete({
        source: branches
    });
    $( "[title]" ).tooltip("destroy");

    // Handler for form submission.
    $('.admin_page form').submit(function (event) {
        event.preventDefault();
        // Display loading notification.
        var $notification = HAA_showNotification();
        var form_data = $(this).serialize() + '&ajax_request=true';

        // Submit form.
        $.ajax({
            type: 'POST',
            url: 'jadmin.php',
            data: form_data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                // Remove notification.
                $notification.remove();
                // Display a dialog containing response. --START--
                // Variable that holds the response dialog.
                var $response_dialog = null;
                // Dialog title.
                var dialog_title = 'Hostel-J Administration';
                // Dialog Button options.
                var buttonOptions = {};
                // 'Close' button action.
                buttonOptions['Close'] = function () {
                    document.body.style.overflow = "visible";
                    if (response.not_logged_in) {
                        window.location.replace('index.php');
                    }
                    $(this).remove();
                };

                if (response.success) {
                    // Dialog content.
                    var dialog_content = $('<div/>').append(response.message);
                    // Create dialog.
                    $response_dialog = $(dialog_content).dialog({
                        minWidth: 525,
                        minHeight: 250,
                        modal: true,
                        title: dialog_title,
                        // resizable: false,
                        // draggable: false,
                        buttons: buttonOptions,
                        open: function () {
                            document.body.style.overflow = "hidden";
                            $('.ui-dialog-titlebar').addClass('green_grad shadow');
                            $('.ui-dialog, .ui-dialog-buttonpane').addClass('gray_grad');
                        },
                        close: function () {
                            document.body.style.overflow = "visible";
                            if (response.not_logged_in) {
                                window.location.replace('index.php');
                            }
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
    });
});
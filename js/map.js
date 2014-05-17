/**
 * Handles Hostel Map page.
 */

$(document).ready(function () {
    $('#wing_tabs').tabs({
        beforeLoad: function(event, ui){
            $(ui.panel)
            .siblings('div.ui-tabs-panel[aria-expanded="true"]')
            .empty()
            .html('<strong>Loading...</strong>');
        }
    });
    $('.ui-tabs-nav').addClass('green_grad');

    // Bind 'click' event on Cluster anchors.
    $('#wing_tabs').on('click', '.cluster_anchor',function (event) {
        event.preventDefault();
        HAA_showClusterMap($(this));
    });
    // Bind 'click' event on Cluster rooms.
    $('body').on('click', '.room_available', function (event) {
        if ($(this).hasClass('room_blocked')
            || ! $(this).hasClass('selectable')
            || $(this).hasClass('room_selected')) {
            return false;
        }
        HAA_selectRoom($(this).attr('data-room'));
    });
    $('body').on('click', '.room_selected', function (event) {
        HAA_deSelectRoom($(this).attr('data-room'));
    });
    // Bind 'click' event on remove link.
    $('body').on('click', '.selected_rooms_list span',function () {
        HAA_deSelectRoom($(this).attr('data-room'));
    });
    // Submit Rooms choices.
    $('#rooms_form').bind('submit', function (event) {
        event.preventDefault();
        $(".ui-dialog-content").dialog("close");
        HAA_submitRoomChoices($(this));
    });
    // Run HAA_updateWingMap() repeatedly
    update_interval = setInterval(function () {
        var wing = $('.ui-tabs-active').attr('data-wing');
        HAA_updateWingMap(wing);
    }, 8000);
});

/**
 * Array holding currently selected room numbers.
 * @type {Array}
 */
var marked_rooms = Array();

/**
 * Variable to store update timer.
 */
var update_interval = null;

/**
 * Displays Cluster map
 * @param {jQuery Object} $cluster_anchor Cluster anchor displayed on Wing Map
 */
function HAA_showClusterMap($cluster_anchor)
{
    // Show loading notification.
    var $notification = HAA_showNotification();
    var cluster_url = $cluster_anchor.attr('href');
    var cluster_name = $cluster_anchor.find('.vacant_rooms')
        .find('span').attr('id');
    // Ajax request for Cluster map.
    $.ajax({
        type: 'GET',
        url: cluster_url,
        /*data: '',*/
        cache: false,
        dataType: 'json',
        success: function (response) {
            // Remove notification.
            $notification.remove();
            // Display a dialog containing response. --START--
            // Variable that holds the response dialog.
            var $response_dialog = null;
            // Dialog title.
            var dialog_title = cluster_name;
            // Dialog Button options.
            var buttonOptions = {};
            if (response.is_map) {
                buttonOptions['Select All'] = function () {
                    // Select All available rooms
                    HAA_selectAll();
                };
                buttonOptions['Deselect All'] = function () {
                    // Deselect All selected rooms.
                    HAA_deSelectAll();
                };
            }
            // 'Close' button action.
            buttonOptions['Close'] = function () {
                document.body.style.overflow = "visible";
                if (response.not_logged_in) {
                    window.location.replace('index.php');
                }
                $(this).remove();
            };

            if (response.success) {
                // Pre-process Cluster map Html for selected rooms.
                $cluster_map = $(response.message);
                $cluster_map.find('td.room_available').each(function () {
                    if (marked_rooms.indexOf($(this).attr('data-room')) > -1) {
                        $(this).addClass('room_selected green_grad');
                    } else {
                        if (selected_rooms === group_size) {
                            $(this).addClass('room_blocked');
                        }
                    }
                });
                // Dialog content.
                var dialog_content = $('<div/>').append($cluster_map);
                // Create dialog.
                $response_dialog = $(dialog_content).dialog({
                    minWidth: 525,
                    minHeight: 250,
                    modal: true,
                    title: dialog_title,
                    resizable: false,
                    draggable: false,
                    buttons: buttonOptions,
                    open: function () {
                        document.body.style.overflow = "hidden";
                        $('.ui-dialog-titlebar').addClass('green_grad shadow');
                        $('.ui-dialog, .ui-dialog-buttonpane').addClass('gray_grad');
                        // Focus the "Select All" button after opening the dialog
                        $(this).closest('.ui-dialog')
                            .find('.ui-dialog-buttonpane button:first')
                            .focus();
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
}

/**
 * Selects a room from Cluster map.
 * @param {string} room_no Selected room number
 */
function HAA_selectRoom(room_no)
{
    // If room is already selected, do nothing.
    if (marked_rooms.indexOf(room_no) > -1 || selected_rooms == group_size) {
        return false;
    }
    // Get the selected Room cell.
    var $room = $('td[data-room*="' + room_no + '"]');
    // Step 1: Increment selected_rooms.
    selected_rooms++;
    // Step 2: Mark it as 'selected'.
    $room.addClass('room_selected green_grad');
    $room.removeClass('room_available');
    // Step 3: Create a hidden input in '#selected_rooms' form.
    $('<input type="hidden" name="selected_rooms[]" value="' + room_no + '">')
        .appendTo('#rooms_form');
    // Step 4: Add selected room to list.
    $('<li>' + room_no + '<span data-room="' + room_no + '">x</span></li>')
        .appendTo('#selected_rooms_list');
    // Step 5: Handle 'submit' button.
    if (selected_rooms === group_size) {
        /*var disabled = (process_status) ? '' : 'disabled="disabled"';*/
        var disabled = '';
        $('<input type="submit" name="submit" value="Submit"' +
            ' class="submit_button green_grad" ' +
            disabled + '>')
            .appendTo('#rooms_form');
    // Step 6: Block all available room if selected_rooms == group_size.
        $('.room_available').each(function () {
            $(this).addClass('room_blocked');
        });
    }
    // Step 7: Update 'num_selected_rooms' span.
    $('#num_selected_rooms').text(' ' + selected_rooms + ' ');
    // Step 8: Push selected room in marked_rooms array.
    marked_rooms.push(room_no);
}

/**
 * Deselects a room from Cluster map.
 * @param {string} room_no Selected room number
 */
function HAA_deSelectRoom(room_no)
{
    // Get the selected Room cell.
    var $room = $('td[data-room*="' + room_no + '"]');
    // Step 1: Decrement selected_rooms.
    selected_rooms--;
    // Step 2: Mark it as 'available'.
    $room.removeClass('room_selected green_grad');
    $room.addClass('room_available');
    // Step 3: Delete hidden input in '#selected_rooms' form.
    $('#rooms_form').find('input[value*="' + room_no + '"]').remove();
    // Step 4: Remove room from selected rooms list.
    $('#selected_rooms_list').find('span[data-room*="' + room_no + '"]')
        .parent().remove();
    // Step 5: Handle 'submit' button.
    $('#rooms_form').find('input[type="submit"]').remove();
    // Step 6: Unblock all available room if selected_rooms != group_size.
    $('.room_available').each(function () {
        $(this).removeClass('room_blocked');
    });
    // Step 7: Update 'num_selected_rooms' span.
    $('#num_selected_rooms').text(' ' + selected_rooms + ' ');
    // Step 8: Remove selected room in marked_rooms array.
    var index = marked_rooms.indexOf(room_no);
    if (index !== -1) {
        marked_rooms.splice(index, 1);
    }
}

/**
 * Selects all available rooms in current cluster.
 */
function HAA_selectAll()
{
    $('.room_available').each(function () {
        HAA_selectRoom($(this).attr('data-room'));
    });
}

/**
 * Deselects all selected rooms in current cluster.
 */
function HAA_deSelectAll()
{
    $('.room_selected').each(function () {
        HAA_deSelectRoom($(this).attr('data-room'));
    });
}

/**
 * Deselects all selected rooms anywhere in Hostel Map.
 */
function HAA_removeAll()
{
    while (marked_rooms.length) {
        var index = marked_rooms.length -1;
        HAA_deSelectRoom(marked_rooms[index]);
    }
}

/**
 * Submits room choices using Ajax and displays response in a dialog.
 *
 * @param jQuery Object $form Form to be submitted
 * @return void
 */
function HAA_submitRoomChoices($form)
{
    // Show loading notification.
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
                if (response.not_logged_in || response.book_success) {
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
                    minHeight: 250,
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
                        if (response.not_logged_in || response.book_success) {
                            window.location.replace('index.php');
                        } else {
                            HAA_removeAll();
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
 * Updates each cluster's 'Vacant rooms' count.
 * @param {string} wing_name Wing name 'E' or 'W'
 * @return void
 */
function HAA_updateWingMap(wing_name)
{
    // URL for update map.
    var map_url = 'map.php';
    // Fetch the latest data.
    $.ajax({
        type: 'GET',
        url: map_url,
        data: {
            ajax_request: 'true',
            update_map: 'true',
            wing: wing_name
        },
        cache: false,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                if (response.cluster_data) {
                    // Update each cluster's vacant room count.
                    $.each(JSON.parse(response.cluster_data), function (i, obj) {
                        if (obj.vacant_rooms == 0) {
                            // If vacant rooms = 0, then display it in red.
                            $('#' + obj.cluster).attr('class', 'red');
                        } else {
                            $('#' + obj.cluster).attr('class', 'blue');
                        }
                        $('#' + obj.cluster).text(obj.vacant_rooms);
                    });
                    // Update 'Last update' time.
                    $('.update_time').find('span').text(response.update_time);
                } else {
                    clearInterval(update_interval);
                }
            }
        },
        error: function () {
            // Nothing.
        }
    });
}
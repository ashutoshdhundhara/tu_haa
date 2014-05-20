/**
 * Handles Group creation page.
 */

$(document).ready(function () {
    $("input:file, select").uniform();
    $('#input_size').bind('change', function () {
        HAA_togglePasswordFields($(this),'group.lib');
        HAA_generateGroupDetailsForm($(this).val());
    });

    $('.group_form').bind('submit', function (event) {
        event.preventDefault();

        if (HAA_validateFields() && HAA_validatePasswords()) {
            // Submit form if everything is fine.
            HAA_submitForm($(this));
        } else {
            return false;
        }
    });
});

/**
 * Global variable to hold current group size.
 * @type {Number}
 */
var curr_group_size = 0;

/**
 * Generates Html Create Group form
 * @param {Number} group_size Value selected from group size select list
 */
function HAA_generateGroupDetailsForm(group_size)
{
    if (/^\d+$/.test(group_size)) {
        // If no value selected from group size list.
        if ($('#members_table').length === 0) {
            var $members_table = $(
                '<table id="members_table">' +
                '<caption>Members Details</caption>' +
                '<tr>' +
                '<th>Roll Number</th>' +
                '<th>Unique ID</th>' +
                '</tr>' +
                '<tr>' +
                '<td colspan="2">' +
                '<input type="submit" name="submit" value="Create">' +
                '</tr>' +
                '</table>'
            );
            // Insert after password fields.
            $('#password_table').after($members_table);
            // Styling for submit button.
            $('input:submit').addClass('submit_button green_grad');
            HAA_generateMemberFields(group_size);
        } else {
            HAA_generateMemberFields(group_size);
        }
    } else {
        // If '...' selected from group size list
        // remove password and other fields and reinitialize curr_group_size.
        $('#members_table').remove();
        curr_group_size = 0;
    }
}

/**
 * Generates Html for Roll No and Unique ID fields.
 * @param {Number} group_size Size of the group
 */
function HAA_generateMemberFields(group_size)
{
    var $members_table = $('#members_table');
    // Increase number of fields at the bottom.
    if (curr_group_size <= group_size) {
        while (true) {
            if (group_size == curr_group_size) {
                break;
            }
            var $member_row = $(
                '<tr>' +
                '<td>' +
                '<input type="text" name="roll_no[]" class="required tip_left"' +
                ' title="Please provide Roll Number of group member">' +
                '</td>' +
                '<td>' +
                '<input type="text" name="unique_id[]" class="required tip_right"' +
                ' title="Please provide Unique ID of group member.">' +
                '</td>' +
                '</tr>'
            );
            $member_row.find('.tip_left')
                .tooltip(tooltip_left)
                .mask(roll_no_format);
            $member_row.find('.tip_right')
                .tooltip(tooltip_right)
                .mask(unique_id_format);
            $members_table.find('tr:last').before($member_row);
            curr_group_size++;
        }
    } else {
        // Remove fields from bottom.
        if ($members_table.length !== 0) {
            while (true) {
                if (group_size == curr_group_size) {
                    break;
                }
                $members_table.find('tr:last').prev().remove();
                curr_group_size--;
            }
        }
    }
}
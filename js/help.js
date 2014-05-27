/**
 * Handles frontend for help page.
 */

$(document).ready(function () {
    $("a[rel]").overlay({
        onBeforeLoad: function (event) {
            // Get filename.
            var filename = $(event.target).attr('data-file');
            // Append overlay image src.
            $('#overlay_image')
            .attr('src', 'img/snapshots/' + filename);
            // Add caption to image.
            $('#simple_overlay')
            .find('h2')
            .text(messages[filename][0]);
            // Add image description.
            $('#simple_overlay')
            .find('p')
            .text(messages[filename][1]);
        },
        onClose: function () {
            // Clear image src.
            $('#overlay_image')
            .attr('src', '');
            // Clear caption to image.
            $('#simple_overlay')
            .find('h2')
            .text('');
            // Clear image description.
            $('#simple_overlay')
            .find('p')
            .text('');
        }
    });
});

/**
 * Holds all image captions and descriptions.
 * @type {Array}
 */
var messages = Array();
messages['snapshot_unique_ID.png'] = Array(
    'Passkey',
    'Use the Passkey you received on Web-Kiosk to register.'
);
messages['snapshot_group.png'] = Array(
    'Group Registration',
    'Select group option to register as part of a group.'
);
messages['snapshot_individual.png'] = Array(
    'Individual Registration',
    'Select individual option to register as an individual.'
);
messages['snapshot_loginID_individual.png'] = Array(
    'LoginID',
    'A system generated LoginID will be issued on successful registration.'
);
messages['snapshot_groupID.png'] = Array(
    'GroupID',
    'A system generated group LoginID will be issued for the entire group.'
);
messages['snapshot_wingmap.png'] = Array(
    'Wing Map',
    'Choose the wing and then select the cluster you the want room in.'
);
messages['snapshot_clustermap.png'] = Array(
    'Cluster Map',
    'Select the rooms you want from your desired cluster.'
);
messages['snapshot_reorder.png'] = Array(
    'Reorder',
    'Drag and reorder member names to assign rooms within the group.'
);
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
messages['snapshot_uid.png'] = Array(
    'Caption',
    'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
);
/**
 * Contains functions and variables common to all Javascripts.
 */

$(document).ready(function () {
    $('select, input:file, input:button').uniform();
    $('[title]').tooltip(tooltip_defaults);
});

/**
 * Default options for tooltip widget.
 */
var tooltip_defaults = {
    position: {
      my: 'left center',
      at: 'right center'
    },
    tooltipClass: 'haa_tooltip'
};

/**
 * Validates an input field.
 *
 * @param elem which is to be parsed
 * @param string type of element (text,password,date etc)
 * @return bool
 */
function validateField(elem, type)
{

}

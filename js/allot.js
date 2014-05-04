/**
 * Handles post room selection page.
 */

$(document).ready(function () {
    $('#member_list').sortable({
      placeholder: 'ui-state-highlight',
      items: 'li:not(:first)'
    });
    $('#member_list').disableSelection();
});
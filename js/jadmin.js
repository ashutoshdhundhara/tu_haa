/**
 * Handles Admin page.
 */

$(document).ready(function () {
    $('.admin_content').accordion();
    $('.roll_no').mask(roll_no_format);
    $('.cluster').mask(cluster_format);
    $('.ui-accordion-content').addClass('gray_grad');
    // $("input:file, select").uniform();
});
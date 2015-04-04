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
    $(".radio").buttonset();

    // Handler for form submission.
    $('.admin_page form').submit(function (event) {
        event.preventDefault();
        HAA_submitForm($(this));
    });
    
    $('#input_vacate_all').change(function () {
        if ($(this).is(':checked')) {
            $('#input_exclusion_list').removeAttr("disabled");
            $('#uniform-input_exclusion_list').removeClass("disabled");
        } else {
            $('#input_exclusion_list').attr("disabled", "disabled");
            $('#uniform-input_exclusion_list').addClass("disabled");
        }
    });
});
/**
 * Manages User registration page.
 */

$(document).ready(function () {
    var branches = ['COE'
    , 'MEE'
    , 'ECE'
    , 'CIE'
    , 'EIC'
    , 'ELE'
    ];
    $("#input_branch").autocomplete({
        source: branches
    });
});
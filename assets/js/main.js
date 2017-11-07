var $ = require('jquery');

// require('bootstrap-sass');

//require('bootstrap-sass/javascripts/bootstrap/tooltip');
//require('bootstrap-sass/javascripts/bootstrap/popover');
/*

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});*/

function copyToClipboard(text) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
}

$('.copy').bind('click', function (event) {
    var text = $(event.target).data('text');
    copyToClipboard(text);
});
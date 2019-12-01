jQuery(document).ready(function($) {
$(".smart-rate-image").hover(function() {
    $(this).addClass('image-transition');
    }, function() {
        $(this).removeClass('image-transition');
    });
});
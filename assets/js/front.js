jQuery(document).ready(function($) {

// slider für smart-rate-container
$(".smart-rate-container").slideDown(1500);

// hover-effekt für image mittels css-class add & remove
$(".smart-rate-image").hover(function() {
    $(this).addClass('image-transition');
    }, function() {
        $(this).removeClass('image-transition');
    });
});
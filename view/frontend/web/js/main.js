require([
    'jquery', 'domReady!'
], function($) {
    $(document).ready(function() {
        // Adjust menu link images
        // Todo - Remove test
        var newHeight = '50px';
        //var newHeight = $('.mm-link-label').css('font-size');
        $('.mm-link-icon img').css('height', newHeight);

        // Adjust menu link arrow position
        var arrowIcon = $('.mm-menu ul.submenu .ui-menu-icon');
        // Todo - Remove test
        var newTop = '35%';
        //var newTop = arrowIcon.closest('.ui-menu-item').height()/2;
        arrowIcon.css('top', newTop);
    });
});
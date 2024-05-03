
jQuery(document).ready(function ($) {
    $('.popup-modal').hide();
    var popups = $('.popup-modal');
    var popupDelay = custom_ajax_object.popupDelay * 1000;
    var popupDuration = custom_ajax_object.popupDuration * 1000;
    var popupInterval = custom_ajax_object.popupInterval * 1000;
    var currentIndex = 0;

    function showPopup(index) {
        $('.popup-modal').fadeOut(1000);

        popups.eq(index).fadeIn(1000);

        setTimeout(function () {

            popups.eq(index).fadeOut(1000);
            currentIndex++;

            setTimeout(function () {
                showPopup(currentIndex % popups.length);
            }, popupInterval);

        }, popupDuration);
    }


    setTimeout(function () {
        showPopup(currentIndex);
    }, popupDelay);


    $('.close-button').click(function () {
        $('.popup-modal').fadeOut(1000);
        // $('.popup-modal').hide();
    });
});
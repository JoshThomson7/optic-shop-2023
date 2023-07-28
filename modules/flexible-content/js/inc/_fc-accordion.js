/*
-----------------------------------------------------
    ___                            ___
   /   | ______________  _________/ (_)___  ____
  / /| |/ ___/ ___/ __ \/ ___/ __  / / __ \/ __ \
 / ___ / /__/ /__/ /_/ / /  / /_/ / / /_/ / / / /
/_/  |_\___/\___/\____/_/   \__,_/_/\____/_/ /_/

-----------------------------------------------------
Accordion
*/

jQuery(document).ready(function ($) {

    // get url hash
    var hash = window.location.hash;
    if (hash && hash.indexOf('#fc-accordion') > -1) {
        var accordionEl = $('#' + hash.replace('#', ''));
        accordionEl.addClass('active');
        accordionEl.find('h3.toggle span').toggleClass('fa-chevron-down fa-chevron-up');
    }

    $('h3.toggle').click(function (event) {
        event.preventDefault()
        var element = $(this)
        var wrap = element.closest('.accordion__wrap')
        element.closest('.fc-layout-container').find('.accordion__wrap').each(function () {
            if ($(this).is(wrap)) {
                $(this).toggleClass('active')
                $(this).find('.toggle i').toggleClass('fa-plus fa-minus')
            } else {
                $(this).removeClass('active')
                $(this).find('.toggle i').removeClass('fa-minus').addClass('fa-plus');
            }
        })
    });

});

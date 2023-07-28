// JS Awesomeness

/*
-------------------------------------------
    ____           __          __
   /  _/___  _____/ /_  ______/ /__  _____
   / // __ \/ ___/ / / / / __  / _ \/ ___/
 _/ // / / / /__/ / /_/ / /_/ /  __(__  )
/___/_/ /_/\___/_/\__,_/\__,_/\___/____/

-------------------------------------------
*/

// Libs
// @codekit-prepend quiet "../lib/tooltipster/js/_tooltipster.bundle.min.js";
// @codekit-prepend quiet "../lib/mmenu/js/_mmenu.js";
// @codekit-prepend quiet "../lib/slick/js/_slick.min.js";
// @codekit-prepend quiet "../lib/lightgallery/js/_lightgallery.js";
// @codekit-prepend quiet "../lib/lightslider/js/_lightslider.js";
// @codekit-prepend quiet "../lib/chosen/js/_chosen.jquery.min.js";
// @codekit-prepend quiet "../lib/blazy/_blazy.min.js";
// @codekit-prepend quiet "../lib/isotope/_imagesloaded.pkgd.min.js";
// @codekit-prepend quiet "../lib/isotope/_isotope.pkgd.min.js";
// @codekit-prepend quiet "../lib/modal-video/js/_modal-video.min.js";

// Includes
// @codekit-prepend "./inc/_helpers.js";
// @codekit-prepend "./inc/_widget-filterify.js";

// Modules
// @codekit-prepend "../modules/advanced-video-banners/js/_avb.js";
// @codekit-prepend "../modules/flexible-content/js/_flexible-content.js";

jQuery(function ($) {

    $().loadDependencies();
    $().tooltips();
    $().mobileMenu("nav#nav_mobile", "left");
    $().smoothScroll();
    $().scrollToTop();
    $().chosenSelect();
    $().footerAccordion();
    $().lazyLoad();

    /**
     * Video Pop Up
     */
    $(".video-pop").lightGallery({
        hash: false,
        videoMaxWidth: "1200px",
        zoom: false,
        videojsOptions: {
            autoplay: 1,
        },
    });

    /**
     * Plyr
     */
    var audioPlayers = document.querySelectorAll(".fc-audio-player");
    audioPlayers.forEach(function (player) {
        var player = new Plyr(player, {
            invertTime: false,
            controls: ["play", "progress", "mute", "volume"],
        });
    });
});

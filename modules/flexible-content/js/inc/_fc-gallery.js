/*
------------------------------------------------
   ______      ____
  / ____/___ _/ / /__  _______  __
 / / __/ __ `/ / / _ \/ ___/ / / /
/ /_/ / /_/ / / /  __/ /  / /_/ /
\____/\__,_/_/_/\___/_/   \__, /
                         /____/
------------------------------------------------
Gallery
*/
jQuery(document).ready(function($){
	$(".fc_gallery .gallery__images").lightGallery({
        hash: false,
        download: false
    });

    var gallery = $('.gallery__images.gallery__carousel');
    var galleryItems = 6;
    var inSidebar = gallery.closest('.apm__content--content');

    if(gallery.length > 0) {

        if(inSidebar.length > 0) {
            galleryItems = 3
        }

        $('.gallery__images.gallery__carousel').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            arrows: false,
            fade: false,
            adaptiveHeight: true,
            cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1)',
            responsive : [
                {
                    breakpoint: 900,
                    settings: {
                      slidesToShow: 4,
                      slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1
                    }
                }
            ]
        });
    }
});

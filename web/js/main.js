(function ($) {
    $(document).ready(function () {
        // Show/hide back to top div.
        $(window).load(function () {
            $(window).scroll(function () {
                if ($(document).scrollTop() > 0) {
                    $('#back-to-top').css({bottom: "50px"});
                }
                else {
                    $('#back-to-top').css({bottom: "-80px"});
                }
            });
        });

        // Back to top button click behavior.
        $('#back-to-top').on("click", function () {
            $('html, body').animate({scrollTop: 0}, 'slow');
            return false;
        });

        // Scroll spy
        $('body').scrollspy({ target: '#main-menu' });

        // Smooth scroll
        $("#main-menu ul li a[href^='#']").on('click', function(e) {
            e.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 400, 'swing', function() {
                window.location.hash = hash;
            });
        });

        // Room datepickers.
        $(".room-datepicker").datepicker({
            language: '{{ language }}',
            autoclose: true,
            startDate: 'now'
        });

        // Ensure "to" date is greater than "from" date.
        $(".room-datepicker-from").on('changeDate', function(e) {
            $(".room-datepicker-to").datepicker('clearDates').datepicker('setStartDate', e.date);
        });

        // Main site slideshow.
        $("#home-slideshow .royalSlider").royalSlider({
            keyboardNavEnabled: true,
            imageScaleMode: 'fill',
            autoScaleSlider: true,
            loopRewind: true,
            randomizeSlides: true,
            transitionType: 'fade',
            autoPlay: {
                enabled: true,
                pauseOnHover: true
            },
            controlNavigation: 'none',
            fullscreen: {
                enabled: true,
                nativeFS: false
            }
        });

        // Home rooms preview slideshows.
        $("#rooms .royalSlider").royalSlider({
            imageScaleMode: 'fill',
            autoScaleSlider: true,
            loopRewind: true,
            controlNavigation: 'none',
            autoPlay: {
                enabled: true,
                pauseOnHover: true
            }
        });

        // Main room slideshow.
        $("#room-slideshow .royalSlider").royalSlider({
            keyboardNavEnabled: true,
            imageScaleMode: 'fill',
            autoScaleSlider: false,
            loopRewind: true,
            randomizeSlides: true,
            transitionType: 'fade',
            autoPlay: {
                enabled: true
            },
            controlNavigation: 'thumbnails',
            fullscreen: {
                enabled: true,
                nativeFS: false
            }
        });
    });
})(jQuery);
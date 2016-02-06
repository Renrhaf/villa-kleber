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

        // Show datepicker on icon click.
        $('.booking-dates .icon').click(function() {
            $(this).parents('.booking-date').find('input').datepicker('show');
        });

        // Booking room options.
        $('.booking-room').find('input:checked').parents('.radio').addClass('active');
        $('.booking-room input').click(function() {
            var parent = $(this).parents('.booking-room');

            // Remove previous one.
            $(parent).find('.active').removeClass('active');

            // Add curently selected.
            $(parent).find('input:checked').parents('.radio').addClass('active');
        });

        // Calendar navigation.
        init_calendar_ajax();

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

    /**
     * Initialize buttons to load calendar in AJAX.
     */
    function init_calendar_ajax()
    {
        $('.calendar header a').on('click', function(e) {
            var url = $(this).attr('href');
            var calendar = $(this).parents('.calendar');

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function (html) {
                    $(calendar).replaceWith(html);
                    init_calendar_ajax();
                },
                beforeSend: function() {
                    $(calendar).html('LOL');
                }
            });

            e.preventDefault();
            return false;
        });
    }
})(jQuery);
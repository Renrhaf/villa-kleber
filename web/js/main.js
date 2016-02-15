(function ($) {
    $(document).ready(function () {
        // Menu responsive.
        $('#menu-responsive').click(function() {
            $('#menu-responsive').toggleClass('active');

            if ($('#menu-responsive').hasClass('active')) {
                $('#main-menu').css('display', 'block');
            } else {
                $('#main-menu').css('display', '');
            }
        });

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

        // Google map
        google.maps.event.addDomListener(window, 'load', init_map);
    });

    /**
     * Initialize buttons to load calendar in AJAX.
     */
    function init_calendar_ajax()
    {
        // Calendar AJAX.
        $('.calendar header a').on('click', function(e) {
            var url = $(this).attr('href');
            var calendar = $(this).parents('.calendar');

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function (html) {
                    $(calendar).fadeOut(function() {
                        $(this).replaceWith(html).fadeIn();
                        init_calendar_ajax();
                    });

                },
                beforeSend: function() {
                    $(calendar).fadeOut(function() {
                        $(this).html('<div class="ajax-loader"><i class="fa fa-cog fa-spin"></i> ' + Translator.trans('ajax.wait') + '</div>').fadeIn();
                    });
                }
            });

            e.preventDefault();
            return false;
        });

        // Calendar tooltips.
        $('.calendar .day-bookings .booking').tooltip({
            trigger: 'click hover focus',
            placement: 'bottom',
            container: 'body',
            title: function() {
                var translation = 'booking';
                if ($(this).hasClass('booking-red')) {
                    translation = translation + '.red';
                } else if ($(this).hasClass('booking-green')) {
                    translation = translation + '.green';
                } else {
                    translation = translation + '.blue';
                }

                if ($(this).hasClass('validated')) {
                    translation = translation + '.validated';
                } else {
                    translation = translation + '.unconfirmed';
                }

                return Translator.trans(translation);
            }
        });
    }

    /**
     * Initialize the google map.
     */
    function init_map() {
        var center = new google.maps.LatLng(48.5859718, 7.743764800000008);
        var myOptions = {
            zoom: 15,
            center: center,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map($('#map .gmap-map')[0], myOptions);
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(48.5859718, 7.743764800000008)
        });
        infowindow = new google.maps.InfoWindow({content: '<strong>Villa Kleber</strong><br> 6 Quai Kleber, 67000 Strasbourg<br>'});
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
        infowindow.open(map, marker);
        google.maps.event.addDomListener(window, 'resize', function() {
            map.setCenter(center);
        });
    }
})(jQuery);
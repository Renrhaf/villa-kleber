(function ($) {
    <!-- ================================================== -->
    <!-- =============== START JS OPTIONS ================ -->
    <!-- ================================================== -->

    $(document).ready(function () {
        // Go to top button
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

        $('#back-to-top').on("click", function () {
            $('html, body').animate({scrollTop: 0}, 'slow');
            return false;
        });
    });
})(jQuery);
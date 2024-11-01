jQuery(document).ready(function ($) {
    setTimeout(function () {
        wfpc_welcome_pop();
    }, 100);
    function wfpc_welcome_pop() {
        var pathname = location.pathname.split('/').slice(-1)[0];
        if (pathname == 'plugins.php') {
            var scrollTop = $(window).scrollTop(),
                elementOffset = $('tr[data-slug="wp-forms-puzzle-captcha"]').offset().top,
                distance = (elementOffset - scrollTop);
            otheight = $('.wfpc-activate-tooltip').outerHeight();
            $('.wfpc-activate-tooltip').fadeIn('slow');
            $('.wfpc-activate-tooltip').css('top', distance - otheight);
        }
    }
});


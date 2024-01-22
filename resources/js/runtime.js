(function ($) {
    $(".menu-item").on('mouseenter', function () {
        $(".header-dropdown").removeClass('header-dropdown-open');
        if ($(this).hasClass('menu-item-has-children')) {
            $($(this).data('target')).addClass('header-dropdown-open');
        }
    });

    $(".main-menu,.header-dropdown").on('mousemove', function (event) {
        event.stopPropagation();
    });

    $(document).on('mousemove', function (e) {
        $(".header-dropdown").removeClass('header-dropdown-open');
    });

    $("#toggleMobileNav").on('click', function () {
        $("#sideNav").toggleClass('side-nav-show');
        $("#main").toggleClass('side-open');
    });

    $("#sideNav .has-children").on('click', function () {
        $(this).siblings('.submenu').toggle();
    });

    Fancybox.bind("[data-fancybox=gallery]", {
        // Your custom options
    });
    Fancybox.bind("[data-fancybox=video]", {
        // Your custom options
    });
    Fancybox.bind("[data-fancybox=card]", {
        // Your custom options
    });

    $("[data-action=form]").on('click', function () {

    });
})(jQuery);
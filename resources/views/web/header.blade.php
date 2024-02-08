<header class="header">
    <div class="logo-wrapper">
        <img src="{{settings('logo')}}" class="logo" alt=""/>
    </div>
    <div class="menus">
        <ul class="menu-list">
            <li class="menu-item"><a href="{{url('')}}">Home</a></li>
            <li class="menu-item"><a href="{{url('')}}">NOODLEBOX FOOD MENU</a></li>
            <li class="menu-item"><a href="{{url('')}}">OUR MEMORY</a></li>
            <li class="menu-item"><a href="{{url('')}}">FOOD ALLERGIES</a></li>
            <li class="menu-item"><a href="{{url('')}}">ABOUT US</a></li>
        </ul>
    </div>
</header>
<script>
    (function ($) {
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 64) {
                $('.header').addClass('bg-crimson');
            } else {
                $('.header').removeClass('bg-crimson');
            }
        })
    })(jQuery);
</script>
<div class="header-mobile">
    <div class="header-left">
        <a href="{{url('/shop')}}">
            <img src="{{settings('logo')}}" class="logo" alt=""/>
        </a>
    </div>
    <div class="header-title"></div>
    <div class="header-right">
        <a class="menu-btn" id="openMobileNav">
            <i class="bi bi-list"></i>
        </a>
    </div>
</div>
<div class="mobile-nav-wrapper">
    <ul class="mobile-nav-navs">
        <li>
            <a class="has-children">OUR SHOP</a>
            <ul class="submenu">
                <li><a href="{{url('shop')}}">DROGHEDA SHOP</a></li>
                <li><a href="{{url('points-mall')}}">POINTS MALL</a></li>
            </ul>
        </li>
        <li>
            <a class="has-children">NOODLEBOX FOOD MENU</a>
            <ul class="submenu">
                @foreach($categories as $category)
                    <li><a href="{{$category->url}}">{{$category->name}}</a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="{{url('our-memory')}}">OUR MEMORY</a></li>
        <li><a href="{{url('food-allergies')}}">FOOD ALLERGIES</a></li>
        <li><a href="{{url('about-us')}}">ABOUT US</a></li>
    </ul>
</div>
<script>
    (function ($) {
        $("#openMobileNav").on('click', function () {
            $("#main").toggleClass("main-open");
            $(".mobile-nav-wrapper").toggleClass("mobile-nav-open");
        });
        $(".mobile-nav-navs .has-children").on('click', function () {
            $(this).siblings('.submenu').toggle();
        });
    })(jQuery);
</script>
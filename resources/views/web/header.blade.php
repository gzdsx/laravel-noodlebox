<div class="header-wrapper">
    <header class="header">
        <div class="logo-wrapper">
            <a href="{{url('/')}}">
                <img src="{{settings('logo')}}" class="logo" alt=""/>
            </a>
        </div>
        <div class="menus">
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="{{url('/')}}" class="menu-link menu-has-children">OUR SHOP</a>
                    <ul class="submenu">
                        <li><a href="{{url('shop')}}">DROGHEDA SHOP</a></li>
                        <li><a href="{{url('points-mall')}}">POINTS MALL</a></li>
                    </ul>
                </li>
                <li class="menu-item">
                    <a href="{{url('shop')}}" class="menu-link menu-has-children">NOODLEBOX FOOD MENU</a>
                    <ul class="submenu">
                        @foreach($categories as $category)
                            <li><a href="{{$category->url}}">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="menu-item"><a href="{{url('our-memory')}}">OUR MEMORY</a></li>
                <li class="menu-item"><a href="{{url('food-allergies')}}">FOOD ALLERGIES</a></li>
                <li class="menu-item"><a href="{{url('about-us')}}">ABOUT US</a></li>
            </ul>
        </div>
        <div class="menu-right">
            @if(Auth::check())
                <div class="menu-user">
                    <a href="{{route('my-account')}}" class="user-btn">
                        <i class="bi bi-person-fill"></i>
                        <span>{{Auth::user()->nickname}}</span>
                    </a>
                    <a href="{{url('cart')}}" class="logout-btn">
                        <i class="bi bi-cart">
                            <span class="badge cart-count">0</span>
                        </i>
                    </a>
                </div>
            @else
                <div class="menu-user">
                    <a href="{{url('login')}}" class="user-btn">
                        <i class="bi bi-person-fill"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{url('cart')}}" class="logout-btn">
                        <i class="bi bi-cart">
                            <span class="badge cart-count">0</span>
                        </i>
                    </a>
                </div>
            @endif
        </div>
    </header>
</div>
<script>
    (function ($) {
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 20) {
                $('.header').addClass('bg-crimson');
            } else {
                $('.header').removeClass('bg-crimson');
            }
        });
    })(jQuery);
</script>
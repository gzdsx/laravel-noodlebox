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
            <div class="menu-user">
                @auth
                    <div class="dropdown">
                        <a href="{{route('my-account')}}" role="button">
                            <img src="{{auth()->user()->avatar}}" class="avatar" alt="">
                            <span>{{auth()->user()->nickname}}</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('my-account')}}">My Account</a>
                            <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                        </div>
                    </div>
                @endauth
                @guest
                    <div>
                        <a href="{{route('login')}}" class="user-btn">
                            <img src="{{asset('images/common/avatar_default.png')}}" class="avatar" alt="">
                            <span>Login</span>
                        </a>
                    </div>
                @endguest

                <div>
                    <a href="{{url('cart')}}" class="logout-btn">
                        <i class="bi bi-cart">
                            <span class="badge cart-count">0</span>
                        </i>
                    </a>
                </div>
            </div>
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
<header class="header-pc">
    <div class="header-fixed">
        <div class="container-fluid header-container">
            <div class="global-logo">
                <a href="{{url('/')}}">
                    <img src="{{settings('logo')}}" alt="">
                </a>
            </div>
            <div class="main-nav">
                <ul id="menu-main" class="main-menu">
                    <li class="menu-item menu-item-has-children" data-target="#dropdownServices">
                        <a href="{{url('services')}}">Services</a>
                    </li>
                    <li class="menu-item menu-item-has-children" data-target="#dorpdownProperties">
                        <a href="{{url('rental/listings')}}">Properties</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{url('forms-resources')}}">Forms &amp; Resources</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{url('insights-research')}}">Insights & Research</a>
                    </li>
                    <li class="menu-item menu-item-has-children" data-target="#dropdownAbout">
                        <a href="{{url('about-us')}}">About Us</a>
                    </li>
                </ul>
            </div>
            <div class="header-right">
                <a href="{{url('search')}}" class="btn btn-light btn-sm btn-search rounded-circle">
                    <i class="bi bi-search"></i>
                </a>
                <a href="https://sterlingmgmt.managebuilding.com/Resident/rental-application/new/apply"
                   target="_blank" class="btn btn-tiffany-blue btn-sm rounded-pill text-uppercase">
                    Rental Application
                </a>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle rounded-pill text-uppercase" data-toggle="dropdown" aria-expanded="false">
                        Client Login
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item text-uppercase text-dark" href="https://sterlingmgmt.managebuilding.com/manager/public/authentication/login">Rental Owner</a>
                        <a class="dropdown-item text-uppercase text-dark" href="https://sterlingmgmt.managebuilding.com/Resident/portal/">Strata Owner</a>
                        <a class="dropdown-item text-uppercase text-dark" href="https://sterlingmgmt.managebuilding.com/Resident/portal/">tenant</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative">
            <div class="header-dropdown" id="dropdownServices">
                <div class="dropdown-back">
                    <div class="row">
                        <div class="col-4">
                            <div class="dropdown-description">
                                <h1>Services</h1>
                                <div>{!! snippet(4)->content !!}</div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                @foreach(get_categories(['taxonomy'=>'service']) as $category)
                                    <div class="col">
                                        <h3 class="text-light-slate-gray">{{$category->name}}</h3>
                                        <ul>
                                            @foreach(get_posts(['type'=>'service','cate'=>$category->cate_id]) as $post)
                                                <li><a href="{{$post->url}}">{{$post->title}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-dropdown" id="dorpdownProperties">
                <div class="dropdown-back">
                    <div class="row">
                        <div class="col-4">
                            <div class="dropdown-description">
                                <h1>Properties</h1>
                                <div>
                                    {!! snippet(5)->content !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <h3><a href="{{url('properties')}}" class="text-light-slate-gray">For Sale</a></h3>
                                </div>
                                <div class="col">
                                    <h3><a href="{{url('rental/listings')}}" class="text-light-slate-gray">For Rent</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-dropdown" id="dropdownAbout">
                <div class="dropdown-back">
                    <div class="row">
                        <div class="col-4">
                            <div class="dropdown-description">
                                <h1>About Us</h1>
                                <div>
                                    {!! snippet(6)->content !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <ul>
                                        <li><a href="{{url('about-us')}}">About Us</a></li>
                                        <li><a href="{{url('join-us')}}">Join Us</a></li>
                                        <li><a href="{{url('contact-us')}}">Contact Us</a></li>
                                        <li><a href="{{url('request-for-proposal')}}">Request For Proposal</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
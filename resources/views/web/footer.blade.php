<footer class="footer">
    <div class="container footer-container">
        <div class="row flex-column flex-lg-row">
            <div class="col col-lg-3 mb-4 mb-md-0">
                <a href="{{url('/')}}">
                    <img src="{{settings('foot_logo')}}" class="footer-logo" alt="">
                </a>
            </div>

            <div class="col">
                <div class="footer-nav">
                    <h5><a href="{{url('about-us')}}">About Sterling</a></h5>
                    <h5><a href="{{url('join-us')}}">Join Us</a></h5>
                    <h5><a href="{{url('contact-us')}}">Office Locations</a></h5>
                    <h5><a href="{{url('request-for-proposal')}}"> Submit RFP</a></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer-copyright">
        <div class="col d-flex flex-column flex-md-row">
            <div class="text-muted flex-grow-1">{{settings('copyright')}}</div>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://www.linkedin.com" target="_blank">
                    <i class="bi bi-linkedin"></i>
                </a>
                <a href="https://www.x.com" target="_blank">
                    <i class="bi bi-twitter"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
<footer class="ftco-footer bg-bottom ftco-no-pt" style="background-image: url({{ asset('images/bg_3.jpg') }});">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md pt-5">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">About TravelEsy</h2>
                        <p>Your trusted travel partner for discovering amazing destinations around the world. We make travel easy and memorable.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft">
                            <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- Quick Links -->
                <div class="col-md pt-5 border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Quick Links</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}" class="py-2 d-block"> Home</a></li>
                            <li><a href="{{ url('/blogs') }}" class="py-2 d-block"> Blog</a></li>
                            <li><a href="{{ route('about') }}" class="py-2 d-block"> About</a></li>
                            <li><a href="{{ route('contact') }}" class="py-2 d-block"> Contact</a></li>
                            <li><a href="{{ route('terms') }}" class="py-2 d-block"> Terms</a></li>
                            <li><a href="{{ route('privacy') }}" class="py-2 d-block"> Privacy</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Services Widget -->
                <div class="col-md pt-5 border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">Services</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('tours.all') }}" class="py-2 d-block"><i class="fa fa-map-signs mr-1"></i> Trips & Tours</a></li>
                            <li><a href="{{ route('hotels.all') }}" class="py-2 d-block"><i class="fa fa-hotel mr-1"></i> Hotel Booking</a></li>
                            <li><a href="{{ route('flights.all') }}" class="py-2 d-block"><i class="fa fa-plane mr-1"></i> Flight Booking</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md pt-5 border-left">
                    <div class="ftco-footer-widget pt-md-5 mb-4">
                        <h2 class="ftco-heading-2">Contact Info</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon fa fa-map-marker"></span><span class="text">123 Travel Street, City, Country</span></li>
                                <li><a href="tel:+1234567890"><span class="icon fa fa-phone"></span><span class="text">+1 234 567 890</span></a></li>
                                <li><a href="mailto:info@travelesy.com"><span class="icon fa fa-envelope"></span><span class="text">info@travelesy.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | TravelEsy</p>
                </div>
            </div>
        </div>
    </footer>
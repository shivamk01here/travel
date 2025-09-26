<!-- Popular Cities -->
<section class="ftco-section img ftco-select-destination" style="background-image: url({{ asset('images/bg_3.jpg') }});">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">TravelEsy Destinations</span>
                <h2 class="mb-4">Hotels in Popular Cities</h2>
            </div>
        </div>
    </div>
    <div class="container container-2">
        <div class="row">
            <div class="col-md-12">
                <div class="carousel-destination owl-carousel ftco-animate">
                    @foreach($cities as $c)
                    <div class="item">
                        <div class="project-destination">
                            <a href="{{ route('hotels.index', ['city'=>$c->slug]) }}" class="img" style="background-image: url(https://placehold.co/400x300?text={{ urlencode($c->name) }});">
                                <div class="text">
                                    <h3>{{ $c->name }}</h3>
                                    <span>{{ rand(2,15) }} Hotels</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
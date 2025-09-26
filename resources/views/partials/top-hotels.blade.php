<!-- Top Picks Hotels -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Accommodation</span>
                <h2 class="mb-4">Top Picks Hotels</h2>
            </div>
        </div>
        <div class="row">
            @foreach($hotels as $h)
            <div class="col-md-4 ftco-animate">
                <div class="project-wrap">
                    <a href="{{ route('hotels.show', $h->slug) }}" class="img" style="background-image: url(https://placehold.co/400x300?text=Hotel);">
                        <span class="price">₹{{ number_format($h->min_price, 0) }}/night</span>
                    </a>
                    <div class="text p-4">
                        <span class="days">{{ $h->city_name }}</span>
                        <h3><a href="{{ route('hotels.show', $h->slug) }}">{{ $h->name }}</a></h3>
                        <p class="location"><span class="fa fa-map-marker"></span> {{ $h->city_name }}</p>
                        <ul>
                            <li><span class="flaticon-shower"></span>{{ rand(1,3) }}</li>
                            <li><span class="flaticon-king-size"></span>{{ rand(1,4) }}</li>
                            <li><span class="fa fa-star"></span>{{ $h->avg_rating }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
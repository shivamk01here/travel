<!-- Featured Tours -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Adventure</span>
                <h2 class="mb-4">Featured Tours</h2>
            </div>
        </div>
        <div class="row">
            @foreach($topTours as $tour)
            <div class="col-md-4 ftco-animate">
                <div class="project-wrap">
                    <a href="{{ route('tours.show', $tour->id) }}" class="img" style="background-image: url(https://placehold.co/400x300?text=Tour);">
                        <span class="price">₹{{ number_format($tour->price,0) }}/person</span>
                    </a>
                    <div class="text p-4">
                        <span class="days">{{ rand(3,10) }} Days Tour</span>
                        <h3><a href="{{ route('tours.show', $tour->id) }}">{{ $tour->name }}</a></h3>
                        <p class="location"><span class="fa fa-map-marker"></span> {{ $tour->highlights }}</p>
                        <ul>
                            <li><span class="flaticon-shower"></span>{{ rand(1,3) }}</li>
                            <li><span class="flaticon-king-size"></span>{{ rand(2,4) }}</li>
                            <li><span class="flaticon-sun-umbrella"></span>Adventure</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
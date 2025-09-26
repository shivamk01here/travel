<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center">
                <h2 class="mb-4">Featured Hotels</h2>
            </div>
        </div>
        <div class="row">
            @foreach($hotels as $hotel)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ $hotel->image_url }}" class="card-img-top" alt="{{ $hotel->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $hotel->name }}</h5>
                            <p class="card-text">{{ Str::limit($hotel->description, 80) }}</p>
                            <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-sm btn-primary">View Hotel</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

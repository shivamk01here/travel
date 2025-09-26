<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center">
                <h2 class="mb-4">Popular Tours</h2>
            </div>
        </div>
        <div class="row">
            @foreach($popularTours as $tour)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ $tour->image_url }}" class="card-img-top" alt="{{ $tour->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $tour->name }}</h5>
                            <p class="card-text">{{ Str::limit($tour->description, 80) }}</p>
                            <a href="{{ route('tours.index', ['city' => $tour->city]) }}" class="btn btn-sm btn-primary">View Tour</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="ftco-section testimony-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center">
                <h2 class="mb-4">What Travelers Say</h2>
            </div>
        </div>
        <div class="row">
            @foreach($testimonials as $review)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-3 h-100">
                        <p class="mb-3">“{{ Str::limit($review->content, 120) }}”</p>
                        <h6 class="font-weight-bold">- {{ $review->author }}</h6>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

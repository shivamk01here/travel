<!-- Blog Section -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Our Blog</span>
                <h2 class="mb-4">Travel Stories</h2>
            </div>
        </div>
        <div class="row">
            @foreach(array_slice($latestBlogs, 0, 3) as $blog)
            <div class="col-md-4 d-flex ftco-animate">
                <div class="blog-entry card shadow-sm w-100" style="border-radius:8px; overflow:hidden; display:flex; flex-direction:column;">
                    <!-- Fixed image -->
                    <a href="{{ url('/blogs/' . $blog->id) }}" 
                       class="block-20" 
                       style="display:block; width:100%; height:220px; background-image: url('https://placehold.co/400x300?text=Blog'); background-size:cover; background-position:center;">
                    </a>
                    <!-- Card content -->
                    <div class="text p-4 d-flex flex-column justify-content-between" style="flex:1; background:#fff;">
                        <!-- Date -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="one text-center me-2">
                                <span class="day" style="font-size:22px; font-weight:bold; display:block;">{{ date('d', strtotime($blog->created_at)) }}</span>
                            </div>
                            <div class="two">
                                <span class="yr" style="display:block; font-size:13px;">{{ date('Y', strtotime($blog->created_at)) }}</span>
                                <span class="mos" style="display:block; font-size:13px;">{{ date('M', strtotime($blog->created_at)) }}</span>
                            </div>
                        </div>
                        <!-- Title -->
                        <h3 class="heading mb-3" style="font-size:18px; font-weight:600;">
                            <a href="{{ url('/blogs/' . $blog->id) }}" style="text-decoration:none; color:#222;">{{ $blog->title }}</a>
                        </h3>
                        <!-- Button -->
                        <p>
                            <a href="{{ url('/blogs/' . $blog->id) }}" class="btn btn-primary w-100" style="border-radius:4px;">Read more</a>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

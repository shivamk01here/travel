@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ $blog->image_url ?? asset('images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">Home <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span class="mr-2">
                        <a href="{{ url('/blogs') }}">Blog <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>{{ Str::limit($blog->title, 30) }}</span>
                </p>
                <h1 class="mb-0 bread">{{ $blog->title }}</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
        <div class="row">
            <div class="col-12 ftco-animate">
                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-entry justify-content-end mb-md-5">
                            <div class="text">
                                <div class="d-flex align-items-center mb-4 topp">
                                    <div class="one">
                                        <span class="day">{{ \Carbon\Carbon::parse($blog->published_at ?? $blog->created_at)->format('d') }}</span>
                                    </div>
                                    <div class="two">
                                        <span class="yr">{{ \Carbon\Carbon::parse($blog->published_at ?? $blog->created_at)->format('Y') }}</span>
                                        <span class="mos">{{ \Carbon\Carbon::parse($blog->published_at ?? $blog->created_at)->format('F') }}</span>
                                    </div>
                                    @if($blog->author)
                                    <div class="three ml-auto">
                                        <p class="mb-0"><i class="fa fa-user"></i> By {{ $blog->author }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="blog-content">
                                    {!! nl2br(e($blog->content)) !!}
                                </div>
                                @if(isset($blog->tags) && $blog->tags)
                                <div class="tag-widget post-tag-container mb-5 mt-5">
                                    <div class="tagcloud">
                                        @foreach(explode(',', $blog->tags) as $tag)
                                        <a href="#" class="tag-cloud-link">{{ trim($tag) }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="pt-5 mt-5">
                                    <h3 class="mb-5">Share This Article</h3>
                                    <div class="d-flex">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary mr-2">
                                            <i class="fa fa-facebook"></i> Facebook
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-info mr-2">
                                            <i class="fa fa-twitter"></i> Twitter
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-secondary">
                                            <i class="fa fa-linkedin"></i> LinkedIn
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Simplified custom styles for a cleaner look */
.blog-content {
    font-size: 16px;
    line-height: 1.8;
    color: #495057;
}
.blog-content p {
    margin-bottom: 1.5rem;
}
.tag-cloud-link {
    display: inline-block;
    padding: 0.5rem 1.25rem;
    margin: 3px;
    background: #f8f9fa;
    color: #6c757d;
    text-decoration: none;
    border-radius: 20px;
    font-size: 13px;
    border: 1px solid #e9ecef;
}
.tag-cloud-link:hover {
    background: #007bff;
    color: white;
    text-decoration: none;
}
</style>
@endpush
@extends('layouts.app1')
@section('title', $hotel->name)

@push('styles')
<style>
:root { --header-height: 72px; }
body { background: #fff !important; color: #222; }
.hotel-card { background: #fff; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 6px 30px rgba(16,24,40,0.04); }
.hero-img { height: 420px; object-fit: cover; width: 100%; border-top-left-radius:12px;border-top-right-radius:12px; }
.thumb { width:72px; height:56px; object-fit:cover; border-radius:8px; cursor:pointer; border:2px solid transparent; }
.thumb.active { border-color:#f84464; }
.badge-pink { background: linear-gradient(90deg,#f84464,#ff6b8a); color:#fff; padding:6px 10px; border-radius:14px; font-weight:600; font-size:13px; }
.amenity-badge { display:inline-flex; gap:8px; align-items:center; padding:8px 10px; border-radius:12px; background:#fff9fb; border:1px solid #ffe8f0; color:#f84464; margin:6px; font-weight:600; font-size:13px; }
.meta-row { color:#6b7280; font-size:14px; }
.sticky-sidebar { position:sticky; top: calc(var(--header-height) + 16px); }
.price-pill { background: linear-gradient(135deg,#f84464 0%,#ff6b8a 100%); color:#fff; padding:8px 14px; border-radius:18px; font-weight:700; display:inline-block; }
.room-card { border-radius:12px; border:1px solid #f0f0f0; background:#fff; padding:16px; }
.icon-muted { color:#6b7280; margin-right:6px; }
.map-embed { width:100%; height:240px; border-radius:12px; border:1px solid #eee; overflow:hidden; }
.small-muted { color:#6b7280; font-size:13px; }

/* Enhanced Mobile Responsiveness */
@media (max-width:991px){ 
    .sticky-sidebar{ position: static; top:auto; } 
    .hero-img{ height:260px; } 
    .thumb{ width:56px;height:44px; } 
    .room-card { padding:12px; }
    .room-card .d-flex.flex-column.flex-md-row { flex-direction: column !important; }
    .room-card .mr-3 { margin-right: 0 !important; margin-bottom: 12px; }
    .room-card .mr-3 { flex: none !important; }
    .amenity-badge { margin: 3px; padding: 6px 8px; font-size: 12px; }
    .price-pill { padding: 6px 12px; font-size: 14px; }
    .badge-pink { padding: 4px 8px; font-size: 12px; }
}

@media (max-width:767px){
    .hero-img { height: 220px; }
    .thumb { width: 48px; height: 36px; }
    .hotel-card { margin-bottom: 16px; }
    .amenity-badge { margin: 2px; padding: 4px 6px; font-size: 11px; gap: 4px; }
    .form-row.align-items-center { gap: 8px !important; }
    .form-row .form-group { margin-bottom: 8px !important; }
    .btn-lg { padding: 8px 16px; font-size: 16px; }
    .price-pill { font-size: 13px; padding: 5px 10px; }
    h1 { font-size: 1.4rem !important; }
    h3 { font-size: 1.3rem !important; }
    h4 { font-size: 1.2rem !important; }
    h5 { font-size: 1.1rem !important; }
}

@media (max-width:575px){
    .container { padding-left: 12px; padding-right: 12px; }
    .hotel-card { border-radius: 8px; }
    .hero-img { height: 180px; border-radius: 8px 8px 0 0; }
    .thumb { width: 40px; height: 32px; }
    .d-flex.justify-content-between { flex-direction: column !important; align-items: flex-start !important; }
    .text-right { text-align: left !important; margin-top: 12px; }
    .form-row { flex-direction: column; }
    .form-row .form-group { width: 100% !important; }
    .btn-group-vertical .btn, .d-flex .btn { margin-bottom: 8px; width: 100%; }
    .d-flex.flex-wrap.align-items-center { flex-direction: column !important; align-items: stretch !important; }
}
</style>
@endpush

@section('content')
@php
    // Safe JSON decode helpers
    $images = $images ?? [];
    $rooms = $rooms ?? [];
    $amenities = [];
    $faqs = [];
    $highlights = [];
    try { $amenities = is_string($hotel->amenities) ? json_decode($hotel->amenities, true) ?? [] : (array) $hotel->amenities; } catch (\Throwable $e) { $amenities = []; }
    try { $faqs = is_string($hotel->faqs) ? json_decode($hotel->faqs, true) ?? [] : (array) $hotel->faqs; } catch (\Throwable $e) { $faqs = []; }
    try { $highlights = is_string($hotel->property_highlight) ? json_decode($hotel->property_highlight, true) ?? [] : (array) $hotel->property_highlight; } catch (\Throwable $e) { $highlights = []; }

    // Determine rating scale (if avg_rating looks >5, assume /10)
    $avgRating = is_numeric($hotel->avg_rating) ? (float) $hotel->avg_rating : null;
    $ratingScale = ($avgRating !== null && $avgRating > 5) ? 10 : 5;
    $isFeatured = !empty($hotel->is_featured);
    $petAllowed = !empty($hotel->is_pet_allowed);
    $breakfastIncluded = !empty($hotel->is_breakfast_included);
@endphp

<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('hotels.index', ['city'=>$hotel->city_slug ?? null]) }}" class="text-decoration-none" style="color:#f84464;font-weight:600;">
            <i class="fa fa-arrow-left mr-1"></i> Back to {{ $hotel->city_name ?? 'Hotels' }}
        </a>
    </div>

    <div class="row">
        {{-- MAIN COLUMN --}}
        <div class="col-lg-8">
            {{-- Gallery / Hero --}}
            <div class="hotel-card mb-4 overflow-hidden">
                <div style="position:relative;">
                    @if(count($images))
                        <img id="mainHero" 
                             src="{{ $images[0]->url ?? '' }}" 
                             alt="{{ $images[0]->alt ?? $hotel->name }}" 
                             class="hero-img w-100"
                             onerror="this.src='https://via.placeholder.com/1200x420/f84464/ffffff?text={{ urlencode($hotel->name) }}'">
                    @else
                        <img id="mainHero" 
                             src="https://via.placeholder.com/1200x420/f84464/ffffff?text={{ urlencode($hotel->name) }}" 
                             alt="{{ $hotel->name }}" 
                             class="hero-img w-100">
                    @endif

                    <div style="position:absolute; left:18px; top:18px;">
                        @if($isFeatured)
                            <span class="badge-pink mr-2">Featured</span>
                        @endif
                        @if($avgRating)
                            <span class="badge badge-light" style="background:#fff;padding:6px 10px;border-radius:10px;font-weight:700;">
                                <i class="fa fa-star text-warning mr-1"></i> {{ $avgRating }} / {{ $ratingScale }}
                            </span>
                        @endif
                    </div>

                    {{-- thumbnails --}}
                    @if(count($images) > 1)
                        <div class="p-3" style="background:#fff;">
                            <div class="d-flex flex-row align-items-center flex-wrap">
                                @foreach($images as $i => $img)
                                    <img data-src="{{ $img->url }}" 
                                         data-alt="{{ $img->alt ?? $hotel->name }}" 
                                         src="{{ $img->url }}"
                                         class="thumb {{ $i===0 ? 'active' : '' }} mr-2 mb-2" 
                                         alt="{{ $img->alt ?? $hotel->name }}" 
                                         loading="lazy"
                                         onerror="this.src='https://via.placeholder.com/120x80/f84464/ffffff?text=IMG'">
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    {{-- Hotel Title & meta --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <h1 class="mb-1" style="font-size:1.7rem;font-weight:700;">{{ $hotel->name }}</h1>
                            <div class="meta-row mb-2">
                                <i class="fa fa-map-marker icon-muted"></i>
                                {{ $hotel->address ?? ($hotel->city_name ?? '') }}
                                @if(!empty($hotel->nearest_landmarks)) 
                                    <span class="d-block d-md-inline">&middot; <span class="small-muted">Near: {{ $hotel->nearest_landmarks }}</span></span> 
                                @endif
                            </div>
                            <div class="small-muted">
                                {{ $hotel->description ?? '' }}
                            </div>
                        </div>

                        <div class="text-right mt-3 mt-md-0">
                            <div class="price-pill mb-2">From ₹{{ isset($rooms[0]) ? number_format($rooms[0]->price_per_night,0) : '-' }}</div>
                            <div class="small-muted">Avg. rating: <strong>{{ $avgRating ?? '—' }}</strong></div>
                        </div>
                    </div>

                    {{-- Contact & Website --}}
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        @if($hotel->contact_phone)
                            <a href="tel:{{ $hotel->contact_phone }}" class="btn btn-outline-secondary btn-sm mr-2 mb-2"><i class="fa fa-phone mr-1"></i> <span class="d-none d-sm-inline">{{ $hotel->contact_phone }}</span><span class="d-sm-none">Call</span></a>
                        @endif
                        @if($hotel->contact_email)
                            <a href="mailto:{{ $hotel->contact_email }}" class="btn btn-outline-secondary btn-sm mr-2 mb-2"><i class="fa fa-envelope mr-1"></i> Email</a>
                        @endif
                        @if($hotel->official_website)
                            <a href="{{ $hotel->official_website }}" target="_blank" class="btn btn-outline-secondary btn-sm mr-2 mb-2"><i class="fa fa-globe mr-1"></i> <span class="d-none d-sm-inline">Official site</span><span class="d-sm-none">Website</span></a>
                        @endif
                        @if($hotel->scrapped_page_url)
                            <a href="{{ $hotel->scrapped_page_url }}" target="_blank" class="btn btn-outline-secondary btn-sm mb-2"><i class="fa fa-external-link mr-1"></i> Source</a>
                        @endif
                    </div>

                    {{-- Highlights --}}
                    @if(!empty($highlights))
                        <div class="mb-3">
                            <h5 style="font-weight:700;">Property highlights</h5>
                            <div class="d-flex flex-wrap">
                                @foreach($highlights as $k => $v)
                                    <div class="amenity-badge">
                                        <strong style="font-size:13px;color:#b91c4a;">{{ $k }}</strong>
                                        <span style="color:#6b7280;font-weight:600;">{{ $v }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Amenities --}}
                    @if(!empty($amenities))
                        <div class="mb-3">
                            <h5 style="font-weight:700;">Amenities</h5>
                            <div class="d-flex flex-wrap align-items-center">
                                @foreach($amenities as $label => $icon)
                                    <div title="{{ $label }}" class="amenity-badge">
                                        @if(is_string($icon) && Str::startsWith($icon, 'fa'))
                                            <i class="{{ $icon }} mr-1" aria-hidden="true"></i>
                                        @endif
                                        <span style="color:#5b1b3a;">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Booking CTA --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-3">
                        <div class="small-muted mb-2 mb-md-0">Check-in: <strong>{{ $hotel->checkin_time ?? '—' }}</strong> &middot; Check-out: <strong>{{ $hotel->checkout_time ?? '—' }}</strong></div>
                        <div class="d-flex flex-column flex-sm-row">
                            <a href="#rooms" class="btn btn-danger btn-lg mr-0 mr-sm-2 mb-2 mb-sm-0"><i class="fa fa-bed mr-1"></i> View Rooms</a>
                            <a href="mailto:{{ $hotel->contact_email }}" class="btn btn-outline-secondary btn-lg"><i class="fa fa-envelope mr-1"></i> Contact Hotel</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description / Policies --}}
            <div class="mb-4 hotel-card p-4">
                <h4 style="font-weight:700;">About this property</h4>
                <p class="small-muted">{{ $hotel->description }}</p>

                @if($hotel->policies || $hotel->check_in_instruction || $hotel->cancelation_policy)
                    <hr/>
                    <h5 style="font-weight:700;">Policies & instructions</h5>
                    @if(!empty($hotel->policies))
                        <div class="mb-2">{!! nl2br(e($hotel->policies)) !!}</div>
                    @endif
                    @if(!empty($hotel->check_in_instruction))
                        <div class="mb-2"><strong>Check-in instructions:</strong> {!! nl2br(e($hotel->check_in_instruction)) !!}</div>
                    @endif
                    @if(!empty($hotel->cancelation_policy))
                        <div class="mb-2"><strong>Cancellation policy:</strong> {!! nl2br(e($hotel->cancelation_policy)) !!}</div>
                    @endif
                @endif
            </div>

            {{-- Rooms --}}
            <div id="rooms" class="mb-4">
                <h3 style="font-weight:800;">Rooms & rates</h3>
                <div class="small-muted mb-3">Showing {{ count($rooms) }} room types</div>

                @foreach($rooms as $r)
                    <div class="room-card mb-3 d-flex flex-column flex-md-row align-items-stretch">
                        <div class="mr-3" style="flex:0 0 220px;">
                            <img src="{{ $r->primary_image ?? '' }}" 
                                 alt="{{ $r->name }}" 
                                 class="w-100" 
                                 style="height:160px;object-fit:cover;border-radius:10px;"
                                 onerror="this.src='https://via.placeholder.com/420x280/f84464/ffffff?text={{ urlencode($r->name) }}'">
                        </div>
                        <div style="flex:1;">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h5 style="font-weight:700;margin-bottom:4px;">{{ $r->name }}</h5>
                                    <div class="small-muted mb-2">{{ $r->room_type }} • {{ $r->max_adults }} adults @if($r->max_children) &middot; {{ $r->max_children }} children @endif</div>
                                </div>
                                <div class="text-right mt-2 mt-md-0">
                                    <div class="price-pill">₹{{ number_format($r->price_per_night,0) }}</div>
                                    <div class="small-muted" style="margin-top:6px;">{{ $r->available_inventory ?? 0 }} rooms left</div>
                                </div>
                            </div>

                            <p class="small-muted mt-2" style="min-height:46px;">{{ $r->description }}</p>

                            <div class="d-flex flex-wrap align-items-center mb-2">
                                @if($r->refundable) <span class="badge badge-light mr-2 mb-1" style="padding:6px 10px;border-radius:12px;border:1px solid #eee;">Refundable</span> @else <span class="small-muted mr-2 mb-1">Non-refundable</span> @endif
                                @if($r->breakfast_included) <span class="badge badge-light mr-2 mb-1" style="padding:6px 10px;border-radius:12px;border:1px solid #eee;">Breakfast included</span> @endif
                                @if($r->available_inventory < 6) <span class="text-danger mr-2 mb-1">Low availability</span> @endif
                            </div>

                            {{-- Add to cart / quick book form --}}
                            <form method="POST" action="{{ route('cart.add') }}" class="mt-2">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $r->id }}">
                                <div class="form-row align-items-center" style="gap:10px;">
                                    <div class="form-group col-12 col-sm-6 col-md-3 mb-2">
                                        <label class="small-muted small mb-1">Check-in</label>
                                        <input type="date" name="check_in" required class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-12 col-sm-6 col-md-3 mb-2">
                                        <label class="small-muted small mb-1">Check-out</label>
                                        <input type="date" name="check_out" required class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-6 col-md-2 mb-2">
                                        <label class="small-muted small mb-1">Adults</label>
                                        <input type="number" name="adults" min="1" max="{{ $r->max_adults ?? 10 }}" value="2" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="form-group col-6 col-md-2 mb-2">
                                        <label class="small-muted small mb-1">Children</label>
                                        <input type="number" name="children" min="0" max="{{ $r->max_children ?? 5 }}" value="0" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-12 col-md-2 mt-2 mt-md-0">
                                        <button class="btn btn-danger btn-sm btn-block" type="submit"><i class="fa fa-cart-plus mr-1"></i> Add to cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- FAQs --}}
            @if(!empty($faqs))
                <div class="hotel-card p-4 mb-4">
                    <h4 style="font-weight:700;">Frequently asked questions</h4>
                    <div id="faqAccordion">
                        @foreach($faqs as $q => $a)
                            @php $id = 'faq' . md5($q); @endphp
                            <div class="mb-2">
                                <a class="d-block text-decoration-none" data-toggle="collapse" href="#{{ $id }}" role="button" aria-expanded="false" aria-controls="{{ $id }}">
                                    <strong>{{ $q }}</strong>
                                </a>
                                <div class="collapse" id="{{ $id }}">
                                    <div class="small-muted mt-2">{!! nl2br(e($a)) !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Metadata / debug info (collapsible) --}}
            <div class="hotel-card p-3 mb-4 small-muted">
                <div class="d-flex justify-content-between align-items-center">
                    <div><strong>Hotel metadata</strong></div>
                    <div><a class="small-muted" data-toggle="collapse" href="#metaBox" role="button">Show</a></div>
                </div>
                <div class="collapse mt-3" id="metaBox">
                    <div class="table-responsive">
                        <table class="table table-borderless small-muted mb-0">
                            <tbody>
                                <tr><td>Hotel ID</td><td class="text-right">{{ $hotel->id }}</td></tr>
                                <tr><td>Slug</td><td class="text-right">{{ $hotel->slug }}</td></tr>
                                <tr><td>City</td><td class="text-right">{{ $hotel->city_name }} ({{ $hotel->city_slug }})</td></tr>
                                <tr><td>Created</td><td class="text-right">{{ $hotel->created_at }}</td></tr>
                                <tr><td>Updated</td><td class="text-right">{{ $hotel->updated_at }}</td></tr>
                                <tr><td>Source page</td><td class="text-right"><a href="{{ $hotel->scrapped_page_url }}" target="_blank">Booking source</a></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
            <div class="sticky-sidebar">
                {{-- Quick booking widget --}}
                <div class="hotel-card p-4 mb-4">
                    <h5 style="font-weight:800;">Quick book</h5>
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <div class="form-group">
                            <label class="small-muted">Choose room</label>
                            <select name="room_id" class="form-control">
                                @foreach($rooms as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }} — ₹{{ number_format($r->price_per_night,0) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small-muted">Check-in</label>
                                <input type="date" name="check_in" class="form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label class="small-muted">Check-out</label>
                                <input type="date" name="check_out" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small-muted">Guests</label>
                            <div class="d-flex">
                                <input type="number" name="adults" min="1" value="2" class="form-control mr-2" required>
                                <input type="number" name="children" min="0" value="0" class="form-control" >
                            </div>
                        </div>
                        <button class="btn btn-danger btn-block" type="submit"><i class="fa fa-calendar-plus mr-1"></i> Book a room</button>
                    </form>
                </div>

                {{-- Contact card --}}
                <div class="hotel-card p-4 mb-4 text-center">
                    <h6 style="font-weight:700;">Contact & info</h6>
                    <div class="small-muted mb-2">
                        @if($hotel->contact_name) <div>{{ $hotel->contact_name }}</div> @endif
                        @if($hotel->contact_phone) <div><i class="fa fa-phone mr-1"></i> <a href="tel:{{ $hotel->contact_phone }}">{{ $hotel->contact_phone }}</a></div> @endif
                        @if($hotel->contact_email) <div><i class="fa fa-envelope mr-1"></i> <a href="mailto:{{ $hotel->contact_email }}">{{ $hotel->contact_email }}</a></div> @endif
                        @if($hotel->official_website) <div><i class="fa fa-globe mr-1"></i> <a href="{{ $hotel->official_website }}" target="_blank">Official website</a></div> @endif
                    </div>

                    <div class="d-flex flex-wrap justify-content-center mt-2">
                        @if($hotel->is_parking_included || $hotel->is_parking_lot_included) <div class="mr-3 mb-1 small-muted"><i class="fa fa-parking mr-1"></i>Parking</div> @endif
                        @if($hotel->is_airport_pickup_included) <div class="mr-3 mb-1 small-muted"><i class="fa fa-plane mr-1"></i>Airport pickup</div> @endif
                        @if($breakfastIncluded) <div class="mb-1 small-muted"><i class="fa fa-coffee mr-1"></i>Breakfast</div> @endif
                    </div>

                    <div class="mt-3 d-flex flex-column flex-sm-row justify-content-center">
                        <a href="tel:{{ $hotel->contact_phone }}" class="btn btn-outline-danger btn-sm mb-2 mb-sm-0 mr-sm-2"><i class="fa fa-phone mr-1"></i> Call hotel</a>
                        <a href="mailto:{{ $hotel->contact_email }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-envelope mr-1"></i> Email</a>
                    </div>
                </div>

                {{-- Small Map --}}
                <div class="hotel-card p-3 mb-4">
                    <h6 style="font-weight:700;">Location</h6>
                    <div class="small-muted mb-2">{{ $hotel->address ?? ($hotel->city_name ?? '') }}</div>
                    <div class="map-embed mb-2">
                        <iframe
                            width="100%" height="100%"
                            src="https://www.google.com/maps?q={{ $hotel->latitude ?? '' }},{{ $hotel->longitude ?? '' }}&z=15&output=embed"
                            frameborder="0" style="border:0;" allowfullscreen="">
                        </iframe>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(($hotel->address ?? $hotel->name) . ' ' . ($hotel->city_name ?? '')) }}" target="_blank" class="small-muted">Open in Google Maps</a>
                </div>

                {{-- Share / Save --}}
                <div class="hotel-card p-3 text-center">
                    <div class="mb-2"><strong>Share this hotel</strong></div>
                    <div class="d-flex flex-column flex-sm-row justify-content-center">
                        <a class="btn btn-outline-secondary btn-sm mr-0 mr-sm-2 mb-2 mb-sm-0" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank"><i class="fa fa-facebook mr-1"></i> Facebook</a>
                        <a class="btn btn-outline-secondary btn-sm mr-0 mr-sm-2 mb-2 mb-sm-0" href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($hotel->name) }}" target="_blank"><i class="fa fa-twitter mr-1"></i> Twitter</a>
                        <a class="btn btn-outline-secondary btn-sm" href="mailto:?subject={{ urlencode($hotel->name) }}&body={{ urlencode(request()->fullUrl()) }}"><i class="fa fa-envelope mr-1"></i> Email</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // gallery thumbnails -> main image
    document.querySelectorAll('.thumb').forEach(function(t){
        t.addEventListener('click', function(){
            var src = this.getAttribute('data-src') || this.getAttribute('src');
            var alt = this.getAttribute('data-alt') || this.alt;
            var main = document.getElementById('mainHero');
            if(main && src){
                main.src = src;
                main.alt = alt;
            }
            // toggle active
            document.querySelectorAll('.thumb').forEach(function(x){ x.classList.remove('active'); });
            this.classList.add('active');
        });
    });

    // FAQ collapse icons (if bootstrap available)// FAQ collapse icons (if bootstrap available)
    // nothing required - rely on bootstrap collapse
});
</script>
@endpush

@endsection
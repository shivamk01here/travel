<!-- Search Section -->
<section class="ftco-section ftco-no-pb ftco-no-pt">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ftco-search d-flex justify-content-center">
                    <div class="row">
                        <div class="col-md-12 nav-link-wrap">
                            <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active mr-md-1 tab-btn" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true" data-tab="hotel">
                                    <i class="fas fa-bed mr-2"></i>Search Hotels
                                </a>
                                <a class="nav-link tab-btn" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false" data-tab="tour">
                                    <i class="fas fa-map-marked-alt mr-2"></i>Tours
                                </a>
                                <a class="nav-link tab-btn" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false" data-tab="flights">
                                    <i class="fas fa-plane mr-2"></i>Flights
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12 tab-wrap">
                            <div class="tab-content" id="v-pills-tabContent">
                                @include('partials.search.hotel-search')
                                @include('partials.search.tour-search')
                                @include('partials.search.flight-search')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

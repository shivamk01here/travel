<!-- Hotel Search Tab -->
<div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
    <form action="{{ route('hotels.index') }}" method="GET" class="search-property-1">
        <div class="row no-gutters">
            <div class="col-md d-flex">
                <div class="form-group p-4 border-0">
                    <label for="#">Destination</label>
                    <div class="form-field">
                        <div class="icon"><span class="fa fa-search"></span></div>
                        <input type="text" id="hotel-city" name="city" class="form-control" placeholder="Search destinations..." autocomplete="off">
                        <div id="hotel-suggest" class="autocomplete-suggestions"></div>
                    </div>
                </div>
            </div>
            <div class="col-md d-flex">
                <div class="form-group p-4">
                    <label for="#">Check-in date</label>
                    <div class="form-field">
                        <div class="icon"><span class="fa fa-calendar"></span></div>
                        <input type="text" class="form-control checkin_date" placeholder="Check In Date">
                    </div>
                </div>
            </div>
            <div class="col-md d-flex">
                <div class="form-group p-4">
                    <label for="#">Check-out date</label>
                    <div class="form-field">
                        <div class="icon"><span class="fa fa-calendar"></span></div>
                        <input type="text" class="form-control checkout_date" placeholder="Check Out Date">
                    </div>
                </div>
            </div>
            <div class="col-md d-flex">
                <div class="form-group d-flex w-100 border-0">
                    <div class="form-field w-100 align-items-center d-flex">
                        <input type="submit" value="Search Hotels" class="align-self-stretch form-control btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Flight Search Tab -->
<div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
    <form method="GET" class="search-property-1">
        <div class="row no-gutters">
            <div class="col-lg d-flex">
                <div class="form-group p-4 border-0">
                    <label for="#">From</label>
                    <div class="form-field">
                        <div class="icon"><span class="fa fa-plane"></span></div>
                        <input type="text" id="flightFrom" class="form-control" placeholder="Departure city" autocomplete="off">
                        <div id="fromSuggestions" class="autocomplete-suggestions"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg d-flex">
                <div class="form-group p-4">
                    <label for="#">To</label>
                    <div class="form-field">
                        <div class="icon"><span class="fa fa-plane"></span></div>
                        <input type="text" id="flightTo" class="form-control" placeholder="Destination city" autocomplete="off">
                        <div id="toSuggestions" class="autocomplete-suggestions"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg d-flex">
                <div class="form-group p-4">
                    <label for="#">Departure Date</label>
                    <div class="form-field">
                        <div class="icon"><span class="fa fa-calendar"></span></div>
                        <input type="text" class="form-control checkin_date" placeholder="Select Date">
                    </div>
                </div>
            </div>
            <div class="col-lg d-flex">
                <div class="form-group d-flex w-100 border-0">
                    <div class="form-field w-100 align-items-center d-flex">
                        <button type="button" id="searchFlightBtn" class="align-self-stretch form-control btn btn-primary p-0">Search Flights</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
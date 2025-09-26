<!-- Tour Search Tab -->
<div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
    <form action="{{ route('tours.index') }}" method="GET" class="search-property-1">
        <div class="row no-gutters">
            <div class="col-lg d-flex">
                <div class="form-group p-4 border-0">
                    <label for="#">Tour Destination</label>
                    <div class="form-field">
                        <div class="icon"><span class="fa fa-search"></span></div>
                        <input type="text" id="tourSearch" name="city" class="form-control" placeholder="Search cities for tours..." autocomplete="off">
                        <div id="tourSuggestions" class="autocomplete-suggestions"></div>
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
                <div class="form-group p-4">
                    <label for="#">Duration</label>
                    <div class="form-field">
                        <div class="select-wrap">
                            <div class="icon"><span class="fa fa-chevron-down"></span></div>
                            <select name="duration" class="form-control">
                                <option value="">Select Duration</option>
                                <option value="1-3">1-3 Days</option>
                                <option value="4-7">4-7 Days</option>
                                <option value="8+">8+ Days</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg d-flex">
                <div class="form-group d-flex w-100 border-0">
                    <div class="form-field w-100 align-items-center d-flex">
                        <input type="submit" value="Search Tours" class="align-self-stretch form-control btn btn-primary p-0">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
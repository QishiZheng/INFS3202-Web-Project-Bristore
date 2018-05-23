<div class="container-fluid-full">
    <div class="row-fluid">
        <!-- start: left sidebar menu -->
        <div class="sidenav" style="position: absolute;">
            <a href="<?php echo base_url().'user';?>">Profile</a>
            <a href="<?php echo base_url().'user/my_orders';?>">Orders</a>
        </div>


        <!-- end: Main Menu -->

        <!-- start: Content -->
        <div id="content" class="span10"  style="margin-left:10%;">
            <h2  style="margin-left:10%;">Update Address</h2>
            <div id="locationField" style="margin: 50px; padding-left: 30%;">
                <input id="autocomplete" placeholder="Enter your address"
                       onFocus="geolocate()" type="text" style="width: 50%;">
                </input>
            </div>

            <!-- Button trigger modal -->
            <div align="center">
                <button class="btn btn-info" onclick="save_address()">Save</button>
            </div>


            <!-- end: Content -->
        </div><!--/#content.span10-->
    </div><!--/fluid-row-->
</div>


<!--//additional styling for side nav-->
<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .sidenav {
        height: 100%;
        width: 200px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        padding-top: 20px;
        margin-top: 50px;
    }

    .sidenav a {
        padding: 6px 6px 6px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }



    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>

<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var address ="";
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', getAddress);
    }


    /**
     * Output the address autocomplated by Google Maps API as a string
     */

    function getAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        // for (var component in componentForm) {
        //     document.getElementById(component).value = '';
        //     document.getElementById(component).disabled = false;
        // }
        // var s_number = place.address_components[0][componentForm['street_number']];
        // var s_name = place.address_components[1][componentForm['route']];
        // var suburb = place.address_components[2][componentForm['locality']];
        // var city = place.address_components[3];
        // var country = place.address_components[4][componentForm['country']];
        // var country = place.address_components[4][componentForm['country']];
        // console.log(s_number);
        // console.log(s_name);
        // console.log(suburb);
        // console.log(city);
        // console.log(country);


        // Get each component of the address from the place details
        // and fill the corresponding field on the form.

        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                //console.log(val);
                // document.getElementById(addressType).value = val;
                address = address+val+", ";
            }
        }
        address = address.substr(0, address.length-2);
        //console.log(address);
    }


    //call server to save the new address
    function save_address(){
        $.ajax({
            type: "POST",
            url: <?= json_encode(base_url().'user/save_address')?>,
            dataType: "JSON",
            data: { address: address },
            success: function(data) {
                console.log(data);
                window.location.replace(<?= json_encode(base_url().'user')?>);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    // function fillInAddress() {
    //     // Get the place details from the autocomplete object.
    //     var place = autocomplete.getPlace();
    //
    //     for (var component in componentForm) {
    //         document.getElementById(component).value = '';
    //         document.getElementById(component).disabled = false;
    //     }
    //
    //     // Get each component of the address from the place details
    //     // and fill the corresponding field on the form.
    //     for (var i = 0; i < place.address_components.length; i++) {
    //         var addressType = place.address_components[i].types[0];
    //         if (componentForm[addressType]) {
    //             var val = place.address_components[i][componentForm[addressType]];
    //             //console.log(val);
    //             document.getElementById(addressType).value = val;
    //         }
    //     }
    // }


    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCykDvCrPAXxAQiFHGq34TGuZH1DjY6pEY&libraries=places&callback=initAutocomplete"
        async defer></script>
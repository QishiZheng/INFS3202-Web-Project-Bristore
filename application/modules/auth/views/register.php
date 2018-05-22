<h1><?php echo lang('register_user_heading');?></h1>
<p><?php echo lang('register_user_heading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/register");?>

<p>
    <?php echo lang('create_user_fname_label', 'first_name');?> <br />
    <?php echo form_input($first_name);?>
</p>

<p>
    <?php echo lang('create_user_lname_label', 'last_name');?> <br />
    <?php echo form_input($last_name);?>
</p>

<?php
if($identity_column!=='email') {
    echo '<p>';
    echo lang('create_user_identity_label', 'identity');
    echo '<br />';
    echo form_error('identity');
    echo form_input($identity);
    echo '</p>';
}
?>

<!--<p>-->
<!--    --><?php //echo lang('create_user_address_label', 'address');?><!-- <br />-->
<!--    --><?php //echo form_input($address);?>
<!--</p>-->

<p>
    <?php echo lang('create_user_email_label', 'email');?> <br />
    <?php echo form_input($email);?>
</p>

<p>
    <?php echo lang('create_user_phone_label', 'phone');?> <br />
    <?php echo form_input($phone);?>
</p>


<p>
    <?php echo lang('create_user_password_label', 'password');?> <br />
    <?php echo form_input($password);?>
</p>

<p>
    <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
    <?php echo form_input($password_confirm);?>
</p>

<p><?php echo form_submit('submit', 'Create Account');?></p>

<?php echo form_close();?>


<!--<div id="locationField">-->
<!--    <input id="autocomplete" placeholder="Enter your address"-->
<!--           onFocus="geolocate()" type="text" style="width: 50%;"></input>-->
<!--</div>-->
<!---->
<!--<table id="address">-->
<!--    <tr>-->
<!--        <td class="label">Street address</td>-->
<!--        <td class="slimField"><input class="field" id="street_number"-->
<!--                                     disabled="true"></input></td>-->
<!--        <td class="wideField" colspan="2"><input class="field" id="route"-->
<!--                                                 disabled="true"></input></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td class="label">City</td>-->
<!--        <!-- Note: Selection of address components in this example is typical.-->
<!--             You may need to adjust it for the locations relevant to your app. See-->
<!--             https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform-->
<!--        -->-->
<!--        <td class="wideField" colspan="3"><input class="field" id="locality"-->
<!--                                                 disabled="true"></input></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td class="label">State</td>-->
<!--        <td class="slimField"><input class="field"-->
<!--                                     id="administrative_area_level_1" disabled="true"></input></td>-->
<!--        <td class="label">Zip code</td>-->
<!--        <td class="wideField"><input class="field" id="postal_code"-->
<!--                                     disabled="true"></input></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td class="label">Country</td>-->
<!--        <td class="wideField" colspan="3"><input class="field"-->
<!--                                                 id="country" disabled="true"></input></td>-->
<!--    </tr>-->
<!--</table>-->
<!--<script>-->
<!--    // This example displays an address form, using the autocomplete feature-->
<!--    // of the Google Places API to help users fill in the information.-->
<!---->
<!--    // This example requires the Places library. Include the libraries=places-->
<!--    // parameter when you first load the API. For example:-->
<!--    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">-->
<!---->
<!--    var placeSearch, autocomplete;-->
<!--    var componentForm = {-->
<!--        street_number: 'short_name',-->
<!--        route: 'long_name',-->
<!--        locality: 'long_name',-->
<!--        administrative_area_level_1: 'short_name',-->
<!--        country: 'long_name',-->
<!--        postal_code: 'short_name'-->
<!--    };-->
<!---->
<!--    function initAutocomplete() {-->
<!--        // Create the autocomplete object, restricting the search to geographical-->
<!--        // location types.-->
<!--        autocomplete = new google.maps.places.Autocomplete(-->
<!--            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),-->
<!--            {types: ['geocode']});-->
<!---->
<!--        // When the user selects an address from the dropdown, populate the address-->
<!--        // fields in the form.-->
<!--        autocomplete.addListener('place_changed', getAddress);-->
<!--    }-->
<!---->
<!---->
<!--    /**-->
<!--     * Output the address autocomplated by Google Maps API as a string-->
<!--     */-->
<!---->
<!--    function getAddress() {-->
<!--        // Get the place details from the autocomplete object.-->
<!--        var place = autocomplete.getPlace();-->
<!--        var address = "";-->
<!---->
<!--        for (var component in componentForm) {-->
<!--            document.getElementById(component).value = '';-->
<!--            document.getElementById(component).disabled = false;-->
<!--        }-->
<!--        // var s_number = place.address_components[0][componentForm['street_number']];-->
<!--        // var s_name = place.address_components[1][componentForm['route']];-->
<!--        // var suburb = place.address_components[2][componentForm['locality']];-->
<!--        // var city = place.address_components[3];-->
<!--        // var country = place.address_components[4][componentForm['country']];-->
<!--        // var country = place.address_components[4][componentForm['country']];-->
<!--        // console.log(s_number);-->
<!--        // console.log(s_name);-->
<!--        // console.log(suburb);-->
<!--        // console.log(city);-->
<!--        // console.log(country);-->
<!---->
<!---->
<!--        // Get each component of the address from the place details-->
<!--        // and fill the corresponding field on the form.-->
<!---->
<!--        for (var i = 0; i < place.address_components.length; i++) {-->
<!--            var addressType = place.address_components[i].types[0];-->
<!--            if (componentForm[addressType]) {-->
<!--                var val = place.address_components[i][componentForm[addressType]];-->
<!--                //console.log(val);-->
<!--                // document.getElementById(addressType).value = val;-->
<!--                address = address+val+", ";-->
<!--            }-->
<!--        }-->
<!--        address = address.substr(0, address.length-2);-->
<!--        console.log(address);-->
<!--    }-->
<!---->
<!--    function fillInAddress() {-->
<!--        // Get the place details from the autocomplete object.-->
<!--        var place = autocomplete.getPlace();-->
<!---->
<!--        for (var component in componentForm) {-->
<!--            document.getElementById(component).value = '';-->
<!--            document.getElementById(component).disabled = false;-->
<!--        }-->
<!---->
<!--        // Get each component of the address from the place details-->
<!--        // and fill the corresponding field on the form.-->
<!--        for (var i = 0; i < place.address_components.length; i++) {-->
<!--            var addressType = place.address_components[i].types[0];-->
<!--            if (componentForm[addressType]) {-->
<!--                var val = place.address_components[i][componentForm[addressType]];-->
<!--                 //console.log(val);-->
<!--                document.getElementById(addressType).value = val;-->
<!--            }-->
<!--        }-->
<!--    }-->
<!---->
<!---->
<!--    // Bias the autocomplete object to the user's geographical location,-->
<!--    // as supplied by the browser's 'navigator.geolocation' object.-->
<!--    function geolocate() {-->
<!--        if (navigator.geolocation) {-->
<!--            navigator.geolocation.getCurrentPosition(function(position) {-->
<!--                var geolocation = {-->
<!--                    lat: position.coords.latitude,-->
<!--                    lng: position.coords.longitude-->
<!--                };-->
<!--                var circle = new google.maps.Circle({-->
<!--                    center: geolocation,-->
<!--                    radius: position.coords.accuracy-->
<!--                });-->
<!--                autocomplete.setBounds(circle.getBounds());-->
<!--            });-->
<!--        }-->
<!--    }-->
<!--</script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCykDvCrPAXxAQiFHGq34TGuZH1DjY6pEY&libraries=places&callback=initAutocomplete"-->
<!--        async defer></script>-->

/*function initAutocomplete()
{
    // Create the search box and link it to the UI element.
    var input = document.getElementById('home_search');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });
}*/

function initAutocomplete() {

 var options = {
  //types: ['(cities)'],
  componentRestrictions: {country: "dk"}
 };

 var input = document.getElementById('home_search');
 var autocomplete = new google.maps.places.Autocomplete(input, options);
}


function initAddressAutocomplete() {

 var options = {
  //types: ['(cities)'],
  componentRestrictions: {country: "dk"}
 };

 var input = document.getElementById('address');
 var autocomplete = new google.maps.places.Autocomplete(input, options);
}
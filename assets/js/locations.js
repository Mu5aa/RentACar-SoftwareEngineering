$(document).ready(function () {
    // Event listener for form field focus
    $("#pick-up-location, #drop-off-location").on('focus', function() {
        // Fetch and display locations when the form field gains focus
        getLocations();
    });

    // Function to fetch and display locations
    function getLocations() {
        $.get("locations.json", function (data) {
            displayLocations(data);
        });
    }

    // Function to display location options
    function displayLocations(data) {
        // Clear existing options first
        $("#pick-up-location, #drop-off-location").empty();
        
        // Append new options
        data.slice(0, 3).forEach(function (location) {
            var locationHTML = `<option value="${location.id}">${location.name}</option>`;
            $("#pick-up-location, #drop-off-location").append(locationHTML);
        });
    }
});

// DOM ready
$(initialize);

//array with data
var pictures = [];

/**
 * Initialize our application
 */
function initialize() {

    getData();
}

function getData() {

    //ajax call to get Instagram data from php file
    $.ajax({
        dataType: "json",
        url: "instagram.php",
        method: "GET",
        success: getDataSuccessHandler
    });
}

/**
 * puts data into the google maps settings
 *
 * @param response
 */
function getDataSuccessHandler(response) { // response is where the Instagram data is now
    var myLatlng = new google.maps.LatLng(response[0].location.latitude, response[0].location.longitude); //set a center
    var mapOptions = {
        zoom: 4,
        center: myLatlng
    };

    // load the map
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    /**
     * pushes the data into an array
     */
    $.each(response, function (i, imageData) {
        pictures.push(imageData);

    });

    $(pictures).each(function(index, element){
        // puts the location of the pictures into google maps
        var myLatLng = new google.maps.LatLng(element.location.latitude, element.location.longitude);

        // puts the actual picture in the info window
        var contentString = '<img class="image" src="' + element.url + '"/>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        // custom marker
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: 'travel.png'
        });

        // mouseover/mouseout to open an infowindow
        google.maps.event.addListener(marker, 'mouseover', function() {
            infowindow.open(map,marker);
        });
        google.maps.event.addListener(marker, 'mouseout', function() {
            infowindow.close(map,marker);
        });
    });

}
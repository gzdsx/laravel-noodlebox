(function ($) {
    var mapProp = {
        center: new google.maps.LatLng(49.545138, -120.828652),
        zoom: 4,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        gestureHandling: 'greedy'
    };

    var map = new google.maps.Map(document.getElementById("map"), mapProp);
    var infoWindow = new google.maps.InfoWindow();

    $(listings).each(function (index, listing) {
        //console.log(listing);
        var marker = new google.maps.Marker({
            map: map,
            position: {
                lng: listing.lng,
                lat: listing.lat
            },
            title: listing.formatted_address,
            //label: listing.formatted_address,
        });

        marker.addListener("click", function () {
            var infoContent = '<div style="text-align: center; width: 160px; margin: 5px 0 0 5px;">';
            infoContent += '<img src="' + listing.image + '" width="160" height="120" style="object-fit: cover;" alt="">';
            infoContent += '<div style="margin-top: 5px;">' + marker.getTitle() + '</div>';
            infoContent += '</div>';

            infoWindow.close();
            infoWindow.setContent(infoContent);
            infoWindow.open(marker.getMap(), marker);
        });
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (res) {
            // map.setCenter({
            //     lat: res.coords.latitude,
            //     lng: res.coords.longitude
            // });
        }, function (err) {
            console.log(err);
        });
    }
})(jQuery);
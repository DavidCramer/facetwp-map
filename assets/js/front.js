var facetwp_map, facetwp_markers = [], facetwp_markerCluster, facetwp_infowindow;
function facetwpMapInit() {
    var bounds = new google.maps.LatLngBounds();
    if (!facetwp_map) {
        facetwp_map = new google.maps.Map(document.getElementById('facetwp-map'), {});
        facetwp_infowindow = new google.maps.InfoWindow({
            content: ''
        });
    }

    // Add markers to the map.
    facetwp_markers = FWP.settings.map.locations.map(function (location, i) {
        //location.animation = google.maps.Animation.DROP;
        var marker = new google.maps.Marker(location);
        marker.addListener('click', function (e) {
            if (FWP.settings.map.locations[i].content) {
                facetwp_infowindow.setContent(FWP.settings.map.locations[i].content);
                facetwp_infowindow.open(facetwp_map, marker);
            }
        });

        bounds.extend(marker.position);
        return marker;
    });
    if (typeof MarkerClusterer !== 'undefined' && FWP.settings.map.config.group_markers) {

        // Add a marker clusterer to manage the markers.
        facetwp_markerCluster = new MarkerClusterer(facetwp_map, facetwp_markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    } else {
        facetwp_markers.map(function (marker) {
            marker.setMap(facetwp_map);
        });
    }

    facetwp_map.fitBounds(bounds);

    // set options
    facetwp_map.setOptions( FWP.settings.map.init );
    console.log( FWP.settings.map.init );

}

function facetwpMapReset() {
    // remove markers if set.
    if (facetwp_markers.length) {
        facetwp_markers.map(function (marker) {
            marker.setMap(null);
        });
        facetwp_markers = [];
    }
    // clusteres
    if (typeof MarkerClusterer !== 'undefined' && facetwp_markerCluster) {
        facetwp_markerCluster.clearMarkers();
    }
}

jQuery(function ($) {
    $(document).on('facetwp-loaded', function () {
        facetwpMapInit();
    });
    $(document).on('facetwp-refresh', function () {
        facetwpMapReset();
    });
});
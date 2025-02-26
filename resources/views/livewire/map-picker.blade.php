@assets
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet" />
<link href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" rel="stylesheet" />
@endassets

<div>
    <div id="map" style="height: 500px; color: black;"></div>

    <!-- Latitude and Longitude Inputs -->
</div>



@script
<script>
    const mapInit = () => {
        const map = L.map('map');
        map.setView(new L.LatLng(-6.9905534, 110.4186332), 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        }).addTo(map);

        let poly = null;
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })
            .on('markgeocode', function (e) {
                var bbox = e.geocode.bbox;
                var poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                map.fitBounds(poly.getBounds());
            })
            .addTo(map);

        let marker = null;
        map.on('click', function (e) {
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            const LAT = document.getElementById('mountedActionsData.0.latitude') || document.getElementById('mountedTableActionsData.0.latitude')
            const LNG = document.getElementById('mountedActionsData.0.longitude') || document.getElementById('mountedTableActionsData.0.longitude')
            // Remove the previous marker if it exists
            if (marker) {
                map.removeLayer(marker);
            }

            if (lat == null || lng == null) {
                return;
            }

            // Add a new marker at the clicked location
            marker = L.marker([lat, lng]).addTo(map);

            // Update the latitude and longitude input fields

            LAT.value = lat;
            LAT.dispatchEvent(new Event('input'));

            LNG.value = lng;
            LNG.dispatchEvent(new Event('input'));

            // Emit an event to Livewire with the new coordinates
            //Livewire.dispatch('updateCoordinates', lat, lng);

        });
    }

    setTimeout(mapInit, 2000)
</script>
@endscript
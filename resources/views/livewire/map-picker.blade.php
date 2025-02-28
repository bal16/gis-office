@assets
    <script src="{{ asset('leaflet/leaflet.js') }}"></script>
    <link href="{{ asset('leaflet/leaflet.css') }}" rel="stylesheet" />
@endassets
@assets
    <script src="{{ asset('leaflet/geocoder.js') }}"></script>
    <link href="{{ asset('leaflet/geocoder.css') }}" rel="stylesheet" />
@endassets

<div>
    <div id="map" style="height: 500px; color: black;"></div>

    <!-- Latitude and Longitude Inputs -->
</div>



@script
    <script>
        const map = L.map('map');


        const mapInit = () => {
            map.setView(new L.LatLng(-6.9905534, 110.4186332), 12);
        }
        setTimeout(mapInit, 5000)
        const tile = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {})

        tile.addTo(map)


        let poly = null;
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        })

        geocoder.on('markgeocode', function(e) {
                const bbox = e.geocode.bbox;
                poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                map.fitBounds(poly.getBounds());
            })
            .addTo(map);

        let marker = null;

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            const LAT = document.getElementById('mountedActionsData.0.latitude') || document.getElementById(
                'mountedTableActionsData.0.latitude')
            const LNG = document.getElementById('mountedActionsData.0.longitude') || document.getElementById(
                'mountedTableActionsData.0.longitude')

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
    </script>
@endscript

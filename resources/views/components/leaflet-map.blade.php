<div>
    <!-- Map Container -->
    <div id="leaflet-map-{{ $this->id }}" style="height: 400px; width: 100%;"></div>

    <!-- Hidden Inputs for Latitude and Longitude -->
    <input type="hidden" id="latitude-{{ $this->id }}" name="{{ $this->getName() }}[latitude]" value="{{ $this->getState()['latitude'] ?? '' }}">
    <input type="hidden" id="longitude-{{ $this->id }}" name="{{ $this->getName() }}[longitude]" value="{{ $this->getState()['longitude'] ?? '' }}">

    <!-- Leaflet Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize the map
            var map = L.map('leaflet-map-{{ $this->id }}').setView([51.505, -0.09], 13); // Default center

            // Add a tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Initialize a marker variable
            var marker = null;

            // Set initial marker if latitude and longitude are provided
            var initialLat = {{ $this->getState()['latitude'] ?? 'null' }};
            var initialLng = {{ $this->getState()['longitude'] ?? 'null' }};
            if (initialLat && initialLng) {
                marker = L.marker([initialLat, initialLng]).addTo(map);
                map.setView([initialLat, initialLng], 13);
            }

            // Add a click event to the map
            map.on('click', function (e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // Remove the previous marker if it exists
                if (marker) {
                    map.removeLayer(marker);
                }

                // Add a new marker at the clicked location
                marker = L.marker([lat, lng]).addTo(map);

                // Update the hidden input fields
                document.getElementById('latitude-{{ $this->id }}').value = lat;
                document.getElementById('longitude-{{ $this->id }}').value = lng;
            });
        });
    </script>
</div>

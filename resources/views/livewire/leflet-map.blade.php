<div>
    <div id="map" style="height: 400px;"></div>
    <form wire:submit.prevent="saveLocation">
        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" wire:model="latitude" readonly>
        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" wire:model="longitude" readonly>
        <button type="submit">Save Location</button>
    </form>

    <script>
        document.addEventListener('livewire:load', function () {
            // Initialize the map
            var map = L.map('map').setView([51.505, -0.09], 13); // Set initial view to a location

            // Add a tile layer (you can use OpenStreetMap or other providers)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Initialize a marker variable
            var marker = null;

            // Add a click event to the map
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                // Remove the previous marker if it exists
                if (marker) {
                    map.removeLayer(marker);
                }

                // Add a new marker at the clicked location
                marker = L.marker([lat, lng]).addTo(map);

                // Update the latitude and longitude input fields
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // Emit an event to Livewire with the new coordinates
                Livewire.emit('updateCoordinates', lat, lng);
            });
        });
    </script>
</div>

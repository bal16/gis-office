const map = L.map("map").setView([51.505, -0.09], 13); // Set initial latitude, longitude and zoom

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Ask user for current location
navigator.geolocation.getCurrentPosition(function (location) {
    const latlng = [location.coords.latitude, location.coords.longitude];
    L.marker(latlng).addTo(map);
    map.setView(latlng, 13);
});

const calcDistance = (start, end, id) => {
    const control = L.Routing.control({
        waypoints: [
            L.latLng(start[0], start[1]), // Starting point (example)
            L.latLng(end[0], end[1]), // Destination point (example)
        ],
        routeWhileDragging: true, // Allow the route to update as you drag the markers
        createMarker: function () {
            return null;
        }, // Don't display markers
    }).addTo(map);

    // Event listener to show the distance when the route is found
    control.on("routesfound", function (e) {
        const route = e.routes[0]; // Get the first route (in case there are multiple routes)
        let distance = route.summary.totalDistance; // Distance in meters
        // const time = route.summary.totalTime; // Time in seconds

        distance = (distance / 1000).toFixed(2) + " km"; // Display distance in kilometers

        const distanceDiv = document.getElementById(id);
        setTimeout(function () {
            distanceDiv.innerHTML = "Total road distance: " + distance; // Set inner HTML
        }, 2000);

        map.off();
        map.remove();
    });
};

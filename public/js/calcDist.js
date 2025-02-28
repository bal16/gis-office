const map = L.map(document.createElement("div")).setView([51.505, -0.09], 13);
// Ask user for current location
navigator.geolocation.getCurrentPosition(function (location) {
    const latlng = [location.coords.latitude, location.coords.longitude];
    console.log("🚀 ~ latlng:", latlng);
    localStorage.setItem("currentLocation", JSON.stringify(latlng));
    L.marker(latlng).addTo(map);
});
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

function calcDistance(start, end, id) {
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

        const ELEMENTS = document.getElementsByClassName(id);

        setTimeout(function () {
            const text = "Total road distance: " + distance;
            ELEMENTS[0].innerHTML = text; // Set inner HTML
            ELEMENTS[1].innerHTML = text; // Set inner HTML
        }, 2000);

        map.off();
        // map.remove();
    });
}

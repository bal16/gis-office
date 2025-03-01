const map = L.map(document.createElement("div")).setView([0, 0], 13);

navigator.geolocation.getCurrentPosition(function (location) {
    const latlng = [location.coords.latitude, location.coords.longitude];
    localStorage.setItem("currentLocation", JSON.stringify(latlng));
    L.marker(latlng).addTo(map);
});

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

function calcDistance(start, end, id) {
    const ELEMENTS = document.getElementsByClassName(id);

    if (!start) {
        ELEMENTS[0].innerHTML = "Lokasi tidak ditemukan";
        ELEMENTS[1].innerHTML = "Lokasi tidak ditemukan";
    } else {
        const control = L.Routing.control({
            waypoints: [L.latLng(start[0], start[1]), L.latLng(end[0], end[1])],
            routeWhileDragging: false,
            createMarker: function () {
                return null;
            },
        }).addTo(map);

        control.on("routesfound", function (e) {
            const route = e.routes[0];
            let distance = route.summary.totalDistance;

            distance = (distance / 1000).toFixed(2) + " km";

            setTimeout(function () {
                const text = "Jarak: " + distance;
                ELEMENTS[0].innerHTML = text;
                ELEMENTS[1].innerHTML = text;
            }, 2000);
        });
    }
    map.off();
}

import { map, currentLocation } from "./const";
import { calcDistance } from "./utils/distance";

const distanceEls = document.getElementsByClassName("distance"); //htmlCollection
navigator.geolocation.getCurrentPosition(
    (location) => {
        const latlng = [location.coords.latitude, location.coords.longitude];
        L.marker(latlng).addTo(map);
        currentLocation.length = 0;
        currentLocation.push(...latlng);
        Array.from(distanceEls).forEach((el) => {
            calcDistance(
                latlng,
                [el.getAttribute("data-lat"), el.getAttribute("data-lng")],
                `jarak-${el.getAttribute("data-distance")}`
            );
        });
    },
    () => {
        Array.from(distanceEls).forEach((el) => {
            const elements = document.getElementsByClassName(
                `jarak-${el.getAttribute("data-distance")}`
            );
            Array.from(elements).forEach(
                (el) => (el.innerHTML = "Jarak tidak ditemukan.")
            );
        });
    }
);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

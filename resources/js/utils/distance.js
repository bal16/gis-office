import { map } from "../const";
// ?INFO: Distance Calculator

/**
 * Calculate the distance between two points on a map
 * @param {Array<number>} start The starting location, in the format [lat, lng]
 * @param {Array<number>} end The ending location, in the format [lat, lng]
 * @param {string} className The class name of the elements that will display the calculated distance
 */
export function calcDistance(start, end, className) {
    const ELEMENTS = document.getElementsByClassName(className);
    if (!start || !end || !className) {
        // console.error("Error: Invalid arguments provided to calcDistance");
        ELEMENTS[0].innerHTML = "Jarak tidak ditemukan.";
        ELEMENTS[1].innerHTML = "Jarak tidak ditemukan.";
        return;
    }

    const control = L.Routing.control({
        waypoints: [L.latLng(start[0], start[1]), L.latLng(end[0], end[1])],
        routeWhileDragging: true,
        createMarker: function () {
            return null;
        },
    }).addTo(map);

    control.on("routesfound", function (e) {
        try {
            const route = e.routes[0];
            let distance = route.summary.totalDistance;
            distance = (distance / 1000).toFixed(2) + " km";

            if (ELEMENTS.length < 2) {
                // console.error(
                //     "Error: Not enough elements found with the given class name"
                // );
                return;
            }

            const text = "Jarak: " + distance;
            ELEMENTS[0].innerHTML = text;
            ELEMENTS[1].innerHTML = text;

            map.off();
        } catch (error) {
            // console.error(
            //     "Error: Unhandled exception in routesfound event",
            //     error
            // );
        }
    });
}

// ?INFO: Distance Calculator
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
/**
 * Calculate the distance between two points on a map
 * @param {Array<number>} start The starting location, in the format [lat, lng]
 * @param {Array<number>} end The ending location, in the format [lat, lng]
 * @param {string} className The class name of the elements that will display the calculated distance
 */
function calcDistance(start, end, className) {
    if (!start || !end || !className) {
        console.error("Error: Invalid arguments provided to calcDistance");
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

            const ELEMENTS = document.getElementsByClassName(className);
            if (ELEMENTS.length < 2) {
                console.error(
                    "Error: Not enough elements found with the given class name"
                );
                return;
            }

            const text = "Jarak: " + distance;
            ELEMENTS[0].innerHTML = text;
            ELEMENTS[1].innerHTML = text;

            map.off();
        } catch (error) {
            console.error(
                "Error: Unhandled exception in routesfound event",
                error
            );
        }
    });
}

// ?INFO: ELEMENT TEMPLATES
const makePaginationDots = () =>
    `<span class="text-primary w-full min-w-7 min-h-7 text-center border-primary border-r block items-center">...</span>`;
/**
 * Create the HTML for a pagination item, given the key and current page.
 *
 * @param {number} key The key for the pagination item.
 * @param {number} current The current page.
 *
 * @returns {string} The HTML for the pagination item.
 */
const makePaginationItem = (key, current) => `<button
                class="${
                    key === current
                        ? "max-w-8 text-white bg-primary"
                        : "text-primary"
                } full min-w-7 min-h-7 border-primary border-r text-center items-center cursor-pointer"
                onclick="handleAJAX({ page: ${key} })">
                ${key}
            </button>`;
/**
 * Generates an HTML button string for pagination navigation.
 *
 * The button represents either a "Previous" or "Next" navigation action.
 * If the button is disabled, it will not be clickable and will have a different style.
 *
 * @param {string} key - The label for the button, typically "Previous" or "Next".
 * @param {number} value - The page number associated with the button action.
 * @param {boolean} [disabled=false] - Whether the button is disabled.
 * @returns {string} The HTML string for the pagination navigation button.
 */
const makePaginationNav = (key, value, disabled = false) => {
    try {
        return `<button
            class="px-2 min-w-20 min-h-7 cursor-pointer text-center items-center disabled:text-gray-500 ${
                key === "Previous" ? "border-primary border-r" : ""
            } disabled:cursor-not-allowed"
            onclick="handleAJAX({ page: ${value} })"
            ${disabled ? "disabled" : ""}
            >
            ${key}
        </button>`;
    } catch (error) {
        console.error("Error: Unhandled exception in makePaginationNav", error);
        return "";
    }
};
/**
 * Create the HTML for the pagination element, given the current page, the
 * previous page, the last page, and the next page.
 *
 * @param {Object} options
 * @param {number} options.prev The previous page. If this is less than 1, the
 * "Previous" button will be disabled.
 * @param {number} options.current The current page.
 * @param {number} options.last The last page.
 * @param {number} options.next The next page. If this is greater than the last
 * page, the "Next" button will be disabled.
 *
 * @returns {string} The HTML for the pagination element.
 */
const makePaginationElement = ({ prev, current, last, next }) => {
    let paginationHTML = makePaginationNav("Previous", prev, prev < 1);

    if (last > 5) {
        // First two pages
        for (let i = 1; i <= 2; i++) {
            paginationHTML += makePaginationItem(i, current);
        }
        // Dots if needed
        if (current >= 4) {
            paginationHTML += makePaginationDots();
        }
        // Middle page
        if (current > 2 && current < last - 1) {
            paginationHTML += makePaginationItem(current, current);
        }
        // Dots if needed
        if (current <= last - 3) {
            paginationHTML += makePaginationDots();
        }
        // Last two pages
        for (let i = last - 1; i <= last; i++) {
            paginationHTML += makePaginationItem(i, current);
        }
    } else {
        for (let i = 1; i <= last; i++) {
            paginationHTML += makePaginationItem(i, current);
        }
    }

    paginationHTML += makePaginationNav("Next", next, next > last);

    return paginationHTML;
};
/**
 * Generates an HTML string representing a table row element for an office.
 *
 * The table row includes the office ID, name, and district name (if applicable),
 * a link to open the location in Google Maps based on the office's latitude and longitude,
 * a placeholder for distance calculation, and an image of the office.
 *
 * @param {Object} office - An object representing the office.
 * @param {number} office.id - The unique identifier of the office.
 * @param {string} office.name - The name of the office.
 * @param {boolean} office.is_district - Flag indicating if the office is a district.
 * @param {string} office.district_name - The name of the district (if applicable).
 * @param {number} office.latitude - The latitude of the office location.
 * @param {number} office.longitude - The longitude of the office location.
 * @param {string} office.image - The path to the office image.
 * @returns {string} An HTML string representing a table row element.
 */
const makeTableItemElement = (office) => `
            <tr class="bg-white shadow-lg">
                <td class="rounded-l-xl pl-3 pr-5">${office.id}</td>
                <td class="px-5 text-sm max-w-100 min-w-100">
                    <span class="font-bold">${office.name}</span><br />${
    office.is_district ? "" : office.district_name
}
                </td>
                <td class="px-5 text-sm">
                    <a
                        class="bg-red-700 text-white px-3 py-1 rounded-full"
                        href="https://www.google.com/maps/dir/Current+Location/${
                            office.latitude
                        },${office.longitude}"
                        target="_blank"
                    >
                        Buka Map
                    </a><br />
                    <span class="flex inline-text pt-2 jarak-${
                        office.id
                    }"><svg class="mr-3 -ml-1 size-5 animate-spin text-black"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>Menghitung Jarak...</span></span>
                </td>
                <td class="rounded-r-xl p-5">
                <a href="storage/${office.image}" data-fslightbox="gambar-${
    office.id
}" data-alt="gambar-${office.id}" >
                    <img
                        src="storage/${office.image}"
                        class="rounded-xl h-60 w-60 object-cover shadow-md hover:scale-105 transition-transform"
                    />
                    </a>
                </td>
            </tr>
        `;
/**
 * Generates a mobile-friendly HTML element string representing an office location.
 *
 * The element includes the office name, district name (if applicable), a link to open the location
 * in Google Maps based on the office's latitude and longitude, a placeholder for distance calculation,
 * and an image of the office.
 *
 * @param {Object} office - The office information.
 * @param {number} office.id - The unique identifier for the office.
 * @param {string} office.name - The name of the office.
 * @param {boolean} office.is_district - Indicates if the office is a district office.
 * @param {string} office.district_name - The name of the district if not a district office.
 * @param {string} office.image - The URL or path to the office's image.
 * @param {string} office.latitude - The latitude coordinate for the office location.
 * @param {string} office.longitude - The longitude coordinate for the office location.
 * @returns {string} - A string of HTML representing the mobile office element.
 */
const makeMobileItemElement = (office) => `
            <div class="bg-white rounded-xl px-5 py-5 mb-3 shadow-lg text-center">
    <ul>
        <li class="flex font-bold gap-1 pb-5 justify-center">
            <div><span class="font-bold">${office.name}</span> ${
    office.is_district ? "" : office.district_name
}</div>
        </li>
        <li class="flex gap-1 pb-2 justify-center">

            <div>
                    <a
                        href="https://www.google.com/maps/dir/Current+Location/${
                            office.latitude
                        },${office.longitude}"
                        target="_blank"
                        class="bg-primary text-white px-3 py-1 rounded-full"
                    >
                        Buka Map
                    </a>
            </div>
                </li>
        <li class="flex gap-1 pb-2 justify-center">
            <div class="flex inline-text jarak-${
                office.id
            }"> <svg class="mr-3 -ml-1 size-5 animate-spin text-black"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>Menghitung Jarak...</div>
        </li>
        <li>
            <div class="flex items-center justify-center">
                <a href="/storage/${office.image}" data-fslightbox="gambar-${
    office.id
}-mobile" data-alt="gambar-${office.id}" >
                <img class="rounded-xl h-45 w-80 object-cover shadow-md hover:scale-105 transition-transform" src="/storage/${
                    office.image
                }" alt="gambar-${office.id}" />
                </a>
            </div>
        </li>
    </ul>
</div>`;

// ?INFO: handle AJAX operation
const getCurrentQuery = () => {
    try {
        if (window.location.search === null) {
            console.error("Error: Null pointer reference in getCurrentQuery");
            return {};
        }

        const queryString = window.location.search.split("?")[1]; // "page=1&q=tembalang"
        const queryParams = queryString.split("&");

        return queryParams.reduce((acc, param) => {
            const [key, value] = param.split("=");
            acc[key] = isNaN(value) ? value : Number(value); // Convert value to number if possible
            return acc;
        }, {});
    } catch (error) {
        console.error("Error: Unhandled exception in getCurrentQuery", error);
        return {};
    }
};
/**
 * Handles AJAX operations for searching and pagination.
 *
 * @param {Object} queryParams - The object containing query parameters.
 * @param {string} [queryParams.q] - The search query string. Defaults to empty string.
 * @param {number} [queryParams.page] - The page number. Defaults to 1.
 *
 * @async
 */
async function handleAJAX(queryParams) {
    const AJAX_ELEMENTS = document.getElementsByClassName("ajax-content");
    const currentQuery = getCurrentQuery();
    const mergedParams = { ...currentQuery, ...queryParams };

    // Check for null pointer references
    if (queryParams === null || queryParams === undefined) {
        console.error("Error: Null pointer reference in handleAJAX");
        return;
    }

    // Check for unhandled exceptions
    try {
        // Don't send empty string for q to server
        if (mergedParams.q === "") {
            delete mergedParams.q;
        }

        if (mergedParams.page < 2) {
            delete mergedParams.page;
        }
        const queryString = Object.entries(mergedParams)
            .map(([key, value]) => `${key}=${value}`)
            .join("&");

        let currentPage, data, lastPage, nextPage, previousPage, totalData;

        try {
            const response = await fetch(`/api?${queryString}`);
            if (!response.ok) {
                throw new Error(response.statusText);
            }

            const {
                current_page,
                last_page,
                data: apiData,
                total,
            } = await response.json();
            currentPage = current_page;
            lastPage = last_page;
            nextPage = currentPage + 1;
            previousPage = currentPage - 1;

            // Fix bug when page < 2
            if (previousPage < 2) {
                delete mergedParams.page;
            }

            data = apiData;
            totalData = total;
        } catch (error) {
            console.error("Error: Exception in handleAJAX", error);
            return;
        }

        // Check if data is empty
        if (totalData === 0) {
            const noDataMessage = `
                <tr class="w-full">
                    <td colspan="4" class="bg-white rounded-2xl shadow-xl text-center px-100 py-3">Tidak ada data.</td>
                </tr>
            `;
            AJAX_ELEMENTS[0].innerHTML = noDataMessage;
            AJAX_ELEMENTS[1].innerHTML = noDataMessage;
            AJAX_ELEMENTS[2].innerHTML = `Showing 0 of ${totalData} entries`;
            AJAX_ELEMENTS[3].innerHTML = ""; // Clear pagination
            return;
        }

        const listItems = data.map((office) => {
            const desktopItem = makeTableItemElement(office);
            const mobileItem = makeMobileItemElement(office);

            return [desktopItem, mobileItem];
        });

        const [desktopList, mobileList] = listItems.reduce(
            (acc, [desktopItem, mobileItem]) => {
                acc[0] += desktopItem;
                acc[1] += mobileItem;
                return acc;
            },
            ["", ""]
        );

        const newUrl = `${window.location.origin}/?${queryString}`;
        history.pushState({}, "", newUrl);
        AJAX_ELEMENTS[0].innerHTML = desktopList;
        AJAX_ELEMENTS[1].innerHTML = mobileList;
        AJAX_ELEMENTS[2].innerHTML = `Showing ${data.length} of ${totalData} entries`;
        AJAX_ELEMENTS[3].innerHTML = makePaginationElement({
            current: currentPage,
            last: lastPage,
            next: nextPage,
            prev: previousPage,
        });

        refreshFsLightbox();

        setTimeout(() => {
            data.forEach((office) => {
                const currentLocation = JSON.parse(
                    localStorage.getItem("currentLocation")
                );
                if (currentLocation) {
                    calcDistance(
                        currentLocation,
                        [office.latitude, office.longitude],
                        `jarak-${office.id}`
                    );
                }
            });
        }, 5000);
    } catch (error) {
        console.error(
            "Error: Unhandled exception in handleAJAX, queryParams: ",
            queryParams,
            "Error: ",
            error
        );
        return;
    }
}
/**
 * Handles search bar input. It debounces the input by 500ms and
 * calls handleAJAX with the given query string.
 *
 * @param {Event} e - The event object containing the target element
 * @returns {Promise<void>} - A promise that resolves when the debounced function is called
 */
async function handleSearch(e) {
    // Check for null pointer references
    if (e === null || e.target === null) {
        console.error("Error: Null pointer reference in handleSearch");
        return;
    }

    // Check for unhandled exceptions
    try {
        // Debounce
        debounce(async () => {
            await handleAJAX({ q: e.target.value });
        })();
    } catch (error) {
        console.error("Error: Unhandled exception in handleSearch", error);
    }
}
/**
 * Returns a debounced version of the given function. The returned function will
 * only be triggered after the given timeout period has passed since the last
 * time the function was called.
 *
 * @param {function} func - The function to debounce
 * @param {number} [timeout=500] - The timeout period in milliseconds (default=500ms)
 * @returns {function} The debounced function
 */
function debounce(func, timeout = 500) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, timeout);
    };
}


// ? INFO:Scroll to top feature
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    const JUMP = document.getElementById("toTop");
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        console.log("show");
        JUMP.style.display = "block";
    } else {
        JUMP.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


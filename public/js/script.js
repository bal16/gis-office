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
    if (!start || !end || !id) {
        console.error("Error: Invalid arguments provided to calcDistance");
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

            const ELEMENTS = document.getElementsByClassName(id);
            if (ELEMENTS.length < 2) {
                console.error(
                    "Error: Not enough elements found with the given class id"
                );
                return;
            }

            const text = "Total road distance: " + distance;
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

const makePaginationItem = (key, current) => `<button
                class="${
                    key === current
                        ? "text-[#fff] bg-[#a12c2f]"
                        : "text-[#a12c2f]"
                } w-full border-[#a12c2f] border-1 px-2 cursor-pointer"
                onclick="handleAJAX({ page: ${key} })">
                ${key}
            </button>`;

const makePaginationDots = () =>
    `<span class="text-[#a12c2f] w-full border-[#a12c2f] border-1 px-2">...</span>`;

const makePaginationNav = (key, value) => `<button
        class="w-full pl-3 active:cursor-pointer"
        onclick="handleAJAX({ page: ${value} })"
        ${value === null ? "disabled" : ""}
        >
        ${key}
    </button>`;

const makePaginationElement = ({ prev, current, last, next }) => {
    let paginationHTML = makePaginationNav("Previous", prev);

    if (last > 5) {
        // First two pages
        for (let i = 1; i <= 2; i++) {
            paginationHTML += makePaginationItem(i, current);
        }
        // Dots if needed
        if (current > 4) {
            paginationHTML += makePaginationDots();
        }
        // Middle page
        if (current > 2 && current < last - 1) {
            paginationHTML += makePaginationItem(current, current);
        }
        // Dots if needed
        if (current < last - 3) {
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

    paginationHTML += makePaginationNav("Next", next);

    return paginationHTML;
};

const makeTableItemElement = (office) => `
            <tr class="bg-white shadow-lg">
                <td class="rounded-l-xl pl-3 pr-5">${office.id}</td>
                <td class="px-5 text-sm max-w-100 min-w-100">
                    ${office.name}<br />${office.district_name}
                </td>
                <td class="px-5 text-sm">
                    <a
                        class="bg-red-700 text-white px-3 py-1 rounded-full"
                        href="https://www.google.com/maps/dir/Current+Location/${office.latitude},${office.longitude}"
                        target="_blank"
                    >
                        Buka Map
                    </a><br />
                    <span class="pt-2 distance-${office.id}">menghitung jarak...</span>
                </td>
                <td class="rounded-r-xl p-5">
                    <img
                        src="storage/${office.image}"
                        class="rounded-xl h-60 w-60 object-cover"
                    />
                </td>
            </tr>
        `;

const makeMobileItemElement = (office) => `
            <tr class="bg-white shadow-lg">
                <td class="rounded-l-xl pl-3 pr-5">${office.id}</td>
                <td class="px-5 text-sm max-w-100 min-w-100">
                    ${office.name}<br />${office.district_name}
                </td>
                <td class="px-5 text-sm">
                    <a
                        class="bg-red-700 text-white px-3 py-1 rounded-full"
                        href="https://www.google.com/maps/dir/Current+Location/${office.latitude},${office.longitude}"
                        target="_blank"
                    >
                        Buka Map
                    </a><br />
                    <span class="pt-2 distance-${office.id}">menghitung jarak...</span>
                </td>
                <td class="rounded-r-xl p-5">
                    <img
                        src="storage/${office.image}"
                        class="rounded-xl h-60 w-60 object-cover"
                    />
                </td>
            </tr>
        `;

let loading = false;
const AJAX_ELEMENTS = document.getElementsByClassName("ajax-content");

async function handleAJAX(queryParams) {
    const currentQuery = getCurrentQuery();
    const mergedParams = { ...currentQuery, ...queryParams };

    // Don't send empty string for q to server
    if (mergedParams.q === "") {
        delete mergedParams.q;
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

        // Fix bug when page < 1
        if (previousPage < 1) {
            previousPage = 1;
            delete mergedParams.page;
        }

        data = apiData;
        totalData = total;
    } catch (error) {
        console.error("Error: Exception in handleAJAX", error);
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
    AJAX_ELEMENTS[2].innerHTML = `Showing ${data.length} of ${totalData} entriessss`;
    AJAX_ELEMENTS[3].innerHTML = makePaginationElement({
        current: currentPage,
        last: lastPage,
        next: nextPage,
        prev: previousPage,
    });

    data.forEach((office) => {
        const currentLocation = JSON.parse(localStorage.getItem("currentLocation"));
        if (currentLocation) {
            calcDistance(currentLocation, [office.latitude, office.longitude], `distance-${office.id}`);
        }
    });
}

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

function debounce(func, timeout = 500) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            func.apply(this, args);
        }, timeout);
    };
}

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
export const makeTableItemElement = (office) => `
            <tr class="[&>td]:bg-white shadow-lg">
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
                    <span class="flex inline-text pt-2 distance jarak-${
                        office.id
                    }"
                    data-distance="${office.id}"
            data-lat="${office.latitude}"
            data-lng="${
                office.longitude
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
export const makeMobileItemElement = (office) => `
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

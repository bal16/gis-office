import "./vendor";
import {
    makeMobileItemElement,
    makePaginationElement,
    makeTableItemElement,
    getCurrentQuery,
    fetchApi,
    debounce
} from "./utils";
import { currentLocation } from "./const";
import "./distance"


function handlePageNav() {
    document.querySelectorAll(".page-nav").forEach((el) => {
        el.addEventListener("click", () => {
            const target = parseInt(el.getAttribute("data-target"));
            handleAJAX({ page: target });
        });
    });
}
handlePageNav();

// ?INFO: handle AJAX operation
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
    const currentQuery = getCurrentQuery();
    const mergedParams = { ...currentQuery, ...queryParams };

    // Check for null pointer references
    if (queryParams === null || queryParams === undefined) {
        // console.error("Error: Null pointer reference in handleAJAX");
        return;
    }

    // Check for unhandled exceptions
    try {
        // Don't send empty string for q to server
        if (!mergedParams.q) {
            delete mergedParams.q;
        } else if (mergedParams.q && !queryParams.page) {
            delete mergedParams.page;
        }

        if (mergedParams.page < 2) {
            delete mergedParams.page;
        }

        const response = await fetchApi(mergedParams);
        const {
            current_page,
            last_page,
            data: apiData,
            total,
        } = await response.json();

        const currentPage = current_page;
        const lastPage = last_page;
        const nextPage = currentPage + 1;
        const previousPage = currentPage - 1;

        if (previousPage < 1) {
            delete mergedParams.page;
        }

        const data = apiData;
        const totalData = total;

        if (totalData === 0) {
            document.getElementById("not-found").style.display = "table-row";
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

        const newUrl = `${window.location.origin}/?${new URLSearchParams(
            mergedParams
        ).toString()}`;
        history.pushState({}, "", newUrl);

        renderContent(desktopList, mobileList, data.length, totalData);
        renderPagination(currentPage, lastPage, nextPage, previousPage);

        refreshFsLightbox();

        if (currentLocation.length > 1) {
            setTimeout(() => {
                data.forEach((office) => {
                    calcDistance(
                        currentLocation,
                        [office.latitude, office.longitude],
                        `jarak-${office.id}`
                    );
                });
            }, 5000);
        }

        handlePageNav();
    } catch (error) {
        // console.error(
        //     "Error: Unhandled exception in handleAJAX, queryParams: ",
        //     queryParams,
        //     "Error: ",
        //     error
        // );
        return;
    }
}
/**
 * Renders content to the page
 *
 * @param {string} desktopList - The list of desktop items
 * @param {string} mobileList - The list of mobile items
 * @param {number} dataLength - The length of the data array
 * @param {number} totalData - The total number of data
 */
function renderContent(desktopList, mobileList, dataLength, totalData) {
    const AJAX_ELEMENTS = document.getElementsByClassName("ajax-content");
    AJAX_ELEMENTS[0].innerHTML = desktopList;
    AJAX_ELEMENTS[1].innerHTML = mobileList;
    AJAX_ELEMENTS[2].innerHTML = `Showing ${dataLength} of ${totalData} entries`;
}
/**
 * Renders pagination to the page
 *
 * @param {number} currentPage - The current page number
 * @param {number} lastPage - The last page number
 * @param {number} nextPage - The next page number
 * @param {number} previousPage - The previous page number
 */
function renderPagination(currentPage, lastPage, nextPage, previousPage) {
    const AJAX_ELEMENTS = document.getElementsByClassName("ajax-content");
    AJAX_ELEMENTS[3].innerHTML = makePaginationElement({
        current: currentPage,
        last: lastPage,
        next: nextPage,
        prev: previousPage,
    });
}

const searchEl = document.getElementById("search");
searchEl.value = getCurrentQuery().q || "";
searchEl.addEventListener("keyup", (e) => {
    // Check for null pointer references
    if (e === null || e.target === null) {
        // console.error("Error: Null pointer reference in handleSearch");
        return;
    }

    // Check for unhandled exceptions
    try {
        // Debounce
        debounce(async () => {
            await handleAJAX({ q: e.target.value });
        })();
    } catch (error) {
        // console.error("Error: Unhandled exception in handleSearch", error);
    }
});

// ? INFO:Scroll to top feature
const JUMP = document.getElementById("toTop");
JUMP.addEventListener("click", () => {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});
window.onscroll = function () {
    scrollFunction();
};
function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        JUMP.style.display = "block";
    } else {
        JUMP.style.display = "none";
    }
}

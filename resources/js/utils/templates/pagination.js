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
                class="page-nav ${
                    key === current
                        ? "max-w-8 text-white bg-primary"
                        : "text-primary"
                } full min-w-7 min-h-7 border-primary border-r text-center items-center cursor-pointer"
                data-target="${key}">
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
            class="page-nav px-2 min-w-20 min-h-7 cursor-pointer text-center items-center disabled:text-gray-500 ${
                key === "Previous" ? "border-primary border-r" : ""
            } disabled:cursor-not-allowed"
            data-target="${value}"
            id="${key}"
            ${disabled ? "disabled" : ""}
            >
            ${key}
        </button>`;
    } catch (error) {
        // console.error("Error: Unhandled exception in makePaginationNav", error);
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
export const makePaginationElement = ({ prev, current, last, next }) => {
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

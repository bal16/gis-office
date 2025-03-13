
export const getCurrentQuery = () => {
    try {
        if (window.location.search === null) {
            // console.error("Error: Null pointer reference in getCurrentQuery");
            return {};
        }

        const queryString = window.location.search.split("?")[1]; // "page=1&q=tembalang"
        const queryParams = queryString.includes("&")
            ? queryString?.split("&")
            : [queryString];

        return queryParams.reduce((acc, param) => {
            const [key, value] = param.split("=");
            acc[key] = isNaN(value) ? value : Number(value); // Convert value to number if possible
            return acc;
        }, {});
    } catch (error) {
        // console.error("Error: Unhandled exception in getCurrentQuery", error);
        return {};
    }
};

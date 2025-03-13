/**
 * Fetch data from API
 *
 * @param {Object} queryParams - The object containing query parameters.
 * @returns {Promise<Response>} - A promise that resolves with the response object
 */
export async function fetchApi(queryParams) {
    const queryString = new URLSearchParams(queryParams).toString();
    const response = await fetch(`/api?${queryString}`);
    if (!response.ok) {
        throw new Error(response.statusText);
    }

    return response;
}

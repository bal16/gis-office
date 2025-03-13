/**
 * Returns a debounced version of the given function. The returned function will
 * only be triggered after the given timeout period has passed since the last
 * time the function was called.
 *
 * @param {function} func - The function to debounce
 * @param {number} [timeout=500] - The timeout period in milliseconds (default=500ms)
 * @returns {function} The debounced function
 */
export const debounce =(func, timeout = 500) => {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => func(...args), timeout);
    };
}

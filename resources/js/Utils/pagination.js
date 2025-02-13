export const generatePageRange = (totalPages, currentPage, range = 5) => {
    let start = Math.max(currentPage - Math.floor(range / 2), 1);
    let end = Math.min(start + range - 1, totalPages);

    if (end - start < range - 1) {
        start = Math.max(end - range + 1, 1);
    }

    const pages = [];
    for (let i = start; i <= end; i++) {
        pages.push(i);
    }
    return pages;
};

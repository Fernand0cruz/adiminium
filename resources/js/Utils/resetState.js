export const resetState = (state) => {
    state.errorMessage.value = null;
    state.loading.value = true;
    state.products ? state.products.value = [] : null;
    state.companies ? state.companies.value = [] : null;
    state.pagination.value = { last_page: 1 };
    state.currentPage.value = 1;
};

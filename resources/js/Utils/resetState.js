export const resetState = (state) => {
    state.errorMessage.value = null;
    state.loading.value = true;
    state.products.value = [];
    state.pagination.value = { last_page: 1 };
    state.currentPage.value = 1;
};

export default (httpClient) => ({
    get: async () => {
        try {
            const response = await httpClient.get("/api/products");
            return response.data;
        } catch (error) {
            console.error("Erro ao buscar produtos:", error);
            throw error;
        }
    },
});

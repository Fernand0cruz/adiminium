import { formatCurrency } from "@/Utils/formatCurrency";

export default (httpClient) => ({
    create: async (productData) => {
        try {
            const formData = new FormData();
            formData.append("photo", productData.photo);
            formData.append("name", productData.name);
            formData.append("description", productData.description);
            formData.append("price", productData.price);
            formData.append("discount", productData.discount);
            formData.append("quantity", productData.quantity);

            const response = await httpClient.post("/api/products", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            });

            return response.data;
        } catch (error) {
            if (error.response) {
                if (error.response.status === 422) {
                    console.warn(
                        "Erro de validação:",
                        error.response.data.errors
                    );
                    throw error.response.data.errors;
                }

                if (error.response.status === 413) {
                    console.warn("Erro: Arquivo muito grande.");
                    throw { photo: ["O arquivo de imagem é muito grande."] };
                }

                console.error(
                    "Erro do servidor:",
                    error.response.status,
                    error.response.data
                );
                throw {
                    message: [
                        "Ocorreu um erro no servidor. Tente novamente mais tarde!",
                    ],
                };
            }

            if (error.message === "Network Error") {
                console.error("Erro de rede. O backend pode estar offline.");
                throw {
                    message: [
                        "Erro de conexão com o servidor. Verifique sua internet ou tente novamente mais tarde!",
                    ],
                };
            }

            console.error("Erro desconhecido:", error);
            throw { message: ["Ocorreu um erro inesperado."] };
        }
    },

    getAll: async (page = 1) => {
        try {
            const response = await httpClient.get(`/api/products?page=${page}`);

            const formattedData = response.data.data.data.map((product) => {
                const price = parseFloat(product.price);
                const discount = parseFloat(product.discount);
                const finalPrice = price - price * (discount / 100);

                return {
                    ...product,
                    price: formatCurrency(price),
                    discount: discount.toFixed(2),
                    final_price: formatCurrency(finalPrice),
                };
            });

            return {
                ...response.data,
                data: {
                    ...response.data.data,
                    data: formattedData,
                },
            };
        } catch (error) {
            console.error("Erro ao buscar produtos:", error);
            throw error;
        }
    },
    get: async (productId) => {
        try {
            const response = await httpClient.get(`/api/products/${productId}`);

            const product = response.data.data;
            const price = parseFloat(product.price);
            const discount = parseFloat(product.discount);
            const finalPrice = price - price * (discount / 100);

            return {
                ...product,
                price: formatCurrency(price),
                discount: discount.toFixed(2),
                final_price: formatCurrency(finalPrice),
            };
        } catch (error) {
            console.error("Erro ao buscar produto:", error);
            throw error;
        }
    },
});

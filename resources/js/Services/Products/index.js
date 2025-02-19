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
            if (error.response && error.response.status === 422) {
                throw error.response.data.errors;
            } else {
                console.error("Erro ao criar produto:", error);
                throw error;
            }
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
    }
});

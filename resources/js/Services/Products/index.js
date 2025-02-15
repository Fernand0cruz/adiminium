import { formatCurrency } from "@/Utils/formatCurrency";

export default (httpClient) => ({
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
});

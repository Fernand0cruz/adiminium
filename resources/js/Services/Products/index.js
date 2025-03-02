import { formatCurrency } from "@/Utils/formatCurrency";
import { handleRequestError } from "@/Utils/handleRequestError";

const createOrUpdateProduct = (productData, method) => {
    const formData = new FormData();
    formData.append("photo", productData.photo);
    formData.append("name", productData.name);
    formData.append("description", productData.description);
    formData.append("price", productData.price);
    const discount = productData.discount ? parseFloat(productData.discount) : 0;
    formData.append("discount", discount);
    formData.append("quantity", productData.quantity);

    if (method === "PATCH") {
        formData.append("_method", "PATCH");
    }

    return formData; 
};

const formatProductData = (product) => {
    const price = parseFloat(product.price);
    const discount = parseFloat(product.discount);
    const finalPrice = price - price * (discount / 100);

    return {
        ...product,
        price: formatCurrency(price),
        discount: discount.toFixed(2),
        final_price: formatCurrency(finalPrice),
    };
};

export default (httpClient) => ({
    create: async (productData) => {
        try {
            const data = createOrUpdateProduct(productData) 
            const response = await httpClient.post("/api/products", data);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    getAll: async (page = 1) => {
        try {
            const response = await httpClient.get(`/api/products?page=${page}`);
            const formattedData = response.data.data.data.map(formatProductData);
            return {
                ...response.data,
                data: {
                    ...response.data.data,
                    data: formattedData,
                },
            };
        } catch (error) {
            return handleRequestError(error);
        }
    },
    get: async (productId) => {
        try {
            const response = await httpClient.get(`/api/products/${productId}`);
            const product = formatProductData(response.data.data);
            return product
        } catch (error) {
            return handleRequestError(error);
        }
    },
    update: async (productId, productData) => {
        try {
            const data = createOrUpdateProduct(productData, "PATCH") 
            const response = await httpClient.post(`/api/products/${productId}`, data);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    delete: async (productId) => {
        try {
            const response = await httpClient.delete(`/api/products/${productId}`);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
});

import { handleRequestError } from "@/Utils/handleRequestError.js";
export default (httpClient) => ({
    create: async (orderData) => {
        try {
            const response = await httpClient.post("/api/orders", orderData);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    getOrderActive: async () => {
        try {
            const response = await httpClient.get(`/api/orders`);
            return response.data.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
});

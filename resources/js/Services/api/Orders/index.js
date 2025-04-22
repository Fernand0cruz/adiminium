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
            const order = response.data.data;

            return order ? order : null;
        } catch (error) {
            if (error.response && error.response.status === 404) {
                return null;
            }
            return handleRequestError(error);
        }
    },
    addProductToOrderActive: async (orderId, orderData) => {
        try {
            const response = await httpClient.patch(`/api/orders/${orderId}/add-product`, orderData);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    incrementProductToOrderActive: async (orderId, orderData) => {
        try {
            const response = await httpClient.patch(`/api/orders/${orderId}/increment-product`, orderData);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    decrementProductToOrderActive: async (orderId, orderData) => {
        try {
            const response = await httpClient.patch(`/api/orders/${orderId}/decrement-product`, orderData);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    removeProductToOrderActive: async (orderId, orderData) => {
        try {
            const response = await httpClient.patch(`/api/orders/${orderId}/remove-product`, orderData);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
});

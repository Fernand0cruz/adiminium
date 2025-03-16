import { handleRequestError } from "@/Utils/handleRequestError.js";
export default (httpClient) => ({
    create: async (clientData) => {
        try {
            const response = await httpClient.post("/api/clients", clientData);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    getAll: async (page = 1) => {
        try {
            const response = await httpClient.get(`/api/clients?page=${page}`);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    get: async (clientId) => {
        try {
            const response = await httpClient.get(`/api/clients/${clientId}`);
            return response.data.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    update: async (clientId, clientData) => {
        console.log(clientData);

        try {
            const response = await httpClient.patch(
                `/api/clients/${clientId}`,
                clientData
            );
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    delete: async (clientId) => {
        try {
            const response = await httpClient.delete(
                `/api/clients/${clientId}`
            );
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
});

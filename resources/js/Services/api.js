import axios from "axios";

const getAuthHeaders = () => {
    const token = localStorage.getItem("auth_token");
    
    if (!token) {
        // !!Todo: Implementar um mecanismo para tratar tokens expirados, como logout automático ou renovação do token.
        throw new Error(
            "Authentication token not found, please log out and log back in."
        );
    }
    
    return {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    };
};

const handleFetchResponse = async (method, url, data = null) => {
    try {
        const authHeaders = getAuthHeaders();

        const config = {
            method,
            url,
            ...authHeaders,
        };

        if (["post", "patch"].includes(method.toLowerCase()) && data) {
            config.data = data;
        }

        const response = await axios(config);

        if (!response.data.status) {
            throw new Error(response.data.message || "Unexpected error.");
        }

        if(["post", "patch", "delete"].includes(method.toLowerCase())){
            return response.data.message
        }
        
        return response.data.data;
    } catch (error) {
        return handleFetchError(error);
    }
};

const handleFetchError = (error) => {
    console.error("Error details:", {
        message: error.message,
        response: error.response?.data,
        request: error.request,
    });

    let message = "An unexpected error occurred.";
    let formattedErrors = null;

    if (error.response) {
        const responseData = error.response.data;

        if (error.response.status === 422 && responseData.errors) {
            formattedErrors = { errors: responseData.errors };
            message = "Validation errors occurred.";
        } else {
            message =
                responseData.message ||
                responseData.error ||
                "Something went wrong on the server.";
        }
    } else if (error.request) {
        message = "Network error: Unable to contact the server.";
    } else {
        message = `Unexpected error: ${error.message}`;
    }

    if (formattedErrors) {
        throw { message, ...formattedErrors };
    }

    throw new Error(message);
};


const callToApi = async (method, url, data = null) => {
    return await handleFetchResponse(method, url, data);
};

const fetchProducts = async (page = 1) => {
    return await callToApi("get", `/api/products?page=${page}`);
};

const fetchProduct = async (id) => {
    return await callToApi("get", `/api/products/${id}`);
};

const createProduct = async (data) => {
    return await callToApi("post", `/api/products`, data);
};

const updateProduct = async (id, data) => {
    return await callToApi("patch", `/api/products/${id}`, data);
};

const deleteProduct = async (id) => {
    return await callToApi("delete", `/api/products/${id}`);
};

const fetchClients = async (page = 1) => {
    return await callToApi("get", `/api/clients?page-=${page}`);
};

const fetchClient = async (id) => {
    return await callToApi("get", `/api/clients/${id}`);
};

const createClient = async (data) => {
    return await callToApi("post", `/api/clients`, data);
};

const updateClient = async (id, data) => {
    return await callToApi("patch", `/api/clients/${id}`, data);
};

const deleteClient = async (id) => {
    return await callToApi("delete", `/api/clients/${id}`);
};

const createOrder = async (data) => {
    return await callToApi("post", `/api/orders`, data);
};

const fetchOrder = async () => {
    return await callToApi("get", `/api/orders`);
};

const updateOrder = async (id, data) => {
    return await callToApi("patch", `/api/orders/${id}`, data);
};

const deleteOrder = async (id) => {
    return await callToApi("delete", `/api/orders/${id}`);
};

const ordersInProgress = async () => {
    return await callToApi("get", `/api/orders/in-progress`);
};

const ordersCompleted = async () => {
    return await callToApi("get", `/api/orders/completed`);
};

const allOrdersInProgress = async () => {
    return await callToApi("get", `/api/orders/all-in-progress`);
};

const allOrders = async () => {
    return await callToApi("get", `/api/orders/all`);
};

export {
    createProduct,
    fetchProducts,
    fetchProduct,
    updateProduct,
    deleteProduct,
    createClient,
    fetchClients,
    fetchClient,
    updateClient,
    deleteClient,
    createOrder,
    fetchOrder,
    updateOrder,
    deleteOrder,
    ordersInProgress,
    ordersCompleted,
    allOrders,
    allOrdersInProgress,
};

import axios from "axios";

const getAuthHeaders = () => {
    const token = localStorage.getItem("auth_token");
    if (!token) {
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

const handleFetchError = (error) => {
    console.error(error);
    let message = "An unexpected error occurred.";

    if (error.response) {
        if (error.response.status === 422) {
            message = error.response.data.message || message;
        } else {
            message =
                error.response.data.message ||
                error.response.data.error ||
                message;
        }
    } else if (error.request) {
        message = "Network error: Unable to contact the server.";
    } else {
        message = `Error: ${error.message}`;
    }

    throw new Error(message);
};

const fetchProducts = async (page = 1) => {
    try {
        const response = await axios.get(
            `/api/products?page=${page}`,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const fetchProduct = async (id) => {
    try {
        const response = await axios.get(
            `/api/products/${id}`,
            getAuthHeaders()
        );
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const createProduct = async (productData) => {
    try {
        const response = await axios.post(
            `/api/products`,
            productData,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const updateProduct = async (id, productData) => {
    try {
        const response = await axios.patch(
            `/api/products/${id}`,
            productData,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const deleteProduct = async (productId) => {
    try {
        const response = await axios.delete(
            `/api/products/${productId}`,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const fetchClients = async (page = 1) => {
    try {
        const response = await axios.get(
            `/api/clients?page=${page}`,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const fetchClient = async (id) => {
    try {
        const response = await axios.get(
            `/api/clients/${id}`,
            getAuthHeaders()
        );
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const createClient = async (clientData) => {
    try {
        const response = await axios.post(
            `/api/clients`,
            clientData,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const updateClient = async (id, clientData) => {
    try {
        const response = await axios.patch(
            `/api/clients/${id}`,
            clientData,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const deleteClient = async (clientId) => {
    try {
        const response = await axios.delete(
            `/api/clients/${clientId}`,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const createOrder = async (orderData) => {
    try {
        const response = await axios.post(
            `/api/orders`,
            orderData,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const fetchOrder = async () => {
    try {
        const response = await axios.get("/api/orders", getAuthHeaders());
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const updateOrder = async (id, orderData) => {
    try {
        const response = await axios.patch(
            `/api/orders/${id}`,
            orderData,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const deleteOrder = async (id) => {
    try {
        const response = await axios.delete(
            `/api/orders/${id}`,
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.message;
    } catch (error) {
        handleFetchError(error);
    }
};

const ordersInProgress = async () => {
    try {
        const response = await axios.get(
            "/api/orders/in-progress",
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const ordersCompleted = async () => {
    try {
        const response = await axios.get(
            "/api/orders/completed",
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const allOrders = async () => {
    try {
        const response = await axios.get("/api/orders/all", getAuthHeaders());
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
};

const allOrdersInProgress = async () => {
    try {
        const response = await axios.get(
            "/api/orders/all-in-progress",
            getAuthHeaders()
        );
        if (!response.data.status) throw new Error(response.data.message);
        return response.data.data;
    } catch (error) {
        handleFetchError(error);
    }
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

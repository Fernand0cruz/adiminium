import axios from "axios";
import Products from "./Products/index.js";
import Companies from "./Companies/index.js";
import Clients from "./Clients/index.js";

const token = localStorage.getItem("auth_token");

const httpClient = axios.create({
    baseURL: import.meta.VITE_APP_URL,
    //baseURL: "https://api.invalida.com", // URL errada para forçar erro
    headers: {
        Accept: "application/json",
        ...(token && { Authorization: `Bearer ${token}` }),
    },
});

httpClient.interceptors.response.use(
    (response) => response,
    async (error) => {
        if (error.response && error.response.status === 401) {
            // implementar logica para logout do user
            window.location.href = route("login");
            return;
        }

        return Promise.reject(error);
    }
);

export default {
    products: Products(httpClient),
    companies: Companies(httpClient),
    clients: Clients(httpClient),
};

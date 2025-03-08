import { handleRequestError } from "@/Utils/handleRequestError";

const createOrUpdateCompany = (companyData, method) => {
    const formData = new FormData();
    formData.append("photo", companyData.photo);
    formData.append("cnpj", companyData.cnpj);
    formData.append("business_name", companyData.business_name); 
    formData.append("phone", companyData.phone); 
    formData.append("address", companyData.address); 
    formData.append("street", companyData.street); 
    formData.append("neighborhood", companyData.neighborhood); 
    formData.append("state", companyData.state); 
    formData.append("number", companyData.number); 
    formData.append("city", companyData.city); 
    formData.append("zip_code", companyData.zip_code); 

    if (method === "PATCH") {
        formData.append("_method", "PATCH");
    }

    return formData; 
};

const formatCompanyData = (product) => {
    
};

export default (httpClient) => ({
    create: async (productData) => {
        try {
            const data = createOrUpdateCompany(productData) 
            const response = await httpClient.post("/api/companies", data);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    getAll: async (page = 1) => {
        try {
            const response = await httpClient.get(`/api/companies?page=${page}`);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
});

import { handleRequestError } from "@/Utils/handleRequestError";

const createOrUpdateCompany = (companyData, method) => {
    const formData = new FormData();
    formData.append("photo", companyData.photo);
    formData.append("cnpj", companyData.cnpj);
    formData.append("business_name", companyData.business_name);
    formData.append("phone", companyData.phone);
    formData.append("email", companyData.email);
    formData.append("web_site", companyData.web_site);
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

const formatCompanyData = (company) => {
    const formatCNPJ = (cnpj) => {
        return cnpj.replace(
            /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/,
            "$1.$2.$3/$4-$5"
        );
    };

    const formatPhone = (phone) => {
        return phone.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
    };

    return {
        ...company,
        cnpj: formatCNPJ(company.cnpj),
        phone: formatPhone(company.phone),
    };
};

export default (httpClient) => ({
    create: async (productData) => {
        try {
            const data = createOrUpdateCompany(productData);
            const response = await httpClient.post("/api/companies", data);
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    getAll: async (page = 1) => {
        try {
            const response = await httpClient.get(
                `/api/companies?page=${page}`
            );
            const formattedData =
                response.data.data.data.map(formatCompanyData);
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
    get: async (companyId) => {
        try {
            const response = await httpClient.get(
                `/api/companies/${companyId}`
            );
            const company = formatCompanyData(response.data.data);
            return company;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    update: async (companyId, companyData) => {
        try {
            const data = createOrUpdateCompany(companyData, "PATCH");
            const response = await httpClient.post(
                `/api/companies/${companyId}`,
                data
            );
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
    delete: async (companyId) => {
        try {
            const response = await httpClient.delete(
                `/api/companies/${companyId}`
            );
            return response.data;
        } catch (error) {
            return handleRequestError(error);
        }
    },
});

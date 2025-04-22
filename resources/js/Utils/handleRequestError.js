export function handleRequestError(error) {
    if (error.response) {
        if (error.response.status === 422) {
            console.warn("Erro de validação:", error.response.data.errors);
            throw error.response.data.errors;
        }

        if (error.response.status === 413) {
            console.warn("Erro: Arquivo muito grande.");
            throw { image: ["O arquivo de imagem é muito grande."] };
        }

        if (error.response.status === 404) {
            console.warn("Erro: Dado(s) não encontrado.");
            throw { message: ["Dado(s) não encontrado no sistema."] };
        }

        console.error("Erro do servidor:", error.response.status, error.response.data);
        throw {
            message: [error.response.data.message] || ["Ocorreu um erro no servidor. Tente novamente mais tarde!"],
        };
    }

    if (error.message === "Network Error") {
        console.error("Erro de rede. O backend pode estar offline.");
        throw {
            message: ["Erro de conexão com o servidor. Verifique sua internet ou tente novamente mais tarde!"],
        };
    }

    console.error("Erro desconhecido:", error);
    throw { message: ["Ocorreu um erro inesperado."] };
}

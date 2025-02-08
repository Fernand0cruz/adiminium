<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <div class="bg-gray-100 min-h-screen flex flex-col">
        <header class="bg-white border">
            <div class="p-4 flex justify-between items-center max-w-screen-xl m-auto">
                <div class="w-[125px]">
                    <img src="/images/logo.svg" alt="Logo" />
                </div>
                <nav v-if="canLogin" class="flex gap-4">
                    <template v-if="$page.props.auth.user">
                        <Link v-if="$page.props.auth.user.role === 'admin'" :href="route('dashboard')">Home Page</Link>
                        <Link v-else-if="$page.props.auth.user.role === 'client'" :href="route('products')">Home Page
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')">Login</Link>
                        <Link v-if="canRegister" :href="route('register')">Register</Link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-3xl font-semibold text-center">
                            Bem-vindo ao Adminium: A Plataforma Definitiva para Gestão de Produtos e Pedidos
                        </h1>
                        <p class="text-justify">
                            O Adminium foi desenvolvido com o objetivo de simplificar a gestão de produtos e pedidos,
                            oferecendo
                            uma solução eficiente para empresas e administradores. Com uma interface moderna e
                            intuitiva, nossa
                            plataforma permite que você gerencie seu estoque com precisão e agilidade, além de
                            acompanhar de
                            perto cada pedido realizado.
                            Desde o cadastro de produtos até a análise detalhada dos pedidos, o Adminium foi pensado
                            para
                            otimizar o fluxo de trabalho e garantir que os produtos estejam sempre disponíveis para quem
                            mais
                            precisa. Conectando administradores e empresas de forma transparente, garantimos que todos
                            possam
                            acompanhar o progresso em tempo real e tomar decisões informadas.
                        </p>
                    </div>

                    <div
                        class="border rounded-lg p-6 bg-white flex flex-col-reverse md:flex-row items-center md:items-start gap-8">
                        <div class="md:w-1/2 space-y-4">
                            <h2 class="text-2xl font-semibold">
                                Funcionalidades Exclusivas para Administradores
                            </h2>
                            <p class="text-justify">
                                <strong>Cadastro de Produtos e Estoque:</strong> O Adminium facilita o processo de
                                adicionar
                                novos produtos ao catálogo, acompanhar a quantidade disponível em estoque e garantir que
                                as
                                informações estejam sempre atualizadas.
                            </p>
                            <p class="text-justify">
                                <strong>Gestão de Pedidos:</strong> Acompanhe e analise todos os pedidos realizados
                                pelas
                                empresas, com a possibilidade de aprovar ou recusar com base nas necessidades do
                                momento. Nossa
                                plataforma permite um controle total sobre os pedidos.
                            </p>
                            <p class="text-justify">
                                <strong>Relatórios Detalhados:</strong> Com o Adminium, você terá acesso a relatórios
                                completos
                                sobre o desempenho de seu estoque.
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img class="w-96 h-auto rounded-lg" src="/images/undraw_add_to_cart.svg"
                                alt="Add to Cart" />
                        </div>
                    </div>

                    <div
                        class="border rounded-lg p-6 bg-white flex flex-col md:flex-row items-center md:items-start gap-8">
                        <div class="md:w-1/2 flex justify-center">
                            <img class="w-96 h-auto rounded-lg" src="/images/undraw_data_reports.svg"
                                alt="Data Reports" />
                        </div>
                        <div class="md:w-1/2 space-y-4">
                            <h2 class="text-2xl font-semibold">
                                Funcionalidades para Empresas
                            </h2>
                            <p class="text-justify">
                                <strong>Acesso Rápido ao Catálogo de Produtos:</strong> Navegue com facilidade por um
                                catálogo
                                de produtos completo e sempre atualizado. Faça pedidos conforme sua demanda e tenha a
                                garantia
                                de que sua empresa estará sempre bem abastecida com o que precisa.
                            </p>
                            <p class="text-justify">
                                <strong>Pedidos Simples e Eficientes:</strong> Realize seus pedidos em poucos cliques e
                                aguarde
                                a aprovação
                                em tempo
                                real. Nossa plataforma foi desenvolvida para que as empresas possam otimizar suas
                                compras e
                                focar no que realmente importa: o crescimento do negócio.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse md:flex-row items-center md:items-start gap-8">
                        <div class="md:w-1/2 space-y-4">
                            <p class="text-justify">
                                O Adminium vai além de uma simples plataforma de gestão. Ele foi projetado para oferecer
                                total
                                controle sobre seu estoque e pedidos, com uma interface fácil de usar e funcionalidades
                                que
                                atendem tanto aos administradores quanto às empresas. Com segurança, eficiência e uma
                                comunicação clara, você garante que seus produtos estarão sempre disponíveis quando
                                necessário.
                            </p>
                            <p class="text-justify">
                                Experimente o Adminium hoje mesmo e eleve a sua gestão de produtos e pedidos para um
                                novo nível
                                de eficiência e organização. Com a nossa plataforma, seu negócio estará mais preparado
                                do que
                                nunca para os desafios do mercado.
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img class="w-96 h-auto rounded-lg" src="/images/undraw_usability_testing.svg"
                                alt="Usability Testing" />
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border bg-white">
            <div class="p-4 flex justify-between items-center max-w-screen-xl m-auto">
                &copy; 2024 - Adminium
            </div>
        </footer>
    </div>
</template>

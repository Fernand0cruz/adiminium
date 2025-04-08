<template>
    <div class="bg-gray-100">
        <div class="max-w-screen-2xl mx-auto p-4">
            <!-- HEADER -->
            <header class="border py-4 px-8 rounded-xl flex items-center justify-between bg-white">
                <!-- LOGO -->
                <div class="w-[125px]">
                    <img src="/images/logo.svg" alt="Logo" />
                </div>
                <!-- NAVBAR -->
                <nav v-if="canLogin" class="flex gap-4">
                    <template v-if="$page.props.auth.user">
                        <Link v-if="$page.props.auth.user.role === 'admin'" :href="route('admin.dashboard')">Página
                        Inicial </Link>
                        <Link v-else-if="$page.props.auth.user.role === 'client'"
                            :href="route('products.catalog.index')">Página Inicial
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')">Entrar</Link>
                        <Link v-if="canRegister" :href="route('register')">Registrar</Link>
                    </template>
                </nav>
            </header>

            <!-- MAIN -->
            <main class="py-12">
                <div class="mx-auto px-4 lg:px-8 space-y-16">
                    <!-- HERO SECTION-->
                    <section class="text-center py-24 space-y-6 opacity-0 animate-fade-in-down">
                        <h1 class="text-5xl font-bold text-gray-800">
                            Bem-vindo ao <span class="text-indigo-600">Adminium</span>
                        </h1>
                        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                            A plataforma definitiva para uma gestão eficiente entre <strong>destribuidoras</strong> e
                            <strong>clientes</strong>. Simplificamos seus processos com tecnologia de ponta e uma
                            interface moderna.
                        </p>
                    </section>

                    <!-- INTRODUCTION SECTION -->
                    <section
                        class="border flex flex-col-reverse md:flex-row items-center gap-10 bg-white p-8 rounded-xl opacity-0 animate-fade-in-down">
                        <div class="md:w-1/2 space-y-4">
                            <h2 class="text-2xl font-semibold text-indigo-600">
                                Por que escolher o Adminium?
                            </h2>
                            <p class="text-gray-600">
                                O <span class="text-indigo-700 font-bold">Adminium</span> foi pensado para facilitar a
                                rotina de
                                destribuidoras e seus clientes. Desde o
                                controle de
                                produtos até a geração de relatórios, tudo está integrado em um único ambiente digital.
                            </p>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>Gestão centralizada de produtos, empresas e pedidos.</li>
                                <li>Interface intuitiva e responsiva.</li>
                                <li>Fluxo de trabalho otimizado e rápido.</li>
                                <li>Segurança e confiabilidade nos dados.</li>
                                <li>Atualizações constantes com base no feedback dos usuários.</li>
                                <li>Suporte técnico humanizado e ágil.</li>
                            </ul>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="/images/undraw_add_to_cart.svg" alt="Add to Cart"
                                class="w-96 h-auto transition-transform duration-300 hover:scale-105" />
                        </div>
                    </section>

                    <!-- FOR ADMIN SECTION -->
                    <section
                        class="flex border flex-col md:flex-row items-center gap-10 bg-white p-8 rounded-xl opacity-0 animate-fade-in-down">
                        <div class="md:w-1/2 flex justify-center">
                            <img src="/images/undraw_data_reports.svg" alt="Data Reports"
                                class="w-96 h-auto transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="md:w-1/2 space-y-4">
                            <h2 class="text-2xl font-semibold text-indigo-600">Funcionalidades para Administradores</h2>
                            <p><strong>📦 Cadastro e gestao de Produtos:</strong> Controle total sobre seu inventário
                                com
                                atualizações em tempo real.</p>
                            <p><strong>📋 Gestão de Pedidos:</strong> Acompanhe o andamento dos seus pedidos de forma
                                rapida simples
                                e intuitiva.
                            </p>
                            <p><strong>📊 Relatórios Detalhados:</strong> Visualize métricas importantes e tome decisões
                                estratégicas baseadas em dados.</p>
                            <p><strong>👥 Gerenciamento de Empresas e Usuarios:</strong> Crie, edite e controle o acesso
                                de
                                usuários com
                                permissões específicas para cada empresa.</p>
                            <p><strong>🔔 Notificações Inteligentes:</strong> Receba alertas sobre atividades
                                importantes e andamento de pedidos.</p>
                        </div>
                    </section>

                    <!-- FOR COMPANIES SECTION -->
                    <section
                        class="flex border flex-col-reverse md:flex-row items-center gap-10 bg-white p-8 rounded-xl opacity-0 animate-fade-in-down">
                        <div class="md:w-1/2 space-y-4">
                            <h2 class="text-2xl font-semibold text-indigo-600">Funcionalidades para Empresas</h2>
                            <p><strong>🛍️ Catálogo Atualizado:</strong> Acesse o catalogo de produtos disponibiliozados
                                pelo
                                destribuidor e fique a vontade para adicionar aos seu pedido e realizar a compra!</p>
                            <p><strong>⚡ Pedidos Rápidos:</strong> Realize pedidos em poucos cliques e acompanhe o
                                status em tempo
                                real.</p>
                            <p><strong>📑 Histórico de Pedidos:</strong> Visualize todos os pedidos anteriores e repita
                                compras com
                                apenas um clique.</p>
                            <p><strong>🔍 Filtro de Produtos:</strong> Busque produtos por nome ou status de
                                disponibilidade.</p>
                            <p><strong>💬 Comunicação Direta:</strong> Envie mensagens e observações aos administradores
                                diretamente
                                pela plataforma.</p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="/images/undraw_usability_testing.svg" alt="Usability Testing"
                                class="w-96 h-auto transition-transform duration-300 hover:scale-105" />
                        </div>
                    </section>

                    <!-- CARDS SECTION -->
                    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                        <div
                            class="p-6 rounded-lg border border-indigo-500 bg-white text-indigo-700 align-middle transition duration-300 ease-in-out hover:scale-105 hover:shadow-xl">

                            <h3 class="text-lg font-semibold text-indigo-700">Contato direto com o distribuidor</h3>
                            <p class="text-gray-700">Facilite a comunicação com o distribuidor através de mensagens
                                rápidas e
                                centralizadas, garantindo agilidade no atendimento e nas negociações.</p>
                        </div>
                        <div
                            class="p-6 rounded-lg border border-indigo-500 bg-white text-indigo-700 align-middle transition duration-300 ease-in-out hover:scale-105 hover:shadow-xl">

                            <h3 class="text-lg font-semibold text-indigo-700">Atualizações gratuitas</h3>
                            <p class="text-gray-700">Receba melhorias constantes sem custo adicional, mantendo seu
                                sistema sempre
                                moderno.</p>
                        </div>
                        <div
                            class="p-6 rounded-lg border border-indigo-500 bg-white text-indigo-700 align-middle transition duration-300 ease-in-out hover:scale-105 hover:shadow-xl">

                            <h3 class="text-lg font-semibold text-indigo-700">Responsividade total</h3>
                            <p class="text-gray-700">Acesse todas as funcionalidades de qualquer dispositivo, seja
                                desktop, tablet
                                ou celular.</p>
                        </div>
                    </section>

                    <!-- END SECTION-->
                    <section class="text-center py-24 space-y-6">
                        <h2 class="text-3xl font-bold text-gray-800">Experimente o <span
                                class="text-indigo-600">Adminium</span>
                            hoje mesmo</h2>
                        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                            Eleve a gestão da sua empresa com uma plataforma confiável, rápida e feita para facilitar
                            sua rotina.
                            Reduza erros, ganhe tempo e tenha controle total.
                        </p>
                        <a href="/register"
                            class="py-5 px-12 inline-flex justify-center items-center rounded-lg border border-indigo-500 font-bold bg-indigo-100 text-indigo-700 align-middle hover:bg-indigo-200 transition-all text-xl animate-pulse">
                            Registre-se agora
                        </a>
                    </section>
                </div>
            </main>

            <!-- FOOTER -->
            <footer class="border py-4 px-8  rounded-xl flex items-center justify-between bg-white">
                <div class="p-[5.82px]">
                    &copy; 2024 - Adminium
                </div>
            </footer>
        </div>
    </div>
</template>

<style>
@keyframes fade-in-down {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.6s ease-out forwards;
}
</style>

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

<script setup>
import { Link } from '@inertiajs/vue3';

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
                        <Link v-if="$page.props.auth.user.role === 'admin'" :href="route('home')">Página Inicial</Link>
                        <Link v-else-if="$page.props.auth.user.role === 'client'" :href="route('products')">Página
                        Inicial</Link>
                    </template>

                    <template v-else>
                        <Link :href="route('login')">Entrar</Link>
                        <Link v-if="canRegister" :href="route('register')">Registrar</Link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="flex-grow p-8">
            <div class="max-w-4xl mx-auto text-gray-700 space-y-8 flex flex-col gap-8">
                <div class="flex flex-col gap-8">
                    <h1 class="text-3xl font-semibold text-gray-900 text-center">Bem-vindo ao Sistema de Gerenciamento de
                        Estoque e
                        Pedidos</h1>
                        <p class="text-lg text-justify">
                            O <strong>Adminium</strong> é uma solução completa para facilitar o controle de estoque e otimizar o
                            processo de vendas. Desenvolvido para proprietários de empresas, o sistema permite cadastrar
                            clientes,
                            organizar o estoque de produtos e acompanhar pedidos em tempo real.
                        </p>
                    </div>
                <div class="flex flex-col-reverse md:flex-row items-center md:items-start gap-8">
                    <div class="md:w-1/2 space-y-4">
                        <p class="text-lg leading-relaxed text-justify">
                            Com ele, o proprietário pode cadastrar e gerenciar seu catálogo de produtos, definindo
                            preços,
                            descrição
                            e quantidade em estoque. Além disso, é possível registrar clientes, que terão acesso ao
                            sistema para
                            realizar pedidos diretamente, simplificando o processo de compra.
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img class="w-80 h-auto" src="/images/undraw_add_to_cart.svg" alt="Add to Cart" />
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="md:w-1/2 flex justify-center">
                        <img class="w-80 h-auto" src="/images/undraw_data_reports.svg" alt="Data Reports" />
                    </div>
                    <div class="md:w-1/2 space-y-4">
                        <p class="text-lg leading-relaxed text-justify">
                            Cada pedido feito pelos clientes é automaticamente registrado no sistema, permitindo ao
                            proprietário
                            acompanhar o status e administrar os estoques conforme as vendas acontecem. Com uma
                            interface
                            amigável e
                            funcionalidades intuitivas, o sistema garante maior eficiência no gerenciamento do estoque e
                            das
                            vendas.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col-reverse md:flex-row items-center md:items-start gap-8">
                    <div class="md:w-1/2 space-y-4">
                        <p class="text-lg leading-relaxed text-justify">
                            Ideal para empresas que desejam organizar melhor seu estoque e oferecer aos clientes uma
                            experiência
                            de
                            compra simples e prática, o <strong>Adiminium</strong>
                            traz mais
                            controle, agilidade e segurança nas operações do dia a dia.
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <img class="w-80 h-auto" src="/images/undraw_usability_testing.svg" alt="Usability Testing" />
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

<script setup>
import { ref, onMounted } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {
    Home,
    SquareChartGantt,
    Menu,
    CircleUserRound,
    ChevronRight,
    ChevronDown,
    Users,
    ScanBarcode,
    Package2,
} from "lucide-vue-next";
import { Link, usePage } from "@inertiajs/vue3";

const showingAside = ref(false);

const toggleAside = () => {
    showingAside.value = !showingAside.value;
};

const closeAside = () => {
    showingAside.value = false;
};

const toggleSubmenus = ref({
    products: false,
    companies: false,
    clients: false,
});

const toggleSubmenu = (menu) => {
    toggleSubmenus.value[menu] = !toggleSubmenus.value[menu];
};

onMounted(() => {
    const currentRoute = route().current();

    toggleSubmenus.value.products = [
        "admin.products.index",
        "admin.products.create",
    ].includes(currentRoute);
    toggleSubmenus.value.companies = [
        "admin.companies.index",
        "admin.companies.create",
    ].includes(currentRoute);
    toggleSubmenus.value.clients = [
        "admin.clients.index",
        "admin.clients.create",
    ].includes(currentRoute);
});

const isActive = (routes) => {
    return routes.some((r) => route().current(r));
};

const { props } = usePage();
const userRole = props.auth.user.role;
</script>

<template>
    <header
        class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-[48] w-full bg-white border-b py-3 px-6">
        <nav class="flex basis-full items-center w-full mx-auto">
            <div class="lg:hidden">
                <Link :href="userRole === 'admin'
                        ? route('admin.dashboard')
                        : route('products.index')
                    ">
                <ApplicationLogo class="h-16" />
                </Link>
            </div>

            <div class="w-full flex items-center justify-end md:justify-between">
                <span></span>
                <div class="flex flex-row items-center justify-end">
                    <div class="relative inline-flex">
                        <div class="sm:ms-6 sm:flex sm:items-center">
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button type="button"
                                            class="inline-flex items-center p-2 gap-2 transition duration-150 ease-in-out focus:outline-none capitalize">
                                            {{ $page.props.auth.user.name }}
                                            <CircleUserRound />
                                        </button>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="sticky top-0 inset-x-0 z-20 bg-white border-b px-4 sm:px-6 lg:px-8 lg:hidden">
        <div class="flex items-center py-2">
            <button @click="toggleAside" type="button"
                class="size-8 flex justify-center items-center gap-x-2 border border-gray-200 text-gray-800 hover:text-gray-500 rounded-lg focus:outline-none">
                <Menu />
            </button>
            <ol class="flex items-center whitespace-nowrap ml-3">
                <Link :href="userRole === 'admin'
                        ? route('admin.dashboard')
                        : route('products.catalog.index')
                    " class="text-gray-800 hover:text-gray-500">
                Adminium
                </Link>
                <li class="text-gray-800 flex items-center">
                    <ChevronRight size="14" class="mx-2" />
                    <Link class="text-gray-800 hover:text-gray-500 capitalize">
                    teste
                    </Link>
                </li>
            </ol>
        </div>
    </div>

    <div :class="{
        'translate-x-0': showingAside,
        '-translate-x-full': !showingAside,
        'lg:translate-x-0': true,
    }"
        class="fixed inset-y-0 start-0 z-[60] w-[260px] h-full bg-white border-e border-gray-200 transition-transform duration-300 lg:block lg:end-auto lg:bottom-0">
        <div class="relative flex flex-col h-full max-h-full">
            <div class="py-3 mx-auto">
                <Link :href="userRole === 'admin'
                        ? route('admin.dashboard')
                        : route('products.catalog.index')
                    ">
                <ApplicationLogo class="h-14" />
                </Link>
            </div>
            <div class="h-full overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <nav class="p-3 flex flex-col space-y-1">
                    <ul class="flex flex-col space-y-1">
                        <li>
                            <Link
                                class="flex items-center gap-x-3.5 py-2 px-2.5 text-gray-800 rounded-lg hover:bg-gray-100"
                                :href="userRole === 'admin'
                                        ? route('admin.dashboard')
                                        : route('products.catalog.index')
                                    " :class="{
                                    'bg-gray-100':
                                        userRole === 'admin'
                                            ? route().current('admin.dashboard')
                                            : route().current('products.catalog.index'),
                                }">
                            <Home v-if="userRole === 'admin'" />
                            <ScanBarcode v-else />
                            {{
                                userRole === "admin"
                                    ? "Dashboard"
                                    : "Produtos"
                            }}
                            </Link>
                        </li>
                        <li v-show="userRole === 'admin'">
                            <button @click="toggleSubmenu('products')"
                                class="w-full flex justify-between items-center py-2 px-2.5 text-gray-800 rounded-lg hover:bg-gray-100"
                                :class="{
                                    'bg-gray-100': isActive([
                                        'listProducts',
                                        'createProduct',
                                    ]),
                                }">
                                <div class="flex items-center gap-3">
                                    <Package2 />
                                    Produtos
                                </div>
                                <ChevronDown size="16" :class="{
                                    'rotate-180': toggleSubmenus.products,
                                }" />
                            </button>
                            <Transition enter-active-class="transition-all duration-300 ease-out"
                                enter-from-class="opacity-0 max-h-0 overflow-hidden"
                                enter-to-class="opacity-100 max-h-40"
                                leave-active-class="transition-all duration-200 ease-in"
                                leave-from-class="opacity-100 max-h-40"
                                leave-to-class="opacity-0 max-h-0 overflow-hidden">
                                <ul v-if="toggleSubmenus.products" class="mt-1 space-y-1">
                                    <li>
                                        <Link :href="route('admin.products.index')
                                            " :class="{
                                                'bg-gray-100': route().current(
                                                    'admin.products.index'
                                                ),
                                            }"
                                            class="block py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg pl-[43px]">
                                        Listar Produtos</Link>
                                    </li>
                                    <li>
                                        <Link :href="route('admin.products.create')
                                            " :class="{
                                                'bg-gray-100': route().current(
                                                    'admin.products.create'
                                                ),
                                            }"
                                            class="block py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg pl-[43px]">
                                        Novo Produto</Link>
                                    </li>
                                </ul>
                            </Transition>
                        </li>
                        <li v-show="userRole === 'admin'">
                            <button @click="toggleSubmenu('companies')"
                                class="w-full flex justify-between items-center py-2 px-2.5 text-gray-800 rounded-lg hover:bg-gray-100"
                                :class="{
                                    'bg-gray-100': isActive([
                                        'listCompanies',
                                        'createCompanies',
                                    ]),
                                }">
                                <div class="flex items-center gap-3">
                                    <SquareChartGantt />
                                    Empresas
                                </div>
                                <ChevronDown size="16" :class="{
                                    'rotate-180': toggleSubmenus.companies,
                                }" />
                            </button>
                            <Transition enter-active-class="transition-all duration-300 ease-out"
                                enter-from-class="opacity-0 max-h-0 overflow-hidden"
                                enter-to-class="opacity-100 max-h-40"
                                leave-active-class="transition-all duration-200 ease-in"
                                leave-from-class="opacity-100 max-h-40"
                                leave-to-class="opacity-0 max-h-0 overflow-hidden">
                                <ul v-if="toggleSubmenus.companies" class="mt-1 space-y-1">
                                    <li>
                                        <Link :href="route('admin.companies.index')" :class="{
                                            'bg-gray-100': isActive([
                                                'admin.companies.index',
                                            ]),
                                        }"
                                            class="block py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg pl-[43px]">
                                        Listar Empresas</Link>
                                    </li>
                                    <li>
                                        <Link :href="route('admin.companies.create')
                                            " :class="{
                                                'bg-gray-100': isActive([
                                                    'admin.companies.create',
                                                ]),
                                            }"
                                            class="block py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg pl-[43px]">
                                        Nova Empresa</Link>
                                    </li>
                                </ul>
                            </Transition>
                        </li>
                        <li v-show="userRole === 'admin'">
                            <button @click="toggleSubmenu('clients')"
                                class="w-full flex justify-between items-center py-2 px-2.5 text-gray-800 rounded-lg hover:bg-gray-100"
                                :class="{
                                    'bg-gray-100': isActive([
                                        'listClients',
                                        'createClient',
                                    ]),
                                }">
                                <div class="flex items-center gap-3">
                                    <Users />
                                    Clientes
                                </div>
                                <ChevronDown size="16" :class="{
                                    'rotate-180': toggleSubmenus.clients,
                                }" />
                            </button>
                            <Transition enter-active-class="transition-all duration-300 ease-out"
                                enter-from-class="opacity-0 max-h-0 overflow-hidden"
                                enter-to-class="opacity-100 max-h-40"
                                leave-active-class="transition-all duration-200 ease-in"
                                leave-from-class="opacity-100 max-h-40"
                                leave-to-class="opacity-0 max-h-0 overflow-hidden">
                                <ul v-if="toggleSubmenus.clients" class="mt-1 space-y-1">
                                    <li>
                                        <Link :href="route('admin.clients.index')" :class="{
                                            'bg-gray-100': isActive([
                                                'admin.clients.index',
                                            ]),
                                        }"
                                            class="block py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg pl-[43px]">
                                        Listar Clientes</Link>
                                    </li>
                                    <li>
                                        <Link :href="route('admin.clients.create')
                                            " :class="{
                                                'bg-gray-100': isActive([
                                                    'admin.clients.create',
                                                ]),
                                            }"
                                            class="block py-2 px-2.5 text-gray-700 hover:bg-gray-100 rounded-lg pl-[43px]">
                                        Novo Cliente</Link>
                                    </li>
                                </ul>
                            </Transition>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div v-if="showingAside" @click="closeAside" class="fixed inset-0 bg-black bg-opacity-50 z-50 lg:hidden"></div>
    <div class="mx-auto lg:ps-64 bg-gray-50 min-h-screen">
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <div class="bg-white border p-4 rounded-lg shadow-sm max-w-screen-2xl mx-auto space-y-4">
                <slot />
            </div>
        </div>
    </div>
</template>

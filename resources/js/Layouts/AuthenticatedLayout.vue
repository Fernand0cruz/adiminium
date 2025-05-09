<template>
    <!-- HEADER -->
    <header class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-[48] w-full bg-white border-b py-3 px-6">
        <nav class="flex basis-full items-center w-full mx-auto">
            <div class="lg:hidden">
                <Link :href="userRole === 'admin' ? route('admin.dashboard') : route('products.index')">
                    <ApplicationLogo class="h-16" />
                </Link>
            </div>
            <div class="w-full flex items-center justify-end md:justify-between">
                <span></span>
                <div class="relative inline-flex">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button type="button" class="inline-flex items-center p-2 gap-2 capitalize">
                                {{ user.name }}
                                <CircleUserRound class="text-indigo-500"/>
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Perfil</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Sair</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </nav>
    </header>

    <!-- MOBILE BREADCRUMB -->
    <div class="sticky top-0 inset-x-0 z-20 bg-white border-b px-4 sm:px-6 lg:px-8 lg:hidden">
        <div class="flex items-center py-2">
            <button @click="toggleAside" type="button" class="size-8 flex justify-center items-center border border-indigo-500 rounded-lg">
                <Menu class="text-indigo-500" />
            </button>
            <ol class="flex items-center ml-3 whitespace-nowrap text-sm font-medium text-gray-800">
                <template v-for="(crumb, index) in breadcrumbs" :key="index">
                    <li v-if="index !== 0" class="flex items-center">
                        <ChevronRight size="14" class="mx-2" />
                    </li>
                    <li>
                        <template v-if="index === 0 && crumb.link">
                            <Link :href="crumb.link" class="hover:text-gray-600">{{ crumb.label }}</Link>
                        </template>
                        <template v-else>
                            <span class="capitalize">{{ crumb.label }}</span>
                        </template>
                    </li>
                </template>
            </ol>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div
        :class="{
            'translate-x-0': showingAside,
            '-translate-x-full': !showingAside,
            'lg:translate-x-0': true,
        }"
        class="fixed inset-y-0 start-0 z-[60] w-[260px] bg-white border-e transition-transform duration-300 lg:block"
    >
        <div class="flex flex-col h-full">
            <div class="py-3 mx-auto">
                <Link :href="userRole === 'admin' ? route('admin.dashboard') : route('products.catalog.index')">
                    <ApplicationLogo class="h-14" />
                </Link>
            </div>
            <div class="h-full overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 p-3 space-y-1">
                <ul class="flex flex-col space-y-1">
                    <li>
                        <Link
                            :href="userRole === 'admin' ? route('admin.dashboard') : route('products.catalog.index')"
                            class="flex items-center gap-3 py-2 px-2.5 rounded-lg hover:bg-gray-100"
                            :class="{ 'bg-gray-100': route().current(userRole === 'admin' ? 'admin.dashboard' : 'products.catalog.index') }"
                        >
                            <component :is="userRole === 'admin' ? Home : ChartNoAxesGantt" class="text-indigo-400"/>
                            {{ userRole === "admin" ? "Dashboard" : "Produtos" }}
                        </Link>
                    </li>

                    <template v-for="item in menuItems" :key="item.key">
                        <li v-if="item.route">
                            <Link
                                :href="route(item.route)"
                                class="flex items-center gap-3 py-2 px-2.5 rounded-lg hover:bg-gray-100"
                                :class="{ 'bg-gray-100': route().current(item.route) }"
                            >
                                <component :is="item.icon" class="text-indigo-400" />
                                {{ item.title }}
                            </Link>
                        </li>
                        <li v-else>
                            <button
                                @click="toggleSubmenu(item.key)"
                                class="w-full flex justify-between items-center py-2 px-2.5 rounded-lg hover:bg-gray-100"
                                :class="{ 'bg-gray-100': isActiveRoute(item.routes) }"
                            >
                                <div class="flex items-center gap-3">
                                    <component :is="item.icon" class="text-indigo-400"/>
                                    {{ item.title }}
                                </div>
                                <ChevronDown size="16" :class="{ 'rotate-180': submenus[item.key] }" />
                            </button>
                            <Transition
                                enter-active-class="transition-all duration-300 ease-out"
                                enter-from-class="opacity-0 max-h-0 overflow-hidden"
                                enter-to-class="opacity-100 max-h-40"
                                leave-active-class="transition-all duration-200 ease-in"
                                leave-from-class="opacity-100 max-h-40"
                                leave-to-class="opacity-0 max-h-0 overflow-hidden"
                            >
                                <ul v-if="submenus[item.key]" class="mt-1 space-y-1">
                                    <li v-for="child in item.children" :key="child.route">
                                        <Link
                                            :href="route(child.route)"
                                            class="block py-2 px-2.5 rounded-lg hover:bg-gray-100 pl-[43px]"
                                            :class="{ 'bg-gray-100': route().current(child.route) }"
                                        >
                                            {{ child.name }}
                                        </Link>
                                    </li>
                                </ul>
                            </Transition>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>

    <!-- OVERLAY -->
    <div v-if="showingAside" @click="closeAside" class="fixed inset-0 bg-black bg-opacity-50 z-50 lg:hidden"></div>

    <!-- MAIN CONTENT -->
    <div class="mx-auto lg:ps-64 bg-gray-50 min-h-screen">
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <div class="bg-white border p-4 rounded-lg shadow-sm max-w-screen-2xl mx-auto space-y-4">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import {
    Home,
    SquareChartGantt,
    Menu,
    ChartNoAxesGantt,
    CircleUserRound,
    ChevronRight,
    ShoppingBasket,
    ChevronDown,
    Users,
    Package2,
} from "lucide-vue-next";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link, usePage } from "@inertiajs/vue3";

const showingAside = ref(false);
const toggleAside = () => (showingAside.value = !showingAside.value);
const closeAside = () => (showingAside.value = false);

const { props } = usePage();
const user = props.auth.user;
const userRole = user.role;

const submenus = ref({});
const toggleSubmenu = (key) => {
    submenus.value[key] = !submenus.value[key];
};

const menuItems = computed(() => {
    const adminMenus = [
        {
            key: "products",
            title: "Produtos",
            icon: Package2,
            routes: ["admin.products.index", "admin.products.create"],
            children: [
                { name: "Listar Produtos", route: "admin.products.index" },
                { name: "Novo Produto", route: "admin.products.create" },
            ],
        },
        {
            key: "companies",
            title: "Empresas",
            icon: SquareChartGantt,
            routes: ["admin.companies.index", "admin.companies.create"],
            children: [
                { name: "Listar Empresas", route: "admin.companies.index" },
                { name: "Nova Empresa", route: "admin.companies.create" },
            ],
        },
        {
            key: "clients",
            title: "Clientes",
            icon: Users,
            routes: ["admin.clients.index", "admin.clients.create"],
            children: [
                { name: "Listar Clientes", route: "admin.clients.index" },
                { name: "Novo Cliente", route: "admin.clients.create" },
            ],
        },
    ];

    const clientMenus = [
        {
            key: "activeOrder",
            title: "Pedido ativo",
            icon: ShoppingBasket,
            route: "orders.active",
        },
    ];

    return userRole === "admin" ? adminMenus : clientMenus;
});

const isActiveRoute = (routes) =>
    routes.some((r) => route().current(r));

onMounted(() => {
    menuItems.value.forEach((item) => {
        if (item.routes && isActiveRoute(item.routes)) {
            submenus.value[item.key] = true;
        }
    });
});

// BREADCRUMBS
const breadcrumbs = computed(() => {
    const current = route().current();
    const items = [
        {
            label: "Dashboard",
            link: route(userRole === 'admin' ? 'admin.dashboard' : 'products.catalog.index'),
        },
    ];

    if (userRole === 'admin') {
        if (current?.startsWith('admin.products')) {
            items.push({ label: "Produtos" });
            if (current === 'admin.products.index') items.push({ label: "listar" });
            if (current === 'admin.products.create') items.push({ label: "criar" });
        } else if (current?.startsWith('admin.companies')) {
            items.push({ label: "Empresas" });
            if (current === 'admin.companies.index') items.push({ label: "listar" });
            if (current === 'admin.companies.create') items.push({ label: "criar" });
        } else if (current?.startsWith('admin.clients')) {
            items.push({ label: "Clientes" });
            if (current === 'admin.clients.index') items.push({ label: "listar" });
            if (current === 'admin.clients.create') items.push({ label: "criar" });
        }
    } else {
        if (current === 'products.catalog.index') {
            items.push({ label: "Produtos" });
        } else if (current === 'orders.active') {
            items.push({ label: "Pedido Ativo" });
        }
    }

    return items;
});
</script>

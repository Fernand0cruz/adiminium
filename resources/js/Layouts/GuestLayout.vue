<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center">
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-[450px] fill-current text-gray-500" />
            </Link>
        </div>

        <div class="my-6 w-full overflow-hidden bg-white px-6 py-4 border sm:max-w-md sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

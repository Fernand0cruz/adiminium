<template>
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center">
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-[450px] fill-current text-gray-500" />
            </Link>
        </div>

        <div class="my-4 w-full overflow-hidden bg-white px-4 py-4 border sm:max-w-xl sm:rounded-xl">
            <slot />
        </div>
    </div>
</template>

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

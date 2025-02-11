<template>
    <div
        class="bg-red-50 border-s-4 border border-red-500 rounded-xl p-4"
    >
        <div class="flex">
            <div class="shrink-0">
                <span
                    class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800"
                >
                    <svg
                        class="shrink-0 size-4"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </span>
            </div>
            <div class="ms-3">
                <h3 class="font-extrabold text-xl">Erro!</h3>
                <p class="text-gray-500">
                    {{ props.errorMessage }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    errorMessage: String,
});
</script>

<template>
    <div
        class="bg-yellow-50 border-s-4 border border-yellow-500 rounded-lg p-4"
    >
        <div class="flex">
            <div class="shrink-0">
                <span
                    class="animate-pulse inline-flex justify-center items-center size-8 rounded-full border-4 border-yellow-100 bg-yellow-200 text-yellow-800"
                >
                    <svg
                        class="shrink-0 size-4 text-yellow-500 mt-0.5"
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"
                        ></path>
                    </svg>
                </span>
            </div>
            <div class="ms-4">
                <h3 class="font-extrabold text-xl">Informação!</h3>
                <p class="text-gray-500">
                    {{ props.infoMessage }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    infoMessage: String,
});
</script>

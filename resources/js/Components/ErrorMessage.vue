<template>
    <div class="bg-red-50 border-s-4 border border-red-500 rounded-xl p-4">
        <div class="flex">
            <div class="shrink-0">
                <span
                    class="animate-pulse inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800"
                >
                    <svg
                        class="shrink-0 size-4 text-red-500 mt-0.5"
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"
                        ></path>
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

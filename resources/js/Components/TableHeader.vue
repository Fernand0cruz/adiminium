<template>
    <th scope="col" class="px-6 py-3 text-start">
        <div class="flex items-center gap-x-2">
            <span
                class="text-xs font-semibold uppercase tracking-wide text-gray-800 text-nowrap"
            >
                {{ props.colTitle }}
            </span>
        </div>
    </th>
</template>

<script setup>
const props = defineProps({
    colTitle: String
})
</script>

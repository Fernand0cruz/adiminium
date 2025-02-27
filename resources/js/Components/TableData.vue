<template>
    <td class="size-px whitespace-nowrap">
        <span class="block px-3 py-2">
            <span class="text-sm text-gray-600 dark:text-neutral-400"
                >{{ props.data }}</span
            >
        </span>
    </td>
</template>

<script setup>
const props = defineProps({
    data: null,
});
</script>

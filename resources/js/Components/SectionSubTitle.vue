<template>
    <h2 class="text-gray-500">{{ props.subTitle }}</h2>
</template>

<script setup>
    const props = defineProps({
        subTitle: String
    })
</script>

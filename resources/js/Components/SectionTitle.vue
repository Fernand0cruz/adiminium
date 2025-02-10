<template>
    <h1 class="font-extrabold text-xl">{{ props.title }}</h1>
</template>

<script setup>
    const props = defineProps({
        title: String
    })
</script>

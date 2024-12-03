<script setup>
import { computed } from 'vue';

const props = defineProps({
  label: String,
  section: String,
  activeSection: String,
});

const emit = defineEmits(['change-section']);

const isActive = computed(() => props.activeSection === props.section);
</script>

<template>
  <li>
    <button
      @click="emit('change-section', props.section)"  
      :class="{
        'bg-indigo-100 text-indigo-600 border-l-4 border-indigo-400': isActive,
        'hover:bg-gray-100 text-gray-600': !isActive,
      }"
      class="flex items-center gap-2 p-3 w-full text-left rounded-md border-l-4 border-gray-100"
      :aria-current="isActive ? 'page' : undefined"
    >
      <span>{{ props.label }}</span>
    </button>
  </li>
</template>

<style scoped>
/* Your styles here */
</style>

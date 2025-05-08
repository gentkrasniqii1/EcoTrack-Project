<template>
  <div class="bg-white p-6 rounded-lg shadow text-center">
    <p class="text-sm text-gray-500">{{ title }}</p>
    <p :class="['text-3xl font-bold', customClass || 'text-gray-800']">{{ value }}</p>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  value: [String, Number],
  customClass: {
    type: String,
    default: ''
  }
});
</script>

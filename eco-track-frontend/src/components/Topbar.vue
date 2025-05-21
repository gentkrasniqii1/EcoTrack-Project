<template>
  <div class="topbar">
    <button @click="$emit('toggleSidebar')" class="icon-btn">
      <i class="fas fa-bars"></i>
    </button>
    <button @click="toggleDark" class="icon-btn">
      <i class="fas" :class="settings.darkMode ? 'fa-sun' : 'fa-moon'"></i>
    </button>
  </div>
</template>

<script setup>
import { useUserSettings } from '@/stores/userSettings'

const settings = useUserSettings()

const toggleDark = () => {
  settings.darkMode = !settings.darkMode
  document.body.classList.toggle('dark', settings.darkMode)
  settings.saveAll()
}
</script>

<style scoped>
.topbar {
  position: fixed;
  top: 20px;
  right: 20px;
  display: flex;
  gap: 12px;
  z-index: 2000;
}

.icon-btn {
  background-color: var(--sidebar-color);
  color: white;
  border: none;
  padding: 10px;
  border-radius: 8px;
  font-size: 18px;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s;
}

.icon-btn:hover {
  background-color: var(--sidebar-hover);
  transform: scale(1.1);
}
</style>

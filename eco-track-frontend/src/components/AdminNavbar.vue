<template>
    <header class="bg-white shadow px-6 py-4 flex justify-between items-center relative">
      <!-- Titulli -->
      <h1 class="text-xl font-bold text-green-700">EcoTrack – Admin Panel</h1>
  
      <!-- Ikona e notifikimeve -->
      <div class="relative">
        <button @click="dropdownOpen = !dropdownOpen" class="relative focus:outline-none">
          <span class="text-2xl">🔔</span>
          <span
            v-if="notifications.length"
            class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
          >
            {{ notifications.length }}
          </span>
        </button>
  
        <!-- Dropdown -->
        <div
          v-if="dropdownOpen"
          class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded border z-50"
        >
          <div v-if="notifications.length" class="max-h-64 overflow-y-auto divide-y">
            <div
              v-for="n in notifications"
              :key="n.id"
              class="px-4 py-3 text-sm hover:bg-gray-50 space-y-1"
            >
              <div class="flex justify-between items-start">
                <div>
                  <p class="font-medium text-gray-800">{{ n.data.message }}</p>
                  <p class="text-xs text-gray-500">
                    {{ new Date(n.created_at).toLocaleString() }}
                  </p>
                </div>
                <div class="flex flex-col gap-1 ml-3 text-xs whitespace-nowrap">
                  <button
                    @click="markAsRead(n.id)"
                    class="text-blue-500 hover:underline focus:outline-none"
                  >
                    Read
                  </button>
                  <button
                    @click="deleteNotification(n.id)"
                    class="text-red-500 hover:underline focus:outline-none"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
          <p v-else class="text-sm text-gray-600 p-4">No new notifications.</p>
        </div>
      </div>
    </header>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useToast } from 'vue-toastification';
  
  const toast = useToast();
  const notifications = ref([]);
  const dropdownOpen = ref(false);
  
  // Shkarkon të gjitha notifikimet nga API
  const fetchNotifications = async () => {
    try {
      const token = localStorage.getItem('jwt');
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      const res = await axios.get('http://127.0.0.1:8000/api/notifications');
      notifications.value = res.data;
    } catch (err) {
      console.error('Failed to load notifications');
      toast.error('Failed to load notifications');
    }
  };
  
  // Shënon si lexuar dhe e heq nga lista
  const markAsRead = async (id) => {
    try {
      await axios.post(`http://127.0.0.1:8000/api/notifications/${id}/mark-as-read`);
      notifications.value = notifications.value.filter(n => n.id !== id);
      toast.success('Marked as read');
    } catch (err) {
      console.error('Failed to mark as read');
      toast.error('Mark as read failed');
    }
  };
  
  // Fshin përfundimisht një notifikim
  const deleteNotification = async (id) => {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/notifications/${id}`);
      notifications.value = notifications.value.filter(n => n.id !== id);
      toast.success('Deleted');
    } catch (err) {
      console.error('Failed to delete notification');
      toast.error('Delete failed');
    }
  };
  
  onMounted(fetchNotifications);
  </script>
  
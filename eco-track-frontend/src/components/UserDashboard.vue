<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <h1 class="text-3xl font-bold text-blue-700 mb-8">User Dashboard</h1>
  
      <!-- Seksioni i Profilit -->
      <section class="bg-white rounded-lg shadow p-6 mb-8 max-w-2xl">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Profile Info</h2>
        <div class="space-y-2 text-gray-700">
          <p><strong>Name:</strong> {{ user.name }}</p>
          <p><strong>Email:</strong> {{ user.email }}</p>
          <p><strong>Role:</strong> {{ user.role }}</p>
        </div>
      </section>
  
      <!-- Statistikë për Raportet -->
      <section class="bg-white rounded-lg shadow p-6 mb-8 max-w-2xl">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Recycling Summary</h2>
        <div class="grid grid-cols-2 gap-6">
          <div class="bg-green-100 rounded p-4 text-center">
            <p class="text-sm text-gray-600">Total Reports</p>
            <p class="text-2xl font-bold text-green-700">{{ stats.totalReports }}</p>
          </div>
          <div class="bg-blue-100 rounded p-4 text-center">
            <p class="text-sm text-gray-600">Total Amount (kg)</p>
            <p class="text-2xl font-bold text-blue-700">{{ stats.totalAmount }}</p>
          </div>
        </div>
      </section>
  
      <!-- Lista e Raporteve -->
      <section class="bg-white rounded-lg shadow p-6 max-w-4xl">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">My Recycling Reports</h2>
        <div v-if="reports.length" class="overflow-x-auto">
          <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-100 text-left font-medium text-gray-700">
              <tr>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Amount (kg)</th>
                <th class="px-4 py-2">Location</th>
                <th class="px-4 py-2">Date</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="r in reports" :key="r.id" class="hover:bg-gray-50">
                <td class="px-4 py-2">{{ r.type }}</td>
                <td class="px-4 py-2">{{ r.amount }}</td>
                <td class="px-4 py-2">{{ r.location || 'N/A' }}</td>
                <td class="px-4 py-2">{{ new Date(r.created_at).toLocaleDateString() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p v-else class="text-gray-600">You haven't submitted any reports yet.</p>
      </section>
    </div>

    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">📬 Messages with Admin</h2>

    <div class="h-64 overflow-y-auto border rounded p-4 space-y-3 bg-gray-50">
      <div
        v-for="msg in messages"
        :key="msg.id"
        :class="msg.sender_id === user.id ? 'text-right' : 'text-left'"
      >
        <div
          :class="[
            'inline-block px-4 py-2 rounded-lg',
            msg.sender_id === user.id ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-800'
          ]"
        >
          {{ msg.content }}
        </div>
        <p class="text-xs text-gray-500 mt-1">
          {{ msg.sender.name }} – {{ new Date(msg.created_at).toLocaleString() }}
        </p>
      </div>
    </div>

    <form @submit.prevent="sendMessage" class="mt-6 flex gap-4">
      <input
        v-model="messageContent"
        type="text"
        placeholder="Type your message..."
        class="flex-1 border rounded px-4 py-2 text-sm"
        required
      />
      <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Send
      </button>
    </form>
  </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useToast } from 'vue-toastification';
  import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

  
  const toast = useToast();
  const user = ref({});
  const reports = ref([]);
  const stats = ref({ totalReports: 0, totalAmount: 0 });
  
  const loadReports = async () => {
    try {
      const token = localStorage.getItem('jwt');
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      const res = await axios.get('http://127.0.0.1:8000/api/recycling-reports');
      reports.value = res.data;
  
      // përllogarit statistikat
      stats.value.totalReports = res.data.length;
      stats.value.totalAmount = res.data.reduce((acc, r) => acc + r.amount, 0);
    } catch (err) {
      toast.error('Failed to load reports');
    }
  };

  const loadMessages = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/messages');
    messages.value = res.data;
  } catch (err) {
    toast.error('Failed to load messages');
  }
};

const sendMessage = async () => {
  try {
    const adminId = 1; // ose kërko me query API për ta gjetur adminin dinamikisht
    await axios.post('http://127.0.0.1:8000/api/messages', {
      receiver_id: adminId,
      content: messageContent.value
    });
    toast.success('Message sent!');
    messageContent.value = '';
    loadMessages();
  } catch (err) {
    toast.error('Failed to send message');
  }
};

  
  onMounted(() => {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      user.value = JSON.parse(storedUser);
    }
    loadReports();
    loadMessages();
  });
  
  </script>
  
  <style scoped>
  table th, table td {
    padding: 0.5rem 1rem;
  }
  </style>
  
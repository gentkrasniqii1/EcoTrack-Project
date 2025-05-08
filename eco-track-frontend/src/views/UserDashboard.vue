<template>
    <div class="min-h-screen bg-gray-100">
      <!-- 🔝 Navbar -->
      <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
  <h1 class="text-xl font-bold text-blue-700">EcoTrack – User Dashboard</h1>

  <div class="relative">
    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 focus:outline-none">
      <img
        src="https://ui-avatars.com/api/?name={{ user.name }}&background=0D8ABC&color=fff"
        class="w-8 h-8 rounded-full object-cover"
        alt="avatar"
      />
      <span class="text-sm font-semibold text-gray-700">{{ user.name }}</span>
      <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <div
      v-if="dropdownOpen"
      class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded border z-50"
    >
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">👤 Profile</a>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">⚙️ Settings</a>
      <button
        @click="logout"
        class="w-full text-left px-4 py-2 hover:bg-red-100 text-sm text-red-600"
      >
        🚪 Logout
      </button>
    </div>
  </div>
</header>

  
      <!-- 📄 Main content -->
      <main class="p-6 max-w-6xl mx-auto space-y-10">
        <!-- 📘 Profile -->
        <section class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">👤 Profile Info</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
            <p><strong>Name:</strong> {{ user.name }}</p>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Phone:</strong> {{ user.phone || 'N/A' }}</p>
            <p><strong>Role:</strong> {{ user.role }}</p>
          </div>
        </section>
  
        <!-- 📊 Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-green-100 p-6 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Total Reports</p>
            <p class="text-3xl font-bold text-green-800">{{ stats.totalReports }}</p>
          </div>
          <div class="bg-blue-100 p-6 rounded shadow text-center">
            <p class="text-gray-600 text-sm">Total Amount (kg)</p>
            <p class="text-3xl font-bold text-blue-800">{{ stats.totalAmount }}</p>
          </div>
        </section>
  
        <!-- 📈 Chart -->
        <section class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">Waste Types Chart</h2>
          <Bar :data="wasteChartData" :options="wasteChartOptions" />
        </section>
  
        <!-- 📩 Add Report Button -->
        <div class="text-right">
          <button @click="showModal = true" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            ➕ Add New Report
          </button>
        </div>
  
        <!-- ♻️ Reports Table -->
        <section class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">♻️ My Recycling Reports</h2>
          <div v-if="reports.length" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
              <thead class="bg-gray-100 text-left text-gray-700">
                <tr>
                  <th class="px-4 py-2">Type</th>
                  <th class="px-4 py-2">Amount</th>
                  <th class="px-4 py-2">Location</th>
                  <th class="px-4 py-2">Date</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="r in reports" :key="r.id" class="hover:bg-gray-50">
                  <td class="px-4 py-2">{{ r.type }}</td>
                  <td class="px-4 py-2">{{ r.amount }} kg</td>
                  <td class="px-4 py-2">{{ r.location || 'N/A' }}</td>
                  <td class="px-4 py-2">{{ new Date(r.created_at).toLocaleDateString() }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <p v-else class="text-gray-600">You haven’t submitted any reports yet.</p>
        </section>
      </main>
  
      <!-- 📝 Modal -->
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow w-full max-w-md">
          <h2 class="text-xl font-semibold mb-4">Submit New Report</h2>
          <form @submit.prevent="submitReport" class="space-y-4">
            <input v-model="form.type" placeholder="Material Type (e.g. Plastic)" class="input" required />
            <input v-model="form.amount" type="number" placeholder="Amount (kg)" class="input" required />
            <input v-model="form.location" placeholder="Location (optional)" class="input" />
            <div class="flex justify-end gap-4">
              <button type="button" @click="showModal = false" class="px-4 py-2 rounded bg-gray-300">Cancel</button>
              <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from 'vue';
  import axios from 'axios';
  import { useToast } from 'vue-toastification';
  import { Bar } from 'vue-chartjs';
  import {
    Chart as ChartJS,
    Title, Tooltip, Legend,
    BarElement, CategoryScale, LinearScale
  } from 'chart.js';
  
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);
  
  const toast = useToast();
  const user = ref({});
  const reports = ref([]);
  const stats = ref({ totalReports: 0, totalAmount: 0 });
  const showModal = ref(false);
  const dropdownOpen = ref(false);
  
  const form = ref({
    type: '',
    amount: '',
    location: ''
  });
  
  const loadReports = async () => {
    try {
      const token = localStorage.getItem('jwt');
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      const res = await axios.get('http://127.0.0.1:8000/api/recycling-reports');
      reports.value = res.data;
      stats.value.totalReports = res.data.length;
      stats.value.totalAmount = res.data.reduce((acc, r) => acc + r.amount, 0);
    } catch {
      toast.error('Failed to load reports');
    }
  };
  
  const submitReport = async () => {
    try {
      await axios.post('http://127.0.0.1:8000/api/recycling-reports', form.value);
      toast.success('Report submitted successfully!');
      showModal.value = false;
      form.value = { type: '', amount: '', location: '' };
      loadReports();
    } catch {
      toast.error('Failed to submit report');
    }
  };
  
  const logout = () => {
    localStorage.removeItem('jwt');
    localStorage.removeItem('user');
    window.location.href = '/auth';
  };
  
  const wasteChartData = computed(() => {
    const grouped = {};
    reports.value.forEach(r => {
      grouped[r.type] = (grouped[r.type] || 0) + r.amount;
    });
  
    return {
      labels: Object.keys(grouped),
      datasets: [{
        label: 'Amount (kg)',
        data: Object.values(grouped),
        backgroundColor: '#3b82f6'
      }]
    };
  });
  
  const wasteChartOptions = {
    responsive: true,
    plugins: {
      legend: { display: false },
      title: { display: false }
    }
  };
  
  onMounted(() => {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      user.value = JSON.parse(storedUser);
    }
    loadReports();
  });
  </script>
  
  <style scoped>
  .input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
  }
  table th,
  table td {
    padding: 0.5rem 1rem;
  }
  </style>
  
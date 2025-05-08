<template>
    <div class="bg-gray-100 min-h-screen">
      <!-- 🔝 Navbar -->
      <AdminNavbar />
  
      <main class="p-6 max-w-7xl mx-auto space-y-10">
        <!-- 📊 Statistika -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <StatCard title="Total Users" :value="stats.totalUsers" />
          <StatCard title="Recycling Reports" :value="stats.reports" />
          <StatCard title="System Status" value="Operational ✅" customClass="text-green-600" />
        </div>
  
        <!-- 📈 Grafik për role -->
        <section class="bg-white rounded-lg shadow p-6 max-w-2xl">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">User Roles Distribution</h2>
          <Pie :data="chartData" :options="chartOptions" />
        </section>
  
        <!-- 👥 Përdoruesit -->
        <section>
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">User Management</h2>
          <UserTable :users="users" @toggle-role="toggleRole" @delete-user="deleteUser" />
        </section>
  
        <!-- ♻️ Raportet -->
        <section>
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">Recycling Reports</h2>
          <ReportTable :reports="reports" />
        </section>
  
        <!-- 🔔 Notifikime -->
        <section>
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">Latest Notifications</h2>
          <ul class="bg-white p-4 rounded-lg shadow space-y-2 max-h-64 overflow-y-auto">
            <li
              v-for="n in notifications"
              :key="n.id"
              class="text-sm text-gray-700 border-b last:border-0 pb-2"
            >
              <span class="font-medium">🔔 {{ n.data.message }}</span>
              <span class="text-gray-500 ml-2">({{ new Date(n.created_at).toLocaleString() }})</span>
            </li>
          </ul>
        </section>
      </main>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from 'vue';
  import axios from 'axios';
  import { useToast } from 'vue-toastification';
  import { Pie } from 'vue-chartjs';
  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement
  } from 'chart.js';
  
  import AdminNavbar from '@/components/AdminNavbar.vue';
  import StatCard from '@/components/admin/StatCard.vue';
  import UserTable from '@/components/admin/UserTable.vue';
  import ReportTable from '@/components/admin/ReportTable.vue';
  
  ChartJS.register(Title, Tooltip, Legend, ArcElement);
  
  const toast = useToast();
  
  // STATE
  const stats = ref({ totalUsers: 0, reports: 0 });
  const users = ref([]);
  const reports = ref([]);
  const notifications = ref([]);
  
  // 📈 Chart Data
  const chartData = computed(() => {
    const roles = users.value.reduce((acc, user) => {
      acc[user.role] = (acc[user.role] || 0) + 1;
      return acc;
    }, {});
    return {
      labels: Object.keys(roles),
      datasets: [{
        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b'],
        data: Object.values(roles)
      }]
    };
  });
  
  const chartOptions = {
    responsive: true,
    plugins: {
      legend: { position: 'bottom' }
    }
  };
  
  // 🔄 Fetching data
  const fetchDashboardStats = async () => {
    try {
      const token = localStorage.getItem('jwt');
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      const [userRes, reportRes] = await Promise.all([
        axios.get('http://127.0.0.1:8000/api/admin/users-count'),
        axios.get('http://127.0.0.1:8000/api/admin/reports-count')
      ]);
      stats.value.totalUsers = userRes.data.count;
      stats.value.reports = reportRes.data.count;
    } catch {
      toast.error('Failed to load statistics');
    }
  };
  
  const fetchUsers = async () => {
    try {
      const res = await axios.get('http://127.0.0.1:8000/api/admin/users');
      users.value = res.data;
    } catch {
      toast.error('Failed to load users');
    }
  };
  
  const fetchReports = async () => {
    try {
      const res = await axios.get('http://127.0.0.1:8000/api/admin/reports');
      reports.value = res.data;
    } catch {
      toast.error('Failed to load reports');
    }
  };
  
  const fetchNotifications = async () => {
    try {
      const res = await axios.get('http://127.0.0.1:8000/api/notifications');
      notifications.value = res.data;
    } catch {
      toast.error('Failed to fetch notifications');
    }
  };
  
  // 🔄 Role & Delete
  const toggleRole = async (user) => {
    try {
      await axios.put(`http://127.0.0.1:8000/api/admin/users/${user.id}/toggle-role`);
      toast.success(`Role updated for ${user.name}`);
      fetchUsers();
    } catch {
      toast.error('Failed to update role');
    }
  };
  
  const deleteUser = async (id) => {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/admin/users/${id}`);
      toast.success('User deleted');
      fetchUsers();
    } catch {
      toast.error('Failed to delete user');
    }
  };
  
  // 🔃 Initial load
  onMounted(() => {
    fetchDashboardStats();
    fetchUsers();
    fetchReports();
    fetchNotifications();
  });
  </script>
  
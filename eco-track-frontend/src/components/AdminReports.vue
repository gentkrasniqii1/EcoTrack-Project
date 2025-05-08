<template>
  <div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold mb-4">All Recycling Reports</h1>

    <input v-model="filter" type="text" placeholder="Filter by type..." class="input mb-4 w-full max-w-md" />

    <div class="overflow-x-auto bg-white rounded-lg shadow">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left font-semibold text-gray-700">
          <tr>
            <th class="px-4 py-2">User</th>
            <th class="px-4 py-2">Type</th>
            <th class="px-4 py-2">Amount</th>
            <th class="px-4 py-2">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="r in filteredReports"
            :key="r.id"
            class="hover:bg-gray-50 border-b"
          >
            <td class="px-4 py-2">{{ r.user.name }}</td>
            <td class="px-4 py-2">{{ r.type }}</td>
            <td class="px-4 py-2">{{ r.amount }}</td>
            <td class="px-4 py-2">{{ new Date(r.created_at).toLocaleDateString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="bg-white p-6 rounded-lg shadow max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-semibold mb-4">Report Totals by Type</h2>
    <Bar :data="chartData" :options="chartOptions" />
    
  </div>

  <div class="flex justify-end gap-4 mb-6">
  <button @click="exportToExcel" class="btn bg-blue-600">Export to Excel</button>
  <button @click="exportToPDF" class="btn bg-red-600">Export to PDF</button>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
  <input v-model="filterType" placeholder="Filter by type..." class="input" />
  <input v-model="filterLocation" placeholder="Filter by location..." class="input" />
  <input v-model="filterDate" type="date" class="input" />
</div>

</template>



<script setup>

import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js';

import { utils, writeFile } from 'xlsx';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';

const exportToExcel = () => {
  const ws = utils.json_to_sheet(reports.value.map(r => ({
    User: r.user.name,
    Type: r.type,
    Amount: r.amount,
    Date: new Date(r.created_at).toLocaleDateString()
  })));

  const wb = utils.book_new();
  utils.book_append_sheet(wb, ws, 'Reports');
  writeFile(wb, 'RecyclingReports.xlsx');
};

const exportToPDF = () => {
  const doc = new jsPDF();
  autoTable(doc, {
    head: [['User', 'Type', 'Amount', 'Date']],
    body: reports.value.map(r => [
      r.user.name,
      r.type,
      r.amount,
      new Date(r.created_at).toLocaleDateString()
    ])
  });
  doc.save('RecyclingReports.pdf');
};

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

// `reports` duhet të jetë i marrë nga API
const chartData = computed(() => {
  const grouped = {};
  reports.value.forEach(r => {
    grouped[r.type] = (grouped[r.type] || 0) + r.amount;
  });

  return {
    labels: Object.keys(grouped),
    datasets: [{
      label: 'Total (kg)',
      data: Object.values(grouped),
      backgroundColor: '#10b981'
    }]
  };
});

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { position: 'bottom' },
    title: { display: false }
  }
};
const toast = useToast();
const reports = ref([]);
const filter = ref('');

const filteredReports = computed(() =>
  reports.value.filter(r => r.type.toLowerCase().includes(filter.value.toLowerCase()))
);

const fetchReports = async () => {
  try {
    const token = localStorage.getItem('jwt');
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    const res = await axios.get('http://127.0.0.1:8000/api/admin/reports');
    reports.value = res.data;
  } catch (err) {
    toast.error('Failed to load reports');
  }
};

const filterType = ref('');
const filterLocation = ref('');
const filterDate = ref('');

const filteredReports = computed(() => {
  return reports.value.filter(r => {
    const matchType = r.type.toLowerCase().includes(filterType.value.toLowerCase());
    const matchLocation = !filterLocation.value || (r.location || '').toLowerCase().includes(filterLocation.value.toLowerCase());
    const matchDate = !filterDate.value || r.created_at.startsWith(filterDate.value);
    return matchType && matchLocation && matchDate;
  });
});


onMounted(fetchReports);
</script>

<style scoped>
.input {
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
}
</style>

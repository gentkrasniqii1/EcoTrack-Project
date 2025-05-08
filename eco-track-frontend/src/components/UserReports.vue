<template>
  <div class="p-6 bg-gray-100 rounded-lg shadow max-w-4xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">My Recycling Reports</h2>

    <div v-if="reports.length" class="space-y-4">
      <div
        v-for="report in reports"
        :key="report.id"
        class="bg-white p-4 rounded shadow-md flex justify-between items-center"
      >
        <div>
          <p><strong>Type:</strong> {{ report.type }}</p>
          <p><strong>Amount:</strong> {{ report.amount }} kg</p>
          <p class="text-sm text-gray-500">Submitted: {{ new Date(report.created_at).toLocaleDateString() }}</p>
        </div>
        <div class="space-x-2">
          <button @click="edit(report)" class="text-blue-600 hover:underline">Edit</button>
          <button @click="remove(report.id)" class="text-red-600 hover:underline">Delete</button>
        </div>
      </div>
    </div>
    <p v-else class="text-gray-600">No reports submitted yet.</p>

    <!-- Edit Modal -->
    <div v-if="editing" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow w-full max-w-md">
        <h3 class="text-xl font-bold mb-4">Edit Report</h3>
        <form @submit.prevent="submitEdit">
          <input v-model="editForm.type" type="text" placeholder="Type" class="input mb-3" required />
          <input v-model="editForm.amount" type="number" placeholder="Amount (kg)" class="input mb-3" required />
          <div class="flex justify-end space-x-3">
            <button type="button" @click="editing = null" class="btn bg-gray-300 text-black">Cancel</button>
            <button type="submit" class="btn bg-green-600">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const reports = ref([]);
const editing = ref(null);
const editForm = ref({ type: '', amount: 0 });

const loadReports = async () => {
  try {
    const token = localStorage.getItem('jwt');
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    const res = await axios.get('http://127.0.0.1:8000/api/recycling-reports');
    reports.value = res.data;
  } catch (err) {
    toast.error('Failed to load reports');
  }
};

const edit = (report) => {
  editing.value = report;
  editForm.value = { type: report.type, amount: report.amount };
};

const submitEdit = async () => {
  try {
    await axios.put(`http://127.0.0.1:8000/api/recycling-reports/${editing.value.id}`, editForm.value);
    toast.success('Report updated!');
    editing.value = null;
    loadReports();
  } catch (err) {
    toast.error('Failed to update');
  }
};

const remove = async (id) => {
  try {
    await axios.delete(`http://127.0.0.1:8000/api/recycling-reports/${id}`);
    toast.success('Deleted successfully!');
    loadReports();
  } catch (err) {
    toast.error('Delete failed');
  }
};

onMounted(loadReports);
</script>

<style scoped>
.input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
}
.btn {
  padding: 8px 16px;
  border-radius: 6px;
  color: white;
}
</style>

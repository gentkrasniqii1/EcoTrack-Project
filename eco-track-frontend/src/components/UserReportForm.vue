<template>
  <div class="bg-white p-6 rounded-lg shadow max-w-md mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Submit Recycling Report</h2>

    <form @submit.prevent="submitReport" class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1">Type of Material</label>
        <input v-model="form.type" type="text" placeholder="e.g. Plastic" class="input" required />
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Amount (kg)</label>
        <input v-model="form.amount" type="number" class="input" required />
      </div>
      <button :disabled="loading" class="btn w-full">
        {{ loading ? 'Submitting...' : 'Submit Report' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const form = ref({ type: '', amount: '' });
const loading = ref(false);

const submitReport = async () => {
  loading.value = true;
  try {
    const token = localStorage.getItem('jwt');
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    await axios.post('http://127.0.0.1:8000/api/recycling-reports', form.value);
    toast.success('Report submitted successfully!');
    form.value = { type: '', amount: '' };
  } catch (err) {
    toast.error('Failed to submit report');
    console.error(err);
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
  font-size: 15px;
}
.input:focus {
  border-color: #10b981;
}
.btn {
  background-color: #10b981;
  color: white;
  font-weight: bold;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
}
.btn:hover {
  background-color: #059669;
}
</style>

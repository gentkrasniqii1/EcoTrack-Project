<template>
  <div>
    <h2>Raportet e Riciklimit</h2>

    <form @submit.prevent="saveReport">
      <select v-model="form.type">
        <option value="plastic">Plastikë</option>
        <option value="glass">Qelq</option>
        <option value="paper">Letër</option>
      </select>
      <input type="number" v-model="form.quantity" placeholder="Sasia (kg)" />
      <input v-model="form.location" placeholder="Lokacioni" />
      <button type="submit">{{ form.id ? 'Përditëso' : 'Shto' }}</button>
    </form>

    <ul>
      <li v-for="report in reports" :key="report.id">
        {{ report.type }} - {{ report.quantity }}kg - {{ report.location }}
        <button @click="editReport(report)">✏️</button>
        <button @click="deleteReport(report.id)">🗑️</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      reports: [],
      form: { id: null, type: 'plastic', quantity: 0, location: '' }
    };
  },
  mounted() {
    this.loadReports();
  },
  methods: {
    async loadReports() {
      const res = await axios.get('/api/recycling-reports');
      this.reports = res.data;
    },
    async saveReport() {
      if (this.form.id) {
        await axios.put(`/api/recycling-reports/${this.form.id}`, this.form);
      } else {
        await axios.post('/api/recycling-reports', this.form);
      }
      this.resetForm();
      this.loadReports();
    },
    editReport(report) {
      this.form = { ...report };
    },
    async deleteReport(id) {
      if (confirm('Fshij raportin?')) {
        await axios.delete(`/api/recycling-reports/${id}`);
        this.loadReports();
      }
    },
    resetForm() {
      this.form = { id: null, type: 'plastic', quantity: 0, location: '' };
    }
  }
};
</script>

<style scoped>
input, select {
  margin: 5px 0;
}
</style>

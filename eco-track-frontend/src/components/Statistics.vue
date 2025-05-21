<template>
  <div class="track-waste-content">
    <h1 class="section-title">📊 {{ t('trackWaste') }}</h1>

    <div class="stat-grid">
      <div class="stat-box">
        <h3>{{ totalWaste }}</h3>
        <p>{{ t('totalThisMonth') }}</p>
      </div>
      <div class="stat-box">
        <h3>{{ commonType }}</h3>
        <p>{{ t('mostCommonType') }}</p>
      </div>
      <div class="stat-box">
        <h3>{{ entryCount }}</h3>
        <p>{{ t('entries') }}</p>
      </div>
    </div>

    <form @submit.prevent="submitForm">
      <input v-model="form.type" type="text" :placeholder="t('wasteType')" required>
      <input v-model="form.weight" type="number" :placeholder="t('amountKg')" required>
      <input v-model="form.date" type="date" required>
      <textarea v-model="form.comment" rows="3" :placeholder="t('commentOptional')"></textarea>
      <button type="submit" class="btn-submit">{{ t('addEntry') }}</button>
    </form>

    <button v-if="records.length" @click="clearAll" id="clearAll">🗑️ {{ t('clearAll') }}</button>

    <table v-if="records.length">
      <thead>
        <tr>
          <th>{{ t('type') }}</th>
          <th>{{ t('amount') }}</th>
          <th>{{ t('date') }}</th>
          <th>{{ t('comment') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(r, index) in records" :key="index">
          <td>{{ r.type }}</td>
          <td>{{ r.weight }}</td>
          <td>{{ r.date }}</td>
          <td>{{ r.comment }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import { useWasteStore } from '@/stores/wasteStore'

const { t } = useI18n()
const wasteStore = useWasteStore()

const form = ref({ type: '', weight: '', date: '', comment: '' })
const records = ref(wasteStore.records)

onMounted(() => {
  wasteStore.loadWasteItems()
  records.value = wasteStore.records
})

watch(records, () => {
  wasteStore.records = records.value
  localStorage.setItem('wasteRecords', JSON.stringify(records.value))
}, { deep: true })

const totalWaste = computed(() => {
  const thisMonth = new Date().toISOString().slice(0, 7)
  const total = records.value.filter(r => r.date.startsWith(thisMonth)).reduce((acc, r) => acc + parseFloat(r.weight), 0)
  return total.toFixed(1) + ' kg'
})

const entryCount = computed(() => {
  const thisMonth = new Date().toISOString().slice(0, 7)
  return records.value.filter(r => r.date.startsWith(thisMonth)).length
})

const commonType = computed(() => {
  const thisMonth = new Date().toISOString().slice(0, 7)
  const count: Record<string, number> = {}
  records.value.forEach(r => {
    if (r.date.startsWith(thisMonth)) {
      count[r.type] = (count[r.type] || 0) + 1
    }
  })
  const sorted = Object.entries(count).sort((a, b) => b[1] - a[1])
  return sorted[0]?.[0] || 'N/A'
})

function submitForm() {
  records.value.push({ ...form.value })
  wasteStore.records = records.value
  wasteStore.saveWasteItems()
  form.value = { type: '', weight: '', date: '', comment: '' }
}

function clearAll() {
  if (confirm(t('confirmClear'))) {
    records.value = []
    wasteStore.clearWasteItems()
  }
}
</script>

<style scoped>
.track-waste-content {
  padding: 30px;
}
.section-title {
  font-size: 2rem;
  color: #2ecc71;
  margin-bottom: 20px;
  text-align: center;
}
.stat-grid {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  justify-content: center;
  margin-bottom: 30px;
}
.stat-box {
  background: white;
  padding: 20px;
  border-radius: 10px;
  width: 200px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
form input,
form textarea {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
}
.btn-submit {
  background-color: #2ecc71;
  color: white;
  border: none;
  padding: 10px 25px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1rem;
  margin-top: 10px;
}
.btn-submit:hover {
  background-color: #27ae60;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 30px;
}
th, td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
}
th {
  background-color: #2ecc71;
  color: white;
}
#clearAll {
  background: transparent;
  border: 2px solid #e74c3c;
  color: #e74c3c;
  padding: 8px 15px;
  border-radius: 6px;
  margin-top: 10px;
  cursor: pointer;
}
#clearAll:hover {
  background-color: #e74c3c;
  color: white;
}
</style>

<style>
body.dark {
  --bg-color: #121212;
  --text-color: #f1f1f1;
  --card-color: #1e1e1e;
  --sidebar-color: #1f7a4c;
  --sidebar-hover: #2ecc71;
}
body {
  background-color: var(--bg-color);
  color: var(--text-color);
  transition: background-color 0.3s ease, color 0.3s ease;
}
</style>

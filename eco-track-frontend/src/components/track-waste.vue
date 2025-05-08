<template>
    <section class="container py-5">
      <h2 class="text-center section-title mb-5">📊 Gjurmo Mbeturinat e tua</h2>
  
      <div class="row mb-5">
        <div class="col-md-4 mb-3">
          <div class="stat-box">
            <h2>12.5 kg</h2>
            <p>Total këtë muaj</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="stat-box">
            <h2>Plastika</h2>
            <p>Lloji më i zakonshëm</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="stat-box">
            <h2>6</h2>
            <p>Regjistrime</p>
          </div>
        </div>
      </div>
  
      <!-- Forma për regjistrim -->
      <div class="card shadow-sm mb-5">
        <div class="card-body">
          <h5 class="mb-4">➕ Shto Mbeturina</h5>
          <form @submit.prevent="submitWaste">
            <div class="row">
              <div class="col-md-4 mb-3">
                <input v-model="newRecord.type" type="text" class="form-control" placeholder="Lloji i mbeturinës" required>
              </div>
              <div class="col-md-4 mb-3">
                <input v-model="newRecord.weight" type="number" class="form-control" placeholder="Sasia (kg)" required>
              </div>
              <div class="col-md-4 mb-3">
                <input v-model="newRecord.date" type="date" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <textarea v-model="newRecord.comment" class="form-control" rows="3" placeholder="Komente (opsionale)"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Shto Regjistrimin</button>
            <button @click="clearRecords" type="button" class="btn btn-outline-danger ms-2">🗑️ Fshi të gjitha</button>
          </form>
        </div>
      </div>
  
      <!-- Lista e regjistrimeve -->
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="mb-4">📄 Regjistrimet</h5>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Lloji</th>
                <th>Sasia (kg)</th>
                <th>Data</th>
                <th>Komente</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(record, index) in records" :key="index">
                <td>{{ record.type }}</td>
                <td>{{ record.weight }}</td>
                <td>{{ record.date }}</td>
                <td>{{ record.comment }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    name: 'TrackWasteView',
    data() {
      return {
        newRecord: {
          type: '',
          weight: '',
          date: '',
          comment: ''
        },
        records: JSON.parse(localStorage.getItem('wasteRecords')) || []
      };
    },
    methods: {
      submitWaste() {
        this.records.push({ ...this.newRecord });
        localStorage.setItem('wasteRecords', JSON.stringify(this.records));
        this.newRecord = { type: '', weight: '', date: '', comment: '' };
      },
      clearRecords() {
        if (confirm('A je i sigurt që do t’i fshish të gjitha regjistrimet?')) {
          this.records = [];
          localStorage.removeItem('wasteRecords');
        }
      }
    }
  };
  </script>
  
  <style scoped>
  /* Stilet mund të merren nga style.css ekzistuese ose të importohen globalisht */
  </style>
  
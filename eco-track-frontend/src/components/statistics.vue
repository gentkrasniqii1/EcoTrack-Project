<template>
    <div class="container py-5">
      <h2 class="text-center section-title mb-5">📈 Statistikat Mjedisore</h2>
  
      <div class="row mb-5">
        <div class="col-md-4 mb-3">
          <div class="stat-box">
            <i class="fas fa-weight fa-2x mb-2 text-success"></i>
            <h2>18.6 kg</h2>
            <p>Totali i mbeturinave</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="stat-box">
            <i class="fas fa-recycle fa-2x mb-2 text-primary"></i>
            <h2>Plastika</h2>
            <p>Lloji më i zakonshëm</p>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="stat-box">
            <i class="fas fa-calendar-alt fa-2x mb-2 text-warning"></i>
            <h2>Mars 2025</h2>
            <p>Muaji me më shumë mbetje</p>
          </div>
        </div>
      </div>
  
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="bg-white p-4 rounded shadow-sm">
            <h5 class="text-center mb-3">Përqindja sipas Llojit</h5>
            <canvas id="pieChart"></canvas>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="bg-white p-4 rounded shadow-sm">
            <h5 class="text-center mb-3">Sasia mujore (kg)</h5>
            <canvas id="barChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Chart from 'chart.js/auto';
  
  export default {
    name: 'StatisticsView',
    mounted() {
      const pieCtx = document.getElementById('pieChart').getContext('2d');
      new Chart(pieCtx, {
        type: 'pie',
        data: {
          labels: ['Plastikë', 'Letër', 'Ushqimore', 'Metal', 'Tjetër'],
          datasets: [{
            data: [45, 20, 15, 10, 10],
            backgroundColor: ['#2ecc71', '#3498db', '#f1c40f', '#e67e22', '#95a5a6']
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
  
      const barCtx = document.getElementById('barChart').getContext('2d');
      new Chart(barCtx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj'],
          datasets: [{
            label: 'Kg të mbeturinave',
            data: [2.5, 3.7, 6.0, 3.0, 3.4],
            backgroundColor: '#2ecc71'
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          },
          responsive: true,
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });
    }
  };
  </script>
  
  <style scoped>
  /* Përfshi stilet për .stat-box nga style.css ose të importohen globalisht */
  </style>
  
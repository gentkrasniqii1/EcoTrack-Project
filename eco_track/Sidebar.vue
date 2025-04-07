<template>
  <div class="sidebar">
    <h2>EcoTrack</h2>
    <a href="#"><i class="fas fa-home"></i> Dashboard</a>
    <a href="#"><i class="fas fa-leaf"></i> Track Waste</a>
    <a href="#"><i class="fas fa-chart-line"></i> Statistics</a>
    <a href="#"><i class="fas fa-lightbulb"></i> Eco Tips</a>
    <a href="#"><i class="fas fa-file-alt"></i> Reports</a>
    <a href="#"><i class="fas fa-cog"></i> Settings</a>
    <a href="#"><i class="fas fa-user"></i> Profile</a>
  </div>
</template>

<style scoped>
.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  height: 100vh;
  width: 220px;
  background-color: #2ecc71;
  color: white;
}


.sidebar h2 {
  text-align: center;
  margin-bottom: 30px;
}

.sidebar a {
  display: block;
  padding: 12px 20px;
  text-decoration: none;
  color: white;
  transition: background 0.3s;
}

.sidebar a:hover {
  background-color: #27ae60;
}

.sidebar a i {
  margin-right: 10px;
}
</style>

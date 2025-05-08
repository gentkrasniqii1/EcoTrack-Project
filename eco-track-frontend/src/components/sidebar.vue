<template>
    <div class="sidebar">
      <h2>EcoTrack</h2>
      <router-link to="/" class="sidebar-link"><i class="fas fa-home"></i> Dashboard</router-link>
      <router-link to="/track-waste" class="sidebar-link"><i class="fas fa-leaf"></i> Track Waste</router-link>
      <router-link to="/statistics" class="sidebar-link"><i class="fas fa-chart-line"></i> Statistics</router-link>
      <router-link to="/tips" class="sidebar-link"><i class="fas fa-lightbulb"></i> Eco Tips</router-link>
      <router-link to="/reports" class="sidebar-link"><i class="fas fa-file-alt"></i> Reports</router-link>
      <router-link to="/settings" class="sidebar-link"><i class="fas fa-cog"></i> Settings</router-link>
      <router-link to="/profile" class="sidebar-link"><i class="fas fa-user"></i> Profile</router-link>
    </div>
  </template>
  
  <script>
  export default {
    name: 'SidebarComponent'
  };
  </script>
  
  <style scoped>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
  }
  
  .sidebar {
    width: 220px;
    background-color: #2ecc71;
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
  }
  
  .sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .sidebar-link {
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    color: white;
    transition: background 0.3s;
  }
  
  .sidebar-link:hover {
    background-color: #27ae60;
  }
  
  .sidebar-link i {
    margin-right: 10px;
  }
  </style>
  
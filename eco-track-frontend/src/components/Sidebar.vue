<template>
  <aside class="sidebar" :class="{ hide: sidebarHidden }">
    <!-- Logo / Emri -->
    <div class="sidebar-header">
      <h2>EcoTrack</h2>
    </div>

    <!-- Menu -->
    <nav class="sidebar-menu">
      <router-link to="/"><i class="fas fa-home"></i> Dashboard</router-link>
      <router-link to="/track-waste"><i class="fas fa-leaf"></i> Track Waste</router-link>
      <router-link to="/stats"><i class="fas fa-chart-line"></i> Statistics</router-link>
      <router-link to="/tips"><i class="fas fa-lightbulb"></i> Tips</router-link>
      <router-link to="/reports"><i class="fas fa-file-alt"></i> Reports</router-link>
      <router-link to="/settings"><i class="fas fa-cog"></i> Settings</router-link>

      <!-- Profile menu -->
      <div class="sidebar-profile-group">
        <a href="#" @click.prevent="toggleProfileMenu">
          <i class="fas fa-user"></i> Profile
          <i class="fas fa-caret-down right-icon"></i>
        </a>
        <div v-if="profileMenuOpen" class="submenu">
          <router-link to="/profile/view">View Profile</router-link>
          <router-link to="/profile/edit">Edit Profile</router-link>
          <router-link to="/profile/change-password">Change Password</router-link>
          <a href="#" @click="logoutUser">Logout</a>
        </div>
      </div>
    </nav>

   ]
  </aside>
</template>

<script setup>

import { useI18n } from 'vue-i18n'
import { useUserSettings } from '@/stores/userSettings'

const settings = useUserSettings()
const { t, locale } = useI18n()




const toggleProfileMenu = () => {
  profileMenuOpen.value = !profileMenuOpen.value
}



const logoutUser = () => {
  localStorage.removeItem('token')
  window.location.href = '/login'
}


</script>

<style scoped>
.sidebar {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 220px;
  height: 100vh;
  background-color: var(--sidebar-color);
  color: white;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  transition: transform 0.3s ease;
}

.sidebar.hide {
  transform: translateX(-100%);
}

.sidebar-header {
  padding: 20px;
  font-size: 1.5rem;
  font-weight: bold;
}

.sidebar-menu {
  flex-grow: 1;
  padding: 0 10px;
}

.sidebar-menu a,
.sidebar-menu .router-link-exact-active {
  display: block;
  padding: 12px 16px;
  color: white;
  text-decoration: none;
}

.sidebar-menu a:hover,
.sidebar-menu .router-link-exact-active {
  background-color: var(--sidebar-hover);
}

.sidebar-profile-group {
  margin: 10px 0;
  position: relative;
}

.submenu {
  background-color: var(--sidebar-color);
  padding: 5px 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.submenu a {
  display: block;
  padding: 10px 20px;
  font-size: 14px;
  color: white;
  text-decoration: none;
}

.submenu a:hover {
  background-color: var(--sidebar-hover);
}

.right-icon {
  float: right;
}

.sidebar-footer {
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 12px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-btn {
  background: transparent;
  border: none;
  color: white;
  font-size: 1.4rem;
  cursor: pointer;
  transition: color 0.3s, transform 0.2s;
}

.sidebar-btn:hover {
  color: #f1c40f;
  transform: scale(1.1);
}

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
  }

  .sidebar:not(.hide) {
    transform: translateX(0);
  }
}
</style>

<style>
body.dark-mode {
  --bg-color: #121212;
  --text-color: #f5f5f5;
  --card-color: #2c2c2c;
  --sidebar-color: #1f7a4c;
  --sidebar-hover: #2ecc71;

  background-color: var(--bg-color);
  color: var(--text-color);
}
</style>

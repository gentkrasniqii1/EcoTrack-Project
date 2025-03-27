import { createRouter, createWebHistory } from 'vue-router';
import LoginRegisterView from '../views/LoginRegisterView.vue';
import Register from '../views/Register.vue'; // Optional: only if you use it

const routes = [
  {
    path: '/',
    name: 'home',
    component: LoginRegisterView, // 👈 Use your login/register form here
  },
  {
    path: '/register',
    name: 'register',
    component: Register, // ✅ If you have a separate register view
  }
];

export default createRouter({
  history: createWebHistory(),
  routes
});

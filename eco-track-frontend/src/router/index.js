import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Register from '../views/Register.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/register', component: Register }
];

export default createRouter({
  history: createWebHistory(),
  routes
});

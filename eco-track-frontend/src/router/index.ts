import { createRouter, createWebHistory } from 'vue-router'
import LoginRegisterView from '../views/LoginRegisterView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: LoginRegisterView, // Show login/register on home
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue'), // lazy-loaded
    },
    {
      path: '/login',
      name: 'login',
      component: LoginRegisterView, // optional route alias if needed
    },
  ],
})

export default router

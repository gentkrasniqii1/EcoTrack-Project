import { createRouter, createWebHistory } from 'vue-router';

// ==========================
// 🔄 Component Imports
// ==========================
import AuthForm from '@/components/AuthForm.vue';
import AdminDashboard from '@/components/AdminDashboard.vue';
import UserDashboard from '@/views/UserDashboard.vue';

// ==========================
// 🌐 Route Definitions
// ==========================
const routes = [
  // 🔐 Public
  {
    path: '/auth',
    name: 'auth',
    component: AuthForm
  },

  // 🛠 Admin routes
  {
    path: '/admin-dashboard',
    name: 'admin-dashboard',
    component: AdminDashboard,
    meta: { requiresAuth: true, role: 'admin' }
  },
  {
    path: '/admin-messages',
    name: 'admin-messages',
    component: () => import('@/components/AdminMessages.vue'),
    meta: { requiresAuth: true, role: 'admin' }
  },

  // 👤 User routes
  {
    path: '/user-dashboard',
    name: 'user-dashboard',
    component: UserDashboard,
    meta: { requiresAuth: true, role: 'user' }
  },
  {
    path: '/messages',
    name: 'user-messages',
    component: () => import('@/components/UserMessages.vue'),
    meta: { requiresAuth: true, role: 'user' }
  },

  // 🌐 Default redirect
  {
    path: '/',
    redirect: '/auth'
  }
];

// ==========================
// 🚦 Router Setup & Guards
// ==========================
const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('jwt');
  const user = JSON.parse(localStorage.getItem('user') || 'null');

  if (to.meta.requiresAuth && !token) {
    return next('/auth');
  }

  if (to.meta.role && user?.role !== to.meta.role) {
    return next('/auth');
  }

  next();
});

export default router;

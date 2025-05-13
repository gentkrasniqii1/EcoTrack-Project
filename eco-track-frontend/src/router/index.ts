import { createRouter, createWebHistory } from 'vue-router';

// Components
import AuthForm from '@/components/AuthForm.vue';
import AdminDashboard from '@/components/AdminDashboard.vue';
import UserDashboard from '@/views/UserDashboard.vue';

const routes = [
  // 🔓 Login/Register (AuthForm.vue)
  {
    path: '/',
    name: 'auth',
    component: AuthForm
  },

  // 🛠 Admin-only
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

  // 👤 User-only
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

  // ❌ 404 fallback
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// ✅ Route guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('jwt');
  const user = JSON.parse(localStorage.getItem('user') || 'null');

  if (to.meta.requiresAuth && !token) {
    return next('/');
  }

  if (to.meta.role && user?.role !== to.meta.role) {
    return next('/');
  }

  next();
});

export default router;

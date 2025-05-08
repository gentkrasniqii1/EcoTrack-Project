<script setup>
import { onMounted } from 'vue';
import { useToast } from 'vue-toastification';
import { useRouter, useRoute } from 'vue-router';
import axios from '@/axios';

const toast = useToast();
const router = useRouter();
const route = useRoute();

onMounted(() => {
  const token = route.query.token;
  if (token) {
    localStorage.setItem('jwt', token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    toast.success('Login with OAuth successful!');
    router.push('/');
  } else {
    toast.error('Login failed');
    router.push('/auth');
  }
});
</script>

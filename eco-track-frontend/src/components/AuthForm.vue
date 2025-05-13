<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800">
        {{ isLogin ? 'Sign In to your account' : 'Create a new account' }}
      </h2>

      <form @submit.prevent="isLogin ? handleLogin() : handleRegister()" class="space-y-4">
        <div v-if="!isLogin">
          <input v-model="form.name" type="text" placeholder="Full Name" class="input" required />
          <input v-model="form.username" type="text" placeholder="Username" class="input" required />
          <input v-model="form.phone" type="text" placeholder="Phone" class="input" required />
        </div>

        <input v-model="form.email" type="email" placeholder="Email" class="input" required />
        <input :type="showPassword ? 'text' : 'password'" v-model="form.password" placeholder="Password" class="input" required />

        <div v-if="!isLogin">
          <input v-model="form.confirmPassword" type="password" placeholder="Confirm Password" class="input" required />
        </div>

        <button :disabled="loading" class="btn w-full">
          {{ loading ? 'Please wait...' : (isLogin ? 'Login' : 'Register') }}
        </button>

        <p class="text-sm text-center text-gray-600">
          {{ isLogin ? "Don't have an account?" : "Already have an account?" }}
          <span class="text-green-600 font-semibold cursor-pointer" @click="toggleForm">
            {{ isLogin ? 'Sign Up' : 'Sign In' }}
          </span>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import axios from 'axios';

const toast = useToast();
const router = useRouter();

const isLogin = ref(true);
const loading = ref(false);
const showPassword = ref(false);

const form = ref({
  name: '',
  username: '',
  phone: '',
  email: '',
  password: '',
  confirmPassword: ''
});

const toggleForm = () => {
  isLogin.value = !isLogin.value;
  Object.keys(form.value).forEach(key => form.value[key] = '');
};

const handleLogin = async () => {
  loading.value = true;
  try {
    const res = await axios.post('http://127.0.0.1:8000/api/login', {
      email: form.value.email,
      password: form.value.password
    });

    const { access_token, user } = res.data;

    localStorage.setItem('jwt', access_token);
    localStorage.setItem('user', JSON.stringify(user));
    axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;

    toast.success('Login successful!');

    if (user.role === 'admin') {
      router.push('/admin-dashboard');
    } else {
      router.push('/user-dashboard');
    }
  } catch (err) {
    toast.error(err.response?.data?.error || 'Login failed');
  } finally {
    loading.value = false;
  }
};

const handleRegister = async () => {
  loading.value = true;

  if (form.value.password !== form.value.confirmPassword) {
    toast.error("Passwords don't match");
    loading.value = false;
    return;
  }

  try {
    await axios.post('http://127.0.0.1:8000/api/register', {
      name: form.value.name,
      username: form.value.username,
      phone: form.value.phone,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.confirmPassword
    });

    toast.success('Registration successful! Please log in.');
    toggleForm();
  } catch (err) {
    if (err.response?.data?.errors) {
      Object.values(err.response.data.errors).flat().forEach(msg => toast.error(msg));
    } else {
      toast.error('Registration failed');
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
}
.input:focus {
  border-color: #10b981;
}
.btn {
  background-color: #10b981;
  color: white;
  font-weight: bold;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}
.btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
.btn:hover {
  background-color: #059669;
}
</style>

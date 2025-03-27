<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#0f2027] via-[#203a43] to-[#2c5364] p-6">
    <div
      class="flex flex-col md:flex-row w-full max-w-6xl rounded-3xl overflow-hidden border border-white/20 backdrop-blur-xl shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] transition-all duration-500 bg-white/10 dark:bg-white/5">

      <!-- Form Section -->
      <div class="w-full md:w-1/2 p-10 bg-white dark:bg-gray-900 text-gray-800 dark:text-white transition duration-300">
        <h2 class="text-4xl font-bold text-center mb-10 tracking-tight leading-tight">
          {{ isLogin ? 'Sign In' : 'Create Account' }}
        </h2>

        <form @submit.prevent="isLogin ? handleLogin() : handleRegister()" class="space-y-6 animate-fade-in">
          <!-- Name Field (Register only) -->
          <div v-if="!isLogin" class="relative group">
            <input
              type="text"
              v-model="registerData.name"
              required
              placeholder="Full Name"
              class="form-input peer pl-10 w-full px-4 pt-5 pb-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
            />
            <i class="fas fa-user absolute left-3 top-4 text-gray-400 group-focus-within:text-emerald-500"></i>
            <label
              class="absolute left-10 top-2 text-sm text-gray-500 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base transition-all">
              Full Name
            </label>
            <p v-if="registerErrors.name" class="text-red-500 text-sm mt-1">{{ registerErrors.name }}</p>
          </div>

          <!-- Email Field -->
          <div class="relative group">
            <!-- Login Email -->
            <input
              v-if="isLogin"
              type="email"
              v-model="loginData.email"
              required
              placeholder="Email"
              class="form-input peer pl-10 w-full px-4 pt-5 pb-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
            />
            <!-- Register Email -->
            <input
              v-else
              type="email"
              v-model="registerData.email"
              required
              placeholder="Email"
              class="form-input peer pl-10 w-full px-4 pt-5 pb-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
            />
            <i class="fas fa-envelope absolute left-3 top-4 text-gray-400 group-focus-within:text-emerald-500"></i>
            <label
              class="absolute left-10 top-2 text-sm text-gray-500 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base transition-all">
              Email
            </label>
            <p v-if="isLogin ? loginErrors.email : registerErrors.email" class="text-red-500 text-sm mt-1">
              {{ isLogin ? loginErrors.email : registerErrors.email }}
            </p>
          </div>

          <!-- Password Field -->
          <div class="relative group">
            <!-- Login Password -->
            <input
              v-if="isLogin"
              type="password"
              v-model="loginData.password"
              required
              placeholder="Password"
              class="form-input peer pl-10 w-full px-4 pt-5 pb-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
            />
            <!-- Register Password -->
            <input
              v-else
              type="password"
              v-model="registerData.password"
              required
              placeholder="Password"
              class="form-input peer pl-10 w-full px-4 pt-5 pb-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
            />
            <i class="fas fa-lock absolute left-3 top-4 text-gray-400 group-focus-within:text-emerald-500"></i>
            <label
              class="absolute left-10 top-2 text-sm text-gray-500 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base transition-all">
              Password
            </label>
            <p v-if="isLogin ? loginErrors.password : registerErrors.password" class="text-red-500 text-sm mt-1">
              {{ isLogin ? loginErrors.password : registerErrors.password }}
            </p>
          </div>

          <!-- Confirm Password Field (Register only) -->
          <div v-if="!isLogin" class="relative group">
            <input
              type="password"
              v-model="registerData.confirmPassword"
              required
              placeholder="Confirm Password"
              class="form-input peer pl-10 w-full px-4 pt-5 pb-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition"
            />
            <i class="fas fa-check-circle absolute left-3 top-4 text-gray-400 group-focus-within:text-emerald-500"></i>
            <label
              class="absolute left-10 top-2 text-sm text-gray-500 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base transition-all">
              Confirm Password
            </label>
            <p v-if="registerErrors.confirmPassword" class="text-red-500 text-sm mt-1">
              {{ registerErrors.confirmPassword }}
            </p>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            class="w-full bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-semibold py-3 rounded-xl shadow-lg transition-all duration-300">
            {{ isLogin ? 'Sign In' : 'Register' }}
          </button>
        </form>

        <!-- Social Login Options -->
        <div class="text-center mt-8">
          <p class="text-sm text-gray-500 mb-3">or continue with</p>
          <div class="flex justify-center space-x-4">
            <button class="bg-white hover:bg-gray-100 p-3 rounded-full shadow transition">
              <i class="fab fa-facebook-f text-blue-600"></i>
            </button>
            <button class="bg-white hover:bg-gray-100 p-3 rounded-full shadow transition">
              <i class="fab fa-google text-red-600"></i>
            </button>
            <button class="bg-white hover:bg-gray-100 p-3 rounded-full shadow transition">
              <i class="fab fa-linkedin-in text-sky-500"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Side Info Panel -->
      <div
        class="hidden md:flex w-1/2 flex-col justify-center items-center bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-10 text-center transition-all duration-500">
        <h2 class="text-4xl font-extrabold mb-4 leading-snug drop-shadow-lg animate-fade-in">
          {{ isLogin ? 'Welcome Back 👋' : 'Join Our Community 🚀' }}
        </h2>
        <p class="mb-8 max-w-sm text-md leading-relaxed">
          {{ isLogin
            ? 'We’re glad to see you again. Let’s continue your journey with us!'
            : 'Create your account and unlock endless learning, collaboration, and growth.' }}
        </p>
        <button
          @click="toggleForm"
          class="bg-white text-green-600 font-semibold px-6 py-2 rounded-full shadow-md hover:bg-gray-200 transition">
          {{ isLogin ? 'No account? Sign Up' : 'Have an account? Sign In' }}
        </button>
      </div>

    </div>
  </div>
</template>



<script>
import axios from 'axios';

export default {
  name: 'AuthForm',
  data() {
    return {
      isLogin: true,
      loginData: { email: '', password: '' },
      registerData: { name: '', email: '', password: '', confirmPassword: '' },
      loginErrors: {},
      loginError: '',
      registerErrors: {},
      registerError: ''
    };
  },
  methods: {
    toggleForm() {
      this.isLogin = !this.isLogin;
      this.loginError = '';
      this.registerError = '';
      this.loginErrors = {};
      this.registerErrors = {};
    },
    validateLogin() {
      this.loginErrors = {};
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!this.loginData.email) {
        this.loginErrors.email = 'Email is required.';
      } else if (!emailPattern.test(this.loginData.email)) {
        this.loginErrors.email = 'Enter a valid email address.';
      }

      if (!this.loginData.password) {
        this.loginErrors.password = 'Password is required.';
      }

      return Object.keys(this.loginErrors).length === 0;
    },
    validateRegister() {
      this.registerErrors = {};
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

      if (!this.registerData.name) {
        this.registerErrors.name = 'Name is required.';
      }

      if (!this.registerData.email) {
        this.registerErrors.email = 'Email is required.';
      } else if (!emailPattern.test(this.registerData.email)) {
        this.registerErrors.email = 'Enter a valid email address.';
      }

      if (!this.registerData.password) {
        this.registerErrors.password = 'Password is required.';
      } else if (!passwordPattern.test(this.registerData.password)) {
        this.registerErrors.password = 'Must be at least 8 characters, include uppercase, number, and symbol.';
      }

      if (!this.registerData.confirmPassword) {
        this.registerErrors.confirmPassword = 'Confirm your password.';
      } else if (this.registerData.password !== this.registerData.confirmPassword) {
        this.registerErrors.confirmPassword = 'Passwords do not match.';
      }

      return Object.keys(this.registerErrors).length === 0;
    },
    async handleLogin() {
      this.loginError = '';
      if (!this.validateLogin()) return;

      try {
        const response = await axios.post('/api/login', this.loginData);
        console.log('Login successful:', response.data);
        // TODO: Redirect or store auth token
      } catch (error) {
        this.loginError = error.response?.data?.message || 'Login failed. Try again.';
      }
    },
    async handleRegister() {
      this.registerError = '';
      if (!this.validateRegister()) return;

      try {
        const response = await axios.post('/api/register', this.registerData);
        console.log('Registration successful:', response.data);
        // TODO: Redirect or auto-login
      } catch (error) {
        if (error.response?.status === 422 && error.response.data.errors) {
          const serverErrors = error.response.data.errors;
          for (const field in serverErrors) {
            this.registerErrors[field] = serverErrors[field][0];
          }
        } else {
          this.registerError = error.response?.data?.message || 'Registration failed. Try again.';
        }
      }
    }
  }
};
</script>

<style scoped>
</style>

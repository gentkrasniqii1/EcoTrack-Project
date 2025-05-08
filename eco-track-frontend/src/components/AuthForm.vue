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
        <div v-else key="register">
          <h2>Create Account</h2>
          <form @submit.prevent="handleRegister">
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" v-model="registerData.name" placeholder="Your full name" required />
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" v-model="registerData.username" placeholder="Choose a username" required />
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" v-model="registerData.phone" placeholder="Enter your phone number" required />
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" v-model="registerData.email" placeholder="Enter your email" required />
            </div>
            <div class="form-group">
              <label>Password</label>
              <div class="password-wrapper">
                <input :type="showPassword ? 'text' : 'password'" v-model="registerData.password" placeholder="Create a password" required />
                <span class="toggle-visibility" @click="togglePassword">
                  {{ showPassword ? '🙈' : '👁️' }}
                </span>
              </div>
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" v-model="registerData.confirmPassword" placeholder="Confirm your password" required />
            </div>
            <button type="submit" class="btn">Register</button>

            <div class="divider">or</div>
            <button type="button" class="btn google-btn">Sign up with Google</button>
            <button type="button" class="btn facebook-btn">Sign up with Facebook</button>

            <div class="toggle">Already have an account? <a @click="toggleForm">Sign In</a></div>
          </form>
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
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import AuthService from '@/services/AuthService'; // 👈 Import AuthService (you need to create it as I showed before!)

export default {
  name: 'AuthPureCSS',
  data() {
    return {
      isLogin: true,
      isLoading: false,
      showPassword: false,
      loginData: { identifier: '', password: '' },
      registerData: {
        name: '',
        username: '',
        phone: '',
        email: '',
        password: '',
        confirmPassword: ''
      },
      toast: useToast()
    };
  },
  methods: {
    toggleForm() {
      this.isLogin = !this.isLogin;
    },
    togglePassword() {
      this.showPassword = !this.showPassword;
    },
    async handleLogin() {
      this.isLoading = true;
      try {
        const res = await axios.post('/login', this.loginData);
        const token = res.data.token;
        localStorage.setItem('jwt', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        this.toast.success('Login successful!');
      } catch (err) {
        this.toast.error('Invalid credentials');
      } finally {
        this.isLoading = false;
      }
    },
    async handleRegister() {
      this.isLoading = true;
      try {
        await axios.post('/register', this.registerData);
        this.toast.success('Registration successful! Please login.');
        this.toggleForm();
      } catch (err) {
        this.toast.error('Registration failed');
      } finally {
        this.isLoading = false;
      }
    },
    mockOAuth(provider) {
      this.toast.info(`Redirecting to ${provider} login...`);
    }
  }
};
</script>


<style scoped>
.input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
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

<template>
  <div class="auth-wrapper">
    <div class="auth-box" :class="{ loading: isLoading }">
      <img src="#" alt="Logo" class="logo" />
      <transition name="fade-slide">
        <div v-if="isLogin" key="login">
          <h2>Sign In</h2>
          <form @submit.prevent="handleLogin">
            <div class="form-group">
              <label>Email or Username</label>
              <input type="text" v-model="loginData.identifier" placeholder="Enter your email or username" required />
            </div>
            <div class="form-group">
              <label>Password</label>
              <div class="password-wrapper">
                <input :type="showPassword ? 'text' : 'password'" v-model="loginData.password" placeholder="Enter your password" required />
                <span class="toggle-visibility" @click="togglePassword">
                  {{ showPassword ? '🙈' : '👁️' }}
                </span>
              </div>
            </div>
            <button type="submit" class="btn">Login</button>

            <div class="divider">or</div>
            <button type="button" class="btn google-btn" @click="mockOAuth('Google')">Sign in with Google</button>
            <button type="button" class="btn facebook-btn" @click="mockOAuth('Facebook')">Sign in with Facebook</button>

            <div class="toggle">No account? <a @click="toggleForm">Sign Up</a></div>
          </form>
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
      </transition>
      <div v-if="isLoading" class="spinner"></div>
    </div>
  </div>
</template>
<script>
import axios from '@/axios';
import { useToast } from 'vue-toastification';

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
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html,
body {
  height: 100%;
  width: 100%;
  overflow-x: hidden;
  overflow-y: auto;
  font-family: Arial, sans-serif;
}

.auth-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  width: 100vw;
  background: linear-gradient(to right, rgba(15,32,39,0.9), rgba(32,58,67,0.9), rgba(44,83,100,0.9)), url('/background.jpg') center/cover no-repeat;
  padding: 40px 20px;
  overflow-x: hidden;
}

.auth-box {
  background: #fff;
  padding: 40px 30px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  width: 100%;
  max-width: 400px;
  position: relative;
  animation: fadeIn 0.5s ease-in-out;
}

.logo {
  display: block;
  margin: 0 auto 20px;
  width: 60px;
  height: auto;
  object-fit: contain;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.4s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

.spinner {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 24px;
  height: 24px;
  border: 3px solid #ccc;
  border-top-color: #10b981;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

h2 {
  text-align: center;
  margin-bottom: 25px;
  font-size: 28px;
  color: #111;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
  font-size: 14px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  transition: border-color 0.3s;
}

input:focus {
  border-color: #10b981;
  outline: none;
}

.btn {
  width: 100%;
  background: #10b981;
  color: white;
  padding: 12px;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
  margin-top: 10px;
}

.btn:hover {
  background: #059669;
}

.btn.google-btn {
  background: #db4437;
}

.btn.google-btn:hover {
  background: #c23321;
}

.btn.facebook-btn {
  background: #3b5998;
}

.btn.facebook-btn:hover {
  background: #2d4373;
}

.divider {
  text-align: center;
  margin: 20px 0 10px;
  font-size: 14px;
  color: #777;
  position: relative;
}

.toggle {
  margin-top: 20px;
  text-align: center;
  font-size: 14px;
}

.toggle a {
  color: #10b981;
  cursor: pointer;
  text-decoration: underline;
}
.password-wrapper {
  position: relative;
}

.password-wrapper input {
  width: 100%;
}

.toggle-visibility {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  font-size: 18px;
}

@media (max-width: 480px) {
  .auth-box {
    padding: 25px 20px;
    border-radius: 8px;
  }

  h2 {
    font-size: 22px;
  }

  .btn {
    font-size: 15px;
    padding: 10px;
  }

  .logo {
    width: 50px;
    margin-bottom: 16px;
  }
}
</style>

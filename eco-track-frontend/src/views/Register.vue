<template>
  <div class="p-4 max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Eco-Track — Register</h2>

    <form @submit.prevent="register" class="space-y-4 bg-white p-6 rounded shadow">
      <input type="text" v-model="name" placeholder="Full Name" class="w-full border p-2 rounded" required />
      <input type="email" v-model="email" placeholder="Email" class="w-full border p-2 rounded" required />
      <input type="password" v-model="password" placeholder="Password" class="w-full border p-2 rounded" required />

      <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
        Register
      </button>

      <p v-if="message" class="text-center text-green-700 mt-4">{{ message }}</p>
      <p v-if="error" class="text-center text-red-500 mt-4">{{ error }}</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      message: '',
      error: ''
    };
  },
  methods: {
    async register() {
      this.message = '';
      this.error = '';
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/register', {
          name: this.name,
          email: this.email,
          password: this.password
        });

        this.message = '✅ User registered successfully!';
        this.name = this.email = this.password = '';
      } catch (err) {
        this.error = err.response?.data?.message || '❌ Registration failed';
      }
    }
  }
}
</script>

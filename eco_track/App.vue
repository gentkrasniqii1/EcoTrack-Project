<template>
  <div id="app" style="display: flex">
    <Sidebar />

    <div class="content">
      <Home />

      <form @submit.prevent="login">
        <div>
          <label for="email">Email:</label>
          <input v-model="email" type="email" id="email" required />
        </div>
        <div>
          <label for="password">Password:</label>
          <input v-model="password" type="password" id="password" required />
        </div>
        <button type="submit">Kyçu</button>

        <p v-if="error" style="color: red;">{{ error }}</p>
        <p v-if="message" style="color: green;">{{ message }}</p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Sidebar from './components/Sidebar.vue'
import Home from './components/Home.vue'

export default {
  name: 'App',
  components: {
    Sidebar,
    Home
  },
  data() {
    return {
      email: '',
      password: '',
      message: '',
      error: ''
    }
  },
  methods: {
    async login() {
      this.message = ''
      this.error = ''
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
          email: this.email,
          password: this.password
        })
        const token = response.data.token
        this.message = '✅ Login i suksesshëm!'
        console.log('Token:', token)
        this.email = this.password = ''
      } catch (err) {
        this.error = err.response?.data?.message || '❌ Login i dështuar'
      }
    }
  }
}
</script>

<style>
.content {
  margin-left: 220px;
  padding: 20px;
  flex: 1;
}
</style>

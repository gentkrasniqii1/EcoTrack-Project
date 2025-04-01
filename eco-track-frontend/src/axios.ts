// src/axios.ts
import axios from 'axios'

// ✅ Vendos URL-në e backend-it Laravel
axios.defaults.baseURL = 'http://localhost:8000/api'
axios.defaults.headers.common['Accept'] = 'application/json'

// ✅ Vendos token nëse ekziston
const token = localStorage.getItem('jwt')
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

export default axios
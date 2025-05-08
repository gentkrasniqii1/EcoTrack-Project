// src/services/AuthService.js
import axios from 'axios';

const AuthService = {
  loginWithGoogleCallback(response) {
    const token = response.access_token;
    const user = response.user;

    localStorage.setItem('access_token', token);
    localStorage.setItem('user', JSON.stringify(user));

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
  },

  logout() {
    localStorage.removeItem('access_token');
    localStorage.removeItem('user');
    delete axios.defaults.headers.common['Authorization'];
  },

  getCurrentUser() {
    return JSON.parse(localStorage.getItem('user'));
  },

  isLoggedIn() {
    return !!localStorage.getItem('access_token');
  }
};

export default AuthService;

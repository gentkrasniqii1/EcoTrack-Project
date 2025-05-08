<template>
  <div>
    <h2>Menaxhimi i Përdoruesve</h2>

    <ul>
      <li v-for="user in users" :key="user.id">
        {{ user.name }} ({{ user.email }}) - {{ user.role }}
        <select v-model="user.role" @change="updateUser(user)">
          <option value="admin">Admin</option>
          <option value="citizen">Qytetar</option>
          <option value="authority">Autoritet</option>
        </select>
        <button @click="deleteUser(user.id)">🗑️</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return { users: [] };
  },
  mounted() {
    this.loadUsers();
  },
  methods: {
    async loadUsers() {
      const res = await axios.get('/api/users');
      this.users = res.data;
    },
    async updateUser(user) {
      await axios.put(`/api/users/${user.id}`, {
        name: user.name,
        email: user.email,
        role: user.role
      });
      alert('Roli u ndryshua.');
    },
    async deleteUser(id) {
      if (confirm('Fshi përdoruesin?')) {
        await axios.delete(`/api/users/${id}`);
        this.loadUsers();
      }
    }
  }
};
</script>

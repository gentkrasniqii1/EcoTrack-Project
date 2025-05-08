<template>
  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm divide-y divide-gray-200">
      <thead class="bg-gray-100 text-left text-gray-700">
        <tr>
          <th class="px-4 py-2">#</th>
          <th class="px-4 py-2">Name</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Role</th>
          <th class="px-4 py-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(u, index) in users"
          :key="u.id"
          class="hover:bg-gray-50 border-b"
        >
          <td class="px-4 py-2">{{ index + 1 }}</td>
          <td class="px-4 py-2">{{ u.name }}</td>
          <td class="px-4 py-2">{{ u.email }}</td>
          <td class="px-4 py-2 capitalize">{{ u.role }}</td>
          <td class="px-4 py-2 text-center space-x-2">
            <button @click="$emit('toggle-role', u)" class="text-blue-600 hover:underline">Toggle</button>
            <button @click="$emit('delete-user', u.id)" class="text-red-600 hover:underline">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  users: {
    type: Array,
    required: true
  }
});

defineEmits(['toggle-role', 'delete-user']);
</script>

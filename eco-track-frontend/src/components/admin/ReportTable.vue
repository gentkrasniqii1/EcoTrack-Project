<template>
  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm divide-y divide-gray-200">
      <thead class="bg-gray-100 text-left text-gray-700">
        <tr>
          <th class="px-4 py-2">User</th>
          <th class="px-4 py-2">Type</th>
          <th class="px-4 py-2">Amount</th>
          <th class="px-4 py-2">Location</th>
          <th class="px-4 py-2">Date</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="r in reports"
          :key="r.id"
          class="hover:bg-gray-50 border-b"
        >
          <td class="px-4 py-2">{{ r.user.name }}</td>
          <td class="px-4 py-2">{{ r.type }}</td>
          <td class="px-4 py-2">{{ r.amount }} kg</td>
          <td class="px-4 py-2">{{ r.location || 'N/A' }}</td>
          <td class="px-4 py-2">{{ new Date(r.created_at).toLocaleDateString() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  reports: {
    type: Array,
    required: true
  }
});
</script>

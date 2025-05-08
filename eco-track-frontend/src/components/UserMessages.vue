<template>
  <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">📬 Messages with Admin</h2>

    <div class="h-64 overflow-y-auto border rounded p-4 space-y-3 bg-gray-50">
      <div
        v-for="msg in messages"
        :key="msg.id"
        :class="msg.sender_id === user.id ? 'text-right' : 'text-left'"
      >
        <div
          :class="[
            'inline-block px-4 py-2 rounded-lg',
            msg.sender_id === user.id ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-800'
          ]"
        >
          {{ msg.content }}
        </div>
        <p class="text-xs text-gray-500 mt-1">
          {{ msg.sender.name }} – {{ new Date(msg.created_at).toLocaleString() }}
        </p>
      </div>
    </div>

    <form @submit.prevent="sendMessage" class="mt-6 flex gap-4">
      <input
        v-model="messageContent"
        type="text"
        placeholder="Type your message..."
        class="flex-1 border rounded px-4 py-2 text-sm"
        required
      />
      <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Send
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();

const user = ref({});
const messages = ref([]);
const messageContent = ref('');

const loadMessages = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/messages');
    messages.value = res.data;
  } catch (err) {
    toast.error('Failed to load messages');
  }
};

const sendMessage = async () => {
  try {
    const adminId = 1; // ose kërko me query API për ta gjetur adminin dinamikisht
    await axios.post('http://127.0.0.1:8000/api/messages', {
      receiver_id: adminId,
      content: messageContent.value
    });
    toast.success('Message sent!');
    messageContent.value = '';
    loadMessages();
  } catch (err) {
    toast.error('Failed to send message');
  }
};

onMounted(() => {
  const storedUser = localStorage.getItem('user');
  if (storedUser) {
    user.value = JSON.parse(storedUser);
  }
  loadMessages();
});
</script>

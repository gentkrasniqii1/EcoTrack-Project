<template>
  <div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold mb-6 text-green-700">📨 User Messages</h1>

    <div v-if="messages.length" class="space-y-6">
      <div
        v-for="msg in messages"
        :key="msg.id"
        class="bg-white p-4 rounded shadow"
      >
        <p class="text-gray-700 mb-2">
          <strong>{{ msg.sender.name }}:</strong> {{ msg.content }}
        </p>
        <p class="text-xs text-gray-500 mb-3">
          Sent: {{ new Date(msg.created_at).toLocaleString() }}
        </p>

        <form @submit.prevent="replyTo(msg.sender_id, msg.id)" class="flex gap-2">
          <input
            v-model="replies[msg.sender_id]"
            placeholder="Type a reply..."
            class="flex-1 border rounded px-4 py-2 text-sm"
          />
          <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Reply
          </button>
        </form>
      </div>
    </div>
    <p v-else class="text-gray-600">No messages available.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const messages = ref([]);
const replies = ref({});

const fetchMessages = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/messages');
    messages.value = res.data;
  } catch (err) {
    toast.error('Failed to load messages');
  }
};

const replyTo = async (userId, originalMessageId) => {
  const content = replies.value[userId];
  if (!content) return;

  try {
    await axios.post('http://127.0.0.1:8000/api/messages', {
      receiver_id: userId,
      content
    });
    toast.success('Reply sent!');
    replies.value[userId] = '';
    fetchMessages();
  } catch (err) {
    toast.error('Failed to send reply');
  }
};

onMounted(fetchMessages);
</script>

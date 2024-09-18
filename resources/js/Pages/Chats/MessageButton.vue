<template>
  <div>
    <div v-if="canSendMessage">
      <textarea v-model="messageContent" placeholder="Type a message..." class="message-input"></textarea>
      <button @click="sendMessage" class="sendMessage">📩 Message</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    receiverId: {
      type: [String, Number],
      required: true,
    },
  },
  data() {
    return {
      currentUserId: null,
      messageContent: '',
    };
  },
  computed: {
    canSendMessage() {
      const canSend = this.currentUserId && this.currentUserId !== this.receiverId;
      console.log('Current User ID:', this.currentUserId);
      console.log('Receiver ID:', this.receiverId);
      console.log('Can send message:', canSend);
      return canSend;
    },
  },
  async created() {
    try {
      const authResponse = await axios.get('/auth-user');
      this.currentUserId = authResponse.data.id;
      console.log('Current User ID:', this.currentUserId);
    } catch (error) {
      console.error('Error fetching authenticated user data:', error);
    }
  },
  methods: {
    async sendMessage() {
      if (!this.messageContent.trim()) {
        alert('Message cannot be empty.');
        return;
      }

      try {
        const response = await axios.post('/send-message', {
          receiver_id: this.receiverId,
          content: this.messageContent,
        });

        if (response.data.success) {
          console.log('Message successfully sent:', response.data.message);
          alert('Message sent successfully!');
          this.messageContent = '';
          this.$emit('message-sent', response.data.message);
        } else {
          console.error('Error sending the message:', response.data.error);
        }
      } catch (error) {
        console.error('Error sending message:', error);
      }
    },
  },
};
</script>


<style scoped>
.message-input {
  width: 100%;
  height: 100px;
  border: 1px solid #ccc;
  padding: 10px;
  box-sizing: border-box;
  display: block;
}

.sendMessage {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  display: block;
  margin: 10px 0;
}

.sendMessage:hover {
  background-color: #0056b3;
}
</style>

  

  <style scoped>
  /* @import '@/Assets/MessageButton'; */
  </style>
  
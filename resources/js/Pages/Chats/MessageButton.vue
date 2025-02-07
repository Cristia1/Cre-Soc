<template>
  <div>
    <div v-if="canSendMessage">
      <textarea v-model="messageContent" placeholder="Type a message..." class="message-input"></textarea>
      <button @click="sendMessage" class="sendMessage hidden-button">📩 Message</button>
    </div>

    <div class="messages" style="margin-left: 580px;">
      <div v-for="message in messages" :key="message.id" class="message">
        <p><strong>{{ message.sender_id === currentUserId ? 'You' : message.sender_name }}</strong>:</p>
        <p>{{ message.content }}</p>
      </div>
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
      messages: [],
    };
  },
  computed: {
    canSendMessage() {
      return this.currentUserId !== null && this.currentUserId !== undefined &&
         this.receiverId !== null && this.receiverId !== undefined &&
         this.currentUserId !== this.receiverId;
    },
  },
  async created() {
    try {
        const authResponse = await axios.get('/user-messages'); 
          if (authResponse.data && authResponse.data.user && authResponse.data.user.id) {
              this.currentUserId = authResponse.data.user.id;
              this.fetchMessages();
          } else {
              console.error('No user ID returned from /current-user endpoint');
          }
      } catch (error) {
          console.error('Error fetching authenticated user data:', error);
      }
  },
  methods: {
    async fetchMessages() {
      try {
        const response = await axios.get('/user-messages'); 
          if (response.data.success && response.data.messages) {
            this.messages = response.data.messages
            // .filter((message) => message.sender.id !== this.currentUserId) 
            .map((message) => ({
              id: message.id,
              content: message.content,
              sender_name: message.sender.name, 
              sender_id: message.sender.id,
            }));
          } else {
            console.error('No messages returned from /user-messages endpoint');
          }
        } catch (error) {
          console.error('Error fetching messages:', error);
        }
      },
      async sendMessage() {
        if (!this.messageContent.trim()) {
            alert('Message cannot be empty.');
            return;
        }
        try {
          const response = await axios.post('/send-message', {
              receiver_name: this.receiverName,
              content: this.messageContent,
          });

          if (response.data.success) {
              alert('Message sent successfully!');
              this.messageContent = '';
              this.messages.unshift(response.data.message);
              this.$emit('message-sent', response.data.message);
          } else {
              console.error('Error sending the message:', response.data.error);
          }
      } catch (error) {
          console.error('Error sending message:', error);
      }
    }
  },
};
</script>

<style scoped>
@import '@/Assets/MessageButton';
</style>
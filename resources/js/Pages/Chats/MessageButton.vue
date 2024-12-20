<template>
  <div>
    <div v-if="canSendMessage">
      <textarea v-model="messageContent" placeholder="Type a message..." class="message-input"></textarea>
      <button @click="sendMessage" class="sendMessage hidden-button">📩 Message</button>
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
      return this.currentUserId !== null && this.currentUserId !== undefined &&
         this.receiverId !== null && this.receiverId !== undefined &&
         this.currentUserId !== this.receiverId;
    },
  },
  async created() {
    try {
      const authResponse = await axios.get('/current-user'); 
      if (authResponse.data && authResponse.data.id) {
        this.currentUserId = authResponse.data.id;
      } else {
        console.error('No user ID returned from /current-user endpoint');
      }
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
@import '@/Assets/MessageButton';

</style>
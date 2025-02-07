<template>
  <div class="friend-requests" v-if="requests.length > 0">
    <div v-for="request in requests" :key="request.id" class="request-alert">
      <p>{{ request.sender.name }} ți-a trimis o cerere de prietenie</p>
      <button @click="acceptRequest(request.id, request.sender.id)">Accept</button>
      <button @click="deleteRequest(request.id)">Delete</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      requests: [], 
      loggedInUserId: null, 
    };
  },
  async mounted() {
    await this.getUserId(); 
    await this.fetchRequests(); 
  },
  methods: {
    // 🔹 1. Obține ID-ul utilizatorului logat
    async getUserId() {
      try {
        const response = await axios.get('/getAuthenticatedUser'); 
        this.loggedInUserId = response.data.id; 
      } catch (error) {
        console.error('Eroare la preluarea utilizatorului:', error);
      }
    },
    async fetchRequests() {
      try {
        const response = await axios.get('/getFriendRequests');
        this.requests = response.data.filter(req => req.receiver_id === this.loggedInUserId); 
      } catch (error) {
        console.error('Eroare la preluarea cererilor:', error);
      }
    },
    async acceptRequest(requestId, senderId) {
      try {
        await axios.post('/acceptRequest', { sender_id: senderId });
        this.requests = this.requests.filter(req => req.id !== requestId);
        this.$emit('friendAccepted', senderId);
      } catch (error) {
        console.error('Eroare la acceptarea cererii:', error);
      }
    },
    async deleteRequest(requestId) {
      try {
        await axios.post('/deleteRequest', { request_id: requestId });
        this.requests = this.requests.filter(req => req.id !== requestId);
      } catch (error) {
        console.error('Eroare la ștergerea cererii:', error);
      }
    }
  }
};
</script>
  
  <style scoped>
    @import "@/Assets/AcceptRequest";
  </style>
  
<template>
  <div>
    <div class="friend-request" v-if="requests.length > 0">
      <div v-for="request in requests" :key="request.id">
        <p>{{ request.sender.name }} sent you a friend request</p>
        <button class="accept-button" @click="acceptRequest(request.sender.id)">Accept</button>
        <button class="delete-button" @click="deleteRequest(request.id)">Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      requests: [],
    };
  },
  async mounted() {
    await this.fetchRequests();
  },
  methods: {
    async fetchRequests() {
      try {
        const response = await axios.get('/getFriendRequests');
        this.requests = response.data;
      } catch (error) {
        console.error('Error fetching friend requests:', error);
      }
    },
    async acceptRequest(senderId) {
      try {
        const response = await axios.post('/acceptRequest', { sender_id: senderId });
        this.requests = this.requests.filter(request => request.sender.id !== senderId);
      } catch (error) {
        console.error('Error accepting request:', error);
      }
    },
    async deleteRequest(requestId) {
      try {
        await axios.post('/deleteRequest', { request_id: requestId });
        this.fetchRequests();
      } catch (error) {
        console.error('Error deleting request:', error);
      }
    }
  }
};
</script>

<style scoped>
  @import "@/Assets/AcceptRequest";
</style>
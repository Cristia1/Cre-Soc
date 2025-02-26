<template>
    <div v-if="currentUserId && userId">
        <button 
            v-if="currentUserId !== userId" 
            @click="sendFriendRequest(userId)" 
            class="AddFriendButton">
            + Add
        </button>
    </div>
</template>


<script>
import axios from 'axios';

export default {
  props: {
      userId: { 
          type: [String, Number],
          required: true
      }
  },
  data() {
      return {
          currentUserId: null, 
          friendRequests: []
      };
  },
  async created() {
    const metaUserId = document.querySelector('meta[name="user-id"]')?.content;
        this.currentUserId = metaUserId ? parseInt(metaUserId) : null;
        if (this.currentUserId) {
            this.fetchFriendRequests();
        }
    },
    methods: {
        async fetchFriendRequests() {
          try {
              const response = await axios.get('/getFriendRequests'); 
              this.friendRequests = response.data;
          } catch (error) {
              console.error('Error fetching friend requests:', error);
          }
      },
      async sendFriendRequest(receiverId) {
          if (!receiverId) {
              alert("Eroare: ID-ul prietenului este invalid!");
              return;
          }

          try {
              await axios.post('/sendRequest', { 
                  sender_id: this.currentUserId, 
                  receiver_id: receiverId   
              });
              alert('Friend request sent successfully!');
          } catch (error) {
              alert('Failed to send friend request');
          }
      }
  }
};
</script>


<style scoped>
@import "@/Assets/FriendRequest";
</style>

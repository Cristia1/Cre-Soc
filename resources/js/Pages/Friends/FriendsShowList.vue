<template>
  <div>
    <button @click="toggleFriends">
      {{ showFriends ? 'Friends' : 'Friends' }}
    </button>

    <ul v-if="showFriends">
      <li v-for="friend in friends" :key="friend.id">
        <img 
          :src="friend.profilePicture || defaultProfilePicture"  alt="Profile Picture" class="profile-img"
        />
        {{ friend.name }}
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      friends: [],
      showFriends: false,
      defaultProfilePicture: '/storage/default-profile.jpg', 
    };
  },
  methods: {
    async loadFriends() {
      try {
        const response = await axios.get('/getFriends');
        if (response.data && Array.isArray(response.data)) {
          this.friends = response.data
            .filter(friend => friend.status === 'confirmed')
            .map(friend => ({
              ...friend,
              profilePicture: friend.profilePicture || this.defaultProfilePicture,
            }));
        } else {
          console.error('Response does not contain valid friend data');
        }
      } catch (error) {
        console.error("Error fetching friends:", error);
      }
    },
    toggleFriends() {
      this.showFriends = !this.showFriends;
      if (this.showFriends && this.friends.length === 0) {
        this.loadFriends();
      }
    }
  }
};
</script>

<style scoped>
@import '@/Assets/FriendsShowList';
</style>

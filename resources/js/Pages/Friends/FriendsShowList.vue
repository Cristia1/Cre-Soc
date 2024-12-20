<template>
  <div class="friends-preview-container">
    <div class="active-friends">
      <ul class="friend-list-preview">
        <li v-for="(friend, index) in friends.slice(0, 4)" :key="friend.id" class="friend-preview-item">
          <img :src="friend.profilePicture" alt="Profile Picture" class="friend-preview-pic" />
          <span>{{ friend.name }}</span>
        </li>
      </ul>
    </div>

    <div class="FriendsButton">
      <button @click="showFriendsSection">Friends</button>
    </div>

    <div v-if="showFriends" class="friends-container">
      <ul class="friend-list">
        <li
          v-for="friend in friends"
          :key="friend.id"
          @click="selectFriend(friend.id)"
          class="friend-item"
        >
          <img :src="friend.profilePicture" alt="Profile Picture" class="friend-profile-pic" />
          <span>{{ friend.name }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

  export default {
    props: {
      user_id: {
        type: [String, Number],
        required: true,
      },
    },
    data() {
      return {
        friends: [],
        showFriends: false,
      };
    },
    methods: {
      async loadFriends(userId) {
        try {
          const response = await axios.get(`/user/${userId}/friends`); 
          this.friends = response.data.friends || []; 
        } catch (error) {
          console.error("Error fetching friends:", error); 
        }
      },
      showFriendsSection() {
        this.showFriends = !this.showFriends;
        if (this.showFriends && !this.friends.length) {
          this.loadFriends(this.user_id);
        }
      },
      selectFriend(friendId) {
        this.$emit('update:user_id', friendId);
      },
    },
    watch: {
      user_id(newId) {
        if (newId) {
          this.loadFriends(newId); 
        }
      },
    },
    created() {
      this.loadFriends(this.user_id);
    },
  };
</script>
 
<style scoped>
@import '@/Assets/FriendsShowList';
</style>
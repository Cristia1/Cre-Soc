<template>
    <button @click="FriendsRequest(userId)" class="AddFriendButton hidden-button">+Add</button>
</template>



<script>
import axios from 'axios';

export default {
    props: ['userId'],
    methods: {
        async FriendsRequest (userId) {
            try {
                const response = await axios.post('/sendFriendRequest', { receiverId: userId });
                alert('Friend request sent!');
            } catch (error) {
                console.error('Error sending friend request:', error);
                alert('Failed to send friend request');
            }
        },
        AddFriend(userId) {
            this.$emit('update:Add-id', userId);
      },
    },
};
</script>

<style scoped>
@import "@/Assets/FriendRequest";
</style>

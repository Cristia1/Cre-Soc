<template>
    <div v-if="currentUserId">
        <div v-for="friendRequest in friendRequests" :key="friendRequest.id">
            <button @click="sendFriendRequest" class="AddFriendButton hidden-button">+Add</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        receiverId: { 
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
        try {
            const authResponse = await axios.get('/User'); 
            if (authResponse.data?.user?.id) {
                this.currentUserId = authResponse.data.user.id;
                this.fetchFriendRequests();
            } else {
                console.error('No user ID returned from /user endpoint');
            }
        } catch (error) {
            console.error('Error fetching authenticated user data:', error);
        }
    },
    methods: {
        async fetchFriendRequests() {
            try {
                const response = await axios.get('/friend-requests');
                this.friendRequests = response.data;
            } catch (error) {
                console.error('Error fetching friend requests:', error);
            }
        },
        async sendFriendRequest() {
            if (!this.receiverId) {
                alert("Eroare: ID-ul prietenului este invalid!");
                return;
            }
            try {
                await axios.post('/sendRequest', { sender_id: this.currentUserId, receiver_id: this.receiverId });
                alert('Friend request sent successfully!');
                console.log('Cerere trimisă către:', this.receiverId);
                this.$emit('userId', this.receiverId);
            } catch (error) {
                console.error('Error sending friend request:', error);
                alert('Failed to send friend request');
            }
        }
    }
};
</script>

<style scoped>
@import "@/Assets/FriendRequest";
</style>

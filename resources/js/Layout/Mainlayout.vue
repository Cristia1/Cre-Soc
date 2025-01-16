<template>
  <div>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light rounded" style="background-color: #3d3d3d; margin-bottom: 10px; height: 40px;">
        <div class="container d-flex align-items-center justify-content-between">

          <!-- Logo -->
          <a class="navbar-brand" href="http://127.0.0.1:8000/Home">
            <img src="/logo.png" alt="Logo" style="height: 40px;">
          </a>

          <!-- Search bar -->
          <form class="form-inline my-2 my-lg-0" @submit.prevent="searchUsers">
            <div class="input-group">
              <input class="form-control search-input" type="search" placeholder="Search Social" aria-label="Search" v-model="searchQuery" />
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fas fa-search"></i>
                </span>
              </div>
            </div>
          </form>

          <!-- Navigation icons -->
          <a href="http://127.0.0.1:8000/Home" class="HOME">
            <i class="fas fa-home" style="font-size:28px; color:black;"></i>
          </a> 

          <a class="FRIENDS" href="http://127.0.0.1:8000/MainLayout">
            <i class="fas fa-user-friends" style="font-size:28px;color:black;"></i>
          </a>

          <a class="PROFILE" href="http://127.0.0.1:8000/Profile">
            <i class="fa fa-shopping-cart" style="font-size:28px; color:black;"></i>
          </a>

          <!-- Notification icon -->
          <div class="notification-bell" @click="toggleNotifications">
            <i class="fas fa-bell"></i>
            <span class="notification-count" v-if="notificationCount > 0">{{ notificationCount }}</span>
            <div v-if="showNotifications" class="notification-dropdown">
              <div v-if="notifications.length === 0">No new notifications.</div>
              <ul>
                <li v-for="notification in notifications" :key="notification.id">
                  {{ notification.text }}
                </li>
              </ul>
            </div>
          </div>

          <!-- Messenger icon -->
          <div class="messenger-icon" @click="toggleMessenger">
            <i class="fas fa-comment-dots"></i>
            <span class="message-count" v-if="messageCount > 0">{{ messageCount }}</span>
            <div v-if="showMessenger" class="messenger-dropdown">
              <div v-if="messages.length === 0">No new messages.</div>
              <ul>
                <li v-for="message in messages" :key="message.id">
                  <strong>{{ message.sender_name }}</strong>: {{ message.content }}
                </li>
              </ul>
            </div>
          </div>

          <!-- Profile icon -->
          <div class="navbar-right" v-if="profilUrl">
            <div class="profil-image" @click="toggleDropdown">
              <img :src="profilUrl" alt="Profile" class="rounded-circle" />
            </div>
            <div class="dropdown-menu dropdown-menu-right" :class="{ 'show': isDropdownOpen }">
              <!-- <button @click="logout" class="dropdown-item logout-button">Logout</button> -->
            </div>
          </div>

        </div>
      </nav>
    </header>

    <div class="card">
      <div class="card-body">
        <div class="container-fluid">
          <div v-if="users.length > 0" class="search-results">
            <div v-for="user in users" :key="user.id" class="user-item" @click="goToUserProfile(user.id)">
              <img :src="user.profilUrl || '/default-profile.png'" alt="Profile" class="user-image" />
              <div class="user-details">
                <h5>{{ user.name }}</h5>
              </div>
            </div>
          </div>
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      isDropdownOpen: false,
      searchQuery: '',
      users: [],
      id: null,
      profilUrl: '',
      isDropdownOpen: false, 
      notificationCount: '', 
      messageCount: '', 
    };
  },
  async created() {
    try {
      const response = await axios.get('/PhotoProfil');
      
      if (response.data.success) {
        const baseUrl = window.location.origin;
        this.profilUrl = response.data.profilUrl.startsWith('http')
          ? response.data.profilUrl
          : `${baseUrl}${response.data.profilUrl}`;
      } else {
        console.error('Error fetching profile photo:', response.data.message);
      }
    } catch (error) {
      console.error('Error fetching profile photo:', error);
    }
  },
  methods: {
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    openNotifications() {
      console.log('Opening notifications...');
    },
    openMessenger() {
      this.showMessenger = !this.showMessenger;
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    async logout() {
      try {
        await axios.post('/logout');
        window.location.href = '/login';
      } catch (error) {
        console.error('Error during logout:', error);
      }
    },
    async searchUsers() {
      try {
        const response = await axios.get('/users', {
          params: {
            query: this.searchQuery
          }
        });
        this.users = response.data.users; 
      } catch (error) {
        console.error('Error during search:', error);
      }
    },
    goToUserProfile(userId) {
      this.$router.push({ name: 'Profile', params: { id: userId } });
    }
  },
};
</script>

<style scoped>
@import '@/Assets/MainLayout';
</style>
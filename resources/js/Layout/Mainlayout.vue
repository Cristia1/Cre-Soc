<template>
  <div>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light rounded" style="background-color: #3d3d3d; margin-bottom: 10px; height: 40px;">
        <div class="container d-flex align-items-center justify-content-between">

          <!-- Logo -->
          <a class="navbar-brand" href="profile">
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

          <!-- <a href="/home" class="HOME">
            <i class="fas fa-home" style="font-size:28px; color:black;"></i>
          </a>

          <a class="FRIENDS" href="/friends">
            <i class='fas fa-user-friends' style='font-size:28px;color:black; '></i>
          </a>

          <a class="PROFILE" href="/profile">
            <i class="fa fa-shopping-cart" style="font-size:28px; color:black;"></i>
          </a> -->
          
          <!-- The logout button -->
          <ul class="navbar-nav ml-auto">
            <div class="dropdown-menu dropdown-menu-right" :class="{ 'show': isDropdownOpen }">
              <button @click="logout" class="dropdown-item logout-button">Logout</button>
            </div>
          </ul>

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
    };
  },
  methods: {
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
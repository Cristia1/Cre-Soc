<template>
  <div>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light rounded" style="background-color: #3d3d3d; margin-bottom: 10px; height: 40px;">
        <div class="container d-flex align-items-center justify-content-between">
          <!-- Logo -->
          <a class="navbar-brand" href="profile">
            <img src="/logo.png" alt="Logo" style="height: 40px;">
          </a>

          <!-- Search bar search bar -->
          <form class="form-inline my-2 my-lg-0" @submit.prevent="searchUsers">
            <div class="input-group">
              <input
                class="form-control search-input"
                type="search"
                placeholder="Search Social"
                aria-label="Search"
                v-model="searchQuery"
              />
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fas fa-search"></i>
                </span>
              </div>
            </div>
          </form>

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
            <!-- <h4>Search Results:</h4> -->
            <div v-for="user in users" :key="user.id" class="user-item">
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
    }
  }
};
</script>


<style scoped>
@import '@/Assets/MainLayout';
</style>

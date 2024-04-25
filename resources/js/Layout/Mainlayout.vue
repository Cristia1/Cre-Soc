<template>
    <div>
      <header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #4267B2; margin-bottom: 10px; height: 40px;">
          <div class="container">
            <a class="navbar-brand" href="#">
              <img src="/logo.png" alt="Logo" style="height: 40px;">
            </a>
            <div class="ml-auto">
              <a class="navbar-toggler" type="button" @click="toggleDropdown">
                <span class="navbar-toggler-icon"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" :class="{ show: isDropdownOpen }">
                <button @click="logout" class="dropdown-item">Logout</button>
              </div>
            </div>
          </div>
        </nav>
      </header>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import logout from "../Components/logout.vue";
  
  export default {
    components: {
      logout,
    },
    data() {
      return {
        isDropdownOpen: false
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
    },
  };
  </script>
  
  <style scoped>
  .dropdown-menu {
    position: absolute;
    right: 0;
  }
  
  
  .navbar-brand1{
    margin-left: 33px;
  }
  </style>
<template>
  <div>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light rounded" style="background-color: #4267B2; margin-bottom: 10px; height: 40px;">
        <div class="container">
          <a class="navbar-brand" href="">
            <img src="/logo.png" alt="Logo" style="height: 40px;">
          </a>

            <ul>
              <router-link to="/profile"  class="Profile">Profile</router-link>
            </ul>

            <ul class="navbar-nav ml-auto">
                <div class="dropdown-menu dropdown-menu-right" :class="{ 'show': isDropdownOpen }">
                  <button @click="logout"  class="dropdown-item logout-button">Logout</button>
                </div>
            </ul>
        </div>
      </nav>
    </header>
  </div>
  <div class="card">
      <div class="card-body">
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </div>
    </div>
</template>


<script>
import axios from 'axios';
import logout from "../Components/logout.vue";
import Profile from "../Pages/Profiles/Profile.vue";

export default {
  components: {
    logout,
    Profile,
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
        location.reload();
        await axios.post('/logout');
        location.reload();
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

.navbar {
  border-radius: 9px; 
  left: 3px;
  margin-right: -07px;
  margin-left: -07px;
  margin-top: -5px;
}

.Profile {
  background-color: #bc2e2e; 
  color: #333; 
  font-family: 'Arial', sans-serif; 
  padding: 1px; 



}
</style>

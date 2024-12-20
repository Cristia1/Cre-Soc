<template>
    <Profile :user="user"></Profile>
  </template>
  
  <script>
  import Profile from "../Profiles/Profile.vue";
  import axios from 'axios';
  
  export default {
    components: {
      Profile,
    },
    data() {
      return {
        user: null,
      };
    },
    async mounted() {
      try {
        const response = await axios.get('/user');
        this.user = response.data.user;
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
  };
  </script>  
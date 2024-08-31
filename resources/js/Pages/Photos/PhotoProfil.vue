<template>
  <div class="photo-profil">
    <label for="profil" class="custom-file-upload">
      <div class="add-image" v-if="!profilUrl">Add a Profil</div>
      <input id="profil" type="file" accept="image/*" @change="handleProfilUpload">
      <div class="profil-image" v-if="profilUrl">
        <img :src="profilUrl" alt="profil">
      </div>
    </label>
    <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    <UserId @user-id-received="handleUserIdReceived" />
  </div>
</template>


<script>
import axios from 'axios';
import UserId from "../Users/UserId.vue";

export default {
  components: {
    UserId,
  },
  data() {
    return {
      profilUrl: null,
      errorMessage: '',
      userId: null,
    };
  },
  mounted() {
    this.fetchUserPhoto('profil'); 
  },
  methods: {
    async handleProfilUpload(event) {
      if (event.target.files.length === 0) {
        console.log('No file selected');
        return;
      }
      
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append('image', file);
      formData.append('type', 'profil'); 
      try {
        const response = await axios.post('/photo', formData);
        if (response.data.success) {
          localStorage.setItem('profilUrl', response.data.profilUrl);
          this.profilUrl = response.data.profilUrl;
          this.errorMessage = ''; 
        } else {
          this.errorMessage = 'Error uploading image';
        }
      } catch (error) {
        console.error('Error uploading image:', error);
        this.errorMessage = 'Error uploading image';
      }
    },
    async fetchUserPhoto(type) {
      try {
        const response = await axios.get(`/PhotoProfil`);
        if (response.data.success) {
          this.profilUrl = response.data.profilUrl;
          localStorage.setItem(`${type}ProfilUrl`, this.profilUrl);
          this.errorMessage = '';
        } else {
          this.errorMessage = 'No image found';
        }
      } catch (error) {
        console.error('Error fetching user photo:', error);
        this.errorMessage = 'Error fetching user photo';
      }
    },
    handleUserIdReceived(userId) {
      this.userId = userId;
      this.fetchUserPhoto('profil'); 
    },
  },
};
</script>


<style scoped>
@import '@/Assets/PhotoProfil';
</style>
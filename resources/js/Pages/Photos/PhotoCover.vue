<template>
  <div class="profile-cover">
    <label for="image-upload" class="custom-file-upload">
      Add an image
      <input id="image-upload" type="file" accept="image/*" @change="handleImageUpload">
    </label>
    <div class="cover-image" v-if="imageUrl">
      <img :src="imageUrl" alt="Image loaded">
    </div>
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
      imageUrl: null,
      errorMessage: '',
      userId: null,
    };
  },
  mounted() {
    this.fetchUserPhoto();
  },
  methods: {
    async handleImageUpload(event) {
      if (event.target.files.length === 0) {
        return console.log('No file selected');
      }
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append('image', file);

      try {
        const response = await axios.post('/photos', formData);
        if (response.data.success) {
          localStorage.setItem('userImageUrl', response.data.imageUrl);
          this.imageUrl = response.data.imageUrl;
          this.errorMessage = ''; 
        } else {
          this.errorMessage = 'Error uploading image';
        }
      } catch (error) {
        console.error('Error uploading image:', error);
        this.errorMessage = 'Error uploading image';
      }
    },
    async fetchUserPhoto() {
      try {
        const response = await axios.get('/CoverPhoto');
        if (response.data.success) {
          this.imageUrl = response.data.imageUrl;
          localStorage.setItem('userImageUrl', this.imageUrl);
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
      this.fetchUserPhoto();
    },
  },
};
</script>


<style scoped>
@import '@/Assets/Components';
</style>
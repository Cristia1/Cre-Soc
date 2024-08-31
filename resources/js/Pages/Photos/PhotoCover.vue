<template>
  <div class="photo-cover">
    <label for="cover" class="custom-file-upload" style='font-size:10px'>
      &#128247;Add an Cover
      <input id="cover" type="file" accept="image/*" @change="handleCoverUpload">
    </label>
    <div class="cover-image" v-if="coverUrl">
      <img :src="coverUrl" alt="cover">
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
      coverUrl: null,
      errorMessage: '',
      userId: null,
    };
  },
  mounted() {
    this.fetchUserPhoto('cover'); 
  },
  methods: {
    async handleCoverUpload(event) {
      if (event.target.files.length === 0) {
        console.log('No file selected');
        return;
      }
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append('image', file);
      formData.append('type', 'cover'); 

      try {
        const response = await axios.post('/photo', formData);
        if (response.data.success) {
          localStorage.setItem('coverUrl', response.data.coverUrl);
          this.coverUrl = response.data.coverUrl;
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
        const response = await axios.get(`/PhotoCover`);
        if (response.data.success) {
          this.coverUrl = response.data.coverUrl;
          localStorage.setItem(`${type}CoverUrl`, this.coverUrl);
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
      this.fetchUserPhoto('cover'); 
    },
  },
};
</script>

<style scoped>
@import '@/Assets/PhotoCover';
</style>

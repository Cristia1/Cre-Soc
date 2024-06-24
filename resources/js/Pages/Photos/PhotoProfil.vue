<template>
  <div class="photo-profile">
    <label for="image-upload" class="custom-file-upload">
      <input id="image-upload" type="file" accept="image/*" @change="uploadProfilePhoto">
      <div class="profile-image" v-if="imageUrl">
        <img :src="imageUrl" alt="Profile Image">
      </div>
      <div class="add-image" v-else>
        Add Profile Image
      </div>
    </label>
    <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    <UserId @user-id-received="handleUserIdReceived" />
  </div>
</template>

<script>
import axios from 'axios';
import UserId from '../Users/UserId.vue';

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
    this.fetchProfilePhoto();
  },
  methods: {
    async uploadProfilePhoto(event) {
      if (event.target.files.length === 0) {
        return console.log('No file selected');
      }
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append('image', file);
      formData.append('type', 'profile');

      try {
        const response = await axios.post('/photos', formData);
        if (response.data.success) {
          localStorage.setItem('profileImageUrl', response.data.imageUrl);
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
    async fetchProfilePhoto() {
      try {
        const response = await axios.get('/photos/type/profile');
        if (response.data.success) {
          this.imageUrl = response.data.imageUrl;
          localStorage.setItem('profileImageUrl', this.imageUrl);
          this.errorMessage = '';
        } else {
          this.errorMessage = 'No image found';
        }
      } catch (error) {
        console.error('Error fetching profile photo:', error);
        this.errorMessage = 'Error fetching profile photo';
      }
    },
    handleUserIdReceived(userId) {
      this.userId = userId;
      this.fetchProfilePhoto();
    },
  },
};
</script>

<style scoped>
.photo-profile {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.custom-file-upload {
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  padding: 8px 16px;
  border: 2px dashed #1877f2;
  border-radius: 50%;
  width: 150px;
  height: 150px;
  overflow: hidden;
  position: relative;
}

.custom-file-upload input[type="file"] {
  display: none;
}

.profile-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.add-image {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  font-size: 14px;
  color: #1877f2;
  font-weight: bold;
  text-align: center;
}
</style>
<template>
  <div class="profile-cover">
    <label for="image-upload" class="custom-file-upload">
      Select an image
      <input id="image-upload" type="file" accept="image/*" @change="handleImageUpload">
    </label>
    <div class="cover-image" v-if="imageUrl">
      <img :src="imageUrl" alt="Image loaded">
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import InputError from './InputError.vue';

export default {
  components: {
    InputError
  },
  data() {
    return {
      imageUrl: null,
      errorMessage: ''
    };
  },
  methods: {
    async handleImageUpload(event) {
      const file = event.target.files[0];
      this.imageUrl = URL.createObjectURL(file);

      const formData = new FormData();
      formData.append('image', file);
      try {
        const response = await axios.post('/photos', formData);
        console.log('Image uploaded successfully:', response.data);
      } catch (error) {
        console.error('Error uploading image:', error);
        this.errorMessage = 'Error uploading image';
      }
    }
  }
};
</script>

<style scoped>
/* PhotoCover.vue */
.profile-cover {
  position: relative;
  width: 100%;
  height: 200px; 
  overflow: hidden;
}

.custom-file-upload {
  position: absolute;
  bottom: 10px; 
  left: 10px; 
  cursor: pointer;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  background-color: #1877f2;
  color: #fff;
  font-size: 14px;
  font-weight: bold;
}

.custom-file-upload input[type="file"] {
  display: none;
}

.cover-image {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.cover-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

</style>

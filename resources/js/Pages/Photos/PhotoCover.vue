<template>
  <div class="photo-cover">
    <label for="cover" class="custom-file-upload" style='font-size:10px'>
      &#128247;Add a Cover
      <input id="cover" type="file" accept="image/*" @change="handleCoverUpload">
    </label>
    <div class="cover-image" v-if="coverUrl">
      <img :src="coverUrl" alt="cover">
    </div>
    <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    
    <div v-if="userId && coverUrl && photoId !== null && initialLiked !== undefined && initialLikesCount !== undefined">
          <LikeButton
            itemType="photo"
            :itemId="photoId"
            :initialLiked="initialLiked"
            :initialLikesCount="initialLikesCount"
          />
      </div>
    <UserId @user-id-received="handleUserIdReceived" />
  </div>
</template>

<script>
import axios from 'axios';
import UserId from "../Users/UserId.vue";
import LikeButton from '../Likes/LikeButton.vue';

export default {
  components: {
    UserId,
    LikeButton,
  },
  data() {
    return {
      coverUrl: null,
      errorMessage: '',
      userId: null,
      photoId: null,
      initialLiked: false,
      initialLikesCount: 0,
    };
  },
  mounted() {
    const storedCoverUrl = localStorage.getItem('coverUrl');
    if (storedCoverUrl) {
      this.coverUrl = storedCoverUrl;
    } else {
      this.fetchUserPhoto('cover');
    }
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
        if (response.data.success === false) {
          this.coverUrl = null; 
          localStorage.removeItem('coverUrl'); 
          this.errorMessage = 'No image found';
        } else {
          const coverUrl = `${response.data.imageUrl}?t=${new Date().getTime()}`; 
          this.coverUrl = coverUrl;
          this.photoId = response.data.photoId;  
          this.initialLiked = response.data.liked; 
          this.initialLikesCount = response.data.likesCount; 
          localStorage.setItem('coverUrl', coverUrl);
          this.errorMessage = '';
        }
      } catch (error) {
        console.error('Error uploading image:', error);
        this.errorMessage = 'Error uploading image';
      }
    },



    async fetchUserPhoto(type) {
      let userId = this.$route.params.id || this.user?.id;
      try {
        const response = await axios.get(`/PhotoCover`, {
          params: { id: userId }, 
        }); 
        if (response.data.success === false) {
          this.coverUrl = null;
          localStorage.removeItem('coverUrl');
          this.errorMessage = 'No image found';
        } else {
          const coverUrl = `${response.data.coverUrl}?t=${new Date().getTime()}`;
          this.coverUrl = coverUrl;
          this.photoId = response.data.photoId; 
          this.initialLiked = response.data.liked; 
          this.initialLikesCount = response.data.likesCount; 
          localStorage.setItem('coverUrl', coverUrl);
          this.errorMessage = '';
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
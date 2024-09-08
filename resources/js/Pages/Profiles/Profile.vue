<template>
  <div class="profile1">
    <PhotoCover class="profile2"></PhotoCover>
    <PhotoProfil class="photo-profil"></PhotoProfil>

    <div class="details">
      <h1 class="UserName">{{ user.name }}</h1>
      <p>{{ user.bio }}</p>
      <p>{{ user.job }}</p>
      <p>{{ user.school }}</p>
    </div>
    <br><br><br><br>

    <!-- Button for viewing all photos -->
    <div class="photos-button">
      <button @click="openGallery">Photos</button>
    </div>

    <!-- User Posts -->
    <div class="posts">
      <div class="post" v-for="post in user.posts" :key="post.id">
        <p>{{ post.content }}</p>
        <img :src="post.image" alt="Post Image">
      </div>
    </div>

    <!-- Gallery under the Photos button -->
    <div v-if="showGallery" class="photo-gallery">
      <div class="gallery">
        <img v-for="photo in photos" :key="photo.id" :src="photo.url" alt="User Photo" class="gallery-image">
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import PhotoCover from '../Photos/PhotoCover.vue';
import PhotoProfil from '../Photos/PhotoProfil.vue';

export default {
  components: {
    PhotoCover,
    PhotoProfil,
  },
  data() {
    return {
      user: {
        name: "",
        bio: "",
        job: "",
        school: "",
        posts: []
      },
      photos: [],    
      showGallery: false,
    };
  },
  async mounted() {
    try {
      const response = await axios.get('/user');
      this.user = response.data.user;
    } catch (error) {
      console.error('Error fetching user profile:', error);
    }
  },
  methods: {
    async openGallery() {
      if (!this.photos.length) {  // Fetch photos only if not already loaded
        try {
          const response = await axios.get(`/user/${this.user.id}/photos`);
          this.photos = response.data.photos;
        } catch (error) {
          console.error('Error fetching user photos:', error);
        }
      }
      this.showGallery = !this.showGallery; // Toggle the gallery visibility
    }
  }
};
</script>


<style scoped>
@import '@/Assets/Profile';

</style>

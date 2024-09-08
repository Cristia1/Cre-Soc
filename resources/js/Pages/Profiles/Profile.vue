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

    <!-- Photo Gallery Modal -->
    <div v-if="showGallery" class="photo-gallery-modal">
      <div class="modal-content">
        <span @click="closeGallery" class="close-button">&times;</span>
        <div class="gallery">
          <img v-for="photo in photos" :key="photo.id" :src="photo.url" alt="User Photo" class="gallery-image">
        </div>
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
      showGallery: false 
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
      try {
        const response = await axios.get(`/user/${this.user.id}/photos`);
        this.photos = response.data.photos;
        this.showGallery = true;
      } catch (error) {
        console.error('Error fetching user photos:', error);
      }
    },
    closeGallery() {
      this.showGallery = false;
    }
  }
};
</script>

<style scoped>
@import '@/Assets/Profile';

/* Style for the button */
.photos-button {
  margin-top: 100px;
  text-align: center;
  margin-left: -350px;
}

.photos-button button {
  color: white;
  background-color: #111417;
  cursor: pointer;
  border-radius: 5px;
}

/* Photo Gallery Modal Styles */
.photo-gallery-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 10px;
  max-width: 90%;
  max-height: 90%;
  overflow-y: auto;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  cursor: pointer;
}

.gallery {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.gallery-image {
  width: 150px;
  height: 150px;
  object-fit: cover;
  margin: 5px;
  border-radius: 5px;
}
</style>

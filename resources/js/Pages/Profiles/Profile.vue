<template>
  <div class="profile1">
    <PhotoCover class="profile2"></PhotoCover>
      <PhotoProfil class="photo-profil"></PhotoProfil>

    <div class="details">
      <h1>{{ user.name }}</h1>
        <p>{{ user.bio }}</p>
      <!-- Other details such as work, school, etc. -->
          <p>{{ user.job }}</p>
      <p>{{ user.school }}</p>
    </div>
    
    <!-- User Posts -->
    <div class="posts">
      <div class="post" v-for="post in user.posts" :key="post.id">
        <p>{{ post.content }}</p>
          <img :src="post.image" alt="Post Image">
      </div>
    </div>
  </div>
</template>


<script>
import PhotoCover  from '../Photos/PhotoCover.vue';
import PhotoProfil from '../Photos/PhotoProfil.vue';

export default {
  components: {
    PhotoCover,
    PhotoProfil,
  },
  data() {
    return {
      user: {
        name: "Alesio Albert Rares",
        bio: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        job: "Software Developer",
        school: "Harvard University",
        posts: [
          { id: 1, content: "Post content 1", image: "post1.jpg" },
          { id: 2, content: "Post content 2", image: "post2.jpg" },
          // ...
        ]
      }
    };
  }
};
</script>

<style scoped>
@import '@/Assets/Profile';
</style>

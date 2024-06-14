<template>
  <div class="profile">
    <!-- Cover image -->
    <PhotoCover class="cover-photo"></PhotoCover>
    <!-- Profile picture -->
    <div class="profile-photo"></div>
    
    <!-- Name and other details -->
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

export default {
  components: {
    PhotoCover,
  },
  data() {
    return {
      user: {
        name: "Cristian Cristian ",
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
@import '@/Assets/Components';
</style>

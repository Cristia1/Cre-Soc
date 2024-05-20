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
import PhotoCover from '../../Components/PhotoCover.vue';

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
/* Styling for the profile component */
.profile {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Styling for cover image */
.cover-photo {
  height: 300px;
  background-color: #4267b2; /* Culoarea de fundal a Facebook-ului */
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

/* Stylization for profile picture */
.profile-photo {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background-color: #fff;
  border: 4px solid #4267b2; 
  margin: -60px auto 20px auto;
  overflow: hidden;
}

/* Styling for details*/
.details {
  text-align: center;
}

/* Styling for posts */
.posts {
  margin-top: 20px;
}

.post {
  margin-bottom: 20px;
  padding: 10px;
  background-color: #f0f2f5; 
  border-radius: 8px;
}

.post img {
  max-width: 100%;
  border-radius: 8px;
}
</style>

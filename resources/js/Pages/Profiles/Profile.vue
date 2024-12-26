<template>
  <div class="profile1">
    <PhotoCover class="profile2"></PhotoCover>
      <PhotoProfil class="photo-profil"></PhotoProfil>

    <div class="details" v-if="user">
      <h1 class="UserName">{{ user.name }}</h1>
    </div>

    <br><br><br>

      <div class="button-group">
        <div class="Post1">
          <button @click="openPost">Post</button>
        </div>

        <div class="about-button">
          <button @click="openAbout">About</button>
        </div>

        <div class="photos-button">
          <button @click="openGallery">Photos</button>
        </div>

        <div class="FriendsButton">
          <FriendsShowList :user_id="FriendsUserId"></FriendsShowList>
        </div>
        
        <div v-if="localUserId" class="Message1">
          <MessageButton :receiver-id="localUserId">Messages</MessageButton>
        </div>

        <div class="Add">
          <FriendRequest @update:Add-id="AddFriend" />
        </div>
      </div>

    <!-- Photo Gallery under the Photos button -->
      <div v-if="showGallery" class="photo-gallery">
        <div class="gallery">
          <img v-for="photo in photos" :key="photo.id" :src="photo.url" alt="User Photo" class="gallery-image">
        </div>
      </div>

    <!-- About section, initially hidden -->
      <div v-if="showAbout" class="about-section">
        <div v-if="!isEditing ">
          <!-- Display profile information -->
          <h3>Profile Information</h3>
          <p><strong>City:</strong> {{ profile.city }}</p>
          <p><strong>Work:</strong> {{ profile.work }}</p>
          <p><strong>Birthdate:</strong> {{ profile.birthdate }}</p>
          <p><strong>Marital Status:</strong> {{ profile.marital_status }}</p>
          <p><strong>Education:</strong> {{ profile.education }}</p>
          <p><strong>Phone Number:</strong> {{ profile.phone_number }}</p>
          <p><strong>Gender:</strong> {{ profile.gender }}</p>
          <p><strong>Favorite Movies:</strong> {{ profile.favorite_movies }}</p>
          <p><strong>Favorite Sports:</strong> {{ profile.favorite_sports }}</p>
          <p><strong>Favorite Books:</strong> {{ profile.favorite_books }}</p>
          
          <!-- Edit button -->
          <button @click="toggleEdit">Edit</button>
      </div>

      <form v-if="isEditing" @submit.prevent="saveProfile">
        <!-- Edit profile form -->
        <label for="city">City:</label>
        <input v-model="profile.city" type="text" id="city" required>
        <label for="work">Work:</label>
        <input v-model="profile.work" type="text" id="work" required>
        <label for="birthdate">Birthdate:</label>
        <input v-model="profile.birthdate" type="date" id="birthdate" required>
        <label for="marital_status">Marital Status:</label>
        <select v-model="profile.marital_status" id="marital_status" required>
          <option value="single">Single</option>
          <option value="married">Married</option>
          <option value="divorced">Divorced</option>
          <option value="widowed">Widowed</option>
        </select>
        <label for="education">Education:</label>
        <input v-model="profile.education" type="text" id="education" required>
        <label for="phone_number">Phone Number:</label>
        <input v-model="profile.phone_number" type="text" id="phone_number" required>
        <label for="gender">Gender:</label>
        <select v-model="profile.gender" id="gender" required>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
        <label for="favorite_movies">Favorite Movies:</label>
        <textarea v-model="profile.favorite_movies" id="favorite_movies"></textarea>
        <label for="favorite_sports">Favorite Sports:</label>
        <textarea v-model="profile.favorite_sports" id="favorite_sports"></textarea>
        <label for="favorite_books">Favorite Books:</label>
        <textarea v-model="profile.favorite_books" id="favorite_books"></textarea>
        <button type="submit">Save Profile</button>
        <button @click="cancelEdit" type="button">Cancel</button>
      </form>
    </div>
  </div>  
</template>

<script>
import axios from 'axios';
import PhotoCover from '../Photos/PhotoCover.vue';
import PhotoProfil from '../Photos/PhotoProfil.vue';
import FriendsShowList from '../Friends/FriendsShowList.vue';
import MessageButton from '../Chats/MessageButton.vue';
import FriendRequest from '../Friends/FriendRequest.vue';

export default {
  components: {
    PhotoCover,
    PhotoProfil,
    FriendsShowList,
    MessageButton,
    FriendRequest,
  },
  data() {
    return {
      userId: '',
      FriendsUserId: '',
      localUserId: '',
      AddFriend: '',
      Send: '',
      user: {
        id: null,
        name: "",
        bio: "",
        job: "",
        school: "",
        posts: []
      },
      profile: {    
        city: '',
        work: '',
        birthdate: '',
        marital_status: 'single', 
        education: '',
        phone_number: '',
        gender: 'male',
        favorite_movies: '',
        favorite_sports: '',
        favorite_books: ''
      },
      isEditing: false, 
      profileSaved: false,
      photos: [],
      showGallery: false,
      showAbout: false,
    };
  },
  watch: {
  '$route.params.id': {
    immediate: true,
      handler(newId) {
        if (newId) {
          console.log("Detected new user ID:", newId);
          this.fetchUserData(newId);
        } else {
          console.warn("No user ID provided. Falling back to current user.");
          this.loadLoggedInUser();
        }
      }
    }
  },
  async mounted() {
    if (this.$route.params.id) {
      await this.fetchUserData(this.$route.params.id);
    } else {
      this.loadLoggedInUser();
    }
    try {
      const response = await axios.get('/user');
        if (response.data.user) {
          this.user = response.data.user;
          this.localUserId = this.user.id;
          this.FriendsUserId = this.user.id;
          this.AddFriend = this.user.id;
          this.Send = this.user.id;
        } else {
          console.warn('User data not found.');
        }
        const profileResponse = await axios.get(`/profile/${this.userId}`, this.profile);
          if (profileResponse.data.profile) {
            this.profile = profileResponse.data.profile;
          }
      } catch (error) {
        console.error('Error fetching user or profile data:', error);
      }
    },
  methods: {
    toggleEdit() {
      this.isEditing = true;
    },
    async saveProfile() {
      try {
        const response = await axios.post(`/profile/${this.user.id}`, this.profile);
        if (response.data.success) {
          alert('Profile saved successfully!');
          this.profile = response.data.profile;
          this.isEditing = false; 
          this.profileSaved = true;
        } else {
          alert('Error saving profile.');
        }
      } catch (error) {
        console.error('Error saving profile:', error);
        alert('Error saving profile.');
      }
    },
    cancelEdit() {
      this.isEditing = false;
    },
    async openGallery() {
      if (!this.photos.length && this.user?.id) {  
        try {
          const response = await axios.get(`/user/${this.user.id}/photos`);
          this.photos = response.data.photos;
        } catch (error) {
          console.error('Error fetching user photos:', error);
        }
      }
      this.showGallery = !this.showGallery; 
    },
    async openAbout() {
      this.showAbout = !this.showAbout; 

      if (this.user?.id) {
        try {
          const profileResponse = await axios.get(`/profile/${this.userId}`);
          if (profileResponse.data.profile) {
            this.profile = profileResponse.data.profile;
          }
        } catch (error) {
          console.error('Error fetching profile data:', error);
        }
      }
    },
    async fetchUserData(userId) {
      try {
        const userResponse = await axios.get(`/user/${userId}`);

        if (userResponse.data.user) {
          this.user = userResponse.data.user; 
        }

        if (this.user?.id) {
          const profileResponse = await axios.get(`/profile/${userId}`);
        if (profileResponse.data.profile) {
          this.profile = profileResponse.data.profile; 
        }

        const photosResponse = await axios.get(`/user/${userId}/photos`);
        this.photos = photosResponse.data.photos || [];

          const detailsResponse = await axios.get(`/user/${userId}/profile`);
          this.details = detailsResponse.data.details || [];
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    }
  }
};
</script>

<style scoped>
@import '@/Assets/Profile';
</style>  
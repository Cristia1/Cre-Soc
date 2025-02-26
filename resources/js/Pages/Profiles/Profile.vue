<template>
  <div class="messenger1-icon" @click="toggleMessenger">
    <i class="fas fa-comment-dots"></i>
    <span class="message1-count" v-if="messageCount > 0">{{ messageCount }}</span>
    <div v-if="showMessenger" class="messenger1-dropdown">
      <div v-if="notifications.length === 0">No new notifications.</div>
      <ul>
        <li v-for="message in messages" :key="message.id">
          <strong>{{ message.sender_name }}</strong>: {{ message.content }}
        </li>
      </ul>
    </div>
  </div>

  <div class="notification1-bell" @click="toggleNotifications">
    <i class="fas fa-bell"></i>
    <span class="notification1-count" v-if="notificationCount > 0">{{ notificationCount }}</span>
    <div v-if="showNotifications" class="notification1-dropdown">
      <div v-if="notifications.length === 0">Notifications.</div>
      <ul>
        <li v-for="notification in notifications" :key="notification.id">
          {{ notification.text }}
        </li>
      </ul>
    </div>
  </div>
  <br><br><br>
  <br><br>
<!-- Down is profile -->
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
        
        <div v-if="localUserId" class="Send">
          <MessageButton :receiver-id="localUserId">Messages</MessageButton>
        </div>

        <div v-if="localUserId">
          <FriendRequest :userId="user.id" />
        </div>
      </div>

      <AcceptRequest v-if="localUserId" :userId="localUserId" />
      
    <!-- Photo Gallery under the Photos button -->
      <div v-if="showGallery" class="photo-gallery">
        <div class="gallery">
          <img v-for="photo in photos" :key="photo.id" :src="photo.url" alt="User Photo" class="gallery-image">
        </div>
      </div>

    <!-- About section, initially hidden -->
      <div v-if="showAbout" class="about-section">
        <div v-if="!isEditing ">

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
        <button type="submit"  @click="saveProfile">Save Profile</button>
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
import AcceptRequest from '../Friends/AcceptRequest.vue';

export default {
  components: {
    PhotoCover,
    PhotoProfil,
    FriendsShowList,
    MessageButton,
    FriendRequest,
    AcceptRequest,
  },
  data() {
    return {
      loggedInUserId: '',
      messageContent: '',  
      messages: [],
      showMessenger: false,
      messageCount: 0,
      // 
      userId: '',
      // 
      FriendsUserId: '',
      localUserId: null,
      receiverId: null, 
      // 
      messageContent: '', 
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
      // 
      notificationCount: '', 
      messageCount: '', 
      showNotifications: '',
    };
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler(newId) {
        if (newId) {
          this.fetchUserData(newId); 
        } else {
          console.warn("No user ID provided. Falling back to current user.");
          this.loadLoggedInUser();
        }
      }
    }
  },
  async mounted() {
   
    try {
      let userId = this.$route.params.id || this.user?.id;
      this.targetUserId = userId; 
      
      if (userId) {
        this.userId = userId; 
      } else {
        console.warn('User ID is not available');
      }

      if (this.$route.params.id) {
        userId = this.$route.params.id; 
        this.friendRequestUserId = this.$route.params.id;
      } else {
        await this.loadLoggedInUser(); 
        userId = this.user.id;  
      }

      const userResponse = await axios.get(`/user/${userId}`);
      if (userResponse.data.user) {
        this. loggedInUserId = userResponse.data.user.id;
        this.currentUserId = userResponse.data.user.id;
        this.user = userResponse.data.user;
        this.localUserId = this.user.id;
        this.FriendsUserId = this.user.id;
        this.AddFriend = this.user.id;
        this.Send = this.user.id;
      } else {
        console.warn('User data not found.');
      }

      const profileResponse = await axios.get(`/profile/${userId}`);
      if (profileResponse.data.profile) {
        this.profile = profileResponse.data.profile;
      } else {
        console.warn('Profile data not found.');
      }

    } catch (error) {
      console.error('Error fetching user or profile data:', error);
    }
  },
  
  methods: {
    toggleMessenger() {
    this.showMessenger = !this.showMessenger;
  },
  async fetchMessages() {
    try {
      const response = await axios.get('/user-messages');
      if (response.data.success && response.data.messages) {
        this.messages = response.data.messages.map((message) => ({
          id: message.id,
          content: message.content,
          sender_name: message.sender.name,
          sender_id: message.sender.id,
        }));
        this.messageCount = response.data.messages.length; 
      } else {
        console.error('No messages returned from /user-messages endpoint');
      }
    } catch (error) {
      console.error('Error fetching messages:', error);
    }
  },
    openNotifications() {
      console.log('Opening notifications...');
    },
    openMessenger() {
      this.showMessenger = !this.showMessenger;
    },


    async LocalUserId(userId) {
      console.log('megees');
      try {
        const response = await fetch('/messages', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${localStorage.getItem('token')}`, 
          },
          body: JSON.stringify({
            receiver_id: this.receiverId,
            content: this.messageContent,
          }),
        });

        if (!response.ok) {
          throw new Error('Failed to send the message');
        }

        const data = await response.json();
        console.log('Message sent successfully:', data);
        this.messageContent = ''; 
      } catch (error) {
        console.error('Error sending message:', error);
      }
    },
    toggleEdit() {
      this.isEditing = true;
    },
    async saveProfile() {
      const method = this.profile.id ? 'put' : 'post';
      const url = this.profile.id
        ? `/profile/${this.profile.id}`
        : '/profile';

      const dataToSend = {
        city: this.profile.city,
        work: this.profile.work,
        birthdate: this.profile.birthdate,
        marital_status: this.profile.marital_status,
        education: this.profile.education,
        phone_number: this.profile.phone_number,
        gender: this.profile.gender,
        favorite_movies: this.profile.favorite_movies,
        favorite_sports: this.profile.favorite_sports,
        favorite_books: this.profile.favorite_books,
      };

      try {
        const response = await axios[method](url, dataToSend);
        if (response.data.success) {
          // alert('Profile updated successfully!');
          this.profile = response.data.profile;
          this.isEditing = false;
        } else {
          alert('Error updating profile.');
        }
      } catch (error) {
        if (error.response) {
          console.error('Validation errors:', error.response.data.errors);
          alert(`Validation errors: ${JSON.stringify(error.response.data.errors)}`);
        } else if (error.request) {
          console.error('Request error:', error.request);
        } else {
          console.error('Error:', error.message);
        }
      }
    },
    cancelEdit() {
      this.isEditing = false;
      this.fetchUserData(this.user.id);
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
      try {
        const profileResponse = await axios.get(`/profile/${this.userId}`, {
          headers: {
            Accept: "application/json",
          },
        });

        if (profileResponse.data.success) {
          this.profile = profileResponse.data.profile;
        }
      } catch (error) {
        console.error("Eroare la fetch-ul profilului:", error);
      }
    },
    openPost() {
      console.log('Se posteaza');
    },
    handleFriendRequestSent(friendId) {
        alert(`The friend request has been sent to the user with the ID ${friendId}`);
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
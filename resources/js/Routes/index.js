import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Reusable Components
import MainLayout from '../Layout/Mainlayout.vue';
import Logout from "../Components/logout.vue";
import Home from "../Components/Home.vue";
import Google from "../Components/Google.vue"; 
import InputError from "../Components/InputError.vue";

// Users Components
import UserList from '../Pages/Users/UserList.vue';
import UserId from "../Pages/Users/UserId.vue";

// Chat Components
import MessageButton from "../Pages/Chats/MessageButton.vue";

// Friends Components
import FriendsShowList from "../Pages/Friends/FriendsShowList.vue";
import FriendRequest from "../Pages/Friends/FriendRequest.vue";

// Photos Components
import PhotoCover from "../Pages/Photos/PhotoCover.vue";
import PhotoProfil from "../Pages/Photos/PhotoProfil.vue";

// Profile Components
import Profile from "../Pages/Profiles/Profile.vue";

// Likes Components
import LikeButton from "../Pages/Likes/LikeButton.vue";

// Router setup
const routes = [
    // Main layout and home
    { path: '/', redirect: '/MainLayout' },

    { path: '/MainLayout', name: 'MainLayout', component: MainLayout },
    { path: '/home', component: Home },
    { path: '/google', component: Google },
    { path: '/logout', component: Logout },
    { path: '/auth/google/callback', redirect: '/MainLayout' },
    { path: '/input-error', component: InputError },

    // Users Components
    { path: '/UserId', component: UserId },

    // Photos Components
    { path: '/photo-profil', component: PhotoProfil },
    { path: '/photo-cover', component: PhotoCover },

    // Profile Components
    { path: '/profile/:id', name: 'Profile', component: Profile, },

    // Likes Components
    { path: '/like-button', component: LikeButton },

    // Message Components

];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Create and mount the app
const app = createApp(MainLayout);
app.config.globalProperties.$appUrl = import.meta.env.APP_URL;
app.use(router);
app.mount('#app');
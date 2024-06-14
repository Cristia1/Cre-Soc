import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Components Reusaile
import MainLayout from "../Layout/Mainlayout.vue";
import Logout from "../Components/logout.vue";
import Home from "../Components/Home.vue";
import google from "../Components/google.vue"
import InputError  from "../Components/InputError.vue";
import UserId from "../Pages/Users/UserId.vue";
//  End Components


// Components Photos
import PhotoCover from "../Pages/Photos/PhotoCover.vue";
import PhotoProfil from "../Pages/Photos/PhotoProfil.vue";
// Ends



// Profile Components
import Profile from "../Pages/Profiles/Profile.vue";
//  End Components

const router = createRouter({
    history: createWebHistory(),
    routes: [
        // Components Reusabile
        { path: '/', redirect: '/MainLayout' },
        { path: '/MainLayout', name: 'MainLayout', component: MainLayout },
        { path: '/home', component: Home },
        { path: '/google', component: google },
        { path: '/Logout', component: Logout },
        { path: '/auth/google/callback', redirect: '/MainLayout' },
        { path: '/InputError', component: InputError },
        { path: '/UserId', component: UserId },
        //  End Components


        // Photos Components
        { path: '/PhotoProfil', component: PhotoProfil },
        { path: '/PhotoCover', component: PhotoCover },
        // 


        // Profile Components
        { path: '/Profile', component: Profile },
        //  End Components
    ]
});


const app = createApp(MainLayout);
app.config.globalProperties.$appUrl = import.meta.env.APP_URL;
app.use(router);
app.mount('#app');
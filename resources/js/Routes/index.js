import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Components Reusaile
import MainLayout from "../Layout/Mainlayout.vue";
import Logout from "../Components/logout.vue";
import PhotoCover from "../Components/PhotoCover.vue"
import InputError  from "../Components/InputError.vue";
//  End Components


// Profile Components
import Profile from "../Pages/Profiles/Profile.vue";
//  End Components

const router = createRouter({
    history: createWebHistory(),
    routes: [
        // Components Reusabile
        { path: '/', redirect: '/MainLayout' },
        { path: '/MainLayout', name: 'MainLayout', component: MainLayout },
        { path: '/Logout', component: Logout },
        { path: '/auth/google/callback', redirect: '/MainLayout' },
        { path: '/PhotoCover', component: PhotoCover },
        { path: '/InputError', component: InputError },
        //  End Components


        // Profile Components
        { path: '/Profile', component: Profile },
        //  End Components
    ]
});


const app = createApp(MainLayout);
app.config.globalProperties.$appUrl = import.meta.env.APP_URL;
app.use(router);
app.mount('#app');
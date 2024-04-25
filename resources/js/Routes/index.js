import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Components 
import MainLayout from "../Layout/Mainlayout.vue";
import Logout from "../Components/logout.vue";
//  End Components


// Users Components

//  End Components

const router = createRouter({
    history: createWebHistory(),
    routes: [
        // Components 
        { path: '/', redirect: '/MainLayout' },
        { path: '/MainLayout', name: 'MainLayout', component: MainLayout },
        { path: '/Logout', component: Logout },
        // { path: '/auth/google/callback', redirect: '/MainLayout' },
        //  End Components
    ]
});


const app = createApp(MainLayout);
app.config.globalProperties.$appUrl = import.meta.env.APP_URL;
app.use(router);
app.mount('#app');
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';


import axios from 'axios';
import MainLayout from "../Layouts/MainLayout.vue";
import User from "../Components/Users/User.vue";


const app = createApp(MainLayout);
app.config.globalProperties.$axios = axios;
app.config.globalProperties.$appUrl = window.APP_URL;



// Create router
const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/MainLayout', component: MainLayout },
        { path: '/User', component: User },
    ],
});


app.use(router);
import Echo from "laravel-echo";
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

app.mount('#app');

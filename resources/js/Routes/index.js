import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import Navbar from '../js/Navbar.vue';
import User from '../Components/Users/User.vue';




const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/Navbar', component: Navbar },
        { path: '/user', component: User, name: 'user.index' },
    ],
});

const app = createApp(App);
app.use(router);
app.config.globalProperties.$appUrl = import.meta.env.APP_URL;

app.mount('#app');

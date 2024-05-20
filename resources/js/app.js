import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import App from "../js/App.vue"

const app = createApp({App});
app.component('App', App);
app.mount('#app');

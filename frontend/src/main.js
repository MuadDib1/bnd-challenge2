import { createApp } from 'vue';
import App from './App.vue';

import './assets/main.css'; // Optional: add your global styles here
import 'bootstrap/dist/css/bootstrap.min.css';


const app = createApp(App);

app.mount('#app');

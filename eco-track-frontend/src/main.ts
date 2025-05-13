import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
import Toast from 'vue-toastification';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'vue-toastification/dist/index.css';

// Krijo aplikacionin Vue
const app = createApp(App);

// Shto libraritë
app.use(createPinia());
app.use(router);
app.use(Toast);

// Montoje aplikacionin te #app (index.html)
app.mount('#app');

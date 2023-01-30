import axios from 'axios';
import { createApp } from 'vue';

import App from './components/App.vue';
import { router } from './router';

axios.defaults.withCredentials = true;
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.baseURL = window.location.origin;

const app = createApp(App);
app.use(router);
app.mount("#app");

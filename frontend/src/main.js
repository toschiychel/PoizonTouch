import { createApp, nextTick } from 'vue'
import App from '../App.vue'
import router from './router'
import axios from 'axios'
const app = createApp(App)

axios.defaults.withCredentials = true;
app.config.globalProperties.$adminUrl = 'http://admin.toschiy.ru';
axios.defaults.baseURL = 'http://admin.toschiy.ru';

app.use(router)
app.config.globalProperties.axios = axios
app.mount('#app')

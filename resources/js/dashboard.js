import { createApp } from 'vue';
import Dashboard from './Dashboard.vue';
import Maska from 'maska';

createApp(Dashboard).use(Maska).mount("#dashboard");
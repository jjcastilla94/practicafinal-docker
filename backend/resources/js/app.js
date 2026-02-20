import './bootstrap';
import { createApp } from 'vue';
import Courses from './components/Courses.vue';
import Students from './components/Students.vue';

const app = createApp({});
app.component('courses', Courses);
app.component('students', Students);
app.mount('#app');
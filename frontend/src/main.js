import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import TaskList from './components/TaskList.vue'
import LoginForm from './components/LoginForm.vue'

import 'bootstrap/dist/css/bootstrap.min.css'

const routes = [
  { path: '/', component: TaskList },
  { path: '/login', component: LoginForm },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

createApp(App).use(router).mount('#app')

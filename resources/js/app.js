import './bootstrap';
import {createApp} from 'vue';  
import * as VueRouter from 'vue-router'

import MainComponent from './components/main.vue' 
import LoginComponent from './components/login.vue'
import RegisterComponent from './components/register.vue'
import MainRegisterComponent from './components/register-2.vue'

const routes = [
  {path: '/', component: MainComponent},
  {path: '/login', component: LoginComponent},
  {path: '/register', component: RegisterComponent},
  {path: '/register-2', component: MainRegisterComponent}
]
  
const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(''),
    routes,
})
  
const app = createApp({})

app.use(router)

app.component('homecomponent',MainComponent)

app.mount('#home');

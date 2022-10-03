import './bootstrap';
import {createApp} from 'vue';  
import * as VueRouter from 'vue-router'

import MainComponent from './components/main.vue' 
import LoginComponent from './components/authentication/login.vue'
import RegisterComponent from './components/authentication/register.vue'
import MainRegisterComponent from './components/authentication/register-2.vue'
import OverViewComponent from './components/home/overview.vue'
import TenantsComponent from './components/home/tenants.vue'
import PropertiesComponent from './components/home/properties.vue'
import QuizComponent from './components/home/quiz.vue'
import BinComponent from './components/home/bin.vue'
import SettingsComponent from './components/home/settings.vue'
import InboxComponent from './components/home/inbox.vue'
import NotificationComponent from './components/home/notification.vue'

const routes = [
  {path: '/', component: MainComponent},
  {path: '/login', component: LoginComponent},
  {path: '/register', component: RegisterComponent},
  {path: '/register-2', component: MainRegisterComponent},
  {path: '/overview', component: OverViewComponent},
  {path: '/tenants', component: TenantsComponent},
  {path: '/properties', component: PropertiesComponent},
  {path: '/quiz', component: QuizComponent},
  {path: '/bin', component: BinComponent},
  {path: '/settings', component: SettingsComponent},
  {path: '/inbox', component: InboxComponent},
  {path: '/notification', component: NotificationComponent}
  
]
  
const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(''),
    routes,
})
  
const app = createApp({})

app.use(router)

app.component('maincomponent',MainComponent)

app.mount('#main');

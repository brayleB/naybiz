import './bootstrap';
import {createApp} from 'vue';  
import * as VueRouter from 'vue-router'
import { createPinia } from 'pinia';
import piniaPersist from 'pinia-plugin-persist';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueClipboard from 'vue-clipboard2'

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
import TenantApplicationComponent from './components/home/tenantapplication.vue'
import TenantQuizComponent from './components/tenantquiz.vue'
import LandlordsComponent from './components/home/landlords.vue'
import TenantQuizPreviewComponent from './components/tenantquizpreview.vue'

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
  {path: '/notification', component: NotificationComponent},
  {path: '/tenantapplication', component: TenantApplicationComponent},
  {path: '/tenantquiz', component: TenantQuizComponent},
  {path: '/landlords', component: LandlordsComponent},
  {path: '/tenantquizpreview', component: TenantQuizPreviewComponent}
  
]
  
const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(''),
    routes,
})
const pinia = createPinia()
pinia.use(piniaPersist)

const app = createApp({})
app.use(router)
app.use(pinia)
app.use(VueSweetalert2);
app.use(VueClipboard);
app.component('maincomponent',MainComponent)
app.mount('#main');

const tenantapp = createApp({})
tenantapp.use(router)
tenantapp.use(pinia)
tenantapp.use(VueSweetalert2);
tenantapp.component('tenantapplicationcomponent',TenantApplicationComponent)
tenantapp.mount('#tenantapplication');

const tenantquiz = createApp({})
tenantquiz.use(router)
tenantquiz.use(pinia)
tenantquiz.use(VueSweetalert2);
tenantquiz.component('tenantquizcomponent',TenantQuizPreviewComponent)
tenantquiz.mount('#tenantquiz');
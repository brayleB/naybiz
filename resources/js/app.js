import './bootstrap';
import {createApp} from 'vue';  
import * as VueRouter from 'vue-router'
import { createPinia } from 'pinia';
import piniaPersist from 'pinia-plugin-persist';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueClipboard from 'vue-clipboard2';

import MainComponent from './components/main.vue' 
import LoginComponent from './components/authentication/login.vue'
import RegisterComponent from './components/authentication/register.vue'
import RegisterHoaComponent from './components/authentication/register_hoa.vue'
import RegisterLandlordComponent from './components/authentication/register_landlord.vue'

//landlord
import OverViewComponent from './components/landlord/overview.vue'
import TenantsComponent from './components/landlord/tenants.vue'
import PropertiesComponent from './components/landlord/properties.vue'
import QuizComponent from './components/landlord/quiz.vue'
import BinComponent from './components/landlord/bin.vue'
import SettingsComponent from './components/landlord/settings.vue'
import InboxComponent from './components/landlord/inbox.vue'
import NotificationComponent from './components/landlord/notification.vue'

//hoa
import LandlordsHoaComponent from './components/hoa/landlords.vue'
import OverViewHoaComponent from './components/hoa/overview.vue'
import TenantsHoaComponent from './components/hoa/tenants.vue'
import PropertiesHoaComponent from './components/hoa/properties.vue'
import QuizHoaComponent from './components/hoa/quiz.vue'
import BinHoaComponent from './components/hoa/bin.vue'
import SettingsHoaComponent from './components/hoa/settings.vue'
import InboxHoaComponent from './components/hoa/inbox.vue'
import NotificationHoaComponent from './components/hoa/notification.vue'

//tenant
import TenantApplicationComponent from './components/tenantapplication.vue'
import TenantQuizComponent from './components/tenantquiz.vue'
import TenantQuizPreviewComponent from './components/tenantquizpreview.vue'



const routes = [
  {path: '/', component: MainComponent},
  {path: '/login', component: LoginComponent},
  {path: '/register', component: RegisterComponent},
  {path: '/register/hoa', component: RegisterHoaComponent},
  {path: '/register/landlord', component: RegisterLandlordComponent},

  {path: '/landlord/overview', component: OverViewComponent},
  {path: '/landlord/tenants', component: TenantsComponent},
  {path: '/landlord/properties', component: PropertiesComponent},
  {path: '/landlord/quiz', component: QuizComponent},
  {path: '/landlord/bin', component: BinComponent},
  {path: '/landlord/settings', component: SettingsComponent},
  {path: '/landlord/inbox', component: InboxComponent},
  {path: '/landlord/notification', component: NotificationComponent},

  {path: '/hoa/overview', component: OverViewHoaComponent},
  {path: '/hoa/tenants', component: TenantsHoaComponent},
  {path: '/hoa/landlords', component: LandlordsHoaComponent},
  {path: '/hoa/properties', component: PropertiesHoaComponent},
  {path: '/hoa/quiz', component: QuizHoaComponent},
  {path: '/hoa/bin', component: BinHoaComponent},
  {path: '/hoa/settings', component: SettingsHoaComponent},
  {path: '/hoa/inbox', component: InboxHoaComponent},
  {path: '/hoa/notification', component: NotificationHoaComponent},

  {path: '/tenantapplication', component: TenantApplicationComponent},
  {path: '/tenantquiz', component: TenantQuizComponent},
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


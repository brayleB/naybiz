<script>
    import SidebarLink from './sidebarlink.vue'
    import LogoutButton from './logoutbutton.vue'
    import { collapsed, toggleSidebar, sidebarWidth } from './state.js'
    import Logoutbutton from './logoutbutton.vue'
    import {useUserStore} from '../../store/user'
    export default {
      props: {},
      components: { SidebarLink, LogoutButton, Logoutbutton },
      setup() {
        const userStore = useUserStore();
        return { userStore, collapsed, toggleSidebar, sidebarWidth }
      },
      methods: {                
          async logout() {    
              this.$swal.fire({
                imageUrl: "https://naybiz.com/users/questions-icon.png",
                title: "<h1 class='text-primary'>Log-out</h1>",
                        text:'Do you really want to Sign-out?', 
                        color: 'black',
			                  showDenyButton: true,                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'           
              }).then(async (result)  => {              
                if (result.isConfirmed) {
                  await this.userStore.logoutUser();  
                  this.$router.push('/login')   
                  this.$swal.fire({
                       imageUrl: "https://naybiz.com/users/success-icon.png",
                       title: "<h1 class='text-primary'>Log-out Successful</h1>",
                        text:'Thanks for using Naybiz', 
                        color: 'black',                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'               
                    })          
                } 
              })
            },                  
        },                 
    }
</script>

<template>
  <div class="sidebar" :style="{ width: sidebarWidth }" v-if="(this.userStore.currentUser['type']=='landlord')">
    <h1>
      <span v-if="collapsed">
        <div class="logo">         
          <router-link to="/">
              <img class="img-fluid" src="../../../images/logo-icon.png" alt="alternative" />
          </router-link> 
          </div>  
      </span>
      <span v-if="!collapsed">
      <div class="logo">         
          <router-link to="/">
              <img class="img-fluid" src="../../../images/Logo-black.png" alt="alternative" />
          </router-link> 
          </div> 
        </span> 
    </h1>
    <!-- <SidebarLink to="/landlord/overview" icon="fas fa-chart-bar">Overview</SidebarLink> -->
    <SidebarLink to="/landlord/tenants" icon="fas fa-columns">Tenants</SidebarLink>
    <SidebarLink to="/landlord/properties" icon="fas fa-home">Properties</SidebarLink>   
    <SidebarLink to="/landlord/quiz" icon="fas fa-users">Community Quiz</SidebarLink>
    <!-- <SidebarLink to="/bin" icon="fas fa-image">Bin</SidebarLink> -->
    <SidebarLink to="/landlord/settings" icon="fas fa-tools">Settings</SidebarLink>
    <!-- <SidebarLink to="/landlord/inbox" icon="fa fa-inbox">Inbox</SidebarLink>
    <SidebarLink to="/landlord/notification" icon="fa fa-home">Notification</SidebarLink>   -->
    <Logoutbutton v-on:click="logout()" icon="fa fa-sign-out-alt">Logout</Logoutbutton>        
    <span
      class="collapse-icon"
      :class="{ 'rotate-180': collapsed }"
      @click="toggleSidebar">
      <i class="fas fa-angle-double-left"/>
    </span>
  </div>

  <div class="sidebar" :style="{ width: sidebarWidth }" v-else-if="(this.userStore.currentUser['type']=='hoa')">
    <h1>
      <span v-if="collapsed">
        <div class="logo">         
          <router-link to="/">
              <img class="img-fluid" src="../../../images/logo-icon.png" alt="alternative" />
          </router-link> 
          </div>  
      </span>
      <span v-if="!collapsed">
      <div class="logo">         
          <router-link to="/">
              <img class="img-fluid" src="../../../images/Logo-black.png" alt="alternative" />
          </router-link> 
          </div> 
        </span> 
    </h1>
    <!-- <SidebarLink to="/hoa/overview" icon="fas fa-home">Overview</SidebarLink> -->
    <SidebarLink to="/hoa/tenants" icon="fas fa-columns">Tenants</SidebarLink>
    <SidebarLink to="/hoa/properties" icon="fas fa-chart-bar">Properties</SidebarLink>   
    <SidebarLink to="/hoa/landlords" icon="fa fa-person-booth">Landlords</SidebarLink>
    <SidebarLink to="/hoa/quiz" icon="fas fa-users">Community Quiz</SidebarLink>
    <!-- <SidebarLink to="/bin" icon="fas fa-image">Bin</SidebarLink> -->
    <SidebarLink to="/hoa/settings" icon="fas fa-tools">Settings</SidebarLink>
    <!-- <SidebarLink to="/hoa/inbox" icon="fa fa-inbox">Inbox</SidebarLink>
    <SidebarLink to="/hoa/notification" icon="fa fa-home">Notification</SidebarLink>   -->
    <Logoutbutton v-on:click="logout()" icon="fa fa-sign-out-alt">Logout</Logoutbutton>        
    <span
      class="collapse-icon"
      :class="{ 'rotate-180': collapsed }"
      @click="toggleSidebar">
      <i class="fas fa-angle-double-left"/>
    </span>
  </div>
</template>
    <style>
    :root {
      --sidebar-font-color: #FCFDFF;
      /* --sidebar-bg-color: #FCFDFF; */
      --sidebar-bg-color: #eeeef0;
      --sidebar-item-hover: #3d78e6;
      --sidebar-item-active: #1760E8;
    }
    </style>
    
    <style scoped>
    .sidebar {
      color: white;  
      background-color: var(--sidebar-bg-color);
      float: left;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      bottom: 0;    
      transition: 0.3s ease;
      display: flex;
      flex-direction: column;
      padding-left: 1em;
      padding-right:1em;
    }
    .sidebar h1 {
      height: 2.5em;
    }
    .collapse-icon {
      position: absolute;
      bottom: 0;
      padding: 1em 1.5em;
      color: #1760E8;
      transition: 0.2s linear;
      cursor: pointer;
    }
    .rotate-180 {
      transform: rotate(180deg);
      transition: 0.2s linear;
    }

    .logo{    
      padding-top: 0.5em; 
      padding-bottom: 0.5em; 
      text-align: center;     
    }

    @media (max-width: 900px) {  
      .sidebar {
        padding-top: 1.5rem;
      }
      .collapse-icon {
        max-height: 100%;
        bottom: 21.6rem;
      }   
    }

    @media (max-width: 800px) {
      .sidebar {
        overflow-y: scroll;
        overflow-x: hidden;
      }      
      .collapse-icon {
        bottom: 18.6rem;
      } 
    }
    @media (max-width: 700px) {
      .collapse-icon {
        bottom: 14.6rem;
      } 
    }
    @media (max-width: 600px) {
      .collapse-icon {
        bottom: 11.6rem;
      } 
    }
    </style>
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
                icon: 'warning',
                title: 'Do you really want to logout?',            
                showDenyButton: true,
                confirmButtonText: 'Logout',
                confirmButtonColor: '#1760E8'                      
              }).then(async (result)  =>  {              
                if (result.isConfirmed) {
                  await this.userStore.logoutUser();  
                  this.$router.push('/login')   
                  this.$swal.fire({
                    icon: 'success',
                    title: 'Logout Successfull',   
                    confirmButtonText: 'Confirm',
                    confirmButtonColor: '#1760E8'                            
                    })          
                } 
              })
             }
        },
    }
</script>

<template>
  <div class="sidebar" :style="{ width: sidebarWidth }">
    <h1>
      <span v-if="collapsed">
        <div class="logo">         
          <router-link to="/overview">
              <img class="img-fluid" src="../../../images/logo-icon.png" alt="alternative" />
          </router-link> 
          </div>  
      </span>
      <span v-if="!collapsed">
      <div class="logo">         
          <router-link to="/overview">
              <img class="img-fluid" src="../../../images/Logo-black.png" alt="alternative" />
          </router-link> 
          </div> 
        </span> 
    </h1>

    <SidebarLink to="/overview" icon="fas fa-home">Overview</SidebarLink>
    <SidebarLink to="/tenants" icon="fas fa-columns">Tenants</SidebarLink>
    <SidebarLink to="/properties" icon="fas fa-chart-bar">Properties</SidebarLink>
    <SidebarLink to="/quiz" icon="fas fa-users">Community Quiz</SidebarLink>
    <!-- <SidebarLink to="/bin" icon="fas fa-image">Bin</SidebarLink> -->
    <SidebarLink to="/settings" icon="fas fa-tools">Settings</SidebarLink>
    <SidebarLink to="/inbox" icon="fa fa-inbox">Inbox</SidebarLink>
    <SidebarLink to="/notification" icon="fa fa-home">Notification</SidebarLink>  
    <Logoutbutton v-on:click="logout()" icon="fa fa-sign-out-alt">Logout</Logoutbutton>        
    <span
      class="collapse-icon"
      :class="{ 'rotate-180': collapsed }"
      @click="toggleSidebar"
    >
      <i class="fas fa-angle-double-left" />
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
      padding: 0.75em;
      color: rgba(255, 255, 255, 0.7);
      transition: 0.2s linear;
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
         
    </style>
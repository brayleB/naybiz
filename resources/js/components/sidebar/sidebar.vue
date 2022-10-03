<script>
    import SidebarLink from './sidebarlink.vue'
    import { collapsed, toggleSidebar, sidebarWidth } from './state.js'
    export default {
      props: {},
      components: { SidebarLink },
      setup() {
        return { collapsed, toggleSidebar, sidebarWidth }
      }
    }
    </script>
    
    <template>
      <div class="sidebar" :style="{ width: sidebarWidth }">
        <h1>
          <span v-if="collapsed">
            <div>V</div>
            <div>S</div>
          </span>
          <span v-else>Vue Sidebar</span>
        </h1>
    
        <SidebarLink to="/overview" icon="fas fa-home">Overview</SidebarLink>
        <SidebarLink to="/tenants" icon="fas fa-columns">Tenants</SidebarLink>
        <SidebarLink to="/properties" icon="fas fa-chart-bar">Properties</SidebarLink>
        <SidebarLink to="/quiz" icon="fas fa-users">Community Quiz</SidebarLink>
        <SidebarLink to="/bin" icon="fas fa-image">Bin</SidebarLink>
        <SidebarLink to="/settings" icon="fas fa-tools">Settings</SidebarLink>
        <SidebarLink to="/inbox" icon="fas fa-chat">Inbox</SidebarLink>
        <SidebarLink to="/notification" icon="fas fa-notification">Notification</SidebarLink>
        <SidebarLink to="/login" icon="fas fa-notification">Logout</SidebarLink>        
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
      --sidebar-bg-color: #2f855a;
      --sidebar-item-hover: #38a169;
      --sidebar-item-active: #276749;
    }
    </style>
    
    <style scoped>
    .sidebar {
      color: white;  
      float: left;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      bottom: 0;
      padding: 0.5em;
      transition: 0.3s ease;
      display: flex;
      flex-direction: column;
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
    </style>
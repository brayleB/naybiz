<script>
    import { computed } from 'vue'
    import { useRoute } from 'vue-router'
    import { collapsed } from './state.js'
    
    export default {
      props: {
        to: { type: String, required: true },
        icon: { type: String, required: true }
      },
      setup(props) {
        const route = useRoute()
        const isActive = computed(() => route.path === props.to)
        return { isActive, collapsed }
      }
    }
    </script>
    
    <template>
      <button v-on:click="click" class="link" :class="{ active: isActive }">
        <i class="icon" :class="icon" />
        <transition name="fade">
          <span v-if="!collapsed">
            <slot />
          </span>
        </transition>
      </button>
    </template>
    
    <style scoped>
    .fade-enter-active,
    .fade-leave-active {
      transition: opacity 0.1s;
    }
    
    .fade-enter,
    .fade-leave-to {
      opacity: 0;
    }
    
    .link {
      display: flex;
      align-items: center;
      border: none;
      cursor: pointer;
      position: relative;
      font-weight: 400;
      user-select: none;
    
      margin: 0.1em 0;
      padding-left: 1.5em;
      padding-right: 1.5em;
      padding-top: 1.8em;
      padding-bottom: 1.8em;
      
      border-radius: 0.5em;
      height: 1.5em;
    
      color: #768BB1;
      text-decoration: none;
    }    
    
    .link:hover {
      color: var(--sidebar-font-color);
      background-color: var(--sidebar-item-hover);      
    }
    
    .link.active {
      color: var(--sidebar-font-color);
      background-color: var(--sidebar-item-active);
    }    
    
    .link .icon {
      flex-shrink: 0;
      width: 25px;
      margin-right: 10px;
    }
    </style>
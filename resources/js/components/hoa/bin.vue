<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          selected: 'Quiz'
        }
      },
      setup() {
        return { sidebarWidth }
      },
      props: {
        isSelected: {
          type: Boolean
        }
      },
      methods: {
        setSelected(tab){
          this.selected = tab;
        }
      }
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">.
          <div class="homesection container-fluid">
          <div class="row">
            <Sidebar />    
            <router-view />           
            <div class="col-lg-2 col-xl-8">  
              <p class="p-medium text-black">Back | <r class="p-medium text-primary" to="/register">Recycle Bin</r></p>                  
              <h1>Recycle Bin</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus erat quis metus tincidunt, vel faucibus tortor convallis. Duis nec vestibulum est, ac suscipit lacus.</p>
            </div>
            <div class="col-lg-6 col-xl-12">                       
              <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any properties</h4>                    
                        </div>                                              
                   </div>                                
              </div>             
          </div> 
      </div>
      
    </div>           
    </template>
    
  <style>
 
    </style>
<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          selected: 'Messages'
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
            <div class="col-lg-2 col-xl-4">  
              <p class="p-medium text-black">Back | <r class="p-medium text-primary" to="/register">Inbox</r></p>                  
              <h1>Inbox</h1>
            </div>
            <div class="col-lg-6 col-xl-12">   
              <TabNav :tabs="['Messages']" :selected="selected" @selected="setSelected">
              <Tab :isSelected="selected === 'Messages'">                                      
                <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>You have no messages</h4>                    
                        </div>                                              
                   </div>       
                  </Tab>                 
                 
              </TabNav>         
            </div>             
          </div> 
      </div>
    </div>
       
    
    </template>
    
  <style>
 
    </style>


    <template>
      <Sidebar />
      <div :style="{ 'margin-left': sidebarWidth }">           
        <router-view />  
              
        <div class="overview-main container-fluid">          
          <div class="row">
            <div class="col-lg-8">
              <h4>Hello, {{ displayName }}</h4>
              <h1>Welcome back to Naybiz</h1>  
              <div class="what">             
                    <img class="img-fluid" src="../../../images/whatsnew-bgcolor.png" alt="alternative" />               
              </div>           
            </div>           
            <div class="col-lg-3">
              <div class="form-group has-search">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" class="form-control" placeholder="Search">
              </div>
            </div>             

          </div>
        </div>
      </div>
      
      <!-- Modal -->

    </template>  
    <script>
    import {useUserStore} from '../../store/user'
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
  
    export default {   
        components: { Sidebar },                     
        methods: {                
             async getCurrentUser() {                           
              await this.userStore.fetchUser(); 
              if(this.userStore.accessToken==null)
              {        
                this.$swal.fire({
                    icon: 'warning',
                    title: "PLease Login",   
                    confirmButtonText: 'Confirm',
                    confirmButtonColor: '#1760E8'                            
                    }).then(async (result)  =>  {              
                if (result.isConfirmed) {   
                  this.$router.push('/login')              
                } 
              })                                   
              }
              else{               
                this.displayName = this.userStore.currentUser['firstname']
              }
                                       
            },                                                 
        },
        setup() {                 
            const userStore = useUserStore();           
            return {sidebarWidth , userStore };
        },

        data() {           
            return {  
                displayName: ""                  
            };
        },
        mounted() {                
            this.getCurrentUser()           
        }      
    }
    
 
    </script>  
    <style>
    #app {
      font-family: Avenir, Helvetica, Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-align: center;
      color: #2c3e50;
    }
    
    #nav {
      padding: 30px;
    }
    
    #nav a {
      font-weight: bold;
      color: #2c3e50;
    }
    
    #nav a.router-link-exact-active {
      color: #42b983;
    }

    .has-search .form-control {
        padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
      position: absolute;
      z-index: 2;
      display: block;
      width: 2.375rem;
      height: 2.375rem;
      line-height: 2.375rem;
      text-align: center;
      pointer-events: none;
      color: #aaa;
    }
    </style>


    <template>
      <Sidebar />
      <div :style="{ 'margin-left': sidebarWidth }">           
        <router-view />  
              
        <div class="overview-main container-fluid">          
          <div class="row">
            <div class="col-lg-8">
              <h4>Hello, {{ displayName }}!</h4>
              <h1>Welcome to Landlord dashboard</h1>  
                <div class="d-block position-relative" style="margin-top: 25px;">    
                    <img class="img-fluid position-absolute" src="../../../images/whatsnew-bgcolor.png" alt="alternative" 
                    style=" width: 52rem; height: auto;" />               
                    <img class="img-fluid position-absolute" src="../../../images/whatsnew-bgcolor2.png" alt="alternative" 
                    style=" width: 44rem; height: auto; margin-left: 25px; margin-top: 10px;" />
                    <img class="img-fluid position-absolute" src="../../../images/Globe.png" alt="" 
                    style=" width: 10rem; height: auto;"/>
                </div>            
            </div>           
            <div class="col-lg-4">
              <div class="form-group has-search mb-5">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <div class="what mb-4">             
                    <img class="img-fluid" src="../../../images/temp2.png" alt="alternative" />               
              </div> 
              <div class="what">             
                    <img class="img-fluid" src="../../../images/temp3.png" alt="alternative" />               
              </div> 
            </div>             

          </div>
        </div>
      </div>
      

    </template>  
    <script>
    import {useUserStore} from '../../store/user'
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
  
    export default {   
        components: { Sidebar },                     
        methods: {     
            async checkLoggedIn() {    
                await this.userStore.fetchUser()             
                if(this.userStore.hasError==true){ 
                  this.$router.push('/login')  
                }          
            }  ,                      
            setUserType(){         
              this.displayName = this.userStore.currentUser['first_name'] 
                if(this.userStore.currentUser['type']=='landlord'){
                    this.userTypeStr='Landlord'
                }
                else if(this.userStore.currentUser['type']=='hoa'){
                    this.userTypeStr='HOA'
                }
                else{       
                   
                }
            },                                                
        },
        setup() {                 
            const userStore = useUserStore();           
            return {userStore, sidebarWidth};
        },

        data() {           
            return {  
                displayName: "",
                userTypeStr:""                 
            };
        },
        mounted() {                
            this.checkLoggedIn() 
            this.setUserType()         
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
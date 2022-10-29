<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    import {useTenantStore} from '../../store/tenant';
    import {useUserStore} from '../../store/user';
    import {useConstant} from '../../store/constants'
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          selected: 'Request',              
          landlordApplicationLink:"",                     
        }
      },
      setup() {            
        const userStore = useUserStore()   
        const constantStore = useConstant()     
        return {  userStore, constantStore, sidebarWidth }
      },
      props: {
        isSelected: {
          type: Boolean
        }
      },
      methods: {
        setSelected(tab){
          this.selected = tab;
        },       
        prepareData() {
          this.landlordApplicationLink = this.constantStore.baseUrl+"register-2?type=0&id="+this.userStore.currentUser['id']       
        },
        copylink() {                    
          let container = this.$refs.container
          this.$copyText(this.landlordApplicationLink, container)
          this.$swal.fire({
                    icon: 'success',
                    title: 'Link saved to clipboard',   
                    confirmButtonText: 'Confirm',
                    confirmButtonColor: '#1760E8'                            
                    }) 
          this.userStore.regUserType='landlord'
          console.log(this.userStore.regUserType)
        },                     
      },  
      created() {
        this.prepareData()
      }         
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">.
          <div class="homesection container-fluid">
          <div class="row">
            <Sidebar />    
            <router-view />           
            <div class="col-lg- col-xl-4">  
              <p class="p-medium text-black">Back | <r class="p-medium text-primary" to="/register">Landlords</r></p>                  
              <h1>Landlords</h1>  
              <button class="btn btn-link" @click="copylink()">Click here for Landlord Signup invitation link</button>            
            </div>
            <div class="col-lg-6 col-xl-12">          
            <TabNav :tabs="['Request', 'Accepted', 'Trash']" :selected="selected" @selected="setSelected">           
              <Tab :isSelected="selected === 'Request'">     
                <div class="emptycon d-flex align-items-center justify-content-center">
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any requests</h4>                    
                        </div>                                              
                   </div>                                                                                       
                  </Tab>                
                  <Tab :isSelected="selected === 'Accepted'">
                    <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any accepted requests</h4>                    
                        </div>                                              
                   </div>                          
                  </Tab>
                  <Tab :isSelected="selected === 'Trash'">
                    <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Empty</h4>                    
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
.card {
    box-shadow: 0 0.15rem .1rem 0 rgb(33 40 50 / 15%); 
    padding: 5%;      
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}

.img-account-profile {
    height: 15rem;
}

.form-control, .dataTable-input {
    display: o;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>
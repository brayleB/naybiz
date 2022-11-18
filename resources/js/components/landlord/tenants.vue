<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    import {useTenantStore} from '../../store/tenant';
    import {useUserStore} from '../../store/user';
    import {usePropertiesStore} from '../../store/properties';
    import {useConstant} from '../../store/constants'
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          occupantList:[],
          vehicleList:[],
          selected: 'Request',     
          tenants_accepted: [],
          tenants_requested:[],
          tenant_view :{},              
          showAdd:false,
          tempId:null,
          indexId:null,
        }
      },
      setup() {    
        const tenantStore = useTenantStore()
        const userStore = useUserStore()
        const constantStore = useConstant()
        const propertyStore = usePropertiesStore()     
        return { tenantStore, userStore, constantStore, sidebarWidth, propertyStore }
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
        // async getTenants(){
        //   await this.tenantStore.fetchTenantByLandlordId()          
        //   this.tenants_list_new = this.tenantStore.tenants  
        //   this.tenantapplicationlink = this.constantStore.baseUrl+"tenantapplication?id="+this.userStore.currentUser['id']         
        //   this.tenantquizlink = this.constantStore.baseUrl+"tenantquiz?id="+this.userStore.currentUser['id']                         
        // },
        async getTenantsAccepted(){
          await this.tenantStore.fetchTenantByLandlordIdAccepted()          
          this.tenants_accepted = this.tenantStore.acceptedTenants                                         
        },
        async getTenantsRequested(){
          await this.tenantStore.fetchTenantByLandlordIdRequested()          
          this.tenants_requested = this.tenantStore.requestedTenants                                          
        },
        showRequested(id){ 
          this.indexId = id          
          this.tempId = this.tenants_requested[id]['id']         
          this.tenant_view = this.tenants_requested[id] 
          this.occupantList = JSON.parse(this.tenants_requested[id]['occupants'])
          this.vehicleList = JSON.parse(this.tenants_requested[id]['vehicles'])
        },  
        showAccepted(id){       
          this.tenant_view = this.tenants_accepted[id] 
          this.occupantList = JSON.parse(this.tenants_accepted[id]['occupants'])
          this.vehicleList = JSON.parse(this.tenants_accepted[id]['vehicles'])
        },  
        async setTenant(){                                             
          await this.propertyStore.setTenant(this.tenants_requested[this.indexId]['property_id'],this.tempId)                                 
        },
        async clickAccept(){                           
          await this.tenantStore.acceptTenant(this.tempId)  
          this.setTenant()
          location.reload(true)                       
        },
        async checkLoggedIn() {    
                await this.userStore.fetchUser()             
                if(this.userStore.error==true){ 
                  this.$router.push('/login')  
                }          
            }                             
      },
      created() {
        this.getTenantsAccepted()
        this.getTenantsRequested()
        this.checkLoggedIn()
      },
     
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">
          <div class="homesection container-fluid">
          <div class="row">
            <Sidebar />    
            <router-view />           
            <div class="col-lg- col-xl-4">  
              <p class="p-medium text-black">Back | Landlord |<r class="p-medium text-primary" to="/register">Tenants</r></p>                  
              <h1>Tenants</h1>  
              <!-- <button class="btn btn-link" @click="copylink()">Click here for Application link</button>             -->
            </div>
            <div class="col-lg-6 col-xl-12">                 
            <TabNav :tabs="['Request', 'Accepted', 'Trash']" :selected="selected" @selected="setSelected">           
              <Tab :isSelected="selected === 'Request'">     
                <div class="emptycon d-flex align-items-center justify-content-center" v-if="!tenants_requested || !tenants_requested.length">
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any requests</h4>                    
                        </div>                                              
                   </div>                                  
                    <div class="maincon overflow-auto" v-else>                          
                        <div class="table-responsive">
                          <table class="table table-borderless mb-0">
                            <thead>
                              <tr>
                                <th scope="col" class="col-lg-1">                                  
                                </th>                                  
                                <th scope="col" class="col-lg-4">Name</th>                               
                                <th scope="col" class="col-lg-3">Email Address</th>
                                <th scope="col" class="col-lg-2">Contact</th>
                                <th scope="col" class="col-lg-2"></th>                              
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(tenants_requested, index) in tenants_requested" :key="index">
                                <th scope="row">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                  </div>
                                </th>
                                <!-- <td>
                                  <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td> -->
                                <td>{{ tenants_requested.first_name}} {{tenants_requested.last_name}}</td>
                                <td>{{ tenants_requested.email }}</td>
                                <td>{{ tenants_requested.contact_no }}</td>                              
                                <td>
                                  <button type="button" class="btn-1 btn btn-primary btn-sm px-3" data-bs-target="#myModal" data-bs-toggle="modal" @click="showRequested(index)">
                                    View Details
                                  </button>  
                                  <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Tenant Information</h5>
                                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">   
                                          <div class="container-fluid overflow-auto">
                                            <div class="card-body text-center mb-3">                                           
                                            <img class="img-account-profile image-responsive mb-2" src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png" alt="">                                                                                                                                                                                                                 
                                            <div class="small font-italic text- mb-3">ID Screenshot</div>         
                                        </div>                                                                          
                                        <div class="row gx-3 mb-1">                                           
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName" >First name</label>
                                                <h5>{{ tenant_view.first_name }}</h5>
                                            </div>                                         
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputLastName">Last name</label>
                                                <h5>{{ tenant_view.last_name }}</h5>
                                            </div>
                                        </div>    
                                        <div class="row gx-3 mb-1">                                           
                                            <div class="col-md-6">
                                              <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                            <h5>{{ tenant_view.email }}</h5>
                                            </div>                                         
                                            <div class="col-md-6">
                                              <label class="small mb-1" for="inputPhone">Contact number</label>
                                                <h5>{{ tenant_view.contact_no }}</h5>
                                            </div>
                                        </div>                                                                                                       
                                        <div class="mb-2">
                                            <label class="small mb-1" for="inputEmailAddress">Current Address</label>
                                            <h5>{{ tenant_view.address }}</h5>
                                        </div>    
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">Occupants</label>
                                            <ol class="list-group list-group-numbered">
                                              <li class="list-group-item border-0" v-for="(occupantList, index) in occupantList" :key="index">{{ occupantList.name}}</li>                                                                                               
                                          </ol>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">Vehicles</label>
                                            <ol class="list-group list-group-numbered">
                                              <li class="list-group-item border-0" v-for="(vehicleList, index) in vehicleList" :key="index">   Year: {{ vehicleList.year}}, Make: {{ vehicleList.make}}, Model: {{ vehicleList.model}}, LicensePlate Number: {{ vehicleList.plate}}</li>                                                                                               
                                          </ol>
                                        </div>
                                        </div>                                                                                                                                                                                                                                                                                                                                         
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" @click="clickAccept(); setTenant();" class="btn btn-primary" data-bs-dismiss="modal">Accept</button>                                        
                                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Trash</button>                                        
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                     
                                </td>                               
                              </tr>                                                                        
                            </tbody>
                          </table>
                        </div>                                                      
                      </div>                                        
                  </Tab>                
                  <Tab :isSelected="selected === 'Accepted'">
                    <div class="emptycon d-flex align-items-center justify-content-center" v-if="!tenants_accepted || !tenants_accepted.length">
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any requests</h4>                    
                        </div>                                              
                   </div>                                  
                    <div class="maincon overflow-auto" v-else>                          
                        <div class="table-responsive">
                          <table class="table table-borderless mb-0">
                            <thead>
                              <tr>
                                <th scope="col" class="col-lg-1">                                  
                                </th>                                  
                                <th scope="col" class="col-lg-4">Name</th>                               
                                <th scope="col" class="col-lg-3">Email Address</th>
                                <th scope="col" class="col-lg-2">Contact</th>
                                <th scope="col" class="col-lg-2"></th>                              
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(tenants_accepted, index) in tenants_accepted" :key="index">
                                <th scope="row">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                  </div>
                                </th>
                                <!-- <td>
                                  <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td> -->
                                <td>{{ tenants_accepted.first_name}} {{tenants_accepted.last_name}}</td>
                                <td>{{ tenants_accepted.email }}</td>
                                <td>{{ tenants_accepted.contact_no }}</td>                              
                                <td>
                                  <button type="button" class="btn-1 btn btn-primary btn-sm px-3" data-bs-target="#myModal" data-bs-toggle="modal" @click="showAccepted(index)">
                                    View Details
                                  </button>  
                                  <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Tenant Information</h5>
                                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">   
                                          <div class="container-fluid overflow-auto">
                                            <div class="card-body text-center mb-3">                                           
                                            <img class="img-account-profile image-responsive mb-2" src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png" alt="">                                                                                                                                                                                                                 
                                            <div class="small font-italic text- mb-3">ID Screenshot</div>         
                                        </div>                                                                          
                                        <div class="row gx-3 mb-1">                                           
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputFirstName" >First name</label>
                                                <h5>{{ tenant_view.first_name }}</h5>
                                            </div>                                         
                                            <div class="col-md-6">
                                                <label class="small mb-1" for="inputLastName">Last name</label>
                                                <h5>{{ tenant_view.last_name }}</h5>
                                            </div>
                                        </div>    
                                        <div class="row gx-3 mb-1">                                           
                                            <div class="col-md-6">
                                              <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                            <h5>{{ tenant_view.email }}</h5>
                                            </div>                                         
                                            <div class="col-md-6">
                                              <label class="small mb-1" for="inputPhone">Contact number</label>
                                                <h5>{{ tenant_view.contact_no }}</h5>
                                            </div>
                                        </div>                                                                                                       
                                        <div class="mb-2">
                                            <label class="small mb-1" for="inputEmailAddress">Current Address</label>
                                            <h5>{{ tenant_view.address }}</h5>
                                        </div>    
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">Occupants</label>
                                            <ol class="list-group list-group-numbered">
                                              <li class="list-group-item border-0" v-for="(occupantList, index) in occupantList" :key="index">{{ occupantList.name}}</li>                                                                                               
                                          </ol>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">Vehicles</label>
                                            <ol class="list-group list-group-numbered">
                                              <li class="list-group-item border-0" v-for="(vehicleList, index) in vehicleList" :key="index">   Year: {{ vehicleList.year}}, Make: {{ vehicleList.make}}, Model: {{ vehicleList.model}}, LicensePlate Number: {{ vehicleList.plate}}</li>                                                                                               
                                          </ol>
                                        </div>
                                        </div>                                                                                                                                                                                                                                                                                                                                         
                                        </div>
                                        <div class="modal-footer">
                                          <!-- <button type="button" class="btn btn-primary" @click="" data-bs-dismiss="modal">Accept</button>                                         -->
                                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Trash</button>                                        
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                     
                                </td>                               
                              </tr>                                                                        
                            </tbody>
                          </table>
                        </div>                                                      
                      </div>                                           
                  </Tab>
                  <Tab :isSelected="selected === 'Trash'">
                    <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any properties</h4>                    
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
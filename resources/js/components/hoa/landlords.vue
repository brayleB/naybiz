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
          accepted_landlords:[],                    
          requested_landlords:[],
          email:null,
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
          this.landlordApplicationLink = this.constantStore.baseUrl+"register/landlord?type=0&id="+this.userStore.currentUser['id']       
        },
        async copylink() {   
          let container = this.$refs.container     
          this.$copyText(this.landlordApplicationLink, container)                    
          await this.userStore.inviteLandlord(this.email, this.landlordApplicationLink)
          if(this.userStore.response['status']==true){
            this.$swal.fire({
                    imageUrl: "https://naybiz.com/users/success-icon.png",
                    title: "<h1 class='text-primary'>Tenant Application Link</h1>",
                        text:'Email successfully sent', 
                        color: 'black',                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'                            
              }) 
          }              
        },            
        async displayRequestedLandlords(){
          await this.userStore.getLandlordsByHOAIdRequested()
          if(this.userStore.response['status']==true){
            this.requested_landlords = this.userStore.response['landlords']
          }          
        }, 
        async displayAcceptedLandlords(){
          await this.userStore.getLandlordsByHOAIdAccepted()
          if(this.userStore.response['status']==true){
            this.accepted_landlords = this.userStore.response['landlords']
          }          
        }                     
      },  
      created() {
        this.prepareData()
        this.displayRequestedLandlords()
        this.displayAcceptedLandlords()
      }         
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">
          <div class="homesection container-fluid">
          <div class="row">
            <Sidebar />    
            <router-view />           
            <div class="col-lg-4 col-xl-4">  
              <p class="p-medium text-black">Back | HOA | <r class="p-medium text-primary" to="/register">Landlords</r></p>                  
              <h1 class="mt-5">Landlords</h1>                     
            </div>
            <div class="col-lg-12 col-xl-12 mb-2">                            
            <TabNav :tabs="['Request', 'Accepted']" :selected="selected" @selected="setSelected">           
              <Tab :isSelected="selected === 'Request'">     
                <div class="emptycon d-flex align-items-center justify-content-center" v-if="!requested_landlords || !requested_landlords.length">
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4 class="text-primary">Looks like you don’t have any Request</h4>                    
                        </div>                                              
                   </div>                                  
                    <div class="maincon overflow-auto" v-else>                          
                        <div class="table-responsive">
                          <table class="table table-borderless mb-0">
                            <thead>
                              <tr>
                                <th scope="col" class="col-lg-1">                                  
                                </th>                                  
                                <th scope="col" class="col-lg-3">Name</th>                               
                                <th scope="col" class="col-lg-4">Email Address</th>                              
                                <th scope="col" class="col-lg-2"></th>                              
                              </tr>
                            </thead>
                            <tbody tyle="background: #e6ecf9;">
                              <tr v-for="(requested_landlords, index) in requested_landlords" :key="index" style="border-bottom: .4rem solid #f5fafd;">
                                <th scope="row">
                                  <!-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                  </div> -->
                                </th>
                                <!-- <td>
                                  <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td> -->
                                <td>{{ requested_landlords.first_name}} {{requested_landlords.last_name}}</td>
                                <td>{{ requested_landlords.email }}</td>                                                       
                                <td>
                                  <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2" style="width: 8rem; border-radius: .6rem;" data-bs-target="" data-bs-toggle="">
                                    View Details
                                  </button>  
                                  <!-- <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                  </div>                                      -->
                                </td>                               
                              </tr>                                                                        
                            </tbody>
                          </table>
                        </div>                                                      
                      </div>                                                                                      
                  </Tab>                
                  <Tab :isSelected="selected === 'Accepted'">
                    <div class="emptycon d-flex align-items-center justify-content-center" v-if="!accepted_landlords || !accepted_landlords.length">
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4 class="text-primary">Looks like you don’t have any Accepted Tenants</h4>                    
                        </div>                                              
                   </div>                                  
                    <div class="maincon overflow-auto" v-else>                          
                        <div class="table-responsive">
                          <table class="table table-borderless mb-0">
                            <thead>
                              <tr>
                                <th scope="col" class="col-lg-1">                                  
                                </th>                                  
                                <th scope="col" class="col-lg-3">Name</th>                               
                                <th scope="col" class="col-lg-4">Email Address</th>                              
                                <th scope="col" class="col-lg-2"></th>                              
                              </tr>
                            </thead>
                            <tbody style="background: #e6ecf9;">
                              <tr v-for="(accepted_landlords, index) in accepted_landlords" :key="index" style="border-bottom: .4rem solid #f5fafd;">
                                <th scope="row">
                                  <!-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                  </div> -->
                                </th>
                                <!-- <td>
                                  <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td> -->
                                <td>{{ accepted_landlords.first_name}} {{accepted_landlords.last_name}}</td>
                                <td>{{ accepted_landlords.email }}</td>                                                       
                                <td>
                                  <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2" style="width: 8rem; border-radius: .6rem;" data-bs-target="#myModal" data-bs-toggle="modal">
                                    View Details
                                  </button>  
                                  <!-- <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                  </div>                                      -->
                                </td>                               
                              </tr>                                                                        
                            </tbody>
                          </table>
                        </div>                                                      
                      </div>                            
                  </Tab>                
              </TabNav>               
              </div>  
              <div>
                  <button type="submit" class="btn btn-success btn-block"  data-bs-target="#myModal" data-bs-toggle="modal"> + Add Landlord</button>              
              </div>   
              <div class="modal fade" id="myModal" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Enter details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">    
                        <div class="mb-3">
                            <label class="small mb-1" for="hoa_name">Email</label>
                            <input class="form-control" id="hoa_name" type="text"  v-model="email" required>
                        </div>                                                                                                                                                                                        
                        <div class="row gx-3 mb-3">                                                    
                    </div>                                                                                                                                                                                                                                                                                                       
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="copylink()" data-bs-dismiss="modal">Send Link</button>                                                                                                                         
                      </div>
                    </div>
                  </div>
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
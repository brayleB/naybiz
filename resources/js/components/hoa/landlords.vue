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
              <p class="p-medium text-black  mt-5 pt-4">Back | HOA | <r class="p-medium text-primary" to="/register">Landlords</r></p>                  
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
                          <table class="table table-borderless">
                            <thead>
                              <tr>
                                <th scope="col" class="col-lg-1"></th>
                                <th scope="col" class="col-lg-2 text-primary">User</th>         
                                <th scope="col" class="col-lg-3 text-primary">Name</th>                               
                                <th scope="col" class="col-lg-5 text-primary">Email Address</th>                              
                                <th scope="col" class="col-lg-1"></th>      
                              </tr>
                            </thead>
                            <tbody style="background: #e6ecf9;">
                              <tr v-for="(requested_landlords, index) in requested_landlords" :key="index" style="border-bottom: .4rem solid #f5fafd;">
                                <th scope="row">
                                    <!-- <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                    </div> -->
                                </th>
                                <td>
                                  <img v-if="requested_landlords.image!=null" :src="requested_landlords.image" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                  <img v-else src="https://ed-spaces.com/wp-content/uploads/2020/10/default-avatar-profile-icon-vector-18942381.jpg" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td>
                                <td class="pt-3">{{ requested_landlords.first_name}} {{requested_landlords.last_name}}</td>
                                <td class="pt-3">{{ requested_landlords.email }}</td>                                                       
                                <td>
                                  <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2" style="margin-top: 1px; width: 8rem; border-radius: .6rem;" data-bs-target="#myModal" data-bs-toggle="modal">
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
                                  <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                      <div class="modal-content" style="border-radius: .6rem;">
                                        <div class="modal-header border-bottom-0">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Landlord Details</h5>
                                          <button type="button" class="close rounded-circle border-0 px-2 fw-semibold" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">    
                                          <div class="container-fluid overflow-auto">
                                          <div class="row">
                                            <div class="col-lg-2">
                                              <img class="img-account-profile image-responsive rounded-circle" style="height: 120px; width: 120px;" src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png" alt="landlord image">                                                                                                                                                                                                                 
                                            </div>
                                            <!-- <div class="col-lg-12">
                                              <label class="small mb-1 text-light-blue" for="first_name" >Landlord Image</label>
                                            </div> -->
                                              <!-- <label class="small mb-1" for="hoa_name">Email</label>
                                              <input class="form-control" id="hoa_name" type="text"  v-model="email" required> -->
                                              <div class="col-lg-6 my-auto">
                                                <label class="small mb-1 text-light-blue" for="first_name" >Landlord Name</label>
                                                <h5>Firstname Lastname</h5>
                                                <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact Info</label>
                                                <h5>0912-234-5678</h5>
                                              </div>                        
                                          </div>                                                                                                                                                                                        
                                          <div class="row gx-3 mb-5 mt-3">                            
                                          <div class="col-md-12">
                                            <!-- <label class="small mb-1" for="last_name">Landlord Contact Info</label>
                                            <input class="form-control" id="last_name" type="text"  v-model="lastname" required> -->
                                            <!-- <div id="carouselExampleCaptions"> -->
                                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                              <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                  <div class="row">
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Area Size</h5>
                                                            <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="carousel-item">
                                                  <div class="row">
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="carousel-item">
                                                  <div class="row">
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <button class="carousel-control-prev" style="padding-left: .6rem;" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                              </button>
                                              <button class="carousel-control-next" style="padding-left: .85rem;" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                              </button>
                                            </div>
                                            </div>
                                          </div>                                                                                                                                                                                                                                                                                                       
                                        </div>
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
                    <div class="emptycon d-flex align-items-center justify-content-center" v-if="!accepted_landlords || !accepted_landlords.length">
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4 class="text-primary">Looks like you don’t have any Accepted Landlords</h4>                    
                        </div>                                              
                   </div>                                  
                    <div class="maincon overflow-auto" v-else>                          
                        <div class="table-responsive">
                          <table class="table table-borderless">
                            <thead>
                              <tr>
                                <th scope="col" class="col-lg-1"></th>
                                <th scope="col" class="col-lg-2 text-primary">User</th>                                  
                                <th scope="col" class="col-lg-3 text-primary">Name</th>                               
                                <th scope="col" class="col-lg-5 text-primary">Email Address</th>                              
                                <th scope="col" class="col-lg-1"></th>                              
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
                                <td>
                                  <img v-if="requested_landlords.image!=null" :src="requested_landlords.image" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                  <img v-else src="https://ed-spaces.com/wp-content/uploads/2020/10/default-avatar-profile-icon-vector-18942381.jpg" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td>
                                <td class="pt-3">{{ accepted_landlords.first_name}} {{accepted_landlords.last_name}}</td>
                                <td class="pt-3">{{ accepted_landlords.email }}</td>                                                       
                                <td>
                                  <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2" style="margin-top: 1px; width: 8rem; border-radius: .6rem;" data-bs-target="#myModal" data-bs-toggle="modal">
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
                                  </div>
                                  -->
                                  <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                      <div class="modal-content" style="border-radius: .6rem;">
                                        <div class="modal-header border-bottom-0">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Landlord Details</h5>
                                          <button type="button" class="close rounded-circle border-0 px-2 fw-semibold" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">    
                                          <div class="container-fluid overflow-auto">
                                          <div class="row">
                                            <div class="col-lg-2">
                                              <img class="img-account-profile image-responsive rounded-circle" style="height: 120px; width: 120px;" src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png" alt="landlord image">                                                                                                                                                                                                                 
                                            </div>
                                            <!-- <div class="col-lg-12">
                                              <label class="small mb-1 text-light-blue" for="first_name" >Landlord Image</label>
                                            </div> -->
                                              <!-- <label class="small mb-1" for="hoa_name">Email</label>
                                              <input class="form-control" id="hoa_name" type="text"  v-model="email" required> -->
                                              <div class="col-lg-6 my-auto">
                                                <label class="small mb-1 text-light-blue" for="first_name" >Landlord Name</label>
                                                <h5>Firstname Lastname</h5>
                                                <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact Info</label>
                                                <h5>0912-234-5678</h5>
                                              </div>                        
                                          </div>                                                                                                                                                                                        
                                          <div class="row gx-3 mb-5 mt-3">                            
                                          <div class="col-md-12">
                                            <!-- <label class="small mb-1" for="last_name">Landlord Contact Info</label>
                                            <input class="form-control" id="last_name" type="text"  v-model="lastname" required> -->
                                            <!-- <div id="carouselExampleCaptions"> -->
                                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                              <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                  <div class="row">
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Area Size</h5>
                                                            <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="carousel-item">
                                                  <div class="row">
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="carousel-item">
                                                  <div class="row">
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      <div class="card">
                                                        <div class="img-wrapper">
                                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-3" alt="property image">
                                                        </div>
                                                        <div class="card-body">
                                                          <h5 class="card-title">Area Size</h5>
                                                          <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt=""> 9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              <button class="carousel-control-prev" style="padding-left: .6rem;" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                              </button>
                                              <button class="carousel-control-next" style="padding-left: .85rem;" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                              </button>
                                            </div>
                                            </div>
                                          </div>                                                                                                                                                                                                                                                                                                       
                                        </div>
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
              </TabNav>               
              </div>  
              <div>
                  <button type="submit" class="btn btn-success float-end py-2" style="border-radius: .6rem;" data-bs-target="#myModalAdd" data-bs-toggle="modal"><i class="fa fa-plus pe-2"></i>Add Landlord</button>              
              </div>   
              <div class="modal fade" id="myModalAdd" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="border-radius: .6rem;">
                      <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLongTitle">Enter Details</h5>
                        <button type="button" class="close rounded-circle border-0 px-2 fw-semibold" data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">    
                        <div class="mb-3">
                            <label class="small mb-1 text-light-blue" for="hoa_name">Email</label>
                            <input class="form-control" id="hoa_name" type="text"  v-model="email" required>
                        </div>                                                                                                                                                                                        
                        <div class="row gx-3 mb-3">                                                    
                    </div>                                                                                                                                                                                                                                                                                                       
                      </div>
                      <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-primary w-100" style="border-radius: .6rem;" @click="copylink()" data-bs-dismiss="modal">Send Link</button>                                                                                                                         
                      </div>
                    </div>
                  </div>
                </div>          
          </div> 
      </div>
    </div>    
           
    </template>

<style scoped>
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

.carousel-control-prev-icon {
background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%230000FF' viewBox='0 0 14 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
}

.carousel-control-next-icon {
background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%230000FF' viewBox='0 0 14 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
}
.carousel-inner {
  padding: 1em;
}

.card {
  /* margin: 0 0.5em; */
  box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
  border: none;
  border-radius: .6rem;
}

.carousel-control-prev,
.carousel-control-next {
  background-color: #e1e1e1;
  width: 6vh;
  height: 6vh;
  border-radius: 50%;
  top: 50%;
  transform: translateY(-50%);
}

.card .img-wrapper {
    max-width: 100%;
    height: 13em;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card img {
    max-height: 100%;
}

@media (max-width: 767px) {
  .card .img-wrapper {
    height: 17em;
  }
}
</style>
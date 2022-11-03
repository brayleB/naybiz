<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    import {usePropertiesStore} from '../../store/properties'
    import Tabnav from '../tabs/tabnav.vue'
    import {useConstant} from '../../store/constants'
    import {useUserStore} from '../../store/user';
    import {useTenantStore} from '../../store/tenant';

    export default {      
      components: { Sidebar, TabNav, Tab, Tabnav },
      data() {
        return {          
          selected: 'Available',         
          toAdd: false, 
          toView: false,
          imgSrc:'https://images.sampleforms.com/wp-content/uploads/2017/04/9-Sample-House-Rental-Contract-Forms-Free-Sample-Example-Format-Download.jpg',
          name:'',
          address:'',
          description:'',           
          status:'active',
          propertyList:[],
          tenantName:'',
          sendLink:'',
          propertyId:null,
          propertyAddress:'',  
          email:'',
          firstname:'',
          lastname:'',
          tenantName:[]                      
        }
      },
      setup() {
        const propertiesStore = usePropertiesStore()
        const userStore = useUserStore()
        const constantStore = useConstant()
        const tenantStore = useTenantStore()
        return { sidebarWidth, propertiesStore, constantStore, userStore, tenantStore }
      },
      props: {
        isSelected: {
          type: Boolean
        },
      
      },
      methods: {
        setSelected(tab){
          this.selected = tab;
        },
       
        onFile(e) {
          const files = e.target.files
          if (!files.length) return

          const reader = new FileReader()
          reader.readAsDataURL(files[0])
          reader.onload = () => (this.imgSrc = reader.result)
        },
        async createProperty(){         
          this.$swal.fire({
              icon: 'question',
              title: 'Do you want to add property?',   
              showDenyButton: true,                                                                                                                           
              confirmButtonText: 'Yes',
              confirmButtonColor: '#1760E8'                            
          }).then(async (result) => {                      
              if (result.isConfirmed) {               
                await this.propertiesStore.propertyAdd(this.name,this.address,this.description,this.imgSrc,this.status) 
                  if(this.propertiesStore.response['status']==true)
                  {
                      this.$swal.fire({
                          icon: 'success',
                          title: 'Property Added',                                                                                                                                                              
                          confirmButtonText: 'Confirm',
                          confirmButtonColor: '#1760E8'                            
                      }).then(async (result) => { 
                          if (result.isConfirmed) {                                      
                              this.name=""
                              this.address=""
                              this.description="" 
                              location.reload(true)                                                                             
                          }
                      })
                  }                        
              }
          })                     
        },     
        async showProperties(){
          await this.propertiesStore.propertyShow()
          if(this.propertiesStore.response['status']==true){
            this.propertyList = this.propertiesStore.property_list                        
          }
        },
        async getTenantsAccepted(){
          await this.tenantStore.fetchTenantByLandlordIdAccepted()                                                       
        },
        show(id){
          this.propertyAddress = this.propertyList[id]['address'] 
          this.propertyId = this.propertyList[id]['id']        
        },
        sendlink(){   
          this.sendLink = this.constantStore.baseUrl+"tenantapplication?id="+this.userStore.currentUser['id']+'&email='+this.email+'&firstname='+this.firstname+'&lastname='+this.lastname+'&property_add='+this.propertyAddress+'&property_id='+this.propertyId
          let container = this.$refs.container
          this.$copyText(this.sendLink, container)
          this.$swal.fire({
                    icon: 'success',
                    title: 'Link saved to clipboard',   
                    confirmButtonText: 'Confirm',
                    confirmButtonColor: '#1760E8'                            
                    })        
        },
        async getTenantName(id){                
          if(id==null){
            this.tenantName.push('No tenant')                     
          }  
          else{
            await this.tenantStore.getTenantById(id)
            this.tenantName.push(this.tenantStore.response['tenants'][0]['first_name'])
          }                
          console.log(this.tenantName)                      
        }       
      },
      created() {
        this.showProperties()
        this.getTenantsAccepted()
      }
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">
          <div class="homesection container-fluid">
          <div class="row">
            <Sidebar/>    
            <router-view />           
            <div class="col-lg-2 col-xl-4">  
              <p class="p-medium text-black">Back | <r class="p-medium text-primary" to="/register">Properties</r></p>                  
              <h1>Properties</h1>
            </div>
            <div class="col-lg-6 col-xl-12">
            <!-- <button type="button" class="btnadd btn btn-success float-end" @click="toAddState()" v-if="this.toAdd==false">Add properties</button>
            <button type="button" class="btnadd btn btn-success float-end" @click="toAddState()" v-else>Show properties</button> -->
            <TabNav :tabs="['Available', 'Occupied','Add']" :selected="selected" @selected="setSelected" v-if="this.toAdd==false">
                   <Tab :isSelected="selected === 'Available'">                                      
                            <div class="maincon overflow-auto">                          
                                <div class="table-responsive">
                                  <table class="table table-borderless mb-0">
                                    <thead>
                                      <tr>
                                        <th scope="col">                                  
                                        </th>
                                        <th scope="col"></th>
                                        <th scope="col" class="col-lg-3">Property</th>                               
                                        <th scope="col" class="col-lg-4">Address</th>
                                        <th scope="col" class="col-lg-3">Tenant ID</th>
                                        <th scope="col" class="col-lg-1"></th>
                                        <th scope="col" class="col-lg-1"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="(propertyList, index) in propertyList" :key="index">
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1"/>
                                          </div>
                                        </th>
                                        <td>
                                          <img :src="propertyList.image" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>{{ propertyList.name }}</td>
                                        <td>{{ propertyList.address }}</td>
                                        <td>{{ propertyList.tenant_id}}</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3" data-bs-target="#myModal" data-bs-toggle="modal" @click="show(index)">
                                            Add tenant
                                          </button>  
                                          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                  <div class="col-md-6">
                                                      <label class="small mb-1" for="first_name" >First name</label>
                                                      <input class="form-control" id="first_name" type="text"  v-model="firstname" required>
                                                  </div>                          
                                                  <div class="col-md-6">
                                                      <label class="small mb-1" for="last_name">Last name</label>
                                                      <input class="form-control" id="last_name" type="text"  v-model="lastname" required>
                                                  </div>
                                              </div>                                                                                                                                                                                                                                                                                                       
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-primary" @click="sendlink()" data-bs-dismiss="modal">Send Link</button>                                                                                                                         
                                                </div>
                                              </div>
                                            </div>
                                          </div>                                       
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>                                                                        
                                    </tbody>
                                  </table>
                                </div>                                                      
                      </div>                    
                  </Tab>
                  <Tab :isSelected="selected === 'Occupied'">                                      
                            <div class="maincon flex-fill">                          
                               
                                                                                   
                      </div>                    
                  </Tab>
                  <Tab :isSelected="selected === 'Add'">
                    <div class="maincon overflow-auto">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col col-xl-5">                               
                              <label class="small mb-1" for="property_name">Image</label>
                              <input class="form-control mb-3" type="file" @change="onFile" />   
                              <div class="text-center">
                                <img class="img-fluid" :src="imgSrc" v-if="imgSrc" />       
                              </div>                                                                                                                                                                                   
                          </div>
                          <div class="col col-xl-7">
                            <form @submit.prevent="createProperty()">                           
                              <div class="mb-5">
                                  <label class="small mb-1" for="property_name">Property Name / Title</label>
                                  <input class="form-control" id="property_name" type="text"  v-model="name" required>
                              </div>   
                              <div class="mb-5">
                                  <label class="small mb-1" for="hoa_name">Property Address</label>
                                  <input class="form-control" id="hoa_name" type="text"  v-model="address" required>
                              </div>    
                              <div class="mb-5">
                                  <label class="small mb-1" for="hoa_name">Description</label>
                                  <textarea class="form-control" id="hoa_name" type="text"  v-model="description" rows="5" required/>
                              </div>  
                              <!-- <div class="row gx-3 mb-5">                            
                                  <div class="col-md-2">
                                      <label class="small mb-1" for="vcYear" >Price</label>
                                      <input class="form-control" id="vcYear" type="text" v-model="firstname" required>
                                  </div>                                                        
                              </div>                                                                                                           -->
                            <div class="mb-3">
                              <button class="btn btn-primary float-end" type="submit">Add property</button>
                              </div>                                                                                     
                          </form>                            
                          </div>
                        </div>                       
                      </div> 
                    </div>
                  </Tab>                                      
              </TabNav> 
              <!-- <TabNav :tabs="['Add properties','Show existing']" :selected="selectedAdd" @selected="setSelectedAdd" v-else>
                  <Tab :isSelected="selectedAdd === 'Add properties'">
                    <div class="maincon overflow-auto">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col col-xl-5">                               
                              <label class="small mb-1" for="property_name">Image</label>
                              <input class="form-control mb-3" type="file" @change="onFile" />   
                              <div class="text-center">
                                <img class="img-fluid" :src="imgSrc" v-if="imgSrc" />       
                              </div>                                                                                                                                                                                   
                          </div>
                          <div class="col col-xl-7">
                            <form @submit.prevent="tenantApplication">                           
                              <div class="mb-3">
                                  <label class="small mb-1" for="property_name">Property Name / Title</label>
                                  <input class="form-control" id="property_name" type="text"  v-model="property_address" required>
                              </div>   
                              <div class="mb-3">
                                  <label class="small mb-1" for="hoa_name">Property Address</label>
                                  <input class="form-control" id="hoa_name" type="text"  v-model="hoa_name" required>
                              </div>    
                              <div class="mb-3">
                                  <label class="small mb-1" for="hoa_name">Description</label>
                                  <textarea class="form-control" id="hoa_name" type="text"  v-model="hoa_name" rows="5" required/>
                              </div>  
                              <div class="row gx-3 mb-5">                            
                                  <div class="col-md-2">
                                      <label class="small mb-1" for="vcYear" >Price</label>
                                      <input class="form-control" id="vcYear" type="text" v-model="firstname" required>
                                  </div>                                                        
                              </div>                                                                                                          
                            <div class="mb-3">
                              <button class="btn btn-primary float-end" type="submit">Add property</button>
                              </div>                                                                                     
                          </form>
                            
                          </div>
                        </div>                       
                      </div> 
                    </div>
                  </Tab>              
                <Tab :isSelected="selectedAdd === 'Show existing'">
                  <div class="maincon overflow-auto">    
                      <div class="row row-cols-1 row-cols-md-4 g-5 mb-5" v-if="this.toView==false">
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/044.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link" @click="toViewState()">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/043.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-95">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp"  class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                          <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                      </div>                                                                 
                      <div class="container-fluid" v-else>
                        <div class="row">
                          <div class="col col-xl-10">                           
                            <h1>120sqm Propery Lorem Ipsum</h1>
                            <p>9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>                                                        
                            <div class="d-flex align-items-stretch">                             
                              <span class="align-middle">
                                <img src="http://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(58).jpg" class="user-img img-responsive" style="height: 60px;" alt="Avatar" />
                                <text class="name">Jenn Jett Ford </text>
                                <text class="role">(Tenant)</text>
                              </span>                           
                            </div>                                                                  
                          </div>    
                          <div class="col col-xl-2">
                            <button type="button" class="btn btn-success float-end">Add to List</button>
                          </div>                      
                        </div>    
                         <div class="property row">
                          <div class="col col-sm-12 col-xl-5">  
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="property-img img-fluid" alt="Avatar" />                                                                                                                 
                          </div> 
                          <div class="col col-sm-12 col-xl-7">  
                            <p class="description">Duis eget ultricies nisi. Curabitur maximus odio et ex aliquam, eu tempus augue suscipit. Vestibulum vehicula tortor id quam fringilla fermentum. Fusce lobortis dui quam, eu condimentum turpis mattis eget. Sed eleifend, turpis ac hendrerit dictum, ipsum erat imperdiet lectus, vel imperdiet justo augue ut diam. Ut vel ante nec arcu pulvinar viverra eu ut enim. Cras eleifend elit eget nisi hendrerit, vitae accumsan tellus facilisis. Etiam congue rutrum orci, vitae luctus lacus vulputate sit amet. Duis cursus tortor sed ipsum laoreet tempor. Ut eget dui ultrices, hendrerit nisi quis, mollis dui. Mauris quis velit porta, ornare leo id, convallis dui. Aenean luctus lacus non commodo accumsan. Nulla laoreet nibh at interdum pharetra. Aenean rutrum mattis neque quis vulputate. Aenean eget dapibus orci, eu placerat augue.</p>                                                                                                                                     
                            <text class="price float-end">$203.00</text>                           
                          </div>                           
                        </div>                     
                      </div>                                                                                 
                    </div>      
                </Tab>
              </TabNav> -->
              </div>             
          </div> 
      </div>
    </div>
       
    
    </template>
    
<style>
.name {
  color:black;
  margin-left: .5rem;
  font-weight: 600;
	font-size: 1.5rem;
  vertical-align:middle;
}
.role {  
  vertical-align:middle;
}
.description{
  color:black;
}
.property {
  margin-top: 1.5rem;
  margin-bottom: 2.5rem;
}
.user-img {
  border-radius: 0.25rem;
}
.property-img {
  border-radius: 0.5rem;
}
.price {
  color:rgb(25, 79, 255);
  margin-left: .5rem;
  font-weight: 600;
	font-size: 3.5rem;
}
.btnadd{
  margin-right: 1rem;
  border-radius: 0.5rem;
}
</style>
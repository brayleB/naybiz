<script>
  import Sidebar from '../sidebar/sidebar.vue'
  import { sidebarWidth } from '../sidebar/state.js'
  import Tab from '../tabs/tab.vue'
  import TabNav from '../tabs/tabnav.vue'
  import { usePropertiesStore } from '../../store/properties'
  import Tabnav from '../tabs/tabnav.vue'
  import { useConstant } from '../../store/constants'
  import { useUserStore } from '../../store/user';
  import { useTenantStore } from '../../store/tenant';

  export default {
    components: { Sidebar, TabNav, Tab, Tabnav },
    data() {
      return {
        selected: 'Properties',
        toAdd: false,
        toView: false,
        imgSrc: '',
        name: '',
        stAdd: '',
        unitNum: '',
        city: '',
        state: '',
        zipCode: '',
        description: 'No Description',
        status: 'active',
        propertyList: [],
        tenantName: '',
        sendLink: '',
        propertyId: null,
        propertyAddress: '',
        email: '',
        firstname: '',
        lastname: '',
        tenantList: [],
        imgData: null
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
      // async checkLoggedIn() {    
      //     await this.userStore.fetchUser()             
      //     if(this.userStore.error==true){ 
      //       this.$router.push('/login')  
      //     }          
      // } ,
      setSelected(tab) {
        this.selected = tab;
      },

      onFile(e) {
        this.imgData = e.target.files[0]
        const files = e.target.files
        if (!files.length) return

        const reader = new FileReader()
        reader.readAsDataURL(files[0])
        reader.onload = () => (this.imgSrc = reader.result)
      },
      async createProperty() {
        this.$swal.fire({
          imageUrl: "https://naybiz.com/users/questions-icon.png",
          title: "<h1 class='text-primary'>Property</h1>",
          text: 'Do you really want to add this property',
          color: 'black',
          showDenyButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#0066ff'
        }).then(async (result) => {
          if (result.isConfirmed) {
            var address = this.unitNum + ' ' + this.stAdd + ', ' + this.city + ', ' + this.state + ' ' + this.zipCode
            await this.propertiesStore.propertyAdd(this.name, address, this.description, this.imgData, this.status)
            if (this.propertiesStore.response['status'] == true) {
              this.$swal.fire({
                imageUrl: "https://naybiz.com/users/success-icon.png",
                title: "<h1 class='text-primary'>Property</h1>",
                text: 'Successfully added',
                color: 'black',
                confirmButtonText: 'Confirm',
                confirmButtonColor: '#0066ff'
              }).then(async (result) => {
                if (result.isConfirmed) {
                  this.$router.go(this.$router.currentRoute)
                  this.name = ""
                  this.address = ""
                  this.description = ""
                }
              })
            }
          }
        })
      },
      async showProperties() {
        await this.propertiesStore.propertyShow()
        if (this.propertiesStore.response['status'] == true) {
          this.propertyList = this.propertiesStore.property_list
        }
      },
      async getTenantsAccepted() {
        await this.tenantStore.fetchTenantByLandlordIdAccepted()
      },
      show(id) {
        this.propertyAddress = this.propertyList[id]['address']
        this.propertyId = this.propertyList[id]['id']
      },
      async sendlink() {
        this.sendLink = this.constantStore.baseUrl + "tenantapplication?id=" + this.userStore.currentUser['id'] + '&email=' + this.email + '&firstname=' + this.firstname + '&lastname=' + this.lastname + '&property_add=' + this.propertyAddress + '&property_id=' + this.propertyId + '&hoa_id=' + this.userStore.currentUser['assoc_hoa_id']
        let container = this.$refs.container
        this.$copyText(this.sendLink, container)
        await this.tenantStore.inviteTenant(this.email, this.firstname, this.lastname, this.sendLink)
        if (this.tenantStore.response['status'] == true) {
          this.$swal.fire({
            imageUrl: "https://naybiz.com/users/success-icon.png",
            title: "<h1 class='text-primary'>Landlord Application</h1>",
            text: 'Email has been sent',
            color: 'black',
            confirmButtonText: 'Confirm',
            confirmButtonColor: '#0066ff'
          })
        }
      },
      async getTenantsAll() {
        await this.tenantStore.fetchTenantByLandlordId()
        if (this.tenantStore.response['status'] == true) {
          this.tenantList = this.tenantStore.response['tenants']
        }
      },
      getTenantName: function (id) {
        if (id == null) {
          return '-';
        }
        else {
          var name = ''
          for (var i = 0; i < this.tenantList.length; i++) {
            if (id == this.tenantList[i]['id']) {
              name = this.tenantList[i]['first_name'] + ' ' + this.tenantList[i]['last_name']
            }
          }
          return name;
        }
      },
      getTenantContact: function (id) {
        if (id == null) {
          return '-';
        }
        else {
          var contact = ''
          for (var i = 0; i < this.tenantList.length; i++) {
            if (id == this.tenantList[i]['id']) {
              contact = this.tenantList[i]['contact_no']
            }
          }
          return contact;
        }
      },
      async deleteProperty(id) {
        this.$swal.fire({
          imageUrl: "https://naybiz.com/users/questions-icon.png",
          title: "<h1 class='text-primary'>Property</h1>",
          text: 'Do you really want to remove this property?',
          color: 'black',
          showDenyButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#0066ff'
        }).then(async (result) => {
          if (result.isConfirmed) {
            await this.propertiesStore.deleteProperty(id)
            this.$router.push('/landlord/tenants')
          }
        })
      },
      async removeTenant(id) {
        this.$swal.fire({
          imageUrl: "https://naybiz.com/users/questions-icon.png",
          title: "<h1 class='text-primary'>Property</h1>",
          text: 'Do you want to remove tenant to this Property?',
          color: 'black',
          showDenyButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#0066ff'
        }).then(async (result) => {
          if (result.isConfirmed) {
            await this.propertiesStore.clearTenant(id)
            this.$router.go(this.$router.currentRoute)
          }
        })
      },
    },
    created() {
      this.showProperties()
      this.getTenantsAccepted()
      // this.checkLoggedIn()
      this.getTenantsAll()
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
          <p class="p-medium text-black mt-5 pt-4">Back | Landlord |<r class="p-medium text-primary" to="/register">
              Properties</r>
          </p>
          <h1 class="mt-5">Properties</h1>
        </div>
        <div class="col-lg-12 col-xl-12">
          <!-- <button type="button" class="btnadd btn btn-success float-end" @click="toAddState()" v-if="this.toAdd==false">Add properties</button>
            <button type="button" class="btnadd btn btn-success float-end" @click="toAddState()" v-else>Show properties</button> -->
          <TabNav :tabs="['Properties','Add']" :selected="selected" @selected="setSelected" v-if="this.toAdd==false">
            <Tab :isSelected="selected === 'Properties'">
              <div v-if="constantStore.loader==true">
                <div class="emptycon d-flex align-items-center justify-content-center">
                  <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div>
              <div v-else>
                <div class="emptycon d-flex align-items-center justify-content-center"
                  v-if="!propertyList || !propertyList.length">
                  <div class="center-block text-center">
                    <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                    <h4 class="text-primary">Looks like you don???t have any Property</h4>
                  </div>
                </div>
                <div class="maincon overflow-auto" v-else>
                  <div class="table-responsive">
                    <table class="table table-borderless table-hover mb-0">
                      <thead>
                        <tr>
                          <th scope="col"></th>
                          <th scope="col" class="col-lg-1"></th>
                          <th scope="col" class="col-lg-5 text-primary">Address</th>
                          <th scope="col" class="col-lg-2 text-primary">Tenant Name</th>
                          <th scope="col" class="col-lg-2 text-primary">Contact Info</th>
                          <th scope="col" class="col-lg-2"></th>
                        </tr>
                      </thead>
                      <tbody style="background: #e6ecf9;">
                        <tr v-for="(propertyList, index) in propertyList" :key="index"
                          style="border-bottom: .4rem solid #f5fafd;">
                          <th scope="row" class="ps-3" style="padding-top: .9rem;">
                            {{ index + 1 }}.
                          </th>
                          <td style="padding-top: .8rem;">
                            <img :src='this.constantStore.baseUrl+propertyList.image' class="img-responsive"
                              style="width: 45px;" alt="Avatar" />
                          </td>
                          <td style="padding-top: .8rem;">{{ propertyList.address }}</td>
                          <td style="padding-top: .8rem;">{{ getTenantName(propertyList.tenant_id)}}</td>
                          <td style="padding-top: .8rem;">{{ getTenantContact(propertyList.tenant_id) }}</td>
                          <td v-if="propertyList.tenant_id==null">
                            <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2"
                              style="width: 7rem; border-radius: .6rem;" data-bs-target="#myModal"
                              data-bs-toggle="modal" @click="show(index)">
                              Add tenant
                            </button>
                            <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
                              aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" style="border-radius: .6rem;">
                                  <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Enter Details</h5>
                                    <button type="button" class="close rounded-circle border-0 px-2 fw-semibold"
                                      data-bs-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="mb-3">
                                      <label class="small mb-1 text-light-blue" for="hoa_name">Email</label>
                                      <input class="form-control" id="hoa_name" type="text" v-model="email" required>
                                    </div>
                                    <div class="row gx-3 mb-3">
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="first_name">First name</label>
                                        <input class="form-control" id="first_name" type="text" v-model="firstname"
                                          required>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="last_name">Last name</label>
                                        <input class="form-control" id="last_name" type="text" v-model="lastname"
                                          required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-primary w-100" style="border-radius: .6rem;"
                                      @click="sendlink()" data-bs-dismiss="modal">Send Link</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td v-else>
                            <button type="button" @click="removeTenant(propertyList.id)"
                              class="btn-2 btn btn-sm px-3 py-2 text-white"
                              style="background: #FF4C4C; border-radius: .6rem;">
                              Clear Tenant
                            </button>
                          </td>
                          <td v-if="propertyList.tenant_id==null">
                            <button type="button" @click="deleteProperty(propertyList.id)"
                              class="btn-2 btn btn-sm px-3 py-2 text-white"
                              style="background: #FF4C4C; border-radius: .6rem;">
                              <i class="fas fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </Tab>
            <form @submit.prevent="createProperty()">
              <Tab :isSelected="selected === 'Add'">
                <div class="maincon overflow-auto">
                  <div class="container-fluid">
                    <div class="row py-4">
                      <div class="col col-xl-7 col-lg-8 col-md-12 mx-auto">
                        <!-- <label class="form-label" for="customFile">Default file input example</label>                          
                              <input class="form-control mb-3" type="file" id="customFile" @change="onFile" />   
                              <div class="text-center">
                                <img class="img-fluid" :src="imgSrc" v-if="imgSrc" />       
                              </div>  -->
                        <label class="small mb-1 text-light-blue" for="property_name">Property Image</label>
                        <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                          <input id="upload" type="file" @change="onFile" class="form-control border-0" required>
                          <label id="upload-label" for="upload" class="font-weight-light text-muted"
                            style="max-width: 17rem;">Max Size (8 mb),
                            Type (jpg, jpeg, png)</label>
                          <div class="input-group-append my-auto">
                            <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                              <i class="fa fa-cloud-upload-alt mr-2 text-muted"></i><small
                                class="text-uppercase font-weight-bold text-muted fw-semibold"> Choose
                                file</small></label>
                          </div>
                        </div>
                        <!-- Uploaded image area-->
                        <div class="image-area">
                          <img id="imageResult" :src="imgSrc" v-if="imgSrc" alt="upload image"
                            class="img-fluid rounded shadow-sm mx-auto d-block">
                          <img id="imageResult" src="../../../images/default-image.png" v-else alt="upload image"
                            class="img-fluid rounded shadow-sm mx-auto d-block">
                        </div>

                      </div>
                      <div class="col col-xl-5 col-lg-4 col-md-12 mt-1">
                        <div class="mb-4">
                          <label class="small mb-1 text-light-blue" for="property_name">Street Address</label>
                          <input class="form-control" id="property_name" type="text" v-model="stAdd" required>
                        </div>
                        <div class="mb-4">
                          <label class="small mb-1 text-light-blue" for="hoa_name">Unit Number</label>
                          <input class="form-control" id="hoa_name" type="text" v-model="unitNum">
                        </div>
                        <div class="mb-4">
                          <label class="small mb-1 text-light-blue" for="hoa_name">City</label>
                          <input class="form-control" id="hoa_name" type="text" v-model="city" rows="5" required />
                        </div>
                        <div class="mb-4">
                          <label class="small mb-1 text-light-blue" for="property_name">State</label>
                          <input class="form-control" id="property_name" type="text" v-model="state" required>
                        </div>
                        <div class="mb-4">
                          <label class="small mb-1 text-light-blue" for="hoa_name">Zip Code</label>
                          <input class="form-control" id="hoa_name" type="text" v-model="zipCode" required>
                        </div>
                        <div class="mb-4">
                          <label class="small mb-1 text-light-blue" for="hoa_name">HOA Name</label>
                          <input class="form-control" id="hoa_name" type="text" v-model="name" required />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </Tab>
              <div class="mt-2" v-if="selected=='Add'">
                <button class="btn btn-success float-end py-2" style="border-radius: .6rem;" type="submit"><i
                    class="fa fa-plus pe-2"></i>Add Property</button>
              </div>
            </form>
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
  #upload {
    opacity: 0;
  }

  #upload-label {
    position: absolute;
    top: 50%;
    left: 1rem;
    transform: translateY(-50%);
  }

  .image-area {
    border: 2px dashed rgba(156, 156, 156, 0.7);
    padding: 1rem;
    position: relative;
  }

  .image-area::before {
    content: 'Uploaded image result';
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.8rem;
    z-index: 1;
  }

  .image-area img {
    z-index: 2;
    position: relative;
  }

  .name {
    color: black;
    margin-left: .5rem;
    font-weight: 600;
    font-size: 1.5rem;
    vertical-align: middle;
  }

  .role {
    vertical-align: middle;
  }

  .description {
    color: black;
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
    color: rgb(25, 79, 255);
    margin-left: .5rem;
    font-weight: 600;
    font-size: 3.5rem;
  }

  .btnadd {
    margin-right: 1rem;
    border-radius: 0.5rem;
  }
</style>
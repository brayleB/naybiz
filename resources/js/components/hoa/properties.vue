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
        selected: 'Available',
        toAdd: false,
        toView: false,
        imgSrc: 'https://images.sampleforms.com/wp-content/uploads/2017/04/9-Sample-House-Rental-Contract-Forms-Free-Sample-Example-Format-Download.jpg',
        name: '',
        address: '',
        description: '',
        status: 'active',
        propertyAvailableList: [],
        propertyOccupiedList: [],
        tenantName: '',
        sendLink: '',
        propertyId: null,
        propertyAddress: '',
        email: '',
        firstname: '',
        lastname: '',
        tenantName: [],
        viewLLFname:'',
        viewLLLname:'',
        viewLLContact:'',
        viewProImage:'',
        viewProAddress:''
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
      async checkLoggedIn() {
        await this.userStore.fetchUser()
        if (this.userStore.hasError == true) {
          this.$router.push('/login')
        }
      },
      setSelected(tab) {
        this.selected = tab;
      },

      onFile(e) {
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
          text: 'Do you really want to add this property?',
          color: 'black',
          showDenyButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#0066ff'
        }).then(async (result) => {
          if (result.isConfirmed) {
            await this.propertiesStore.propertyAdd(this.name, this.address, this.description, this.imgSrc, this.status)
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
                  this.name = ""
                  this.address = ""
                  this.description = ""
                  location.reload(true)
                }
              })
            }
          }
        })
      },
      async showAvailableProperties() {
        await this.propertiesStore.getPropertiesByHOAIdAvailable()
        if (this.propertiesStore.response['status'] == true) {
          this.propertyAvailableList = this.propertiesStore.response['properties']
        }
      },
      async showOccupiedProperties() {
        await this.propertiesStore.getPropertiesByHOAIdOccupied()
        if (this.propertiesStore.response['status'] == true) {
          this.propertyOccupiedList = this.propertiesStore.response['properties']
        }
      },
      async getTenantsAccepted() {
        await this.tenantStore.fetchTenantByLandlordIdAccepted()
      },
      show(id) {
        this.propertyAddress = this.propertyList[id]['address']
        this.propertyId = this.propertyList[id]['id']
      },
      sendlink() {
        this.sendLink = this.constantStore.baseUrl + "tenantapplication?id=" + this.userStore.currentUser['id'] + '&email=' + this.email + '&firstname=' + this.firstname + '&lastname=' + this.lastname + '&property_add=' + this.propertyAddress + '&property_id=' + this.propertyId
        let container = this.$refs.container
        this.$copyText(this.sendLink, container)
        this.$swal.fire({
          title: "<h1 class='text-primary'>Success</h1>",
          title: 'Link saved to clipboard',
          confirmButtonText: 'Confirm',
          confirmButtonColor: '#1760E8'
        })
      },
      async getTenantName(id) {
        if (id == null) {
          this.tenantName.push('No tenant')
        }
        else {
          await this.tenantStore.getTenantById(id)
          this.tenantName.push(this.tenantStore.response['tenants'][0]['first_name'])
        }
        console.log(this.tenantName)
      },
      async propertyView(id) {
        await this.propertiesStore.propertyView(id)
        if(this.propertiesStore.response['status']==true)
        {
          this.viewLLFname = this.propertiesStore.response['landlord']['first_name']
          this.viewLLLname = this.propertiesStore.response['landlord']['last_name']
          this.viewLLContact = this.propertiesStore.response['landlord']['contact_no']
          this.viewProImage = this.propertiesStore.response['property']['image']
          this.viewProAddress = this.propertiesStore.response['property']['address']
          if(this.propertiesStore.response['landlord']['first_name'] == null && this.propertiesStore.response['landlord']['last_name'] == null){
            this.viewLLFname = 'No'
            this.viewLLLname = 'Data'
          }
          if(this.propertiesStore.response['landlord']['contact_no'] == null){
            this.viewLLContact  = 'No Data'
          }         
        }
      },
    },

    created() {
      this.checkLoggedIn()
      this.showAvailableProperties()
      this.showOccupiedProperties()
      this.getTenantsAccepted()
    },
  }
</script>
<template>
  <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">
    <div class="homesection container-fluid">
      <div class="row">
        <Sidebar />
        <router-view />
        <div class="col-lg-4 col-xl-4">
          <p class="p-medium text-black  mt-5 pt-4">Back | HOA | <r class="p-medium text-primary" to="/register">
              Properties</r>
          </p>
          <h1 class="mt-5">Properties</h1>
        </div>
        <div class="col-lg-12 col-xl-12">
          <TabNav :tabs="['Available', 'Occupied']" :selected="selected" @selected="setSelected"
            v-if="this.toAdd==false">
            <Tab :isSelected="selected === 'Available'">
              <div class="maincon overflow-auto">
                <div class="table-responsive">
                  <table class="table table-borderless mb-0">
                    <thead>
                      <tr>
                        <th scope="col" class="col-lg-1"></th>
                        <th scope="col" class="col-lg-1"></th>
                        <th scope="col" class="col-lg-3 text-primary">Property</th>
                        <th scope="col" class="col-lg-4 text-primary">Address</th>
                        <th scope="col" class="col-lg-2"></th>
                      </tr>
                    </thead>
                    <tbody style="background: #e6ecf9;">
                      <tr v-for="(propertyAvailableList, index) in propertyAvailableList" :key="index"
                        style="border-bottom: .4rem solid #f5fafd;">
                        <th scope="row">
                          <!-- <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1"/>
                                        </div> -->
                        </th>
                        <td style="padding-top: 13px;">
                          <img :src="this.constantStore.baseUrl+propertyAvailableList.image" class="img-responsive"
                            style="width: 45px;" alt="Avatar" />
                        </td>
                        <td style="padding-top: 13px;">{{ propertyAvailableList.name }}</td>
                        <td style="padding-top: 13px;">{{ propertyAvailableList.address }}</td>
                        <td style="padding-top: 13px;">{{ propertyAvailableList.tenant_id}}</td>
                        <td>
                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2"
                            style="width: 8rem; border-radius: .6rem;" data-bs-target="#myModal" data-bs-toggle="modal" @click="propertyView(propertyAvailableList.id)">
                            View Details
                          </button>
                          <!-- <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                              <div class="modal-content" style="border-radius: .6rem;">
                                <div class="modal-header border-bottom-0">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Landlord Details</h5>
                                  <button type="button" class="close rounded-circle border-0 px-2 fw-semibold"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="container-fluid overflow-auto">
                                    <div class="row">
                                      <div class="col-lg-2">
                                        <img class="img-account-profile image-responsive rounded-circle"
                                          style="height: 120px; width: 120px;"
                                          src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png"
                                          alt="landlord image">
                                      </div>
                                      <div class="col-lg-6 my-auto">
                                        <label class="small mb-1 text-light-blue" for="first_name">Landlord Name</label>
                                        <h5>Firstname Lastname</h5>
                                        <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact
                                          Info</label>
                                        <h5>0912-234-5678</h5>
                                      </div>
                                    </div>
                                    <div class="row gx-3 mb-5 mt-3">
                                      <div class="col-md-12">
                                        <div id="carouselExampleCaptions">
                                          <div id="carouselExampleControls" class="carousel slide"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                              <div class="carousel-item active">
                                                <div class="row">
                                                  <div class="col-md-4">
                                                    <div class="card">
                                                      <div class="img-wrapper">
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="card">
                                                      <div class="img-wrapper">
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="card">
                                                      <div class="img-wrapper">
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
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
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="card">
                                                      <div class="img-wrapper">
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="card">
                                                      <div class="img-wrapper">
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
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
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="card">
                                                      <div class="img-wrapper">
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="card">
                                                      <div class="img-wrapper">
                                                        <img src="../../../images/houses1.jpg"
                                                          class="d-block w-100 rounded-3" alt="property image">
                                                      </div>
                                                      <div class="card-body">
                                                        <h5 class="card-title">Area Size</h5>
                                                        <p class="card-text p-small"><img
                                                            src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                          Drive, Jacksonville Beach, FL 32250</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <button class="carousel-control-prev" style="padding-left: .6rem;"
                                              type="button" data-bs-target="#carouselExampleControls"
                                              data-bs-slide="prev">
                                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                              <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" style="padding-left: .85rem;"
                                              type="button" data-bs-target="#carouselExampleControls"
                                              data-bs-slide="next">
                                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                              <span class="visually-hidden">Next</span>
                                            </button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" @click="sendlink()"
                                      data-bs-dismiss="modal">Send Link</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div> -->
                          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                              <div class="modal-content" style="border-radius: .6rem;">
                                <div class="modal-header border-bottom-0">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Landlord Details</h5>
                                  <button type="button" class="close rounded-circle border-0 px-2 fw-semibold"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="container-fluid overflow-auto">
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <img class="img-account-profile image-responsive rounded-circle"
                                          style="height: 120px; width: 120px;"
                                          src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png"
                                          alt="landlord image">
                                      </div>
                                      <div class="col-lg-6 my-auto">
                                        <label class="small mb-1 text-light-blue" for="first_name">Landlord Name</label>
                                        <h5>{{ viewLLFname }} {{ viewLLLname }}</h5>
                                        <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact
                                          Info</label>
                                        <h5>{{ viewLLContact }}</h5>
                                      </div>
                                    </div>
                                    <div class="row gx-3 mb-5 mt-3">
                                      <div class="col-md-12">
                                        <div class="img-wrapper">
                                          <img :src="this.constantStore.baseUrl+viewProImage" class="d-block w-100 rounded-4 mt-4"
                                            alt="property image">
                                        </div>
                                      </div>
                                      <div class="col-md-12" style="margin-bottom: -1.6rem;">
                                        <div class="card mt-3 rounded-4 border border-3 border-primary">
                                          <div class="card-body">                                        
                                            <p class="card-text p-medium"><img src="../../../images/map-pin.svg" alt="">
                                            {{ viewProAddress }}</p>
                                          </div>
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
            <Tab :isSelected="selected === 'Occupied'">
              <div class="maincon overflow-auto">
                <div class="table-responsive">
                  <table class="table table-borderless mb-0">
                    <thead>
                      <tr>
                        <th scope="col" class="col-lg-1"></th>
                        <th scope="col" class="col-lg-1"></th>
                        <th scope="col" class="col-lg-3 text-primary">Property</th>
                        <th scope="col" class="col-lg-4 text-primary">Address</th>
                        <th scope="col" class="col-lg-2 text-primary">Tenant ID</th>
                      </tr>
                    </thead>
                    <tbody style="background: #e6ecf9;">
                      <tr v-for="(propertyOccupiedList, index) in propertyOccupiedList" :key="index"
                        style="border-bottom: .4rem solid #f5fafd;">
                        <th scope="row">
                          <!-- <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1"/>
                                        </div> -->
                        </th>
                        <td style="padding-top: 13px;">
                          <img :src="this.constantStore.baseUrl+propertyOccupiedList.image" class="img-responsive"
                            style="width: 45px;" alt="Avatar" />
                        </td>
                        <td style="padding-top: 13px;">{{ propertyOccupiedList.name }}</td>
                        <td style="padding-top: 13px;">{{ propertyOccupiedList.address }}</td>
                        <td style="padding-top: 13px;">{{ propertyOccupiedList.tenant_id}}</td>
                        <td>
                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2 me-0"
                            style="width: 8rem; border-radius: .6rem;" data-bs-target="#myModal" data-bs-toggle="modal">
                            View Details
                          </button>
                          <!-- <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                              <div class="modal-content" style="border-radius: .6rem;">
                                <div class="modal-header border-bottom-0">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Landlord Details</h5>
                                  <button type="button" class="close rounded-circle border-0 px-2 fw-semibold"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="container-fluid overflow-auto">
                                    <div class="row">
                                      <div class="col-lg-2">
                                        <img class="img-account-profile image-responsive rounded-circle"
                                          style="height: 120px; width: 120px;"
                                          src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png"
                                          alt="landlord image">
                                      </div>
                                      <div class="col-lg-6 my-auto">
                                        <label class="small mb-1 text-light-blue" for="first_name">Landlord Name</label>
                                        <h5>Firstname Lastname</h5>
                                        <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact
                                          Info</label>
                                        <h5>0912-234-5678</h5>
                                      </div>
                                    </div>
                                    <div class="row gx-3 mb-5 mt-3">
                                      <div class="col-md-12">
                                        <div id="carouselExampleControls" class="carousel slide"
                                          data-bs-ride="carousel">
                                          <div class="carousel-inner">
                                            <div class="carousel-item active">
                                              <div class="row">
                                                <div class="col-md-4">
                                                  <div class="card">
                                                    <div class="img-wrapper">
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                  <div class="card">
                                                    <div class="img-wrapper">
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                  <div class="card">
                                                    <div class="img-wrapper">
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
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
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                  <div class="card">
                                                    <div class="img-wrapper">
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                  <div class="card">
                                                    <div class="img-wrapper">
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
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
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                  <div class="card">
                                                    <div class="img-wrapper">
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-md-4">
                                                  <div class="card">
                                                    <div class="img-wrapper">
                                                      <img src="../../../images/houses1.jpg"
                                                        class="d-block w-100 rounded-3" alt="property image">
                                                    </div>
                                                    <div class="card-body">
                                                      <h5 class="card-title">Area Size</h5>
                                                      <p class="card-text p-small"><img
                                                          src="../../../images/map-pin.svg" alt=""> 9463 North Euclid
                                                        Drive, Jacksonville Beach, FL 32250</p>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <button class="carousel-control-prev" style="padding-left: .6rem;"
                                            type="button" data-bs-target="#carouselExampleControls"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                          </button>
                                          <button class="carousel-control-next" style="padding-left: .85rem;"
                                            type="button" data-bs-target="#carouselExampleControls"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card mb-4" style="margin-top: -2rem;">
                                      <div class="row" style="margin-top: -2rem;">
                                        <div class="col-md-6">
                                          <div class="card-header"><label class="small mb-1 text-light-blue"
                                              for="first_name">Tenant Name</label></div>
                                          <div class="card-body">
                                            <p class="card-text">Firstname Lastname</p>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="card-header"><label class="small mb-1 text-light-blue"
                                              for="first_name">Tenant Contact Info</label></div>
                                          <div class="card-body">
                                            <p class="card-text">0912-234-5678</p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div> -->

                          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                              <div class="modal-content" style="border-radius: .6rem;">
                                <div class="modal-header border-bottom-0">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Landlord Details</h5>
                                  <button type="button" class="close rounded-circle border-0 px-2 fw-semibold"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="container-fluid overflow-auto">
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <img class="img-account-profile image-responsive rounded-circle"
                                          style="height: 120px; width: 120px;"
                                          src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png"
                                          alt="landlord image">
                                      </div>
                                      <div class="col-lg-6 my-auto">
                                        <label class="small mb-1 text-light-blue" for="first_name">Landlord Name</label>
                                        <h5>Firstname Lastname</h5>
                                        <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact
                                          Info</label>
                                        <h5>0912-234-5678</h5>
                                      </div>
                                    </div>
                                    <div class="row gx-3 mb-5 mt-3">
                                      <div class="col-md-12">
                                        <div class="img-wrapper">
                                          <img src="../../../images/houses1.jpg" class="d-block w-100 rounded-4 mt-4"
                                            alt="property image">
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="card mt-3 rounded-4 border border-3 border-primary">
                                          <div class="card-body">
                                            <h5 class="card-title">Area Size</h5>
                                            <p class="card-text p-small"><img src="../../../images/map-pin.svg" alt="">
                                              9463 North Euclid
                                              Drive, Jacksonville Beach, FL 32250</p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card mb-4 rounded-4 border border-3 border-primary"  style="margin-top: -2rem;">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="card-header"><label class="small mb-1 text-light-blue"
                                              for="first_name">Tenant Name</label></div>
                                          <div class="card-body">
                                            <p class="card-text fw-semibold">Firstname Lastname</p>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="card-header"><label class="small mb-1 text-light-blue"
                                              for="tenant_contact_info">Tenant Contact Info</label></div>
                                          <div class="card-body">
                                            <p class="card-text fw-semibold">0912-234-5678</p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" @click="sendlink()" data-bs-dismiss="modal">Send Link</button>                                                                                                                         
                                              </div> -->
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

<style scoped>
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

  .carousel-control-prev-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%230000FF' viewBox='0 0 14 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
  }

  .carousel-control-next-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%230000FF' viewBox='0 0 14 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
  }

  /* .carousel-inner {
border: 1.3rem solid #ffffff;
box-shadow: 0px 0px 0px 2px rgba(233, 231, 231, 0.75);
}

.carousel-info {
margin-top: 1rem;
} */

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
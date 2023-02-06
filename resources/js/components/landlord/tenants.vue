<script>
  import Sidebar from '../sidebar/sidebar.vue'
  import { sidebarWidth } from '../sidebar/state.js'
  import Tab from '../tabs/tab.vue'
  import TabNav from '../tabs/tabnav.vue'
  import { useTenantStore } from '../../store/tenant';
  import { useUserStore } from '../../store/user';
  import { usePropertiesStore } from '../../store/properties';
  import { useConstant } from '../../store/constants'
  import Landlord from '../hoa/landlords.vue'

  export default {
    components: { Sidebar, TabNav, Tab, Landlord },
    data() {
      return {
        occupantList: [],
        vehicleList: [],
        selected: 'Request',
        tenants_accepted: [],
        tenants_requested: [],
        tenant_view: {},
        showAdd: false,
        tempId: null,
        indexId: null,
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
      setSelected(tab) {
        this.selected = tab;
      },
      // async getTenants(){
      //   await this.tenantStore.fetchTenantByLandlordId()          
      //   this.tenants_list_new = this.tenantStore.tenants  
      //   this.tenantapplicationlink = this.constantStore.baseUrl+"tenantapplication?id="+this.userStore.currentUser['id']         
      //   this.tenantquizlink = this.constantStore.baseUrl+"tenantquiz?id="+this.userStore.currentUser['id']                         
      // },
      async getTenantsAccepted() {
        await this.tenantStore.fetchTenantByLandlordIdAccepted()
        this.tenants_accepted = this.tenantStore.acceptedTenants
        this.constantStore.loader = false
      },
      async getTenantsRequested() {
        await this.tenantStore.fetchTenantByLandlordIdRequested()
        this.tenants_requested = this.tenantStore.requestedTenants
      },
      showRequested(id) {
        this.indexId = id
        this.tempId = this.tenants_requested[id]['id']
        this.tenant_view = this.tenants_requested[id]
        this.occupantList = JSON.parse(this.tenants_requested[id]['occupants'])
        this.vehicleList = JSON.parse(this.tenants_requested[id]['vehicles'])
      },
      showAccepted(id) {
        this.tenant_view = this.tenants_accepted[id]
        this.occupantList = JSON.parse(this.tenants_accepted[id]['occupants'])
        this.vehicleList = JSON.parse(this.tenants_accepted[id]['vehicles'])
      },
      async setTenant() {
        await this.propertyStore.setTenant(this.tenants_requested[this.indexId]['property_id'], this.tempId)
      },
      async clickAccept() {
        await this.tenantStore.acceptTenant(this.tempId)
        this.setTenant()
        location.reload(true)
      },
      async checkLoggedIn() {
        await this.userStore.fetchUser()
        if (this.userStore.error == true) {
          this.$router.push('/login')
        }
      },
      async deleteTenant(id) {
        await this.tenantStore.deleteTenant(id)
        location.reload(true)
      },
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
        <div class="col-lg-4 col-xl-4">
          <p class="p-medium text-black mt-5 pt-4">Back | Landlord |<r class="p-medium text-primary" to="/register">
              Tenants</r>
          </p>
          <h1 class="mt-5">Tenants</h1>
          <!-- <button class="btn btn-link" @click="copylink()">Click here for Application link</button>             -->
        </div>
        <div class="col-lg-12 col-xl-12">
          <TabNav :tabs="['Request', 'Accepted']" :selected="selected" @selected="setSelected">
            <Tab :isSelected="selected === 'Request'">
              <div v-if="constantStore.loader==true">
                <div class="emptycon d-flex align-items-center justify-content-center">
                  <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div>
              <div v-else-if="constantStore.loader==false">
                <div class="maincon overflow-auto" v-if="tenants_requested.length>0">
                  <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                      <thead>
                        <tr>
                          <th scope="col" class="col-lg-1"></th>
                          <th scope="col" class="col-lg-4 text-primary">Name</th>
                          <th scope="col" class="col-lg-4 text-primary">Email Address</th>
                          <th scope="col" class="col-lg-2 text-primary">Contact</th>
                          <th scope="col" class="col-lg-2"></th>
                        </tr>
                      </thead>
                      <tbody style="background: #e6ecf9;">
                        <tr v-for="(tenants_requested, index) in tenants_requested" :key="index"
                          style="border-bottom: .4rem solid #f5fafd;">
                          <th scope="row">
                            <!-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                  </div> -->
                          </th>
                          <!-- <td>
                                  <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td> -->
                          <td style="padding-top: .8rem;">{{ tenants_requested.first_name}}
                            {{tenants_requested.last_name}}</td>
                          <td style="padding-top: .8rem;">{{ tenants_requested.email }}</td>
                          <td style="padding-top: .8rem;">{{ tenants_requested.contact_no }}</td>
                          <td>
                            <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2"
                              style="width: 8rem; border-radius: .6rem;" data-bs-target="#myModal"
                              data-bs-toggle="modal" @click="showRequested(index)">
                              View Details
                            </button>
                            <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
                              aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content w-75 mx-auto" style="border-radius: .6rem;">
                                  <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Tenant Information</h5>
                                    <button type="button" class="close rounded-circle border-0 px-2 fw-semibold"
                                      data-bs-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="container-fluid overflow-auto">
                                      <div class="row gx-3 mb-1">
                                        <div class="col-md-6">
                                          <label class="small mb-1 text-light-blue" for="inputFirstName">First
                                            Name</label>
                                          <h5>{{ tenant_view.first_name }}</h5>
                                        </div>
                                        <div class="col-md-6">
                                          <label class="small mb-1 text-light-blue" for="inputLastName">Last
                                            Name</label>
                                          <h5>{{ tenant_view.last_name }}</h5>
                                        </div>
                                      </div>
                                      <div class="row gx-3 mb-1">
                                        <div class="col-md-6">
                                          <label class="small mb-1 text-light-blue" for="inputEmailAddress">Email
                                            Address</label>
                                          <h5>{{ tenant_view.email }}</h5>
                                        </div>
                                        <div class="col-md-6">
                                          <label class="small mb-1 text-light-blue" for="inputPhone">Contact
                                            Number</label>
                                          <h5>{{ tenant_view.contact_no }}</h5>
                                        </div>
                                      </div>
                                      <div class="mb-2">
                                        <label class="small mb-1 text-light-blue" for="inputEmailAddress">Current
                                          Address</label>
                                        <h5>{{ tenant_view.address }}</h5>
                                      </div>
                                      <div class="mb-3">
                                        <label class="small mb-1 text-light-blue"
                                          for="inputEmailAddress">Occupants</label>
                                        <ol class="list-group list-group-numbered">
                                          <li class="list-group-item border-0"
                                            v-for="(occupantList, index) in occupantList" :key="index">{{
                                            occupantList.name}}</li>
                                        </ol>
                                      </div>
                                      <div class="mb-3">
                                        <label class="small mb-1 text-light-blue"
                                          for="inputEmailAddress">Vehicles</label>
                                        <ol class="list-group list-group-numbered">
                                          <li class="list-group-item border-0"
                                            v-for="(vehicleList, index) in vehicleList" :key="index"> Year: {{
                                            vehicleList.year}}, Make: {{ vehicleList.make}}, Model: {{
                                            vehicleList.model}}, LicensePlate Number: {{ vehicleList.plate}}</li>
                                        </ol>
                                      </div>

                                      <!-- landlord details -->
                                      <div class="row gx-3 mb-1">
                                        <div class="col-md-12 mt-3 mb-2">
                                          <label class="h5 mb-1 text-dark" for="inputEmailAddress">Landlord Details</label>
                                        </div>
                                        <div class="col-md-6">
                                          <label class="small mb-1 text-light-blue" for="first_name" >Landlord Name</label>
                                                <h5>{{ viewLandlordFName }} {{ viewLandlordLName }}</h5>
                                        </div>
                                        <div class="col-md-6">
                                          <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact Info</label>
                                          <h5>{{ viewLandlordContact }}</h5>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer border-top-0">
                                    <div class="row w-100">
                                      <div class="col-xl-12">
                                        <button type="button" @click="clickAccept(); setTenant();"
                                          class="btn btn-primary w-100 my-1" style="border-radius: .6rem;"
                                          data-bs-dismiss="modal">Accept</button>
                                      </div>
                                      <div class="col-xl-12">
                                        <button type="button" class="btn btn-danger w-100 my-1"
                                          @click="deleteTenant(tenant_view.id)" style="border-radius: .6rem;"
                                          data-bs-dismiss="modal">Trash</button>
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
                <div class="emptycon d-flex align-items-center justify-content-center" v-else>
                  <div class="center-block text-center">
                    <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                    <h4 class="text-primary">Looks like you don’t have any Request</h4>
                  </div>
                </div>
              </div>


            </Tab>
            <Tab :isSelected="selected === 'Accepted'">
              <div class="emptycon d-flex align-items-center justify-content-center"
                v-if="!tenants_accepted || !tenants_accepted.length">
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
                        <th scope="col" class="col-lg-1"></th>
                        <th scope="col" class="col-lg-4 text-primary">Name</th>
                        <th scope="col" class="col-lg-4 text-primary">Email Address</th>
                        <th scope="col" class="col-lg-2 text-primary">Contact</th>
                        <th scope="col" class="col-lg-2"></th>
                      </tr>
                    </thead>
                    <tbody style="background: #e6ecf9;">
                      <tr v-for="(tenants_accepted, index) in tenants_accepted" :key="index"
                        style="border-bottom: .4rem solid #f5fafd;">
                        <th scope="row">
                          <!-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                  </div> -->
                        </th>
                        <!-- <td>
                                  <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                </td> -->
                        <td style="padding-top: .8rem;">{{ tenants_accepted.first_name}} {{tenants_accepted.last_name}}
                        </td>
                        <td style="padding-top: .8rem;">{{ tenants_accepted.email }}</td>
                        <td style="padding-top: .8rem;">{{ tenants_accepted.contact_no }}</td>
                        <td>
                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3 py-2"
                            style="width: 8rem; border-radius: .6rem;" data-bs-target="#myModal" data-bs-toggle="modal"
                            @click="showAccepted(index)">
                            View Details
                          </button>
                          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                              <div class="modal-content w-75 mx-auto" style="border-radius: .6rem;">
                                <div class="modal-header border-bottom-0">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Tenant Information</h5>
                                  <button type="button" class="close rounded-circle border-0 px-2 fw-semibold"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="container-fluid overflow-auto">
                                    <div class="row gx-3 mb-1">
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputFirstName">First
                                          Name</label>
                                        <h5>{{ tenant_view.first_name }}</h5>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputLastName">Last Name</label>
                                        <h5>{{ tenant_view.last_name }}</h5>
                                      </div>
                                    </div>
                                    <div class="row gx-3 mb-1">
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputEmailAddress">Email
                                          Address</label>
                                        <h5>{{ tenant_view.email }}</h5>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputPhone">Contact
                                          Number</label>
                                        <h5>{{ tenant_view.contact_no }}</h5>
                                      </div>
                                    </div>
                                    <div class="mb-2">
                                      <label class="small mb-1 text-light-blue" for="inputEmailAddress">Current
                                        Address</label>
                                      <h5>{{ tenant_view.address }}</h5>
                                    </div>
                                    <div class="mb-3">
                                      <label class="small mb-1 text-light-blue"
                                        for="inputEmailAddress">Occupants</label>
                                      <ol class="list-group list-group-numbered">
                                        <li class="list-group-item border-0"
                                          v-for="(occupantList, index) in occupantList" :key="index">{{
                                          occupantList.name}}</li>
                                      </ol>
                                    </div>
                                    <div class="mb-3">
                                      <label class="small mb-1 text-light-blue" for="inputEmailAddress">Vehicles</label>
                                      <ol class="list-group list-group-numbered">
                                        <li class="list-group-item border-0" v-for="(vehicleList, index) in vehicleList"
                                          :key="index"> Year: {{ vehicleList.year}}, Make: {{ vehicleList.make}}, Model:
                                          {{ vehicleList.model}}, LicensePlate Number: {{ vehicleList.plate}}</li>
                                      </ol>
                                    </div>

                                     <!-- landlord details -->
                                     <div class="row gx-3 mb-1">
                                      <div class="col-md-12 mt-3 mb-2">
                                        <label class="h5 mb-1 text-dark" for="inputEmailAddress">Landlord Details</label>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="first_name" >Landlord Name</label>
                                              <h5>{{ viewLandlordFName }} {{ viewLandlordLName }}</h5>
                                      </div>
                                      <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="last_name">Landlord Contact Info</label>
                                        <h5>{{ viewLandlordContact }}</h5>
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

  .form-control,
  .dataTable-input {
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
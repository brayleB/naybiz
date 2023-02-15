<script>
  import Sidebar from '../sidebar/sidebar.vue'
  import { sidebarWidth } from '../sidebar/state.js'
  import Tab from '../tabs/tab.vue'
  import TabNav from '../tabs/tabnav.vue'
  import { useUserStore } from '../../store/user';
  import { useConstant } from '../../store/constants';
  import { CONSTANT_VALUES_US_STATE } from '../../store/states';

  export default {
    components: { Sidebar, TabNav, Tab },
    data() {
      return {
        selected: 'Edit Profile',
        imgSrc: '',
        first_name: '',
        last_name: '',
        email: '',
        contact_no: '',
        address: '',
        city: '',
        state: '',
        country: '',
        imgData: null,
        chpassEmail: null,
        chpassCurrPass: null,
        chpassNewPass: null,
        chpassConfirmPass: null,
        confirmShowCurrentPassword: false,
        confirmShowNewPassword: false,
        confirmShowConfirmPassword: false,
        matchingValues: [],
        showValues: false,
        selectedValues: '',
        hoveredValue: '',
        fileData: null,
        fileSrc: '',
        filenameDisplay: '',
        fileData2: null,
        filenameDisplay2: '',
        fileSrc2: '',
        clickhere1: '',
        clickhere2: '',
        statementNo:'',
        customerId:'',
        statementDate:'',
        nextPaymentDate:'',
        totalAmountDue:'',
        transactionHistory:[]
      }
    },
    computed: {
      formatted(){
        return Vue.filter('date')(this.value)
      }
    },
    setup() {
      const userStore = useUserStore()
      const constantStore = useConstant()
      return { sidebarWidth, userStore, constantStore }
    },

    computed: {
      confirmShowCurrentPasswordButtonLabel() {
        return (this.confirmShowCurrentPassword) ? "Hide" : "Show";
      },
      confirmShowNewPasswordButtonLabel() {
        return (this.confirmShowNewPassword) ? "Hide" : "Show";
      },
      confirmShowConfirmPasswordButtonLabel() {
        return (this.confirmShowConfirmPassword) ? "Hide" : "Show";
      }
    },

    props: {
      isSelected: {
        type: Boolean
      }
    },
    methods: {
      async getDue(){
        await this.userStore.getDuedate()  
        if(this.userStore.response['status']==true){
          this.statementDate = this.userStore.response['data'][0]['last_payment']
          this.nextPaymentDate = this.userStore.response['data'][0]['next_payment_due_date']
          this.totalAmountDue = this.userStore.response['data'][0]['total_amount_due']['value']                  
        }  
      },
      async getTrans(){
        await this.userStore.getTransaction()   
        if(this.userStore.response['status']==true){
          this.statementNo = this.userStore.response['list'][0]['subscription_info']['plan_id']
          this.customerId = this.userStore.response['list'][0]['subscription_id']  
          this.transactionHistory = this.userStore.response['list']        
        } 
      },
      toggleConfirmShowCurrentPassword() {
        this.confirmShowCurrentPassword = !this.confirmShowCurrentPassword;
      },

      toggleConfirmShowNewPassword() {
        this.confirmShowNewPassword = !this.confirmShowNewPassword;
      },

      toggleConfirmShowConfirmPassword() {
        this.confirmShowConfirmPassword = !this.confirmShowConfirmPassword;
      },
      async getPdf1() {
        await this.userStore.getPdf1(this.userStore.currentUser['id'])
        if (this.userStore.response['status'] == true) {
          this.clickhere1 = this.userStore.response['questions'][0]['path']
          console.log(this.clickhere1)
        }
      },
      async getPdf2() {
        await this.userStore.getPdf2(this.userStore.currentUser['id'])
        if (this.userStore.response['status'] == true) {
          this.clickhere2 = this.userStore.response['questions'][0]['path']
          console.log(this.clickhere2)
        }
      },
      async checkLoggedIn() {
        await this.userStore.fetchUser()
        if (this.userStore.error == true) {
          this.$router.push('/login')
        }
      },
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
      onFilePdf(e) {
        this.fileData = e.target.files[0]
        this.filenameDisplay = this.fileData['name']
        const files = e.target.files
        if (!files.length) return

        const reader = new FileReader()
        reader.readAsDataURL(files[0])
        reader.onload = () => (this.fileSrc = reader.result)
      },
      onFilePdf2(e) {
        console.log('awd')
        this.fileData2 = e.target.files[0]
        this.filenameDisplay2 = this.fileData2['name']
        const files = e.target.files
        if (!files.length) return
        const reader = new FileReader()
        reader.readAsDataURL(files[0])
        reader.onload = () => (this.fileSrc2 = reader.result)
      },
      displayData() {
        if (this.userStore.currentUser['image'] == '' || this.userStore.currentUser['image'] == null) {
          this.imgSrc = 'https://ed-spaces.com/wp-content/uploads/2020/10/default-avatar-profile-icon-vector-18942381.jpg'
        }
        else {
          this.imgSrc = this.constantStore.baseUrl + this.userStore.currentUser['image']
        }
        this.first_name = this.userStore.currentUser['first_name']
        this.last_name = this.userStore.currentUser['last_name']
        this.email = this.userStore.currentUser['email']
        this.contact_no = this.userStore.currentUser['contact_no']
        this.address = this.userStore.currentUser['address']
        this.city = this.userStore.currentUser['city']
        this.state = this.userStore.currentUser['state']
        this.country = this.userStore.currentUser['country']
        this.chpassEmail = this.userStore.currentUser['email']
      },
      async updateProfile() {
        this.$swal.fire({
          imageUrl: "https://naybiz.com/users/questions-icon.png",
          title: "<h1 class='text-primary'>Profile</h1>",
          text: 'Do you really want to update your profile',
          color: 'black',
          showDenyButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#0066ff'
        }).then(async (result) => {
          if (result.isConfirmed) {
            await this.userStore.pdfUpload(this.email, this.imgData, this.first_name, this.last_name, this.contact_no, this.address, this.city, this.state, this.country)
            if (this.userStore.response['status'] == true) {
              this.$swal.fire({
                imageUrl: "https://naybiz.com/users/success-icon.png",
                title: "<h1 class='text-primary'>Profile</h1>",
                text: 'successfully updated',
                color: 'black',
                confirmButtonText: 'Confirm',
                confirmButtonColor: '#0066ff'
              })
            }
          }
        })
      },
      async updatePdf() {
        this.$swal.fire({
          imageUrl: "https://naybiz.com/users/questions-icon.png",
          title: "<h1 class='text-primary'>Profile</h1>",
          text: 'Do you really want to update your Top 10 Community Rules',
          color: 'black',
          showDenyButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#0066ff'
        }).then(async (result) => {
          if (result.isConfirmed) {
            await this.userStore.pdfUpload(this.fileData)
            if (this.userStore.response['status'] == true) {
              this.$swal.fire({
                imageUrl: "https://naybiz.com/users/success-icon.png",
                title: "<h1 class='text-primary'>Profile</h1>",
                text: 'Successfully updated',
                color: 'black',
                confirmButtonText: 'Confirm',
                confirmButtonColor: '#0066ff'
              })
            }
          }
        })
      },
      async updatePdf2() {
        this.$swal.fire({
          imageUrl: "https://naybiz.com/users/questions-icon.png",
          title: "<h1 class='text-primary'>Profile</h1>",
          text: 'Do you really want to update your CC&Rs',
          color: 'black',
          showDenyButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#0066ff'
        }).then(async (result) => {
          if (result.isConfirmed) {
            await this.userStore.pdfUpload2(this.fileData2)
            if (this.userStore.response['status'] == true) {
              this.$swal.fire({
                imageUrl: "https://naybiz.com/users/success-icon.png",
                title: "<h1 class='text-primary'>Profile</h1>",
                text: 'Successfully updated',
                color: 'black',
                confirmButtonText: 'Confirm',
                confirmButtonColor: '#0066ff'
              })
            }
          }
        })
      },
      changePass() {
        if (this.chpassNewPass != this.chpassConfirmPass) {
          this.$swal.fire({
            imageUrl: "https://naybiz.com/users/error-icon.png",
            title: "Confirm Password not match",
            text: 'New password and Confirm password must the same',
            color: 'black',
            confirmButtonText: 'Retry',
            confirmButtonColor: '#0066ff'
          })
        } else {
          this.$swal.fire({
            imageUrl: "https://naybiz.com/users/questions-icon.png",
            title: "Change Password",
            text: 'Do you want to update your password?',
            color: 'black',
            showDenyButton: true,
            confirmButtonText: 'Yes',
            confirmButtonColor: '#0066ff'
          }).then(async (result) => {
            if (result.isConfirmed) {
              await this.userStore.changePassword(this.email, this.chpassCurrPass, this.chpassNewPass, this.chpassConfirmPass)
              if (this.userStore.response['status'] == true) {
                this.$swal.fire({
                  imageUrl: "https://naybiz.com/users/success-icon.png",
                  title: "<h1 class='text-primary'>Profile</h1>",
                  text: 'Successfully updated password',
                  color: 'black',
                  confirmButtonText: 'Confirm',
                  confirmButtonColor: '#0066ff'
                })
              } else {
                if (this.userStore.response['message'] == "Old Password Doesnt match.") {
                  this.$swal.fire({
                    imageUrl: "https://naybiz.com/users/error-icon.png",
                    title: "<h1 class='text-primary'>Invalid</h1>",
                    text: 'Current Password incorrect',
                    color: 'black',
                    confirmButtonText: 'Retry',
                    confirmButtonColor: '#0066ff'
                  })
                }
              }
            }
          })
        }
      },
      handleInput() {
        this.matchingValues = CONSTANT_VALUES_US_STATE.filter(value => value.toLowerCase().includes(this.state.toLowerCase()))
        this.showValues = this.matchingValues.length > 0
      },
      selectValue(value) {
        this.state = value
        this.matchingValues = []
        this.showValues = false
        this.selectedValue = value
      },
      hoverValue(value) {
        this.hoveredValue = value
      },
      hideValues() {
        this.showValues = false
      }
    },
    created() {
      this.displayData()
      this.checkLoggedIn()
      this.getPdf1()
      this.getPdf2()
      this.getDue()
      this.getTrans()
    }
  }
</script>
<template>
  <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">
    <div class="homesection container-fluid ">
      <div class="row">
        <Sidebar />
        <router-view />
        <div class="col-lg-4 col-xl-4">
          <p class="p-medium text-black  mt-5 pt-4">Back | HOA | <r class="p-medium text-primary" to="/register">
              Settings</r>
          </p>
          <h1 class="mt-5">Settings</h1>
        </div>
        <div class="col-lg-12 col-xl-12">
          <TabNav :tabs="['Edit Profile', 'Community Rules','Password & Security', 'Billing']" :selected="selected"
            @selected="setSelected">
            <Tab :isSelected="selected === 'Edit Profile'">
              <div class="maincon overflow-auto" @click="hideValues">
                <div class="container">
                  <div class="row">
                    <div class="col col-xl-12">
                      <form @submit.prevent="updateProfile()">
                        <div class="container">
                          <div class="row">
                            <div class="col-md-9 mb-5">
                              <div class="mb-2">
                                <img :src="imgSrc" v-if="imgSrc" class="avatar img-circle img-thumbnail rounded-5"
                                  alt="avatar">
                                <input type="file" name="file" id="file" class="uploadbtn" @change="onFile" /> <br />
                                <label for="file" class="text-light-blue p-large"
                                  style="margin-left: 2.75rem; cursor: pointer">
                                  Choose Image</label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;"
                                type="submit">Save Profile</button>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="img-section-container container">                               
                                  <div class="img-container text-center mb-2">
                                    <img class="img-fluid" :src="imgSrc" v-if="imgSrc" />       
                                  </div>  
                                <input class="mb-3" type="file" @change="onFile" />                                                                                                                                                                                                                 
                              </div>                        -->
                        <div class="row gx-3 mb-3">
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputFirstName">First Name</label>
                            <input class="form-control" id="inputFirstName" type="tel" v-model="first_name">
                          </div>
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputLastName">Last Name</label>
                            <input class="form-control" id="inputLastName" type="text" v-model="last_name">
                          </div>
                        </div>
                        <div class="row gx-3 mb-3">
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputEmail">Email</label>
                            <input class="form-control" id="inputEmail" type="text" v-model="email" disabled>
                          </div>
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputContactNumber">Contact Number</label>
                            <input class="form-control" id="inputContactNumber" type="text" v-model="contact_no">
                          </div>
                        </div>
                        <div class="row gx-3 mb-3">
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputAddress">Address</label>
                            <input class="form-control" id="inputAddress" type="tel" v-model="address">
                          </div>
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputCity">City</label>
                            <input class="form-control" id="inputCity" type="text" v-model="city">
                          </div>
                        </div>
                        <div class="row gx-3 mb-3">
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputState">State</label>
                            <!-- <input class="form-control" id="inputState" type="tel"  v-model="state" > -->
                            <input class="form-control" id="property_name" v-model="state" @input="handleInput" />
                            <ul class="border border-1 list-unstyled mt-1" style="background-color: #f5fafd;"
                              v-if="showValues">
                              <li class="p-2" v-for="value in matchingValues" :key="value" @click="selectValue(value)"
                                @mouseover="hoverValue(value)"
                                :style="{cursor: 'pointer', backgroundColor: hoveredValue === value ? '#fff' : '' }">
                                {{value}}</li>
                            </ul>
                          </div>
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputCountry">Country</label>
                            <input class="form-control" id="inputCountry" type="text" v-model="country">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </Tab>
            <Tab :isSelected="selected === 'Password & Security'">
              <div class="maincon overflow-auto">
                <div class="container">
                  <div class="row">
                    <div class="col col-xl-12">
                      <form @submit.prevent="changePass()">
                        <div class="container">
                          <div class="row">
                            <div class="col-lg-9 col-md-8 mb-5">
                              <div class="mb-2">
                                <img :src="imgSrc" v-if="imgSrc" class="avatar img-circle img-thumbnail rounded-5"
                                  alt="avatar">
                              </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                              <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;"
                                type="submit">Save Password</button>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="img-section-container container">                               
                                  <div class="img-container text-center mb-2">
                                    <img class="img-fluid" :src="imgSrc" v-if="imgSrc" />       
                                  </div>  
                                <input class="mb-3" type="file" @change="onFile" />                                                                                                                                                                                                                 
                              </div>                        -->
                        <div class="row gx-3 mb-3">
                          <div class="col-md-6">
                            <label class="small mb-1 text-light-blue" for="inputPhone">Email</label>
                            <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number"
                              v-model="chpassEmail" disabled>
                          </div>
                          <div class="col-md-6 position-relative">
                            <label class="small mb-1 text-light-blue" for="inputBirthday">Current Password</label>
                            <!-- <input class="form-control" id="inputBirthday" type="password" name="birthday" placeholder="Enter your current password" v-model="chpassCurrPass" required> -->

                            <div class="field has-addons">
                              <div class="control is-expanded position-relative">
                                <input v-if="confirmShowCurrentPassword" type="text" class="form-control"
                                  id="inputBirthday" name="birthday" v-model="chpassCurrPass"
                                  placeholder="Enter your current password" required />
                                <input v-else type="password" class="form-control" id="inputBirthday" name="birthday"
                                  v-model="chpassCurrPass" placeholder="Enter your current password" />
                              </div>
                              <div class="control position-absolute" style="top: 46%; right: 2.5%;">
                                <button class="btn eye-border" type="button"
                                  @click.prevent="toggleConfirmShowCurrentPassword">
                                  <span class="icon is-small is-right">
                                    <i class="fas text-primary"
                                      :class="{ 'fa-eye-slash': confirmShowCurrentPassword, 'fa-eye': !confirmShowCurrentPassword }"></i>
                                  </span>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row gx-3 mb-3">
                          <div class="col-md-6 position-relative">
                            <label class="small mb-1 text-light-blue" for="inputPhone">New Password</label>
                            <!-- <input class="form-control" id="inputPhone" type="password" placeholder="Enter your new password" v-model="chpassNewPass" required> -->

                            <div class="field has-addons">
                              <div class="control is-expanded position-relative">
                                <input v-if="confirmShowNewPassword" type="text" class="form-control" id="inputPhone"
                                  v-model="chpassNewPass" placeholder="Enter your new password" required />
                                <input v-else type="password" class="form-control" id="inputPhone"
                                  v-model="chpassNewPass" placeholder="Enter your new password" />
                              </div>
                              <div class="control position-absolute" style="top: 46%; right: 2.5%;">
                                <button class="btn eye-border" type="button"
                                  @click.prevent="toggleConfirmShowNewPassword">
                                  <span class="icon is-small is-right">
                                    <i class="fas text-primary"
                                      :class="{ 'fa-eye-slash': confirmShowNewPassword, 'fa-eye': !confirmShowNewPassword }"></i>
                                  </span>
                                </button>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 position-relative">
                            <label class="small mb-1 text-light-blue" for="inputBirthday">Confirm Password</label>
                            <!-- <input class="form-control" id="inputBirthday" type="password" name="birthday" placeholder="Confirm your password" v-model="chpassConfirmPass" required> -->

                            <div class="field has-addons">
                              <div class="control is-expanded position-relative">
                                <input v-if="confirmShowConfirmPassword" type="text" class="form-control"
                                  id="inputBirthday" name="birthday" v-model="chpassConfirmPass"
                                  placeholder="Confirm your password" required />
                                <input v-else type="password" class="form-control" id="inputBirthday" name="birthday"
                                  v-model="chpassConfirmPass" placeholder="Confirm your password" />
                              </div>
                              <div class="control position-absolute" style="top: 46%; right: 2.5%;">
                                <button class="btn eye-border" type="button"
                                  @click.prevent="toggleConfirmShowConfirmPassword">
                                  <span class="icon is-small is-right">
                                    <i class="fas text-primary"
                                      :class="{ 'fa-eye-slash': confirmShowConfirmPassword, 'fa-eye': !confirmShowConfirmPassword }"></i>
                                  </span>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </Tab>
            <Tab :isSelected="selected === 'Community Rules'">
              <div class="maincon overflow-auto">
                <div class="container">
                  <div class="row">
                    <div class="col col-xl-12">
                      <form @submit.prevent="updatePdf()">

                        <!-- <div class="img-section-container container">                               
                                  <div class="img-container text-center mb-2">
                                    <img class="img-fluid" :src="imgSrc" v-if="imgSrc" />       
                                  </div>  
                                <input class="mb-3" type="file" @change="onFile" />                                                                                                                                                                                                                 
                              </div>                        -->
                        <div class="row gx-3 mb-3">
                          <div class="col-md-7">
                            <label class="small mb-2 text-light-blue" for="property_name">Please insert your Top 10
                              Community Rules</label>
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                              <input id="upload" type="file" @change="onFilePdf" class="form-control border-0" required>
                              <label id="upload-label" for="upload" class="font-weight-light text-muted"
                                style="max-width: 17rem;">{{ filenameDisplay }}</label>
                              <div class="input-group-append my-auto">
                                <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;"
                                  type="submit" onclick="">Update</button>
                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                  <i class="fa fa-cloud-upload-alt mr-2 text-muted"></i><small
                                    class="text-uppercase font-weight-bold text-muted fw-semibold"> Choose
                                    file</small></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row gx-3 mb-3">
                          <div class="col-md-5">
                            <label class="small mb-2 text-light-blue" for="property_name">View your Top 10 Community
                              Rules</label>
                            <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;" type="button"
                              onclick="">Click here</button>
                          </div>
                        </div>

                      </form>
                      <form @submit.prevent="updatePdf2()">

                        <div class="row gx-3 mb-3">
                          <div class="col-md-7">
                            <label class="small mb-2 text-light-blue" for="property_name">Please insert your Covenants,
                              conditions, and Restrictions (CC&Rs)</label>
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                              <input id="upload" type="file" @change="onFilePdf2" class="form-control border-0"
                                required>
                              <label id="upload-label" for="upload" class="font-weight-light text-muted"
                                style="max-width: 17rem;">{{ filenameDisplay2 }}</label>
                              <div class="input-group-append my-auto">
                                <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;"
                                  type="submit" onclick="">Update</button>
                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                  <i class="fa fa-cloud-upload-alt mr-2 text-muted"></i><small
                                    class="text-uppercase font-weight-bold text-muted fw-semibold"> Choose
                                    file</small></label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row gx-3 mb-3">
                          <div class="col-md-5">
                            <label class="small mb-2 text-light-blue" for="property_name">View your Covenants,
                              conditions, and Restrictions (CC&Rs</label>
                            <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;" type="button"
                              onclick="">Click here</button>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </Tab>
            <Tab class="position-relative" :isSelected="selected === 'Billing'">
              <button class="position-absolute deactivate border-0">Deactivate Account</button>
              <div class="maincon overflow-auto">
                <div class="container">
                  <div class="row">
                    <div class="col-xl-6">
                      <div class="row">
                        <div class="col-xl-12">
                          <h2>Payment Setting</h2>
                          <div class="row">
                            <div class="col-xl-1"></div>
                            <div class="card card-payment col-xxl-11 col-xl-11">
                              <div
                                class="row d-flex align-items-xl-center align-items-sm-center justify-content-xl-center justify-content-sm-center"
                                style="height: 61px">
                                <div class="col-xl-10 col-sm-10">
                                  <span class="text-black" style="font-size: 20px;">Monthly Payment</span>
                                </div>
                                <div class="col-xl-2 col-sm-2 d-flex justify-content-end">
                                  <button class="text-light-blue d-flex align-items-center justify-content-end border-0"
                                    style="font-size: 20px; background: none;" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Edit</button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-payment-setting">
                              <div class="modal-content rounded-4">
                                <div class="modal-header border-bottom-0 modal-header-payment-setting">
                                  <div class="row d-flex">
                                    <div class="col-xl-12 d-flex justify-content-center">
                                      <h2 class="modal-title text-primary" id="exampleModalLabel">Payment Setting</h2>
                                    </div>
                                    <div class="col-xl-12 d-flex justify-content-center">
                                      <span class="text-black">Choose the best way you can pay </span>
                                    </div>
                                  </div>
                                  <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                </div>
                                <div class="modal-body">
                                  <div
                                    class="form-check d-flex justify-content-xxl-start justify-content-lg-start justify-content-md-center justify-content-md-center align-items-center gap-3 mx-xl-5 mx-md-auto my-1">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                      id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                      <span class="text-black">Monthly Payment</span>
                                    </label>
                                  </div>
                                  <div
                                    class="form-check d-flex justify-content-xxl-start justify-content-lg-start justify-content-md-center justify-content-md-center align-items-center gap-3 mx-xl-5 mx-md-auto my-1">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                      id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                      <span class="text-black">Annual Payment</span>
                                    </label>
                                  </div>
                                </div>
                                <div
                                  class="modal-footer d-flex justify-content-center border-top-0 modal-footer-payment-setting">
                                  <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                  <button type="button" class="btn-solid-lg">Confirm</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-xl-12 mt-4">
                          <div class="row d-flex align-items-center">
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                              <h2>Payment Method</h2>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 d-flex justify-content-end text-light-blue"
                              style="font-size: 20px;">
                              Change
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xl-1"></div>
                            <div class="card card-payment col-xl-11">
                              <div class="row d-flex align-items-center" style="height: 61px">
                                <div class="col-xl-12 col-sm-12">
                                  <div
                                    class="form-check d-flex align-items-center justify-content-xxl-start justify-content-sm-start gap-2">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                      id="flexRadioDefault1">
                                    <label class="form-check-label d-flex align-items-center gap-2"
                                      for="flexRadioDefault1">
                                      <img class="img-fluid w-100" src="../../../images/paypal.png"
                                        alt="paypal image under settings in billing tab" style="max-width: 10rem;" />
                                      <span class="text-black email-text"
                                        style="font-size: 20px;">(email@gmail.com)</span>
                                    </label>
                                  </div>
                                </div>
                                <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-lg-flex d-sm-flex justify-content-lg-end justify-content-sm-end">
                                       <span class="text-black email-text" style="font-size: 20px;">(email@gmail.com)</span> 
                                      </div> -->
                              </div>
                            </div>
                            <div class="col-xl-1"></div>
                            <div class="col-xl-11 mt-3 p-0">
                              <span class="text-light-blue">If you don't have a paypal account,you can also pay via
                                paypal with your credit card or bank debit card. Payment can be submitted in any
                                currency!</span>
                            </div>
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="col-xxl-1"></div>
                    <div class="col-xxl-5 mt-xxl-0 mt-md-4">
                      <h2>Payment Due Date</h2>
                      <div class="card card-payment-due-date px-3 py-2">
                        <table class="table table-borderless">
                          <thead>
                          </thead>
                          <tbody>
                            <tr class="d-flex" style="height: 1.6rem;">
                              <td class="fw-bold">Statement No.</td>
                              <td class="fw-bold">{{ statementNo }}</td>
                            </tr>
                            <tr class="d-flex mb-5" style="height: 1.6rem;">
                              <td class="fw-bold">Customer ID:</td>
                              <td class="fw-bold">{{ customerId }}</td>
                            </tr>
                            <tr class="" style="height: 1.6rem;">
                              <td class="">Statement Date:</td>
                              <td class="text-end">{{ statementDate }}</td>
                            </tr>
                            <tr class="" style="height: 1.6rem;">
                              <td class="">Next Payment Due Date:</td>
                              <td class="text-end">{{ nextPaymentDate }}</td>
                            </tr>
                            <tr class="" style="height: 1.6rem;">
                              <td class="">Total Amount Due:</td>
                              <td class="text-end">{{ totalAmountDue }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="col col-xl-12 mt-5">
                      <h4>Transaction History</h4>
                      <table class="table overflow-auto card-history">
                        <thead>
                        </thead>

                        <tbody class="text-center">
                          <tr class="tr-transaction" style="height: 2.5rem;">
                            <td style="color: #768BB1; font-weight: 500;">Transaction ID</td>
                            <td style="color: #768BB1; font-weight: 500;">Transaction Date</td>
                            <td style="color: #768BB1; font-weight: 500;">Transaction Time</td>
                            <td style="color: #768BB1; font-weight: 500;">Amount</td>
                            <td style="color: #768BB1; font-weight: 500;">Status</td>
                          </tr>
                          <tr class="tr-transaction" style="height: 2.5rem;"  v-for="transactionHistory in transactionHistory" :key="index">
                            <td>{{ transactionHistory.id }}</td>
                            <td>{{ transactionHistory.created_at_date }}</td>
                            <td>{{  transactionHistory.created_at_time }}</td>
                            <td></td>
                            <td></td>
                          </tr>                         
                        </tbody>
                      </table>
                    </div>

                  </div>
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
  body {
    margin-top: -48px !important;
    background-color: #f2f6fc;
    color: #69707a;
  }

  .card {
    box-shadow: 0 0.15rem .1rem 0 rgb(33 40 50 / 15%);
  }

  .card .card-header {
    font-weight: 500;
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

  .img-container {
    width: 320px;
    border: 1px solid gray;
  }

  .avatar {
    width: 200px;
    height: 200px;
  }

  .uploadbtn {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;

  }

  /* .table-striped>tbody>tr:nth-child(odd)>td, 
.table-striped>tbody>tr:nth-child(odd)>th {
  background-color: #ffffff !important; 
 }

.table-striped>tbody>tr:nth-child(even)>td, 
.table-striped>tbody>tr:nth-child(even)>th {
  background-color: #ECF3FF; 
}
  */

  .tr-transaction:nth-child(odd) {
    background-color: #ffffff;
    border: 1px solid #ffffff;
  }

  .tr-transaction:nth-child(even) {
    background-color: #ECF3FF;
    border: 1px solid #ECF3FF;
  }

  .card-payment {
    background: rgb(255, 255, 255);
    box-shadow: none !important;
    border-radius: 1rem;
    border: 1px solid #768BB1;
  }

  .card-payment-due-date {
    background: #ECF3FF;
    box-shadow: none !important;
    border-radius: 1rem;
    border: 1px solid #000000;
  }

  .card-history {
    border: 2px solid #768BB1;
  }

  .modal-dialog-payment-setting {
    width: 425px;
  }

  .modal-header-payment-setting {
    height: 7rem;
  }

  .modal-footer-payment-setting {
    height: 7rem;
  }

  .deactivate {
    background: none;
    top: -6%;
    right: 2%;
    color: #FF4C4C;
    z-index: 4 !important;
    font-weight: 500;
    font-size: 18px;
  }

  @media screen and (max-width: 1085px) {
    .deactivate {
      width: 8rem;
      text-align: start;
      line-height: 1.1;
      background: none;
      top: -7%;
      right: -5%;
      color: #FF4C4C;
      z-index: 4 !important;
      font-weight: 500;
      font-size: 16px;
    }
  }

  @media screen and (max-width: 1272px) {
    .email-text {
      font-size: 16px !important;
    }
  }

  @media screen and (max-width: 1200px) {
    .email-text {
      font-size: 20px !important;
    }
  }
</style>
<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    import {useUserStore} from '../../store/user';
    import {useConstant} from '../../store/constants';
    import { CONSTANT_VALUES_US_STATE } from '../../store/states';
    import { useElementHover } from '@vueuse/core';
    
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          selected: 'Edit Profile',
          imgSrc:'',        
          first_name:'',
          last_name:'',
          email:'',
          contact_no:'',
          address:'',
          city:'',
          state:'',
          country:'', 
          imgData:null,
          chpassEmail:null,
          chpassCurrPass:null,
          chpassNewPass:null,
          chpassConfirmPass:null,
          confirmShowCurrentPassword: false,
          confirmShowNewPassword: false,
          confirmShowConfirmPassword: false,
          matchingValues: [],
          showValues: false,
          selectedValues: '',
          hoveredValue: ''
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
        toggleConfirmShowCurrentPassword() {
            this.confirmShowCurrentPassword = !this.confirmShowCurrentPassword;
        },

        toggleConfirmShowNewPassword() {
            this.confirmShowNewPassword = !this.confirmShowNewPassword;
        },

        toggleConfirmShowConfirmPassword() {
            this.confirmShowConfirmPassword = !this.confirmShowConfirmPassword;
        },

        async checkLoggedIn() {    
            await this.userStore.fetchUser()             
            if(this.userStore.error==true){ 
              this.$router.push('/login')  
            }          
        },
        setSelected(tab){
          this.selected = tab;
        },
        onFile(e) {
          this.imgData=e.target.files[0]
          const files = e.target.files
          if (!files.length) return

          const reader = new FileReader()
          reader.readAsDataURL(files[0])
          reader.onload = () => (this.imgSrc = reader.result)
        },
        displayData(){
          if(this.userStore.currentUser['image']==''||this.userStore.currentUser['image']==null){
            this.imgSrc = 'https://ed-spaces.com/wp-content/uploads/2020/10/default-avatar-profile-icon-vector-18942381.jpg'
          }
          else{
            this.imgSrc = this.constantStore.baseUrl+this.userStore.currentUser['image']
          }
          this.first_name=this.userStore.currentUser['first_name']
          this.last_name=this.userStore.currentUser['last_name']
          this.email=this.userStore.currentUser['email']      
          this.contact_no=this.userStore.currentUser['contact_no']
          this.address=this.userStore.currentUser['address']
          this.city=this.userStore.currentUser['city']
          this.state=this.userStore.currentUser['state']
          this.country=this.userStore.currentUser['country']
          this.chpassEmail=this.userStore.currentUser['email']
        },
        async updateProfile(){    
          this.$swal.fire({
            imageUrl: "https://naybiz.com/users/questions-icon.png",
            title: "<h1 class='text-primary'>Profile</h1>",
                        text:'Do you really want to update your profile', 
                        color: 'black',
			showDenyButton: true,                    
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#0066ff'                       
                    }).then(async (result) => {                      
                        if (result.isConfirmed) {   
                           await this.userStore.updateUser(this.email, this.imgData, this.first_name, this.last_name,  this.contact_no, this.address, this.city, this.state, this.country)
                            if(this.userStore.response['status']==true)
                            {
                                this.$swal.fire({
                                  imageUrl: "https://naybiz.com/users/success-icon.png",
                                  title: "<h1 class='text-primary'>Profile</h1>",
                        text:'successfully updated', 
                        color: 'black',                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'                       
                                })
                            }                        
                        }
                    })                          
        },
        changePass(){
          if(this.chpassNewPass!=this.chpassConfirmPass){
            this.$swal.fire({
              imageUrl: "https://naybiz.com/users/error-icon.png",
                    title: "Confirm Password not match", 
                    text:'New password and Confirm password must the same', 
                    color: 'black',                    
                    confirmButtonText: 'Retry',
                    confirmButtonColor: '#0066ff'
                                })
          }else{
            this.$swal.fire({
              imageUrl: "https://naybiz.com/users/questions-icon.png",
                        title: "Change Password", 
                        text:'Do you want to update your password?', 
                        color: 'black',
			showDenyButton: true,                    
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#0066ff'                   
                                }).then(async (result) => {                      
                        if (result.isConfirmed) {   
                           await this.userStore.changePassword(this.email, this.chpassCurrPass, this.chpassNewPass, this.chpassConfirmPass)
                            if(this.userStore.response['status']==true)
                            {
                                this.$swal.fire({
                                  imageUrl: "https://naybiz.com/users/success-icon.png",
                                  title: "<h1 class='text-primary'>Profile</h1>",
                        text:'Successfully updated password', 
                        color: 'black',                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'                       
                                })
                            }else{                                                      
                                if(this.userStore.response['message']=="Old Password Doesnt match."){
                                  this.$swal.fire({
                                  imageUrl: "https://naybiz.com/users/error-icon.png",
                                  title: "<h1 class='text-primary'>Invalid</h1>",
                                  text:'Current Password incorrect', 
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
      created(){        
        this.displayData()
        this.checkLoggedIn()
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
                <p class="p-medium text-black mt-5 pt-4">Back | Landlord | <r class="p-medium text-primary" to="/register">Settings</r></p>                  
                <h1 class="mt-5">Settings</h1>
              </div>
              <div class="col-lg-12 col-xl-12">
              <TabNav :tabs="['Edit Profile', 'Password & Security',]" :selected="selected" @selected="setSelected">
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
                                        <img :src="imgSrc" v-if="imgSrc" class="avatar img-circle img-thumbnail rounded-5" alt="avatar">                                                                            
                                        <input type="file" name="file" id="file"  class="uploadbtn" @change="onFile" /> <br/>
                                        <label for="file" class="text-light-blue p-large" style="margin-left: 2.75rem; cursor: pointer">
                                          Choose Image</label>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;" type="submit">Save Profile</button>
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
                                        <label class="small mb- text-light-blue" for="inputFirstName">First Name</label>
                                        <input class="form-control" id="inputFirstName" type="tel" v-model="first_name">
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputLastName">Last Name</label>
                                        <input class="form-control" id="inputLastName" type="text" v-model="last_name" >
                                    </div>
                                </div>  
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputEmail">Email</label>
                                        <input class="form-control" id="inputEmail" type="text" v-model="email" disabled>
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputContactNumber">Contact Number</label>
                                        <input class="form-control" id="inputContactNumber" type="text" v-model="contact_no" >
                                    </div>
                                </div> 
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputAddress">Address</label>
                                        <input class="form-control" id="inputAddress" type="tel"  v-model="address" >
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputCity">City</label>
                                        <input class="form-control" id="inputCity" type="text" v-model="city">
                                    </div>
                                </div> 
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6" @click="hideValues">
                                        <label class="small mb-1 text-light-blue" for="inputState">State</label>
                                        <!-- <input class="form-control" id="inputState" type="tel"  v-model="state" > -->
                                        <input class="form-control" id="inputState" v-model="state" @input="handleInput"/>
                                        <ul class="border border-1 list-unstyled mt-1" v-if="showValues">
                                          <li class="p-2" v-for="value in matchingValues" :key="value" @click="selectValue(value)"
                                              @mouseover="hoverValue(value)"
                                              :style="{cursor: 'pointer', backgroundColor: hoveredValue === value ? '#fff' : '' }">{{value}}</li>
                                        </ul>
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1 text-light-blue" for="inputCountry">Country</label>
                                        <input class="form-control" id="inputCountry" type="text"  v-model="country">
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
                                        <img :src="imgSrc" v-if="imgSrc" class="avatar img-circle img-thumbnail rounded-5" alt="avatar">                                                                                                                   
                                      </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                      <button class="btn btn-primary float-end py-2" style="border-radius: .6rem;" type="submit">Save Password</button>
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
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" v-model="chpassEmail" disabled>
                                    </div>                                  
                                    <div class="col-md-6 position-relative">
                                        <label class="small mb-1 text-light-blue" for="inputBirthday">Current Password</label>
                                        <!-- <input class="form-control" id="inputBirthday" type="password" name="birthday" placeholder="Enter your current password" v-model="chpassCurrPass" required> -->

                                        <div class="field has-addons">
                                          <div class="control is-expanded position-relative">   
                                              <input v-if="confirmShowCurrentPassword" type="text" class="form-control" id="inputBirthday" name="birthday" v-model="chpassCurrPass" 
                                              placeholder="Enter your current password" required />
                                              <input v-else type="password" class="form-control" id="inputBirthday" name="birthday" v-model="chpassCurrPass" 
                                              placeholder="Enter your current password" />
                                          </div>
                                          <div class="control position-absolute" style="top: 46%; right: 2.5%;">
                                              <button class="btn eye-border" type="button" @click.prevent="toggleConfirmShowCurrentPassword">
                                                  <span class="icon is-small is-right">
                                                      <i class="fas text-primary" :class="{ 'fa-eye-slash': confirmShowCurrentPassword, 'fa-eye': !confirmShowCurrentPassword }"></i>
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
                                              <input v-if="confirmShowNewPassword" type="text" class="form-control" id="inputPhone" v-model="chpassNewPass" 
                                              placeholder="Enter your new password" required />
                                              <input v-else type="password" class="form-control" id="inputPhone" v-model="chpassNewPass" 
                                              placeholder="Enter your new password" />
                                          </div>
                                          <div class="control position-absolute" style="top: 46%; right: 2.5%;">
                                              <button class="btn eye-border" type="button" @click.prevent="toggleConfirmShowNewPassword">
                                                  <span class="icon is-small is-right">
                                                      <i class="fas text-primary" :class="{ 'fa-eye-slash': confirmShowNewPassword, 'fa-eye': !confirmShowNewPassword }"></i>
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
                                              <input v-if="confirmShowConfirmPassword" type="text" class="form-control" id="inputBirthday" name="birthday" v-model="chpassConfirmPass" 
                                              placeholder="Confirm your password" required />
                                              <input v-else type="password" class="form-control" id="inputBirthday" name="birthday" v-model="chpassConfirmPass" 
                                              placeholder="Confirm your password" />
                                          </div>
                                          <div class="control position-absolute" style="top: 46%; right: 2.5%;">
                                              <button class="btn eye-border" type="button" @click.prevent="toggleConfirmShowConfirmPassword">
                                                  <span class="icon is-small is-right">
                                                      <i class="fas text-primary" :class="{ 'fa-eye-slash': confirmShowConfirmPassword, 'fa-eye': !confirmShowConfirmPassword }"></i>
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
              </TabNav> 
              </div>             
            </div> 
        </div>
      </div>
       
    
    </template>
    
  <style>
 body{
  margin-top: -48px !important;    
background-color:#f2f6fc;
color:#69707a;
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
.img-container {
  width: 320px;
  border: 1px solid gray; 
}
.avatar{
width:200px;
height:200px;
}
.uploadbtn {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
  
}



    </style>
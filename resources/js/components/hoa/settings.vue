<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    import {useUserStore} from '../../store/user';
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
          imgData:null              
        }
      },
      setup() {
        const userStore = useUserStore()
        return { sidebarWidth, userStore }
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
            this.imgSrc = 'https://preview.keenthemes.com/metronic-v4/theme/assets/pages/img/avatars/team1.jpg'
          }
          else{
            this.imgSrc = 'http://127.0.0.1:8000/'+this.userStore.currentUser['image']
          }
          this.first_name=this.userStore.currentUser['first_name']
          this.last_name=this.userStore.currentUser['last_name']
          this.email=this.userStore.currentUser['email']      
          this.contact_no=this.userStore.currentUser['contact_no']
          this.address=this.userStore.currentUser['address']
          this.city=this.userStore.currentUser['city']
          this.state=this.userStore.currentUser['state']
          this.country=this.userStore.currentUser['country']
        },
        async updateProfile(){    
          this.$swal.fire({
                        icon: 'question',
                        title: 'Do you really want to update?',   
                        showDenyButton: true,                                                                                                                           
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#1760E8'                            
                    }).then(async (result) => {                      
                        if (result.isConfirmed) {   
                           await this.userStore.updateUser(this.email, this.imgData, this.first_name, this.last_name,  this.contact_no, this.address, this.city, this.state, this.country)
                            if(this.userStore.response['status']==true)
                            {
                                this.$swal.fire({
                                    icon: 'success',
                                    title: 'User Profile Updated',                                                                                                                                                                                                                 
                                    confirmButtonText: 'Confirm',
                                    confirmButtonColor: '#1760E8'                            
                                })
                            }                        
                        }
                    })                          
        }
      },
      created(){        
        this.displayData()
      }
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">
          <div class="homesection container-fluid">
            <div class="row">
              <Sidebar />    
              <router-view />           
              <div class="col-lg-2 col-xl-4">  
                <p class="p-medium text-black">Back | HOA | <r class="p-medium text-primary" to="/register">Settings</r></p>                  
                <h1>Settings</h1>
              </div>
              <div class="col-lg-6 col-xl-12">
              <TabNav :tabs="['Edit Profile', 'Password & Security',]" :selected="selected" @selected="setSelected">
                <Tab :isSelected="selected === 'Edit Profile'">                                      
                    <div class="maincon overflow-auto">
                      <div class="container">
                        <div class="row">                          
                          <div class="col col-xl-12">
                            <form @submit.prevent="updateProfile()">  
                              <div class="container">
                                  <div class="row">
                                    <div class="col-md-10 mb-5">
                                      <div class="mb-2">
                                        <img :src="imgSrc" v-if="imgSrc" class="avatar img-circle img-thumbnail" alt="avatar">                                                                            
                                        <input type="file" name="file" id="file"  class="uploadbtn" @change="onFile" /> <br/>
                                        <label for="file">Choose image</label>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <button class="btn btn-primary float-end" type="submit">Save Profile</button>
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
                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                        <input class="form-control" id="inputFirstName" type="tel" v-model="first_name">
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                        <input class="form-control" id="inputLastName" type="text" v-model="last_name" >
                                    </div>
                                </div>  
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputEmail">Email</label>
                                        <input class="form-control" id="inputEmail" type="text" v-model="email" >
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputContactNumber">Contact Number</label>
                                        <input class="form-control" id="inputContactNumber" type="text" v-model="contact_no" >
                                    </div>
                                </div> 
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputAddress">Address</label>
                                        <input class="form-control" id="inputAddress" type="tel"  v-model="address" >
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputCity">City</label>
                                        <input class="form-control" id="inputCity" type="text" v-model="city">
                                    </div>
                                </div> 
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputState">State</label>
                                        <input class="form-control" id="inputState" type="tel"  v-model="state" >
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputCountry">Country</label>
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
                            <form @submit.prevent="tenantApplication">  
                              <div class="container">
                                  <div class="row">
                                    <div class="col-md-10 mb-5">
                                      <div class="mb-2">
                                        <img :src="imgSrc" v-if="imgSrc" class="avatar img-circle img-thumbnail" alt="avatar">                                                                                                                   
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                      <button class="btn btn-primary float-end" type="submit">Save Password</button>
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
                                        <label class="small mb-1" for="inputPhone">Email</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="email@gmail.com">
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Current Password</label>
                                        <input class="form-control" id="inputBirthday" type="password" name="birthday" placeholder="Enter your current password" >
                                    </div>
                                </div>  
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">New Password</label>
                                        <input class="form-control" id="inputPhone" type="password" placeholder="Enter your new password" >
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Confirm Password</label>
                                        <input class="form-control" id="inputBirthday" type="password" name="birthday" placeholder="Confirm your password" >
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
 body{margin-top:20px;    
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
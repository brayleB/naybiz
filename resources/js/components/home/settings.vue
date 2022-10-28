<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          selected: 'Edit Profile'
        }
      },
      setup() {
        return { sidebarWidth }
      },
      props: {
        isSelected: {
          type: Boolean
        }
      },
      methods: {
        setSelected(tab){
          this.selected = tab;
        }
      }
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">.
          <div class="homesection container-fluid">
            <div class="row">
              <Sidebar />    
              <router-view />           
              <div class="col-lg-2 col-xl-4">  
                <p class="p-medium text-black">Back | <r class="p-medium text-primary" to="/register">Settings</r></p>                  
                <h1>Settings</h1>
              </div>
              <div class="col-lg-6 col-xl-12">
              <TabNav :tabs="['Edit Profile', 'Password & Security',]" :selected="selected" @selected="setSelected">
                <Tab :isSelected="selected === 'Edit Profile'">                                      
                    <div class="maincon overflow-auto">
                      <div class="container">
                        <div class="row">                          
                          <div class="col col-xl-12">
                            <form @submit.prevent="tenantApplication">  
                                <div class="container">
                                    <div class="row justify-content-center">
                                        
                                    </div>
                                </div>                        
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Contact number</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="555-123-4567">
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Birthday</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value="06/10/1988">
                                    </div>
                                </div>  
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Contact number</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="555-123-4567">
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Birthday</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value="06/10/1988">
                                    </div>
                                </div>        
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Contact number</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="555-123-4567">
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Birthday</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value="06/10/1988">
                                    </div>
                                </div>  
                                <div class="row gx-3 mb-3">                                 
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Contact number</label>
                                        <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="555-123-4567">
                                    </div>                                  
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputBirthday">Birthday</label>
                                        <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value="06/10/1988">
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
                        <div class="row d-flex justify-content-center">                            
                            <div class="col-xl-6">
                                <!-- Account details card-->
                                <div class="card mb-4">                                 
                                    <div class="card-body">
                                        <form>                                           
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                                <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" value="name@example.com">
                                            </div>
                                            <!-- Form Row-->
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputEmailAddress">Current Password</label>
                                                <input class="form-control" id="inputEmailAddress" type="password" placeholder="Enter your email address" value="name@example.com">
                                            </div>
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputEmailAddress">New Password</label>
                                                <input class="form-control" id="inputEmailAddress" type="password" placeholder="Enter your email address" value="name@example.com">
                                            </div>
                                            <div class="mb-3">
                                                <label class="small mb-1" for="inputEmailAddress">Confirm Password</label>
                                                <input class="form-control" id="inputEmailAddress" type="password" placeholder="Enter your email address" value="name@example.com">
                                            </div>
                                            <!-- Save changes button-->
                                            <button class="btn btn-primary" type="button">Save changes</button>
                                        </form>
                                    </div>
                                </div>
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

    </style>
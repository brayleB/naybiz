<template>
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
     <div class="container">             
          <div class="image-container">         
              <router-link class="navbar-brand logo-text" to="/">
                  <img class="img-fluid" src="../../../images/Logo-white.png" alt="alternative" />
              </router-link> 
            </div>          
         <!-- <button class="navbar-toggler navbar-dark p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>            -->
     </div> 
   </nav>
   
   <header id="login-1" class="login-1 register-bg">
    <div class="container">
        <div class="row">
             <div class="col-lg-6 col-xl-7 d-lg-flex d-md-inline-block align-items-lg-center">
                 <div class="text-container">
                     <h1 class="h1-large text-white mt-5">Home Owner Association Registration</h1>
                     <p class="p-large text-white">Set up your free account today!</p>      		         
                 </div>
             </div>
             <div class="col-lg-5 border border-2 rounded-4 border-white bg-blur">              
              <form @submit.prevent="register" class="p-4">
                  <div class="form-group ">
                    <h3 class="text-white py-3">Enter your basic account information</h3>
                  </div>                                 
                  <div class="form-group">
                      <input type="username" v-model="username" class="form-control-input" placeholder="Enter HOA Name" required />
                  </div>             
                  <div class="form-group">
                      <input type="email" v-model="email" class="form-control-input" placeholder="Enter email" required />
                  </div>
                  <div class="form-group">
                      <!-- <input type="password" v-model="password" class="form-control-input" placeholder="Enter password" required /> -->
                      <div class="field has-addons">
                        <div class="control is-expanded position-relative">   
                            <input v-if="showPassword" type="text" class="form-control-input" v-model="password" 
                            placeholder="Enter password" required />
                            <input v-else type="password" class="form-control-input" v-model="password" 
                            placeholder="Enter password"/>
                        </div>
                        <div class="control position-absolute" style="top: 17%; right: 2%;">
                            <button class="btn eye-border" type="button" @click.prevent="toggleShowPassword">
                                <span class="icon is-small is-right">
                                    <i class="fas text-primary" :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                  </div>  
                  <div class="form-group">
                      <!-- <input type="password" v-model="confirmpass" class="form-control-input" placeholder="Confirm password" required /> -->
                      <div class="field has-addons">
                        <div class="control is-expanded position-relative">   
                            <input v-if="confirmShowPassword" type="text" class="form-control-input" v-model="confirmpass" 
                            placeholder="Confirm password" required />
                            <input v-else type="password" class="form-control-input" v-model="confirmpass" 
                            placeholder="Confirm password"/>
                        </div>
                        <div class="control position-absolute" style="top: 17%; right: 2%;">
                            <button class="btn eye-border" type="button" @click.prevent="toggleConfirmShowPassword">
                                <span class="icon is-small is-right">
                                    <i class="fas text-primary" :class="{ 'fa-eye-slash': confirmShowPassword, 'fa-eye': !confirmShowPassword }"></i>
                                </span>
                            </button>
                        </div>
                      </div>
                  </div>           
                  <div class="form-group">
                      <button type="submit" class="form-control-submit-button">Submit</button>
                  </div>                  
                    <p class="text-white text-center m-3">Already have an account? <router-link class="text-white text-decoration-none"
                        style="padding-bottom: 1px; border-bottom: 3px solid;" to="/login">Login</router-link></p>      		                          
              </form>
             </div> 
        </div>      
    </div> 
   </header> 
   <div class="copyright">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <p class="p-small text-light-blue">Naybiz © Copyright 2022, Inc. All rights reserved</p>
            </div> 
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mx-lg-0 mx-md-0 mx-sm-auto" style="width: 11.5rem;">  
                 <div class="d-sm-flex">
                     <span class="fa-stack">
                         <a href="#your-link">
                             <i class="fab fa-instagram fa-stack-1x"></i>
                         </a>
                     </span>
                      <span class="fa-stack">
                          <a href="#your-link">
                              <i class="fab fa-facebook-f fa-stack-1x"></i>
                          </a>
                      </span>
                      <span class="fa-stack">
                          <a href="#your-link">
                              <i class="fab fa-twitter fa-stack-1x"></i>
                          </a>
                      </span>
                      <span class="fa-stack">
                          <a href="#your-link">
                              <i class="fab fa-viber fa-stack-1x"></i>
                          </a>
                      </span>
                 </div> 
            </div> 
        </div> 
    </div>
 </div>
  
   </template>

<script>
    import {useUserStore} from '../../store/user';
    export default {     
        computed: {
            showButtonLabel() {
                return (this.showPassword) ? "Hide" : "Show";
            },
            confirmShowButtonLabel() {
                return (this.showPassword) ? "Hide" : "Show";
            }
        }, 

        methods: {
            toggleShowPassword() {
                this.showPassword = !this.showPassword;
            },

            toggleConfirmShowPassword() {
                this.confirmShowPassword = !this.confirmShowPassword;
            },

            async register() {
                const errorstr = ""
                if(this.password!=this.confirmpass){
                    this.errorstr="Password not match"
                }
                else{  
                    this.errorstr=null                  
                    this.$swal.fire({
                        imageUrl: "https://naybiz.com/users/success-icon.png",
                        title: "<h1 class='text-primary'>Registration</h1>",
                        text:'Do you really want to create user?', 
                        color: 'black',            
			            showDenyButton: true,                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'                           
                    }).then(async (result) => {                      
                        if (result.isConfirmed) {   
                            await this.userStore.signUp(this.assoc_hoa_id, this.username, this.email, this.password, 'new')
                            if(this.userStore.response['status']==false){
                                this.errorstr=this.userStore.response['message']
                            }
                            else{
                                this.$swal.fire({
                                    imageUrl: "https://naybiz.com/users/success-icon.png",
                                    title: "<h1 class='text-primary'>Signup Successful</h1>",                                 
                                        color: 'black',                     
                                        confirmButtonText: 'Proceed',
                                        confirmButtonColor: '#0066ff'                  
                                }).then((result)=>{
                                    if(result.isConfirmed){
                                        this.$router.push('/landlord/properties')
                                    }
                                })                                
                            } 
                        }
                    })                     
                    
                }
                if(this.errorstr!=null){
                    this.$swal.fire({
                        icon: 'error',
                        title: this.errorstr,   
                        confirmButtonText: 'Retry',
                        confirmButtonColor: '#1760E8'                            
                    }) 
                }               
            },          
            setRegType(){                           
                    this.userStore.regUserType='hoa'                                                                                                    
            },
            async getHoa(){                
                await this.userStore.getUserById(this.assoc_hoa_id)      
                if(this.userStore.response['status']==true){
                    this.tempHoaName = this.userStore.response['user']['username']
                }                 
            },                                                
        },      
        setup() {          
            const userStore = useUserStore();
            return { userStore };
        },

        data() {           
            return {  
                tempHoaName:"",
                userTypeStr: '',
                stat: "",     
                msg: "", 
                username: "",    
                email: "",
                password: "",
                confirmpass: "",
                signupType:this.$route.query['type'],
                assoc_hoa_id:this.$route.query['id'],
                showPassword: false,
                confirmShowPassword: false 
            };
        }, 
        
        created() {
            this.setRegType()        
            this.getHoa()
        }
    }
   </script>
<style>
    body {
        margin-top: 0 !important;
    }
</style>
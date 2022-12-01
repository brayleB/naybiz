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
   
   <header id="login-1" class="login-1">
    <div class="container" >
         <div class="row">
             <div class="col-lg-6 col-xl-7 d-lg-flex d-md-inline-block align-items-lg-center">
                 <div class="text-container">
                     <h1 class="h1-large text-white">Login</h1>
                     <p class="p-large text-white">Please login to access your account.</p>      		         
                 </div>
             </div> 
             <div class="loginform col-lg-5 border border-2 rounded-4 border-white bg-blur">              
              <form @submit.prevent="login" class="p-4">
                  <div class="form-group">
                    <h2 class="h2-medium text-white py-2">Hello Again!</h2>
                  </div>                            
                  <div class="form-group">
                      <input type="email" v-model="email" class="form-control-input" placeholder="Enter username or email" required />
                  </div>
                  <div class="form-group">
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
                      <button type="submit" class="form-control-submit-button">Login</button>        
                  </div>
                  <div class="form-group">
                    <p class="text-white text-center m-0 pb-2">Don`t have an account?
                        <router-link class="text-white text-decoration-none" style="padding-bottom: 1px; border-bottom: 3px solid;" 
                        to="/register">Register</router-link>
                    </p>      		         
                    <p class="text-white text-center m-0" style="margin-bottom: -.5rem;">
                        <router-link class="text-white text-decoration-none" style="padding-bottom: 1px; border-bottom: 3px solid;"
                         to="/forgot_password">Forgot password?</router-link>
                    </p>      		         
                </div>
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
    import {useConstant} from '../../store/constants';

    export default {    
        computed: {
            buttonLabel() {
                return (this.showPassword) ? "Hide" : "Show";
            }
        }, 

        methods: {
            toggleShowPassword() {
                this.showPassword = !this.showPassword;
            },
            
            async login() {                
              await this.userStore.signIn(this.email, this.password);   
              this.stat = this.userStore.response["status"]
              this.msg = this.userStore.response["message"]              
              if(this.stat==true){ 
                if(this.userStore.response["user"]["type"]=="landlord"){
                    this.$swal.fire({
                        imageUrl: "https://naybiz.com/users/success-icon.png",
                        title: "<h1 class='text-primary'>Login Successful</h1>",
                        text:'Welcome to Landlord Dashboard', 
                        color: 'black',                    
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#0066ff'        
                    })               
                    this.$router.push('/landlord/properties') 
                } 
                else if(this.userStore.response["user"]["type"]=="hoa"){
                    this.$swal.fire({
                        imageUrl: "https://naybiz.com/users/success-icon.png",
                        title: "<h1 class='text-primary'>Success</h1>",
                        text:'Welcome to HOA Dashboard', 
                        color: 'black',                    
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#0066ff'                       
                    })               
                    this.$router.push('/hoa/tenants')  
                }                                                                        
              }   
              else{
                this.$swal.fire({
                    imageUrl: "https://naybiz.com/users/error-icon.png",
                    title: "<h1 class='text-primary'>Login Failed</h1>",
                    text:'Invalid email or password', 
                    color: 'black',                                    
                    confirmButtonText: 'Retry',
                    confirmButtonColor: '#0066ff'                            
                    })
                                               
              }                                                              
            },  
            
            async checkLoggedIn() {    
                await this.userStore.fetchUser() 
                console.log(this.userStore.hasError)                               
                if(this.userStore.hasError==false){                      
                    this.$swal.fire({
                        imageUrl: "https://naybiz.com/users/success-icon.png",
                        title: "<h1 class='text-primary'>Success</h1>",
                    text:'You are currently Logged - in', 
                    color: 'black',
                    confirmButtonText: 'Confirm',
                    confirmButtonColor: '#1760E8'                            
                    }).then(async (result) => {                                       
                        if (result.isConfirmed) {  
                            if(this.userStore.currentUser['type']=='landlord'){
                                this.$router.push('/landlord/properties')    
                            }   
                            else if(this.userStore.currentUser['type']=='hoa'){
                                this.$router.push('/hoa/tenants')    
                            }                                                   
                                            
                        }
                    })                                                                                                           
                }         
            }                                 
        },
        
        setup() {          
            const userStore = useUserStore();
            return { userStore };
        },

        data() {           
            return {  
                stat: "",     
                msg: "",        
                email: "",
                password: "",
                showPassword: false
            };
        }, 

        created() {
            this.checkLoggedIn()           
        },
    }
   </script>

   <style>
    input::-ms-reveal,
    input::-ms-clear {
        display: none;
    }

    .eye-border {
        border: none !important;
        outline: none !important;
    }

    .eye-border:focus,
    .eye-border:active {
        outline: none !important;
        box-shadow: none !important;
    }
   </style>
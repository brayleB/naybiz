<template>
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
     <div class="container">             
          <div class="image-container">         
              <router-link class="navbar-brand logo-text" to="/">
                  <img class="img-fluid" src="../../../images/Logo-white.png" alt="alternative" />
              </router-link> 
              </div>          
         <button class="navbar-toggler navbar-dark p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>           
     </div> 
   </nav>
   
   <header id="login-1" class="login-1">
    <div class="container" >
         <div class="row">
             <div class="col-lg-6 col-xl-7">
                 <div class="text-container">
                     <h1 class="h1-large text-white">Login</h1>
                     <p class="p-large text-white">Please login to access your account.</p>      		         
                 </div>
             </div> 
             <div class="loginform col-lg-5">              
              <form @submit.prevent="login">
                  <div class="form-group">
                    <h2 class="h2-medium text-white">Hello Again!</h2>
                  </div>                             
                  <div class="form-group">
                      <input type="email" v-model="email" class="form-control-input" placeholder="Enter username or email" required />
                  </div>
                  <div class="form-group">
                      <input type="password" v-model="password" class="form-control-input" placeholder="Enter password" required />
                  </div>                            
                  <div class="form-group">
                      <button type="submit" class="form-control-submit-button">Login</button>        
                  </div>
                  <div class="form-group">
                    <p class="p-large text-white">Don`t have an account? <router-link class="text-white" to="/register">Register</router-link></p>      		         
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
        methods: {
            async login() {                
              await this.userStore.signIn(this.email, this.password);   
              this.stat = this.userStore.response["status"]
              this.msg = this.userStore.response["message"]              
              if(this.stat==true){ 
                if(this.userStore.response["user"]["type"]=="landlord"){
                    this.$swal.fire({
                        imageUrl: "https://naybiz.com/users/success-icon.png",
                        title: "<h1 class='text-primary'>edit</h1>",
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
            };
        }, 
        created() {
            this.checkLoggedIn()           
        }     
    }
   </script>
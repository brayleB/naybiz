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
   
   <header id="login-1" class="login-1 register-bg">
    <div class="container">
         <div class="row">
             <div class="col-xl-6 col-lg-6 d-lg-flex d-md-inline-block align-items-lg-center">
                 <div class="text-container">
                     <h1 class="h1-large text-white">Landlord Registration</h1>
                     <p class="p-large text-white">Set up your free account today!</p>      		         
                 </div>
             </div> 
             <div class="col-xl-5 col-lg-5 border border-2 rounded-4 border-white bg-register-opacity">              
              <form @submit.prevent="register" class="p-4">
                  <div class="form-group">
                    <h3 class="text-white py-3">Enter your basic account information</h3>
                  </div>               
                    <div class="form-group" v-if="this.assoc_hoa_id==null">
                        <select class="form-select" aria-label="Select" v-model="tmpHoaId"> 
                            <option value="0" selected disabled>Choose Home Owners Association</option>                                                     
                            <option :value="hoa_list.id" v-for="(hoa_list, index) in hoa_list" :key="index">{{ hoa_list.username }}</option>                                      
                        </select> 
                    </div>     
                    <div class="form-group" v-else>
                        <select class="form-select" aria-label="Select" disabled> 
                            <option :value="this.assoc_hoa_id" selected disabled>{{ this.tempHoaName }}</option>                                                                    
                        </select> 
                    </div>  
                             
                  <div class="form-group">
                      <input type="username" v-model="username" class="form-control-input" placeholder="Enter username" required />
                  </div>             
                  <div class="form-group">
                      <input type="email" v-model="email" class="form-control-input" placeholder="Enter email" required />
                  </div>
                  <div class="form-group">
                      <input type="password" v-model="password" class="form-control-input" placeholder="Enter password" required />
                  </div>  
                  <div class="form-group">
                      <input type="password" v-model="confirmpass" class="form-control-input" placeholder="Confirm password" required />
                  </div>           
                  <div class="form-group">
                      <button type="submit" class="form-control-submit-button">Submit</button>
                  </div>                  
                    <p class="p-large text-white text-center">Already have an account? <router-link class="text-white" to="/login">Login</router-link></p>      		                          
              </form>
             </div> 
         </div>      </div> 
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
        methods: {
            async register() {
                const errorstr = ""
                if(this.assoc_hoa_id==null){
                    if(this.password!=this.confirmpass){
                        this.errorstr="Password not match"
                    }   
                    else if(this.tmpHoaId==0){
                        this.errorstr="Please select your Home Owners Association"
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
                                await this.userStore.signUp(this.tmpHoaId, this.username, this.email, this.password, 'requested')
                                if(this.userStore.response['status']==false){
                                    this.errorstr=this.userStore.response['message']
                                }
                                else{
                                    this.$swal.fire({
                                        imageUrl: "https://naybiz.com/users/success-icon.png",
                                        title: "<h1 class='text-primary'>Signup Successful</h1>",                                  
                                        color: 'black',                     
                                        confirmButtonText: 'Ok',
                                        confirmButtonColor: '#0066ff'               
                                    }).then((result)=>{
                                        if(result.isConfirmed){
                                            this.$router.push('/login')
                                        }
                                    })                                
                                } 
                            }
                        })                     
                        
                    }
                    if(this.errorstr!=null){
                        this.$swal.fire({
                            imageUrl: "https://naybiz.com/users/error-icon.png",
                            title: "<h1 class='text-primary'>Invalid</h1>",
                            text:this.errorstr, 
                            color: 'black',                    
                            confirmButtonText: 'Retry',
                            confirmButtonColor: '#0066ff'                                               
                        }) 
                    }   
                }else{
                    if(this.password!=this.confirmpass){
                    this.errorstr="Password not match"
                    }              
                    else{  
                        this.errorstr=null                  
                        this.$swal.fire({
                            title: "<h1 class='text-primary'>question</h1>",
                            title: 'Do you really want to create user?',   
                            showDenyButton: true,                                                                                                                           
                            confirmButtonText: 'Yes',
                            confirmButtonColor: '#1760E8'                            
                        }).then(async (result) => {                      
                            if (result.isConfirmed) {   
                                await this.userStore.signUp(this.assoc_hoa_id, this.username, this.email, this.password, 'accepted')
                                if(this.userStore.response['status']==false){
                                    this.errorstr=this.userStore.response['message']
                                }
                                else{
                                    this.$swal.fire({                              
                                         title: "<h1 class='text-primary'>Success</h1>",
                                        title: 'Registration Successful',   
                                        confirmButtonText: 'Proceed to Login',
                                        confirmButtonColor: '#1760E8'                            
                                    }).then((result)=>{
                                        if(result.isConfirmed){
                                            this.$router.push('/login')
                                        }
                                    })                                
                                } 
                            }
                        })                     
                        
                    }
                    if(this.errorstr!=null){
                        this.$swal.fire({
                            imageUrl: "https://naybiz.com/users/error-icon.png",
                            title: "<h1 class='text-primary'>Invalid</h1>",
                            text:this.errorstr, 
                            color: 'black',                    
                            confirmButtonText: 'Retry',
                            confirmButtonColor: '#0066ff'                                      
                        }) 
                    }   
                }
                            
            },         
            setRegType(){                           
                    this.userStore.regUserType='landlord'                                                                                                    
            },
            async getHoa(){   
                if(this.assoc_hoa_id!=null){
                    await this.userStore.getUserById(this.assoc_hoa_id)      
                    if(this.userStore.response['status']==true){
                        this.tempHoaName = this.userStore.response['user']['username']
                    } 
                }                                            
            },
            async getHoaAll(){                
                await this.userStore.getHoaAll()      
                if(this.userStore.response['status']==true){
                   this.hoa_list = this.userStore.response['User']                   
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
                hoa_list:[],
                tmpHoaId:0
            };
        }, 
        
        created() {
            this.setRegType()           
            this.getHoa()
            this.getHoaAll()
        }
    }
   </script>
<style>

</style>
<template>
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
     <div class="container">             
          <div class="image-container">         
              <router-link class="navbar-brand logo-text" to="/">
                  <img class="img-fluid" src="../../../images/Logo-black.png" alt="alternative" />
              </router-link> 
            </div>          
         <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>           
     </div> 
   </nav>
   
   <header id="login-1" class="login-1">
    <div class="container" >
         <div class="row">
             <div class="col-lg-6 col-xl-7">
                 <div class="text-container">
                     <h1 class="h1-large text-white">{{userTypeStr}} Register</h1>
                     <p class="p-large text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus erat quis metus tincidunt, vel faucibus tortor convallis. Duis nec vestibulum est, ac suscipit lacus.</p>      		         
                 </div>
             </div> 
             <div class="col-lg-5">              
              <form @submit.prevent="register">
                  <div class="form-group">
                    <h2 class="h2-medium text-white">Enter required information</h2>
                  </div>
                  <div class="form-group" v-if="this.getId==null">
                    <select class="form-select" aria-label="Select"> 
                        <option value="" selected disabled>Choose Home Owners Association</option>                          
                        <option value="1">ACELA HILLS VILLAGE HOA, INC</option>
                        <option value="2">MONTEROSAS EXEC. HOA INC</option>  
                        <option value="3">LA MAREA HOA, INC.</option>
                        <option value="4">VILLA SAN PABLO SUBDIVISION HOA, INC.</option>
                        <option value="5">CABBA HOA, INC.</option>
                        <option value="6">LA MEDITERRANEA HOA, INC</option>
                        <option value="7">MONTEROYALE RESIDENCES HOA INC</option>                       
                    </select> 
                  </div>     
                  <div class="form-group" v-else>
                    <select class="form-select" aria-label="Select" disabled> 
                        <option value="" selected disabled>Choose Home Owners Association</option>                          
                        <option value="1">ACELA HILLS VILLAGE HOA, INC</option>
                        <option value="2">MONTEROSAS EXEC. HOA INC</option>  
                        <option value="3">LA MAREA HOA, INC.</option>
                        <option value="4">VILLA SAN PABLO SUBDIVISION HOA, INC.</option>
                        <option value="5">CABBA HOA, INC.</option>
                        <option value="6">LA MEDITERRANEA HOA, INC</option>
                        <option value="7">MONTEROYALE RESIDENCES HOA INC</option>                       
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
                    <p class="p-large text-white">Already have an account? <router-link class="text-white" to="/login">Login</router-link></p>      		                          
              </form>
             </div> 
         </div>      </div> 
   </header> 
   <div class="copyright bg-gray">
   <div class="container">
       <div class="row">          
           <div class="col-lg-3 col-md-12 col-sm-12">
               <p class="p-small statement">Copyright © <a href="#">Naybiz</a></p>
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
                if(this.password!=this.confirmpass){
                    this.errorstr="Password not match"
                }
                else{  
                    this.errorstr=null                  
                    this.$swal.fire({
                        icon: 'question',
                        title: 'Do you really want to create user?',   
                        showDenyButton: true,                                                                                                                           
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#1760E8'                            
                    }).then(async (result) => {                      
                        if (result.isConfirmed) {   
                            await this.userStore.signUp(this.username, this.email, this.password)
                            if(this.userStore.response['status']==false){
                                this.errorstr=this.userStore.response['message']
                            }
                            else{
                                this.$swal.fire({
                                    icon: 'success',
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
                        icon: 'error',
                        title: this.errorstr,   
                        confirmButtonText: 'Retry',
                        confirmButtonColor: '#1760E8'                            
                    }) 
                }               
            },
            setUserType(){
                if(this.userStore.regUserType=='landlord'||this.signupType==0){
                    this.userTypeStr='Landlord'
                }
                else if(this.userStore.regUserType=='hoa'||this.signupType==1){
                    this.userTypeStr='Home Owners Association'
                }                                                           
            }
                                                
        },

        setup() {          
            const userStore = useUserStore();
            return { userStore };
        },

        data() {           
            return {  
                userTypeStr: '',
                stat: "",     
                msg: "", 
                username: "",    
                email: "",
                password: "",
                confirmpass: "",
                signupType:this.$route.query['type'],
                getId:this.$route.query['id'] 
            };
        }, 
        
        created() {
            this.setUserType()
        }
    }
   </script>
<style>
.select {
    
}
</style>
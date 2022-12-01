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
             <div class="row d-flex justify-content-center">
                 <div class="loginform col-lg-5 border border-2 rounded-4 border-white bg-blur">              
                  <form @submit.prevent="login" class="p-4">
                      <div class="form-group">
                        <h2 class="h2-medium text-white py-2">Forgot Password</h2>
                      </div>                            
                      <div class="form-group">
                          <input type="email" v-model="email" class="form-control-input" placeholder="Enter email" required />
                      </div>
                      <div class="form-group">
                          <input type="text" v-model="first_name" class="form-control-input" placeholder="Enter first name" required />
                      </div>  
                      <div class="form-group">
                        <input type="text" v-model="last_name" class="form-control-input" placeholder="Enter last name" required />
                      </div>  
                      <div class="form-group">
                        <input type="text" v-model="number" class="form-control-input" placeholder="Enter contact number" required />
                      </div>                           
                      <div class="form-group">
                          <button type="submit" class="form-control-submit-button">Submit</button>        
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
    export default {
        data: function() {
            return {
                number: '',
            }
        },
        
        watch: {
            number() {
                this.number = this.number.replace(/[^0-9]/g, '');
            }
        }
    };
</script> 

<style scoped>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    appearance: none;
    margin: 0;
}

input[type=number] {
    appearance: none;
    -moz-appearance: textfield;
}
</style>
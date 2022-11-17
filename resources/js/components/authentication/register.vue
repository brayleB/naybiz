<template>         
    <div id="register" class="register-1 bg-gray">
      <div class="container">
        <div class="row">
           <div class="col-xl-12">   
                <!-- <div class="image-container">
                    <router-link class="navbar-brand logo-text" to="/">
                        <img class="img-fluid" src="../../../images/Logo-black.png" alt="alternative" />
                    </router-link>   
                 </div>                                                          
               <h2 class="h2-heading">Choose User Type</h2> -->
               <h2 class="h2-heading">Ready To Get Started?</h2>
               <p class="p-heading">Choose a plan tailor your needs</p>
           </div> 
       </div> 
       <div class="row">
           <div class="col-lg-12">   
                <router-link to="/register/landlord">                                                           
                    <div class="card" style="width: 25rem;">   
                        <div class="d-flex justify-content-between">
                            <div class="card-icon">
                                <img class="img-fluid" src="../../../images/icon-3person.png" alt="alternative" />                           
                            </div>  
                            <div class="card-fee text-end">
                                <h5 class="text-primary">Free</h5>
                                <p class="">Registration Fee</p>
                            </div>   
                        </div>     
                        <div class="card-body">
                            <h5 class="card-title">Landlord/Property manager</h5>
                            <div class="px-auto">
                                <a class="btn-solid-lg text-center" style="width: 100%;" href="#contact">Get Started</a>
                            </div>
                            <div class="py-3">
                                <ul class="text-black">
                                    <li><span>Setup account for free.</span> </li>
                                    <li><span>Pay $25 for each new registered tenant.</span></li>
                                </ul>
                            </div>
                            <!-- <p>Et blandit nisl libero at arcu. Donec ac lectus sed tellus mollis viverra. Nulawdawdlam pharetra ante at nunc elementum</p> -->
                            <a class="read-more no-line text-primary border-3 border-bottom border-primary h5" href="#">See all features</a>
                            <!-- <a class="read-more no-line text-primary" href="#">Register Now <span class="fas fa-long-arrow-alt-right text-primary"></span></a> -->
                        </div>
                    </div>
                </router-link>               
                <!-- <router-link to="/register-2" @click="userTypeRoute(2)"> 
                    <div class="card">
                        <div class="card-icon">
                                <img class="img-fluid" src="../../../images/icon-3person.png" alt="alternative"/>                           
                        </div>  
                        <div class="card-fee">
                            <h5 class="text-primary">$950.00</h5>
                            <p class="">Registration Fee</p>
                        </div>  
                        <div class="card-body">
                            <h5 class="card-title">Homeowner Association</h5>
                            <p>Vulputate nibh feugiat. Morbi pellent diam nec libero lacinia, sed ultrices velit scelerisque. Nunc placerat justo sem</p>
                            <a class="read-more no-line text-primary" href="#">Register Now <span class="fas fa-long-arrow-alt-right text-primary"></span></a>
                        </div>
                    </div>
                </router-link>     -->
                <router-link to="/register/hoa">                          
                    <div class="card" style="width: 25rem;">
                        <div class="d-flex justify-content-between">
                            <div class="card-icon">
                                <img class="img-fluid" src="../../../images/icon-3person.png" alt="alternative" />                           
                            </div>  
                            <div class="card-fee text-end">
                                <h5 class="text-primary">$950.0</h5>
                                <p class="">Registration Fee</p>
                            </div>   
                        </div>  
                        <div class="card-body">
                            <h5 class="card-title">Home Owners Association</h5>
                            <div>
                                <a class="btn-solid-lg text-center" style="width: 100%;" href="#contact">Get Started</a>
                            </div>
                            <div class="py-3">
                                <ul class="text-black">
                                    <li><span>$500/year (per association) for an account.</span> </li>
                                    <li><span>Unlimited use.</span></li>
                                </ul>
                            </div>
                            <!-- <p>Ety suscipit metus sollicitudin euqu isq imperdiet nibh nec magna tincidunt, nec pala vehicula neque sodales verum</p> -->
                            <a class="read-more no-line text-primary border-3 border-bottom border-primary h5" href="#">See all features</a>
                            <!-- <a class="read-more no-line text-primary" href="#">Register Now <span class="fas fa-long-arrow-alt-right text-primary"></span></a> -->
                        </div>
                    </div>   
               </router-link>            
           </div>
       </div>
   </div>
 </div>      
   <!-- <div class="copyright bg-gray">
        <div class="container">
            <div class="row">          
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <p class="p-small statement">Copyright © <a href="#">Naybiz</a></p>
                </div>             
            </div> 
        </div> 
    </div> -->
</template>
<script>
    import {useUserStore} from '../../store/user';
    export default {                        
        methods: {                          
        },
        setup() {          
            const userStore = useUserStore();
            return { userStore };
        },

        data() {           
            return {                
            };
        },         
    }
   </script>
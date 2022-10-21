<template>
  <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
   <div class="container">             
        <div class="image-container">
            <a class="navbar-brand logo-text" href="#">
                <img class="img-fluid" src="../../images/Logo-black.png" alt="alternative" />
            </a> 
            </div> 
       
 
       <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>
 
       <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
           <ul class="navbar-nav ms-auto navbar-nav-scroll">
               <li class="nav-item">
                   <a class="nav-link active" aria-current="page" href="#header">Home</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#services">About</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#details">Contact</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#features">Features</a>
               </li>
               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">{{ displayName }}</a>
                   <ul class="dropdown-menu" aria-labelledby="dropdown01">
                       <li><a class="dropdown-item" href="#">Article Details</a></li>
                       <li><div class="dropdown-divider"></div></li>
                       <li><a class="dropdown-item" href="#">Terms Conditions</a></li>
                       <li><div class="dropdown-divider"></div></li>
                       <li><a class="dropdown-item" href="#">Privacy Policy</a></li>
                   </ul>
               </li>
           </ul>
           <span class="nav-item">
               <a class="btn-solid-sm" href="#contact">Contact Us</a>
           </span>
       </div> 
   </div> 
 </nav>
 
 <header id="header" class="header">
  <div class="container" >
       <div class="row">
           <div class="col-lg-6 col-xl-7">
               <div class="text-container">
                   <h1 class="h1-large text-white">Welcome to Naybiz</h1>
                   <p class="p-large text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus erat quis metus tincidunt, vel faucibus tortor convallis. Duis nec vestibulum est, ac suscipit lacus.</p>
                   <router-link class="btn-solid-lg" to="/register">Register</router-link>
		           <router-link class="btn-solid-lg" to="/login">Login</router-link>	
               </div>
           </div> 
           <div class="col-lg-5">              
            <form>
                <div class="form-group">
                  <h2 class="h2-medium text-white">Get in touch with us!</h2>
                </div>             
                <div class="form-group">
                    <input type="text" class="form-control-input" placeholder="Enter First name" required />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control-input" placeholder="Enter Last name" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control-input" placeholder="Enter Email address" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control-input" placeholder="Type your messages here" required />
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control-submit-button">Submit</button>
                </div>
            </form>
           </div> 
       </div> 
   </div> 
 </header> 
 
 <div id="services" class="cards-1 bg-gray">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <h3>Tons of property, tons of possibilities</h3>  
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus erat quis metus tincidunt, vel faucibus tortor convallis. Duis nec vestibulum est, ac suscipit lacus.</p>           
           </div>                                   
       </div>
       <div class="row">
           <div class="col-lg-12">                                            
               <div class="card">
                   <div class="card-icon">
                       <span class="fas fa-headphones-alt"></span>
                   </div>
                   <div class="card-body">
                       <h5 class="card-title">Production</h5>
                       <p>Et blandit nisl libero at arcu. Donec ac lectus sed tellus mollis viverra. Nullam pharetra ante at nunc elementum</p>
                       <a class="read-more no-line text-primary" href="#">Register Now <span class="fas fa-long-arrow-alt-right text-primary"></span></a>
                   </div>
               </div>
           
               <div class="card">
                   <div class="card-icon red">
                       <span class="far fa-clipboard"></span>
                   </div>
                   <div class="card-body">
                       <h5 class="card-title">Finance</h5>
                       <p>Vulputate nibh feugiat. Morbi pellent diam nec libero lacinia, sed ultrices velit scelerisque. Nunc placerat justo sem</p>
                       <a class="read-more no-line text-primary" href="#">Register Now <span class="fas fa-long-arrow-alt-right text-primary"></span></a>
                   </div>
               </div>
             
               <div class="card">
                   <div class="card-icon green">
                       <span class="far fa-comments"></span>
                   </div>
                   <div class="card-body">
                       <h5 class="card-title">Fast Service</h5>
                       <p>Ety suscipit metus sollicitudin euqu isq imperdiet nibh nec magna tincidunt, nec pala vehicula neque sodales verum</p>
                       <a class="read-more no-line text-primary" href="#">Register Now <span class="fas fa-long-arrow-alt-right text-primary"></span></a>
                   </div>
               </div>
               
 
           </div>
       </div>
   </div>
 </div> 
 <div id="details" class="basic-1">
   <div class="container">
       <div class="row">           
           <div class="col-lg-6 col-xl-6">
               <div class="text-container">             
                   <h4>Visualize your data and make </h4>
                   <h4 class="text-primary">Better Decissions</h4>
                   <p>Curabitur in iaculis ex, vel blandit metus. Nulla ac sapien tortor. Aenean in ipsum dolor. Suspendisse potenti. Aenean porta lorem eget ipsum malesuada iaculis. Vestibulum fringilla, est nec dictum laoreet, dolor magna luctus urna, a hendrerit tortor mi a metus. Sed eleifend convallis lacus nec consequat. Mauris quis nisi tristique, consectetur arcu ut, consectetur felis. Aenean vel nisl ante. Fusce ut convallis magna. Etiam id nibh tellus. Maecenas iaculis tellus ipsum, id scelerisque lorem accumsan dignissim. Phasellus facilisis justo lacus, sed auctor justo auctor ac. Aenean at nulla eleifend, blandit nulla sed, iaculis lorem.</p>
                   <a class="btn-solid-reg" href="#contact">Contact Us</a>
               </div> 
           </div> 
           <div class="col-lg-6 col-xl-6">
               <div class="image-container">
                   <img class="img-fluid" src="../../images/houses1.jpg" alt="alternative"/>
               </div> 
           </div> 
       </div>
   </div> 
 </div>
 
 
 
 
 <div class="basic-2">
   <div class="container">
       <div class="row">
           <div class="col-lg-6 col-lg-8">
               <div class="text-container">              
                   <h2>Education</h2>
                   <ul>
                        <li>Offers pre-arrival education so tenants better understand their duties and responsibilities while living in the community.</li>
                        <li>Tenants take short online quiz on community rules. Results are sent to landlord.</li>                      
                    </ul>             
               </div> 
           </div> 
           <div class="col-lg-6 col-xl-4">
               <div class="image-container">
                   <img class="img-fluid" src="../../images/edug-bg.jpg" alt="alternative"/>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
 <div class="basic-2">
   <div class="container">
       <div class="row">
        <div class="col-lg-6 col-xl-4">
               <div class="image-container">
                   <img class="img-fluid" src="../../images/reg-bg.jpg" alt="alternative"/>
               </div> 
           </div> 
           <div class="col-lg-6 col-lg-8">
               <div class="text-container">              
                   <h2>Registration</h2>
                   <ul>
                        <li>Offers pre-arrival education so tenants better understand their duties and responsibilities while living in the community.</li>
                        <li>Tenants take short online quiz on community rules. Results are sent to landlord.</li>                      
                    </ul>             
               </div> 
           </div>            
       </div>
   </div> 
 </div> 
 <div class="basic-2">
   <div class="container">
       <div class="row">
         <div class="col-lg-6 col-lg-8">
               <div class="text-container">              
                   <h2>Communication</h2>
                   <ul>
                        <li>Offers pre-arrival education so tenants better understand their duties and responsibilities while living in the community.</li>
                        <li>Tenants take short online quiz on community rules. Results are sent to landlord.</li>                      
                    </ul>             
               </div> 
           </div> 
           <div class="col-lg-6 col-xl-4">
               <div class="image-container">
                   <img class="img-fluid" src="../../images/com-bg.jpg" alt="alternative"/>
               </div> 
           </div> 
       </div>
   </div> 
 </div>
 
 
 
 
 <div id="features" class="accordion-1">
   <div class="container">
       <div class="row">
           <div class="col-xl-12">
               <h2 class="h2-heading">Benefits of Naybiz</h2>
               <p class="p-heading">Suspendisse vitae enim arcu. Aliquam convallis risus a felis blandit, at mollis nisi bibendum. Aliquam nec purus at ex blandit posuere nec a odio. Proin lacinia dolor justo</p>
           </div> 
       </div>   
       <div class="row">
           <div class="col-xl-8">
               <div class="accordion" id="accordionExample">
                   
                  
                   <div class="accordion-item">
                       <div class="accordion-icon">
                           <span class="fas fa-phone"></span>
                       </div> 
                       <div class="accordion-header" id="headingOne">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Helps
                           </button>
                       </div>
                       <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                           <div class="accordion-body">Helps prevent tenant problems through pre-arrival education.</div>
                       </div>
                   </div>
                  
 
                  
                   <div class="accordion-item">
                       <div class="accordion-icon blue">
                           <span class="fas fa-microphone"></span>
                       </div> 
                       <div class="accordion-header" id="headingTwo">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                               Increases
                           </button>
                       </div>
                       <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                           <div class="accordion-body">Increases tenant registration in community.</div>
                       </div>
                   </div>
                  
 
                  
                   <div class="accordion-item">
                       <div class="accordion-icon purple">
                           <span class="fas fa-tools"></span>
                       </div> 
                       <div class="accordion-header" id="headingThree">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                               Improves
                           </button>
                       </div>
                       <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                           <div class="accordion-body">Improves HOA communication with tenants in the community.</div>
                       </div>
                   </div>
                  
                   
                  
                   <div class="accordion-item">
                       <div class="accordion-icon orange">
                           <span class="fas fa-fire"></span>
                       </div> 
                       <div class="accordion-header" id="headingFour">
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                               Lightens
                           </button>
                       </div>
                       <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                           <div class="accordion-body">Lightens load of HOA by outsourcing tenant registration.</div>
                       </div>
                   </div>
                  
 
               </div> 
           </div> 
           <div class="col-xl-4">
               <div class="image-container">
                   <img class="img-fluid" src="../../images/benefits.jpg" alt="alternative"/>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
 
 
 
 
 <div class="cards-2 bg-gray">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <h2 class="h2-heading">Client testimonials</h2>
           </div> 
       </div>
       <div class="row">
           <div class="col-lg-12">
 
               
               <div class="card">
                   <img class="quotes" src="../../images/quotes.svg" alt="alternative" />
                   <div class="card-body">
                       <p class="testimonial-text">Suspendisse vitae enim arcu. Aliqu convallis risus a felis blandit, at mollis nisi bibendum aliquam noto ricos</p>
                       <div class="testimonial-author">Roe Smith</div>
                       <div class="occupation">General Manager, Presentop</div>
                   </div>
                   <div class="gradient-floor red-to-blue"></div>
               </div>
             
 
               
               <div class="card">
                   <img class="quotes" src="../../images/quotes.svg" alt="alternative" />
                   <div class="card-body">
                       <p class="testimonial-text">Suspendisse vitae enim arcu. Aliqu convallis risus a felis blandit, at mollis nisi bibendum aliquam noto ricos</p>
                       <div class="testimonial-author">Sam Bloom</div>
                       <div class="occupation">General Manager, Presentop</div>
                   </div>
                   <div class="gradient-floor blue-to-purple"></div>
               </div>
             
 
               
               <div class="card">
                   <img class="quotes" src="../../images/quotes.svg" alt="alternative" />
                   <div class="card-body">
                       <p class="testimonial-text">Suspendisse vitae enim arcu. Aliqu convallis risus a felis blandit, at mollis nisi bibendum aliquam noto ricos</p>
                       <div class="testimonial-author">Bill McKenzie</div>
                       <div class="occupation">General Manager, Presentop</div>
                   </div>
                   <div class="gradient-floor purple-to-green"></div>
               </div>
             
               
               
               <div class="card">
                   <img class="quotes" src="../../images/quotes.svg" alt="alternative" />
                   <div class="card-body">
                       <p class="testimonial-text">Suspendisse vitae enim arcu. Aliqu convallis risus a felis blandit, at mollis nisi bibendum aliquam noto ricos</p>
                       <div class="testimonial-author">Vanya Dropper</div>
                       <div class="occupation">General Manager, Presentop</div>
                   </div>
                   <div class="gradient-floor red-to-blue"></div>
               </div>
             
 
               
               <div class="card">
                   <img class="quotes" src="../../images/quotes.svg" alt="alternative" />
                   <div class="card-body">
                       <p class="testimonial-text">Suspendisse vitae enim arcu. Aliqu convallis risus a felis blandit, at mollis nisi bibendum aliquam noto ricos</p>
                       <div class="testimonial-author">Lefty Brown</div>
                       <div class="occupation">General Manager, Presentop</div>
                   </div>
                   <div class="gradient-floor blue-to-purple"></div>
               </div>
             
 
               
               <div class="card">
                   <img class="quotes" src="../../images/quotes.svg" alt="alternative" />
                   <div class="card-body">
                       <p class="testimonial-text">Suspendisse vitae enim arcu. Aliqu convallis risus a felis blandit, at mollis nisi bibendum aliquam noto ricos</p>
                       <div class="testimonial-author">Susane Blake</div>
                       <div class="occupation">General Manager, Presentop</div>
                   </div>
                   <div class="gradient-floor purple-to-green"></div>
               </div>
             
 
           </div> 
       </div>
   </div> 
 </div> 
 
 
 
 
 <!-- <div class="slider-1">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <h4>Trusted by over <span class="blue">5000</span> customers worldwide</h4>
               <hr class="section-divider" />             
               <div class="slider-container">
                   <div class="swiper-container image-slider">
                       <div class="swiper-wrapper">
                           <div class="swiper-slide">
                               <img class="img-fluid" src="../../images/customer-logo-1.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="../../images/customer-logo-2.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="../../images/customer-logo-3.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="../../images/customer-logo-4.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="../../images/customer-logo-5.png" alt="alternative" />
                           </div>
                           <div class="swiper-slide">
                               <img class="img-fluid" src="../../images/customer-logo-6.png" alt="alternative" />
                           </div>
                       </div>
                   </div> 
               </div> 
              
 
           </div> 
       </div>
   </div> 
 </div>  -->
 
 <div class="basic-3">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <div class="text-container">
                   <h2>Find the right estate for you</h2>
                   <p class="p-large">Eu convallis arcu ultrices in. Mauris ornare libero et pharetra hendrerit. Curabitur elementum lectus quis vioc tellus</p>
                   <a class="btn-solid-lg" href="#contact">Find now</a>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
 <div id="contact" class="form-1">
   <div class="container">
       <div class="row">
           <div class="col-lg-6">
               <div class="text-container">                
                   <h2>Find your right estate</h2>
                   <p>Aliquam et enim vel sem pulvinar suscipit sit amet quis lorem. Sed risus ipsum, egestas sed odio in, pulvinar euismod ipsum. Sed ut enim non nunc fermentum dictum et sit amet erat. Maecenas</p>
                   <ul class="list-unstyled li-space-lg">
                       <li class="d-flex">
                           <i class="fas fa-square"></i>
                           <div class="flex-grow-1">Vel maximus nunc aliquam ut. Donec semper, magna a pulvinar</div>
                       </li>
                       <li class="d-flex">
                           <i class="fas fa-square"></i>
                           <div class="flex-grow-1">Suscipit sit amet quis lorem. Sed risus ipsum, egestas mare</div>
                       </li>
                       <li class="d-flex">
                           <i class="fas fa-square"></i>
                           <div class="flex-grow-1">Sem pulvinar suscipit sit amet quis lorem. Sed risus</div>
                       </li>
                   </ul>
               </div> 
           </div> 
           <div class="col-lg-6">
 
              
               <form>
                   <div class="form-group">
                       <input type="text" class="form-control-input" placeholder="Name" required />
                   </div>
                   <div class="form-group">
                       <input type="email" class="form-control-input" placeholder="Email" required />
                   </div>
                   <div class="form-group">
                       <input type="text" class="form-control-input" placeholder="Contact Number" required />
                   </div>
                   <div class="form-group">
                       <input type="text" class="form-control-input" placeholder="Estate Name" required />
                   </div>
                   <div class="form-group">
                       <button type="submit" class="form-control-submit-button">Submit</button>
                   </div>
               </form>
             
 
           </div> 
       </div>
   </div> 
 </div>
 
 <div class="footer" style="background-color: #1760E8;">
   <div class="container">
       <div class="row">
           <div class="col-lg-12">
               <h4>Follow us</h4>
               <div class="social-container">
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-facebook-f fa-stack-1x"></i>
                       </a>
                   </span>
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-twitter fa-stack-1x"></i>
                       </a>
                   </span>
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-pinterest-p fa-stack-1x"></i>
                       </a>
                   </span>
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-instagram fa-stack-1x"></i>
                       </a>
                   </span>
                   <span class="fa-stack">
                       <a href="#your-link">
                           <i class="fas fa-circle fa-stack-2x"></i>
                           <i class="fab fa-youtube fa-stack-1x"></i>
                       </a>
                   </span>
               </div> 
           </div> 
       </div>
   </div> 
 </div> 
 <div class="copyright bg-gray">
   <div class="container">
       <div class="row">
           <div class="col-lg-6 col-md-12 col-sm-12">
               <ul class="list-unstyled li-space-lg p-small">
                   <li><a href="#">Article Details</a></li>
                   <li><a href="#">Terms & Conditions</a></li>
                   <li><a href="#">Privacy Policy</a></li>
               </ul>
           </div> 
           <div class="col-lg-3 col-md-12 col-sm-12">
               <p class="p-small statement">Copyright © <a href="#">Naybiz</a></p>
           </div> 
            
       </div> 
   </div> 
 </div>
 
 <button id="myBtn">
   <img src="../../images/up-arrow.png" alt="alternative" />
 </button>
 </template>

<script>
    import {useUserStore} from '../store/user';
    export default {                        
        methods: {                
             async getCurrentUser() {                
                await this.userStore.fetchUser(); 
              if(this.userStore.accessToken==null){
                this.displayName = "Hello User"                            
              }                
              else{
                this.displayName = this.userStore.currentUser['firstname']+" "+this.userStore.currentUser['lastname']       
              }
            },                                       
        },

        setup() {                 
            const userStore = useUserStore();           
            return { userStore };
        },

        data() {           
            return {  
                displayName: ""                  
            };
        },
        mounted() {                
            this.getCurrentUser()                
        }      
    }
</script>
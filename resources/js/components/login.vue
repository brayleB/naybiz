<template>
    <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
     <div class="container">             
          <div class="image-container">         
              <router-link class="navbar-brand logo-text" to="/">
                  <img class="img-fluid" src="../../images/Logo-black.png" alt="alternative" />
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
                     <h1 class="h1-large text-white">Login</h1>
                     <p class="p-large text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus erat quis metus tincidunt, vel faucibus tortor convallis. Duis nec vestibulum est, ac suscipit lacus.</p>      		         
                 </div>
             </div> 
             <div class="col-lg-5">              
              <form>
                  <div class="form-group">
                    <h2 class="h2-medium text-white">Hello Again!</h2>
                  </div>             
                  <div class="form-group">
                      <input type="email" class="form-control-input" placeholder="Enter username or email" required />
                  </div>
                  <div class="form-group">
                      <input type="password" class="form-control-input" placeholder="Enter password" required />
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
   </script>
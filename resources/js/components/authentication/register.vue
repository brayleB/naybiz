<template>
    <div id="register" class="register-1 register-1-bg" style="padding-top: 8rem;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="image-container">
                        <router-link class="navbar-brand logo-text" to="/">
                            <img class="img-fluid" src="../../../images/Logo-black.png" alt="alternative" />
                        </router-link>
                    </div>
                    <h2 class="h2-heading">Choose User Type</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <router-link to="/register/landlord" style="text-decoration: none;">
                        <div class="card mx-lg-4 mx-md-auto" style="width: 25rem;">
                            <div class="d-flex justify-content-between">
                                <div class="card-icon">
                                    <img class="img-fluid" src="../../../images/icon-3person.png" alt="alternative" />
                                </div>
                                <div class="card-fee text-end">
                                    <h5 class="text-primary">Free</h5>
                                    <p class="text-light-blue">Registration Fee</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title pb-4">Landlord/Property Manager</h5>
                                <div class="py-3">
                                    <ul class="text-light-blue">
                                        <li><span>Setup account for free.</span></li>
                                        <li><span>Pay $25 for each new registered tenant.</span></li>
                                    </ul>
                                </div>
                                <!-- <p>Et blandit nisl libero at arcu. Donec ac lectus sed tellus mollis viverra. Nulawdawdlam pharetra ante at nunc elementum</p> -->
                                <a class="read-more no-line text-primary border-3 border-bottom pb-1 border-primary h5"
                                    href="#">Register Now</a>
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
                    <router-link to="/register/hoa" style="text-decoration: none;">
                        <div class="card mx-lg-4 mx-md-auto" style="width: 25rem; margin-inline: 1rem;">
                            <div class="d-flex justify-content-between">
                                <div class="card-icon">
                                    <img class="img-fluid" src="../../../images/icon-3person.png" alt="alternative" />
                                </div>
                                <div class="card-fee text-end">
                                    <h5 class="text-primary">$950.00</h5>
                                    <p class="text-light-blue">Registration Fee</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Homeowner Association/ Community Manager</h5>
                                <div class="py-3">
                                    <ul class="text-light-blue">
                                        <li><span>$500/year (per association) for an account.</span></li>
                                        <li><span>Unlimited use.</span></li>
                                    </ul>
                                </div>
                                <!-- <p>Ety suscipit metus sollicitudin euqu isq imperdiet nibh nec magna tincidunt, nec pala vehicula neque sodales verum</p> -->
                                <a class="read-more no-line text-primary border-3 border-bottom pb-1 border-primary h5"
                                    href="#">Register Now</a>
                                <!-- <a class="read-more no-line text-primary" href="#">Register Now <span class="fas fa-long-arrow-alt-right text-primary"></span></a> -->
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
    <!-- <footer>
        <div class="copyright">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <p class="p-small text-light-blue">Naybiz ?? Copyright 2022, Inc. All rights reserved</p>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mx-lg-0 mx-md-0 mx-sm-auto"
                        style="width: 11.5rem;">
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
    </footer> -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 text-center mt-3">
                    <p class="p-small text-light-blue">Naybiz ?? Copyright 2022, Inc. All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- <div class="copyright bg-gray">
        <div class="container">
            <div class="row">          
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <p class="p-small statement">Copyright ?? <a href="#">Naybiz</a></p>
                </div>             
            </div> 
        </div> 
    </div> -->
</template>
<script>
    import { useUserStore } from '../../store/user';
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
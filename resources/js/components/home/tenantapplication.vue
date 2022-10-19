<template>
    <div class="container-fluid">                                             
        <div class="row d-flex justify-content-center">          
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header text-center">Tenant Application Form</div>
                    <div class="card-body">
                        <form @submit.prevent="tenantApplication">                                          
                            <div class="card-body text-center mb-3">
                                <!-- Profile picture image-->
                                <img class="img-account-profile image-responsive mb-2" src="https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png" alt="">                            
                                <!-- Profile picture help block-->
                                <div class="large font-italic text-blue">Valid ID</div>                             
                                <div class="small font-italic text-muted mb-3">JPG or PNG no larger than 5 MB</div>                             
                                <!-- Profile picture upload button-->
                                <button class="btn btn-primary" type="button">Upload</button>
                            </div>                                    
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName" >First name</label>
                                    <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" v-model="firstname" required>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                    <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" v-model="lastname" required>
                                </div>
                            </div>
                             <!-- Form Group (email address)-->
                             <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                <input class="form-control" id="inputEmailAddress" type="email" placeholder="Enter your email address" v-model="email" required>
                            </div>
                            <div class="row gx-3 mb-3">                              
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Contact number</label>
                                    <input class="form-control" id="inputPhone"  placeholder="Enter your phone number" v-model="contact" required>
                                </div>
                              
                            </div>  
                            <!-- Form Group (address)-->
                            <div class="mb-5">
                                <label class="small mb-1" for="inputEmailAddress">Location / Address</label>
                                <input class="form-control" id="inputEmailAddress" type="text" placeholder="San Francisco, California" v-model="address" required>
                            </div>                       
                                                   
                            <!-- Form Row-->                           
                            <!-- Save changes button-->                         
                           <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Submit Application</button>
                            </div>                                                                                     
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</template>

<script>
    import {useTenantStore} from '../../store/tenant';
    export default {                        
        methods: {
            async tenantApplication() {
                const errorstr = null
                this.$swal.fire({
                        icon: 'question',
                        title: 'Do you really want to apply?',   
                        showDenyButton: true,                                                                                                                           
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#1760E8'                            
                    }).then(async (result) => {                      
                        if (result.isConfirmed) {   
                            await this.tenantStore.addTenant(this.firstname, this.lastname, this.email, this.contact, this.address,  this.valid_id, "new")  
                            if(this.tenantStore.response['status']==true)
                            {
                                //enter here when added
                            }                        
                        }
                    }) 
              },                                                    
        },

        setup() {          
            const tenantStore = useTenantStore();
            return { tenantStore };
        },

        data() {           
            return {  
                landlord_id:this.$route.query['id'],                
                firstname:"",
                lastname:"",
                email:"",
                address:"",
                contact:"",
                valid_id:"https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png",
            };
        },   
        created() {
            if(this.landlord_id!=null&&this.landlord_id!=""){
                this.tenantStore.landlord_id=this.landlord_id
            }
            else {
                console.log('null')
            }            
        }        
    }
   </script>

<style>


.card {
    box-shadow: 0 0.15rem .1rem 0 rgb(33 40 50 / 15%); 
    padding: 5%;      
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}

.img-account-profile {
    height: 15rem;
}

.form-control, .dataTable-input {
    display: o;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

</style>

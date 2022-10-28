<template>
    <div class="container-fluid">                                             
        <div class="row d-flex justify-content-center">          
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header text-center">Tenant Application Form</div>
                    <div class="card-body">
                        <form @submit.prevent="tenantApplication"> 
                            <div class="large font-italic text-blue">* Main Information</div>                                                                      
                            <hr class="solid"/>
                            <div class="mb-3">
                                <label class="small mb-1" for="property_name">Property Address</label>
                                <input class="form-control" id="property_name" type="text"  v-model="property_address" required>
                            </div>   
                            <div class="mb-3">
                                <label class="small mb-1" for="hoa_name">HOA Name</label>
                                <input class="form-control" id="hoa_name" type="text"  v-model="hoa_name" required>
                            </div>                                                       
                            <div class="row gx-3 mb-3">                            
                                <div class="col-md-6">
                                    <label class="small mb-1" for="first_name" >First name</label>
                                    <input class="form-control" id="first_name" type="text"  v-model="firstname" required>
                                </div>                          
                                <div class="col-md-6">
                                    <label class="small mb-1" for="last_name">Last name</label>
                                    <input class="form-control" id="last_name" type="text"  v-model="lastname" required>
                                </div>
                            </div>                      
                             <div class="mb-3">
                                <label class="small mb-1" for="email_add">Email address</label>
                                <input class="form-control" id="email_add" type="email"  v-model="email" required>
                            </div>
                            <div class="row gx-3 mb-3">                              
                                <div class="col-md-6">
                                    <label class="small mb-1" for="phone_number">Phone number</label>
                                    <input class="form-control" id="phone_number"  v-model="contact" required>
                                </div>                              
                            </div>                                                       
                            <div class="mb-5">
                                <label class="small mb-1" for="current_address">Current Address</label>
                                <input class="form-control" id="current_address" type="text"  v-model="current_address" required>
                            </div>  
                           
                            <div class="large font-italic text-blue">* Names of any other occupants over 18 years old</div>  
                            <hr class="solid"/>                                      
                            <button class="btn btn-success mb-2" id="addOcc" type="button"><span class="fas fa-plus"></span></button>                         
                            <div class="col-md-10 mb-3">                                   
                                <label class="small mb-1" for="occName" >Full Name</label>
                                <input class="form-control" id="occName" type="text"  v-model="firstname" required>                                   
                            </div>                                                                                                                                                                                                                                                                                                                                
                            <ol class="list-group list-group-numbered mb-5">
                                <li class="list-group-item">No occupants</li>                               
                            </ol>                   
                            <div class="large font-italic text-blue">* Vehicle Information</div>  
                            <hr class="solid"/>   
                            <button class="btn btn-success mb-2" id="addVehicle" type="button"><span class="fas fa-plus"></span></button>                           
                            <div class="row gx-3 mb-3">                            
                                <div class="col-md-2">
                                    <label class="small mb-1" for="vcYear" >Year</label>
                                    <input class="form-control" id="vcYear" type="text" v-model="firstname" required>
                                </div>                          
                                <div class="col-md-3">
                                    <label class="small mb-1" for="vcMake">Make</label>
                                    <input class="form-control" id="vcMake" type="text"  v-model="lastname" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small mb-1" for="vcModel">Model</label>
                                    <input class="form-control" id="vcModel" type="text"  v-model="lastname" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small mb-1" for="vcLicense">License plate number</label>
                                    <input class="form-control" id="vcLicense" type="text" v-model="lastname" required>
                                </div>
                            </div>      
                            <ol class="list-group list-group-numbered mb-5">
                                <li class="list-group-item">No vehicles</li>                                
                            </ol>                                           
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
                                this.$swal.fire({
                                    icon: 'success',
                                    title: 'Application Submitted',                                                                                                                                                              
                                    confirmButtonText: 'Confirm',
                                    confirmButtonColor: '#1760E8'                            
                                }).then(async (result) => { 
                                    if (result.isConfirmed) {  
                                        this.contact=""
                                        this.firstname=""
                                        this.lastname=""
                                        this.email=""
                                        this.address=""                                        
                                    }
                                })
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

hr.solid {
  border-top: 3px solid rgb(15, 14, 14);
}
</style>

import { defineStore } from "pinia";
import { useStorage } from '@vueuse/core'
import {useUserStore} from './user'
import { useConstant } from "./constants";

export const useTenantStore = defineStore({  
  id: 'tenant_store',
  state: () => ({   
    error:null,
    response: null,
    landlord_id: null,
    tenants: [],     
  }),      
  actions: {   
    async fetchTenantByLandlordId() {                
      const landlord_id = useUserStore().currentUser['id']
      try {
        const res = await fetch(useConstant().baseUrl+"api/tenant/get",{
            method: "POST",    
            headers: {        
                "Content-Type": "application/json",
                "Authorization": "Bearer "+useUserStore().accessToken,
              }, 
            body: JSON.stringify({ landlord_id }),            
        });            
        const response = await res.json();
        this.response = response     
        if(response['status']==true)
        {          
          this.tenants=response['tenants']       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },
    async addTenant(first_name, last_name, email, contact_no, address, valid_id, status) { 
        const landlord_id=this.landlord_id
      if(landlord_id!=null)
      {
        try{
            const res = await fetch(useConstant().baseUrl+"api/tenant/add", {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            },
            body: JSON.stringify({ landlord_id, first_name, last_name, email, contact_no, address, valid_id, status}),           
        })
        const resp = await res.json();
        this.response = resp;
        }catch(error){
            this.response = error
        }               
      }
        
    },
    // async signIn(email, password) {
    //   const res = await fetch("http://127.0.0.1:8000/api/auth/login", {
    //     method: "POST",
    //     headers: {
    //       "Content-Type": "application/json",
    //     },
    //     body: JSON.stringify({ email, password }),
    //   });
    //   const response = await res.json();
    //   this.response = response;  
    //   if(response['status']==true){
    //     this.accessToken = response['token']
    //   }             
    // },
    // async logoutUser() {         
    //   const res = await fetch("http://127.0.0.1:8000/api/auth/logout",{
    //       method: "POST",    
    //       headers: {        
    //            "Authorization": "Bearer "+this.accessToken,
    //          },             
    //   });            
    //   const userResp = await res.json();
    //   if(userResp['status']==true){               
    //     this.currentUser = []
    //     this.accessToken = null
    //   }      
    // },
  },
  persist: {
    enabled: true,    
  }

  
});
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
    requestedTenants:[],
    acceptedTenants: [],     
  }),      
  actions: {   
    async fetchTenantByLandlordId() {  
      useConstant().loader=true              
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
          useConstant().loader=false       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },
    async fetchTenantByLandlordIdAccepted() {                
      const landlord_id = useUserStore().currentUser['id']
      try {
        const res = await fetch(useConstant().baseUrl+"api/tenant/get/accepted",{
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
          this.acceptedTenants=response['tenants']       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },
    async fetchTenantByLandlordIdRequested() {                
      const landlord_id = useUserStore().currentUser['id']
      try {
        const res = await fetch(useConstant().baseUrl+"api/tenant/get/requested",{
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
          this.requestedTenants=response['tenants']       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },
    async addTenant(first_name, last_name, email, contact_no, address, status, valid_id, occupants, vehicles, property_id) { 
      const landlord_id=this.landlord_id
      if(landlord_id!=null)
      {
        try{
            const res = await fetch(useConstant().baseUrl+"api/tenant/add", {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            },
            body: JSON.stringify({ landlord_id, first_name, last_name, email, contact_no, address, status, valid_id, occupants, vehicles, property_id}),           
        })
        const resp = await res.json();
        this.response = resp;
        }catch(error){
            this.response = error
        }               
      }        
    },  
    async acceptTenant(id) {       
      try{
          const res = await fetch(useConstant().baseUrl+"api/tenant/accept", {
          method: "POST",
          headers: {
          "Content-Type": "application/json",
          "Authorization": "Bearer "+useUserStore().accessToken,
          },
          body: JSON.stringify({id}),                       
      })
      const resp = await res.json();
      this.response = resp;       
      }catch(error){
          this.response = error
      }                          
    },   
    async getTenantById(id) {     
      const res = await fetch(useConstant().baseUrl+'api/tenant/get/id', {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({id}),
      });
      const response = await res.json()
      this.response = response;         
    },
    //workon
    async getTenantByHOAIdRequested() {                
      const hoa = useUserStore().currentUser['id']
      try {
        const res = await fetch(useConstant().baseUrl+"api/tenant/get/hoa/requested/"+hoa,{
            method: "GET",    
            headers: {                   
                "Authorization": "Bearer "+useUserStore().accessToken,
              },                       
        });            
        const response = await res.json();
        this.response = response     
        if(response['status']==true)
        {          
          this.requestedTenants=response['tenants']       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },
    //workon
    async getTenantByHOAIdAccepted() {                
      const hoa = useUserStore().currentUser['id']
      try {
        const res = await fetch(useConstant().baseUrl+"api/tenant/get/hoa/accepted/"+hoa,{
            method: "GET",    
            headers: {                   
                "Authorization": "Bearer "+useUserStore().accessToken,
              },                       
        });            
        const response = await res.json();
        this.response = response     
        if(response['status']==true)
        {          
          this.acceptedTenants=response['tenants']       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },    
    async inviteTenant(email,first_name,last_name,link) {     
      const res = await fetch(useConstant().baseUrl+'api/invite/tenant', {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({ email, first_name, last_name, link}),
      });
      const response = await res.json()
      this.response = response;         
    },

  },
  persist: {
    enabled: true,    
  }

  
});
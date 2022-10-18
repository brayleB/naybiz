import { defineStore } from "pinia";
import { useStorage } from '@vueuse/core'

export const useTenantStore = defineStore({
  id: 'tenant_store',
  state: () => ({   
    response: null,
    landlord_id: null,
    data: [],  
    // currentUser: useStorage('currentUser', []),    
  }),

  actions: {
    // async fetchUser() {  
    //   console.log(this.accessToken)
    //   try {
    //     const res = await fetch("http://127.0.0.1:8000/api/user",{
    //         method: "GET",    
    //         headers: {        
    //             "Authorization": "Bearer "+this.accessToken,
    //           },             
    //     });            
    //     const userResp = await res.json();
    //     this.currentUser = userResp;
    //   } catch (error) {  
    //     this.error = error              
    //     return error
    //   }
            
    // },
    async addTenant(first_name, last_name, email, contact_no, address, valid_id, status) { 
        const landlord_id=this.landlord_id
      if(landlord_id!=null)
      {
        try{
            const res = await fetch("http://127.0.0.1:8000/api/tenant/add", {
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
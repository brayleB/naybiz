import { defineStore } from "pinia";
import { useStorage } from '@vueuse/core'
import {useConstant} from './constants'
export const useUserStore = defineStore({
  id: 'main',
  state: () => ({  
    regUserType: null,    
    response: null,
    currentUser: useStorage('currentUser', []),
    accessToken: useStorage('accessToken', null)
  }),

  actions: {
    async fetchUser() {     
      console.log('token fetched user '+this.accessToken)
      try {
        const res = await fetch(useConstant().baseUrl+"api/user",{
            method: "GET",    
            headers: {        
                "Authorization": "Bearer "+this.accessToken,
              },             
        });            
        const userResp = await res.json();
        this.currentUser = userResp;            
      } catch (error) {  
        this.error = error              
        return error
      }            
    },
    async getUserById(id) {     
      try {
        const res = await fetch(useConstant().baseUrl+"api/user/get/"+id,{
            method: "GET",    
            headers: {        
                "Authorization": "Bearer "+this.accessToken,
              },             
        });            
        const resp = await res.json();
        this.response = resp;            
      } catch (error) {  
        this.error = error              
        return error
      }            
    },
    async signUp(assoc_hoa_id, username, email, password, status) {  
      const image = 'https://www.seekpng.com/png/detail/110-1100707_person-avatar-placeholder.png'  
      const type = this.regUserType
      
      const res = await fetch(useConstant().baseUrl+"api/auth/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ assoc_hoa_id, username, email, password, type, status }),
      });
      const response = await res.json()
      this.response = response;  
      console.log(type)    
    },
    async signIn(email, password) {
      const res = await fetch(useConstant().baseUrl+"api/auth/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      });
      const response = await res.json();
      this.response = response;  
      if(response['status']==true){
        this.accessToken = this.response['token']
      }             
    },
    async logoutUser() {   
      try{
        const res = await fetch(useConstant().baseUrl+"api/auth/logout",{
          method: "POST",    
          headers: {        
               "Authorization": "Bearer "+this.accessToken,
             },             
        });            
        const userResp = await res.json();
        if(userResp['status']==true){               
          this.currentUser = []
          this.accessToken = null
        }   
      } 
      catch(e)
      {
        this.currentUser = []
        this.accessToken = null
        this.error = e
      }              
    },
    async updateUser(email, image, first_name, last_name, contact_no, address, city, state, country) {
      const id = this.currentUser['id']       
      try{
        let formData = new FormData()
        formData.append('email',email)
        formData.append('image',image)
        formData.append('first_name',first_name)
        formData.append('last_name',last_name)
        formData.append('contact_no',contact_no)
        formData.append('address',address)
        formData.append('city',city)
        formData.append('state',state)
        formData.append('country',country)   
        const res = await fetch(useConstant().baseUrl+"api/user/"+id,{
          method: "POST",    
          headers: {                                             
               "Authorization": "Bearer "+this.accessToken,
             },   
          body: formData,          
        });                  
        const userResp = await res.json();
        this.response = userResp        
        if(userResp['status']==true){                       
          this.currentUser = userResp['user']                                              
        }   
      } 
      catch(e){
        this.response = e
      }
      
    },    
      async getLandlordsByHOAIdRequested() {                
        const hoa = useUserStore().currentUser['id']
        try {
          const res = await fetch(useConstant().baseUrl+"api/landlord/get/hoa/requested/"+hoa,{
              method: "GET",    
              headers: {                   
                  "Authorization": "Bearer "+useUserStore().accessToken,
                },                       
          });            
          const response = await res.json();
          this.response = response                    
        } catch (error) {         
          this.error = error              
          return error
        }            
      },       
       async getLandlordsByHOAIdAccepted() {                
        const hoa = useUserStore().currentUser['id']
        try {
          const res = await fetch(useConstant().baseUrl+"api/landlord/get/hoa/accepted/"+hoa,{
              method: "GET",    
              headers: {                   
                  "Authorization": "Bearer "+useUserStore().accessToken,
                },                       
          });            
          const response = await res.json();
          this.response = response                     
        } catch (error) {         
          this.error = error              
          return error
        }            
      },
      async getHoaAll() {                     
        try {
          const res = await fetch(useConstant().baseUrl+"api/hoa/get",{
              method: "GET",    
              headers: {                   
                  "Authorization": "Bearer "+useUserStore().accessToken,
                },                       
          });            
          const response = await res.json();
          this.response = response                     
        } catch (error) {         
          this.error = error              
          return error
        }            
      },
  },
  persist: {
    enabled: true,    
  }

  
});
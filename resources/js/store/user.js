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
    async signUp(username, email, password) {
      const type = this.regUserType
      const status = "new"
      const res = await fetch(useConstant().baseUrl+"api/auth/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ username, email, password, type, status }),
      });
      const response = await res.json()
      this.response = response;
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
  },
  persist: {
    enabled: true,    
  }

  
});
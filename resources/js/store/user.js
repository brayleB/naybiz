import { defineStore } from "pinia";
import { useStorage } from '@vueuse/core'

export const useUserStore = defineStore({
  id: 'main',
  state: () => ({   
    usertype: null,
    response: null,
    currentUser: useStorage('currentUser', []),
    accessToken: useStorage('accessToken', null)
  }),

  actions: {
    async fetchUser() {  
      console.log(this.accessToken)
      try {
        const res = await fetch("http://127.0.0.1:8000/api/user",{
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
      const type = "landlord"
      const status = "new"
      const res = await fetch("http://127.0.0.1:8000/api/auth/register", {
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
      const res = await fetch("http://127.0.0.1:8000/api/auth/login", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      });
      const response = await res.json();
      this.response = response;  
      if(response['status']==true){
        this.accessToken = response['token']
      }             
    },
    async logoutUser() {         
      const res = await fetch("http://127.0.0.1:8000/api/auth/logout",{
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
    },
  },
  persist: {
    enabled: true,    
  }

  
});
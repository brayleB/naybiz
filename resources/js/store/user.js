import { defineStore } from "pinia";
import { useStorage } from '@vueuse/core'

export const useUserStore = defineStore({
  id: 'main',
  state: () => ({
    response: "",
    currentUser: useStorage('currentUser', []),
    accessToken: useStorage('accessToken', null)
  }),

  actions: {
    async fetchUser() {       
      const res = await fetch("http://127.0.0.1:8000/api/user",{
          method: "GET",    
          headers: {        
               "Authorization": "Bearer "+this.accessToken,
             },             
      });            
      const userResp = await res.json();
      this.currentUser = userResp;      
    },
    async signUp(email, password) {
      const res = await fetch("http://127.0.0.1:8000/api/auth/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ email, password }),
      });
      const user = await res.json()
      this.user = user;
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
  },
  persist: {
    enabled: true,    
  }

  
});
import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    response: null,
    user: null,
    token: null
  }),

  actions: {
    async fetchUser() {     
      const res = await fetch("http://127.0.0.1:8000/api/user",{
          method: "GET",    
          headers: {        
               "Authorization": "Bearer "+this.token,
             },    
      });      
      const user = await res.json();
      this.user = user;
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
      const userresponse = await res.json();
      this.response = userresponse;      
    },
  },
});
import { defineStore } from "pinia";
import { useConstant } from "./constants";
import { useUserStore } from "./user";

export const useQuestionStore = defineStore({  
  id: 'question_store',
  state: () => ({   
    error:null,
    response: null,     
    question_list: []
  }),      
  actions: 
  {   
    // async questionAdd() {        
    //   const hoa_id = 1
    //   const landlord_id = useUserStore().currentUser['id']
    //   const res = await fetch(useConstant().baseUrl+useConstant().apiPropertyAdd, {
    //     method: "POST",
    //     headers: {
    //       "Authorization": "Bearer "+useUserStore().accessToken,
    //       "Content-Type": "application/json"          
    //     },
    //     body: JSON.stringify({ name, hoa_id, landlord_id, address, description, image, price, status}),
    //   });
    //   const response = await res.json()
    //   this.response = response;
    // },
    async displayQuestions() {   
      const hoa_id = 1      
      const res = await fetch(useConstant().baseUrl+ useConstant().apiQuestionFetch, {
        method: "POST",
        headers: {    
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({hoa_id}),
      });
      const response = await res.json()      
      if(response['status']==true){
        this.question_list = response['questions']        
      }   
      this.response = response;  
    },
  },  
  
});
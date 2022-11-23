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
    async questionAdd(type, question, options, answer, description, status) {        
      const hoa_id = useUserStore().currentUser['id']    
      const res = await fetch(useConstant().baseUrl+'api/question/add', {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({  hoa_id, type, question, options, answer, description, status}),
      });
      const response = await res.json()
      this.response = response;
    },
    async displayQuestions(id) {     
      var hoa_id = id
      if(useUserStore().currentUser['type']=='landlord'){
        hoa_id=useUserStore().currentUser['assoc_hoa_id']        
      }
      else if(useUserStore().currentUser['type']=='hoa'){
        hoa_id=useUserStore().currentUser['id']       
      } 
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
    async deleteQuestion(id) { 
      useConstant().loader = true
      try{
          const res = await fetch(useConstant().baseUrl+"api/question/delete", {
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
      useConstant().loader = false                         
    }, 
  },  
  
});
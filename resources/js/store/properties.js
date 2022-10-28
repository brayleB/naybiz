import { defineStore } from "pinia";
import { useStorage } from '@vueuse/core'
import { useConstant } from "./constants";

export const usePropertiesStore = defineStore({  
  id: 'tenant_store',
  state: () => ({   
    error:null,
    response: null,
    addState: false,   
  }),      
  actions: {   
   
    },
  persist: {
    enabled: true,    
  }

  
});
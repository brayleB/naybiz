import { defineStore } from "pinia";
import { useConstant } from "./constants";
import { useUserStore } from "./user";

export const usePropertiesStore = defineStore({  
  id: 'properties_store',
  state: () => ({   
    error:null,
    response: null,     
    property_list: [],
    occupied_properties:[],
    available__properties:[]
  }),      
  actions: 
  {   
    async propertyAdd(name, address, description, image, status) {       
      const tenant_id=null 
      const hoa_id = useUserStore().currentUser['assoc_hoa_id']
      const landlord_id = useUserStore().currentUser['id']
      let formData = new FormData()
      formData.append('name',name)
      formData.append('hoa_id',hoa_id)
      formData.append('landlord_id',landlord_id)
      formData.append('tenant_id','')
      formData.append('address',address)
      formData.append('description',description)
      formData.append('image',image)
      formData.append('status',status)      
      const res = await fetch(useConstant().baseUrl+useConstant().apiPropertyAdd, {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,                   
        },
        body: formData,
      });
      const response = await res.json()       
      this.response = response;     
      console.log(image)
    },
    async propertyShow() { 
      useConstant().loader=true    
      const landlord_id = useUserStore().currentUser['id']
      const res = await fetch(useConstant().baseUrl+useConstant().apiPropertyGetByLandlord, {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({landlord_id}),
      });
      const response = await res.json()
      this.response = response;
      if(response['status']==true){          
        this.property_list = response['properties']
      }  
      useConstant().loader=false    
    },
    async setTenant(property_id, tenant_id) {            
      const res = await fetch((useConstant().baseUrl)+('api/property/tenant/set'), {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({ property_id, tenant_id}),
      });
      const response = await res.json()
      this.response = response;
    },  
     async getPropertiesByHOAIdAvailable() {                
      const id = useUserStore().currentUser['id']
      try {
        const res = await fetch(useConstant().baseUrl+"api/property/get/hoa/available/"+id,{
            method: "GET",    
            headers: {                   
                "Authorization": "Bearer "+useUserStore().accessToken,
              },                       
        });            
        const response = await res.json();
        this.response = response     
        if(response['status']==true)
        {          
          this.available__properties=response['properties']       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },  
     async getPropertiesByHOAIdOccupied() {                
      const id = useUserStore().currentUser['id']
      try {
        const res = await fetch(useConstant().baseUrl+"api/property/get/hoa/occupied/"+id,{
            method: "GET",    
            headers: {                   
                "Authorization": "Bearer "+useUserStore().accessToken,
              },                       
        });            
        const response = await res.json();
        this.response = response     
        if(response['status']==true)
        {          
          this.occupied_properties=response['properties']       
        }        
      } catch (error) {         
        this.error = error              
        return error
      }            
    },  
    async deleteProperty(id) { 
      useConstant().loader = true
      try{
          const res = await fetch(useConstant().baseUrl+"api/property/delete", {
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
      async clearTenant(property_id) {               
      const res = await fetch(useConstant().baseUrl+'api/property/tenant/remove', {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({  property_id }),
      });
      const response = await res.json()
      this.response = response;
    },
  },  
  
});
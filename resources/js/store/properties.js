import { defineStore } from "pinia";
import { useConstant } from "./constants";
import { useUserStore } from "./user";

export const usePropertiesStore = defineStore({  
  id: 'properties_store',
  state: () => ({   
    error:null,
    response: null,     
    property_list: []
  }),      
  actions: 
  {   
    async propertyAdd(name, address, description, image, price, status) {      
      const tenant_id=null 
      const hoa_id = 1
      const landlord_id = useUserStore().currentUser['id']
      const res = await fetch(useConstant().baseUrl+useConstant().apiPropertyAdd, {
        method: "POST",
        headers: {
          "Authorization": "Bearer "+useUserStore().accessToken,
          "Content-Type": "application/json"          
        },
        body: JSON.stringify({ name, hoa_id, landlord_id, tenant_id, address, description, image, price, status}),
      });
      const response = await res.json()
      this.response = response;
    },
    async propertyShow() {     
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
  },  
  
});
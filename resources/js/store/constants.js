import { defineStore } from "pinia";

export const useConstant = defineStore({ 
    id:'constants',
    state: () => ({   
        baseUrl:'https://naybiz.com/',  
        // baseUrl:'http://127.0.0.1:8000/',       
        //user     
        apiUserFetchUrl:'api/user',
        apiUserLoginUrl:'api/auth/login',
        apiUserRegisterUrl:'api/auth/login',
        apiUserLogoutUrl:'api/auth/logout',
        //tenant
        apiTenantFetchByIdUrl:'api/tenant/get',
        apiTenantAdd:'api/tenant/add',

        //property
        apiPropertyAdd:'api/property/add',
        apiPropertyGetByLandlord:'api/property/get',
        apiPropertySetTenant:'api/property/tenant/set',

        //question
        apiQuestionFetch: 'api/question/get',
        loader:false,
      }),   
 })
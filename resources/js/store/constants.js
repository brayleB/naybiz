import { defineStore } from "pinia";

export const useConstant = defineStore({ 
    id:'constants',
    state: () => ({   
        baseUrl:'http://127.0.0.1:8000/',       
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

        //question
        apiQuestionFetch: 'api/question/get',
      }),   
 })
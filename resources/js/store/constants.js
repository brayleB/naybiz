import { defineStore } from "pinia";

export const useConstant = defineStore({ 
    id:'constants',
    state: () => ({   
        baseUrl:'https://naybiz.com/',       
        //user     
        apiUserFetchUrl:'api/user',
        apiUserLoginUrl:'api/auth/login',
        apiUserRegisterUrl:'api/auth/login',
        apiUserLogoutUrl:'api/auth/logout',
        //tenant
        apiTenantFetchByIdUrl:'api/tenant/get',
        apiTenantAdd:'api/tenant/add'

      }),   
 })
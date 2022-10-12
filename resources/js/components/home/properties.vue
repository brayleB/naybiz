<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          selected: 'My properties'
        }
      },
      setup() {
        return { sidebarWidth }
      },
      props: {
        isSelected: {
          type: Boolean
        }
      },
      methods: {
        setSelected(tab){
          this.selected = tab;
        }
      }
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">.
          <div class="homesection container-fluid">
          <div class="row">
            <Sidebar />    
            <router-view />           
            <div class="col-lg-2 col-xl-4">  
              <p class="p-medium text-black">Back | <r class="p-medium text-primary" to="/register">Tenants</r></p>                  
              <h1>Properties</h1>
            </div>
            <div class="col-lg-6 col-xl-12">
            <TabNav :tabs="['My properties', 'New', 'Trash']" :selected="selected" @selected="setSelected">
              <Tab :isSelected="selected === 'My properties'">                                      
                            <div class="maincon flex-fill">                          
                                <div class="table-responsive">
                                  <table class="table table-borderless mb-0">
                                    <thead>
                                      <tr>
                                        <th scope="col" class="col-lg-1">                                  
                                        </th>
                                        <th scope="col"></th>
                                        <th scope="col" class="col-lg-3">Property</th>                               
                                        <th scope="col" class="col-lg-4">Address</th>
                                        <th scope="col" class="col-lg-3">Owner</th>
                                        <th scope="col" class="col-lg-1"></th>
                                        <th scope="col" class="col-lg-1"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                          </div>
                                        </th>
                                        <td>
                                          <img src="https://i.pinimg.com/736x/55/26/39/55263941306910ab943af5e25b13b031.jpg" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>120sqm Propery Lorem Ipsum</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>Tiger Nixon</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>                                        
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" />
                                          </div>
                                        </th>
                                        <td>
                                          <img src="https://i.pinimg.com/736x/55/26/39/55263941306910ab943af5e25b13b031.jpg" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>120sqm Propery Lorem Ipsum</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>Sonya Frost</td>                             
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>                                        
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3" checked/>
                                          </div>
                                        </th>
                                        <td>
                                          <img src="https://i.pinimg.com/736x/55/26/39/55263941306910ab943af5e25b13b031.jpg" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>120sqm Propery Lorem Ipsum</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>Jena Gaines</td>              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>                                         
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4" checked/>
                                          </div>
                                        </th>
                                        <td>
                                          <img src="https://i.pinimg.com/736x/55/26/39/55263941306910ab943af5e25b13b031.jpg" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>120sqm Propery Lorem Ipsum</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>Quinn Flynn</td>           
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>                                         
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5" checked/>
                                          </div>
                                        </th>
                                        <td>
                                          <img src="https://i.pinimg.com/736x/55/26/39/55263941306910ab943af5e25b13b031.jpg" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>120sqm Propery Lorem Ipsum</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>Charde Marshall</td> 
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>                                         
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6" />
                                          </div>
                                        </th>
                                        <td>
                                          <img src="https://i.pinimg.com/736x/55/26/39/55263941306910ab943af5e25b13b031.jpg" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>120sqm Propery Lorem Ipsum</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>Haley Kennedy</td>      
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>                                         
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault7" checked/>
                                          </div>
                                        </th>
                                        <td>
                                          <img src="https://i.pinimg.com/736x/55/26/39/55263941306910ab943af5e25b13b031.jpg" class="img-responsive" style="width: 45px;" alt="Avatar" />
                                        </td>
                                        <td>120sqm Propery Lorem Ipsum</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>Tatyana Fitzpatrick</td>      
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>                                          
                                        </td>
                                        <td>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>                                      
                                    </tbody>
                                  </table>
                                </div>
                                                      
                      </div>                    
                  </Tab>
                  <Tab :isSelected="selected === 'New'">
                    <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any properties</h4>                    
                        </div>                                              
                   </div>               
                  </Tab>
                  <Tab :isSelected="selected === 'Trash'">
                    <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any properties</h4>                    
                        </div>                                              
                   </div>      
                  </Tab>                 
              </TabNav> 
              </div>             
          </div> 
      </div>
    </div>
       
    
    </template>
    
  <style>
    
    </style>
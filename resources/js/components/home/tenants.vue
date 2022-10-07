<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    export default {      
      components: { Sidebar, TabNav, Tab},
      data() {
        return {
          selected: 'Request'
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
      <Sidebar />
      <div :style="{ 'margin-left': sidebarWidth }">
        <router-view />
        <div class="col-lg-8">              
              <h1>Tenants</h1>                       
          </div>     
          <TabNav :tabs="['Request', 'New', 'Accepted', 'Trash']" :selected="selected" @selected="setSelected">
              <Tab :isSelected="selected === 'Request'">                                      
                            <div class="card shadow-2-strong" style="background-color: #f5f7fa;">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-borderless mb-0">
                                    <thead>
                                      <tr>
                                        <th scope="col">                                  
                                        </th>
                                        <th scope="col">Name</th>                               
                                        <th scope="col">Address</th>
                                        <th scope="col">Properties</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                          </div>
                                        </th>
                                        <td>Tiger Nixon</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>61</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Sonya Frost</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>23</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Jena Gaines</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>30</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Quinn Flynn</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>22</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Charde Marshall</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>36</td>           
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Haley Kennedy</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>43</td>                     
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Tatyana Fitzpatrick</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>19</td>                     
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                          
                      </div>                    
              </Tab>
              <Tab :isSelected="selected === 'New'">
                <div class="card shadow-2-strong" style="background-color: #f5f7fa;">
                              <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table table-borderless mb-0">
                                    <thead>
                                      <tr>
                                        <th scope="col">                                  
                                        </th>
                                        <th scope="col">Name</th>                               
                                        <th scope="col">Address</th>
                                        <th scope="col">Properties</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <th scope="row">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked/>
                                          </div>
                                        </th>
                                        <td>Tiger Nixon</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>61</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Jena Gaines</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>30</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Quinn Flynn</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>22</td>                              
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Charde Marshall</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>36</td>           
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Haley Kennedy</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>43</td>                     
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
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
                                        <td>Tatyana Fitzpatrick</td>
                                        <td>Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678</td>
                                        <td>19</td>                     
                                        <td>
                                          <button type="button" class="btn-1 btn btn-primary btn-sm px-3">
                                            Send link
                                          </button>
                                          <button type="button" class="btn-2 btn btn-danger btn-sm px-3">
                                            <i class="fas fa-trash"></i>
                                          </button>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                          
                      </div>                    
              </Tab>
              <Tab :isSelected="selected === 'Accepted'">
                Sample Accepted
              </Tab>
              <Tab :isSelected="selected === 'Trash'">
                Sample Trash
              </Tab>
          </TabNav> 
      </div>
    </template>
    
    <style>
      html,
      body,
      .intro {
        height: 100%;
      }

      table td,
      table th {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
      }
    

      .card {
        border-radius: .5rem;
      }

      .mask-custom {
        background: rgba(24, 24, 16, .2);
        border-radius: 2em;
        backdrop-filter: blur(25px);
        border: 2px solid rgba(255, 255, 255, 0.05);
        background-clip: padding-box;
        box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
      }
    #app {
      font-family: Avenir, Helvetica, Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-align: center;
      color: #2c3e50;
    }
    
    #nav {
      padding: 30px;
    }
    
    #nav a {
      font-weight: bold;
      color: #2c3e50;
    }
    
    #nav a.router-link-exact-active {
      color: #42b983;
    }
    </style>
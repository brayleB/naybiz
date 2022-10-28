<script >
    import Sidebar from '../sidebar/sidebar.vue'
    import { sidebarWidth } from '../sidebar/state.js'
    import Tab from '../tabs/tab.vue'
    import TabNav from '../tabs/tabnav.vue'
    import {usePropertiesStore} from '../../store/properties';
    import Tabnav from '../tabs/tabnav.vue';
  

    export default {      
      components: { Sidebar, TabNav, Tab, Tabnav },
      data() {
        return {          
          selected: 'My properties', 
          selectedAdd: 'Add properties',  
          toView: false,
          imgSrc:''     
        }
      },
      setup() {
        const propertiesStore = usePropertiesStore()
        return { sidebarWidth, propertiesStore }
      },
      props: {
        isSelected: {
          type: Boolean
        },
        isSelectedAdd: {
          type: Boolean
        }
      },
      methods: {
        setSelected(tab){
          this.selected = tab;
        },
        setSelectedAdd(tab){
          this.selectedAdd = tab;
        },
        toAddState(){             
          this.propertiesStore.addState=!this.propertiesStore.addState                          
        },
        toViewState(){
          this.toView=!this.toView
          console.log(this.toView)
        },
        onFile(e) {
        const files = e.target.files
        if (!files.length) return

        const reader = new FileReader()
        reader.readAsDataURL(files[0])
        reader.onload = () => (this.imgSrc = reader.result)
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
              <p class="p-medium text-black">Back | <r class="p-medium text-primary" to="/register">Properties</r></p>                  
              <h1>Properties</h1>
            </div>
            <div class="col-lg-6 col-xl-12">
            <button type="button" class="btnadd btn btn-success float-end" @click="toAddState()" v-if="this.propertiesStore.addState==false">Add properties</button>
            <button type="button" class="btnadd btn btn-success float-end" @click="toAddState()" v-else>Show properties</button>
            <TabNav :tabs="['My properties', 'New', 'Trash']" :selected="selected" @selected="setSelected" v-if="this.propertiesStore.addState==false">
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
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1"/>
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
                                            View details
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
                                            View details
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
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3"/>
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
                                            View details
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
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4"/>
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
                                            View details
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
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5"/>
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
                                            View details
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
                                            View details
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
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault7"/>
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
                                            View details
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
              <TabNav :tabs="['Add properties','Show existing']" :selected="selectedAdd" @selected="setSelectedAdd" v-else>
                  <Tab :isSelected="selectedAdd === 'Add properties'">
                    <div class="maincon overflow-auto">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col col-xl-5">                               
                              <label class="small mb-1" for="property_name">Image</label>
                              <input class="form-control mb-3" type="file" @change="onFile" />   
                              <div class="text-center">
                                <img class="img-fluid" :src="imgSrc" v-if="imgSrc" />       
                              </div>                                                                                                                                                                                   
                          </div>
                          <div class="col col-xl-7">
                            <form @submit.prevent="tenantApplication">                           
                              <div class="mb-3">
                                  <label class="small mb-1" for="property_name">Property Name / Title</label>
                                  <input class="form-control" id="property_name" type="text"  v-model="property_address" required>
                              </div>   
                              <div class="mb-3">
                                  <label class="small mb-1" for="hoa_name">Property Address</label>
                                  <input class="form-control" id="hoa_name" type="text"  v-model="hoa_name" required>
                              </div>    
                              <div class="mb-3">
                                  <label class="small mb-1" for="hoa_name">Description</label>
                                  <textarea class="form-control" id="hoa_name" type="text"  v-model="hoa_name" rows="5" required/>
                              </div>  
                              <div class="row gx-3 mb-5">                            
                                  <div class="col-md-2">
                                      <label class="small mb-1" for="vcYear" >Price</label>
                                      <input class="form-control" id="vcYear" type="text" v-model="firstname" required>
                                  </div>                                                        
                              </div>                                                                                                          
                            <div class="mb-3">
                              <button class="btn btn-primary" type="submit">Add property</button>
                              </div>                                                                                     
                          </form>
                            
                          </div>
                        </div>                       
                      </div> 
                    </div>
                  </Tab>              
                <Tab :isSelected="selectedAdd === 'Show existing'">
                  <div class="maincon overflow-auto">    
                      <div class="row row-cols-1 row-cols-md-4 g-5 mb-5" v-if="this.toView==false">
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/044.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link" @click="toViewState()">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/043.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-95">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp"  class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                          <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card h-90">
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="card-img-top img-fluid"
                              alt="Skyscrapers" />
                            <div class="card-body">
                              <h5 class="card-title">Property Name</h5>
                              <p class="card-text">
                                Robert Robertson, 1234 NW Bobcat Lane, St. Robert, MO 65584-5678                              
                              </p>
                            </div>
                            <div>
                              <button class="btn btn-link">View more</button>
                            </div>
                          </div>
                        </div>
                      </div>                                                                 
                      <div class="container-fluid" v-else>
                        <div class="row">
                          <div class="col col-xl-10">                           
                            <h1>120sqm Propery Lorem Ipsum</h1>
                            <p>9463 North Euclid Drive, Jacksonville Beach, FL 32250</p>                                                        
                            <div class="d-flex align-items-stretch">                             
                              <span class="align-middle">
                                <img src="http://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(58).jpg" class="user-img img-responsive" style="height: 60px;" alt="Avatar" />
                                <text class="name">Jenn Jett Ford </text>
                                <text class="role">(Tenant)</text>
                              </span>                           
                            </div>                                                                  
                          </div>    
                          <div class="col col-xl-2">
                            <button type="button" class="btn btn-success float-end">Add to List</button>
                          </div>                      
                        </div>    
                         <div class="property row">
                          <div class="col col-sm-12 col-xl-5">  
                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/042.webp" class="property-img img-fluid" alt="Avatar" />                                                                                                                 
                          </div> 
                          <div class="col col-sm-12 col-xl-7">  
                            <p class="description">Duis eget ultricies nisi. Curabitur maximus odio et ex aliquam, eu tempus augue suscipit. Vestibulum vehicula tortor id quam fringilla fermentum. Fusce lobortis dui quam, eu condimentum turpis mattis eget. Sed eleifend, turpis ac hendrerit dictum, ipsum erat imperdiet lectus, vel imperdiet justo augue ut diam. Ut vel ante nec arcu pulvinar viverra eu ut enim. Cras eleifend elit eget nisi hendrerit, vitae accumsan tellus facilisis. Etiam congue rutrum orci, vitae luctus lacus vulputate sit amet. Duis cursus tortor sed ipsum laoreet tempor. Ut eget dui ultrices, hendrerit nisi quis, mollis dui. Mauris quis velit porta, ornare leo id, convallis dui. Aenean luctus lacus non commodo accumsan. Nulla laoreet nibh at interdum pharetra. Aenean rutrum mattis neque quis vulputate. Aenean eget dapibus orci, eu placerat augue.</p>                                                                                                                                     
                            <text class="price float-end">$203.00</text>                           
                          </div>                           
                        </div>                     
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
.name {
  color:black;
  margin-left: .5rem;
  font-weight: 600;
	font-size: 1.5rem;
  vertical-align:middle;
}
.role {  
  vertical-align:middle;
}
.description{
  color:black;
}
.property {
  margin-top: 1.5rem;
  margin-bottom: 2.5rem;
}
.user-img {
  border-radius: 0.25rem;
}
.property-img {
  border-radius: 0.5rem;
}
.price {
  color:rgb(25, 79, 255);
  margin-left: .5rem;
  font-weight: 600;
	font-size: 3.5rem;
}
.btnadd{
  margin-right: 1rem;
  border-radius: 0.5rem;
}
</style>
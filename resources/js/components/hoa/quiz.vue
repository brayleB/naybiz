<script >
 import {useUserStore} from '../../store/user';
 import {useQuestionStore} from '../../store/questions'
 import Sidebar from '../sidebar/sidebar.vue'
 import { sidebarWidth } from '../sidebar/state.js'
 import Tab from '../tabs/tab.vue'
 import TabNav from '../tabs/tabnav.vue'
  export default {  
    components: { Sidebar, TabNav, Tab},      
    data() {
      const questions = []
        return {
          questions,
          selected: 'Quiz',
          toAddState:false,
          addQuesType:0,
          addQuestionNum:null,
          optionCount:2,
          addCorrectAnswer:0,
          addOption1:'',
          addOption2:'',
          addOption3:'',
          addOption4:'',
          addDescription:'',
          addQuestionStr:'',  
          questionsComponent:0       
        }
      },
      setup() {
        const userStore = useUserStore()
        return { sidebarWidth, userStore }
      },
      props: {
        isSelected: {
          type: Boolean
        }
      },
      methods: {
        async checkLoggedIn() {    
            await this.userStore.fetchUser()             
            if(this.userStore.error==true){ 
              this.$router.push('/login')  
            }          
        },
        setSelected(tab){
          this.selected = tab;
        },
        async getQuestions() {    					            
          await useQuestionStore().displayQuestions(useUserStore().currentUser['id'])
          if(useQuestionStore().response['status']==true){   
            this.questions = useQuestionStore().question_list
            this.addQuestionNum = useQuestionStore().question_list.length+1
          } 			                           			
        }, 
        toAddStateMethod(){          
          this.toAddState = !this.toAddState
        },
        async saveQuestion(){
          if(this.addQuesType==0){
            this.$swal.fire({
              imageUrl: "https://naybiz.com/users/questions-icon.png",
              title: "<h1 class='text-primary'>Quiz</h1>",
                        text:'Do you really want to add this question?', 
                        color: 'black',
			                  showDenyButton: true,                    
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#0066ff'                            
            }).then(async (result) => {                      
                if (result.isConfirmed) {  
                  var addOptionList = ['True','False']                                  
                  await useQuestionStore().questionAdd('true_false', this.addQuestionStr, JSON.stringify(addOptionList), this.addCorrectAnswer, this.addDescription, 'active')
                    if(useQuestionStore().response['status']==true)
                    {
                        this.$swal.fire({
                          imageUrl: "https://naybiz.com/users/success-icon.png",
                          title: "<h1 class='text-primary'>Question</h1>",
                        text:'Successfully added', 
                        color: 'black',                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'                   
                        }).then(async (result) => { 
                            if (result.isConfirmed) {                                                                  
                              this.toAddState = !this.toAddState                                                                
                            }
                        })
                    }                        
                }
            })
          }
          else if(this.addQuesType==1){
            this.$swal.fire({
              imageUrl: "https://naybiz.com/users/questions-icon.png",
              title: "<h1 class='text-primary'>Question</h1>",
                        text:'Do you really wan to add this question?', 
                        color: 'black',
			                  showDenyButton: true,                    
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#0066ff'                             
            }).then(async (result) => {                      
                if (result.isConfirmed) {  
                  var addOptionList = []   
                  if(this.optionCount==2){
                    addOptionList.push(this.addOption1)
                    addOptionList.push(this.addOption2)
                  }  
                  else if(this.optionCount==3){
                    addOptionList.push(this.addOption1)
                    addOptionList.push(this.addOption2)
                    addOptionList.push(this.addOption3)
                  } 
                  else if(this.optionCount==4){
                    addOptionList.push(this.addOption1)
                    addOptionList.push(this.addOption2)
                    addOptionList.push(this.addOption3)
                    addOptionList.push(this.addOption4)
                  }                               
                  await useQuestionStore().questionAdd('multiple', this.addQuestionStr, JSON.stringify(addOptionList), this.addCorrectAnswer, this.addDescription, 'active')
                    if(useQuestionStore().response['status']==true)
                    {
                        this.$swal.fire({
                          imageUrl: "https://naybiz.com/users/success-icon.png",
                          title: "<h1 class='text-primary'>Question</h1>",
                        text:'Successfully added', 
                        color: 'black',                    
                        confirmButtonText: 'Confirm',
                        confirmButtonColor: '#0066ff'                            
                        }).then(async (result) => { 
                            if (result.isConfirmed) {                                                                  
                                                                                 
                            }
                        })
                    }                        
                }
            })
          }          
        },
        renderComponentQuestions(){
          this.questionsComponent += 1
        },
        async deleteQuestion(id){     
          this.$swal.fire({
            imageUrl: "https://naybiz.com/users/questions-icon.png",
            title: "<h1 class='text-primary'>Question</h1>",
                        text:'Do you really want to remove this question?', 
                        color: 'black',
			showDenyButton: true,                    
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#0066ff'                  
          }).then(async (result) => {                      
              if (result.isConfirmed) {                                   
                await useQuestionStore().deleteQuestion(id) 
                this.$router.push('/hoa/tenants')                                                 
              }
          })                                                  
        }, 
      },
      created() { 
        this.checkLoggedIn()               
            this.getQuestions()                
      },   	
    }
    </script>
    <template>
        <div class="vh-100 vw-100" :style="{ 'padding-left': sidebarWidth}">
          <div class="homesection container-fluid">
          <div class="row">
            <Sidebar />    
            <router-view />           
            <div class="col-lg-2 col-xl-4">  
              <p class="p-medium text-black">Back | HOA | <r class="p-medium text-primary" to="/register">Community Quiz</r></p>                  
              <h1>Community Quiz</h1>              
            </div>
            <div class="col-lg-6 col-xl-12">
            <TabNav :tabs="['Quiz', 'Result']" :selected="selected" @selected="setSelected">
              <Tab :isSelected="selected === 'Quiz'">                                      
                      <div class="maincon overflow-auto mb-2">                          
                        <div class="question container-fluid" v-for="(questions, index) in questions" :key="index" >
                          <form>      
                            <div class="form-group row">
                              <div class="col-lg-1">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">                                                    
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <h5>Question {{ index + 1}} </h5>      
                              </div> 
                              <div class="col-lg-3" v-if="index>9">
                                <button type="button" class="btn btn-danger btn-sm btn-block float-end" @click="deleteQuestion(questions.id)">Remove Question</button>                                    
                              </div>                                                                                                                         
                            </div> 
                            <div class="form-group row">                              
                                <label class="col-lg-1 col-form-label" for="form6Example3">Question Type</label>
                                <div class="col-lg-2">
                                  <select class="form-select" aria-label="Select" >                                  
                                    <option value="0" v-if="questions.type=='true_false'">True or False</option>
                                    <option value="1" v-else>Multiple Choice</option>                             
                                  </select>       
                                </div>                                                     
                            </div>                                               
                             <div class="form-group row">
                              <label class="col-lg-1 col-form-label" for="form6Example3">Question</label>
                              <div class="col-lg-11">
                                <input type="text" id="form6Example3" class="form-control" v-model="questions.question" />   
                              </div>                          
                            </div>                                                                                                      
                            <div class="form-group row">                              
                                <label class="col-lg-1 col-form-label" for="form6Example3">Options</label>
                                <div class="col-lg-2" v-if="questions.type=='true_false'">
                                  <select class="form-select" aria-label="Select" >                                  
                                    <option>True</option>
                                    <option>False</option>                             
                                  </select>  
                                </div>
                                <div class="col-lg-11" v-if="questions.type=='multiple'">
                                  <select class="form-select" aria-label="Select" >                                  
                                    <option v-for="(options, index) in JSON.parse(questions.options)" :key="index" >{{ options }}</option>                                                        
                                  </select>       
                                </div>                                                     
                            </div> 
                            <div class="form-group row">                              
                                <label class="col-lg-1 col-form-label" for="form6Example3">Answer</label>
                                <div class="col-lg-11">
                                  <span type="text" id="form6Example3" class="form-control" >{{ JSON.parse(questions.options)[questions.answer] }}</span>
                                </div>                                                     
                            </div>        
                            <div class="form-group row">
                              <label class="col-lg-1 col-form-label" for="form6Example3">Explanation</label>
                              <div class="col-lg-11">
                                 <textarea class="form-control" id="form6Example7" rows="4" v-model="questions.description" />
                              </div>
                            </div>                                                                               
                          </form>     
                        </div> 
                        <!-- addquestion -->
                        <div class="questionAdd container-fluid" v-if="toAddState==true">
                          <form @submit.prevent="saveQuestion">      
                            <div class="form-group row">
                              <div class="col-lg-1">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">                                                    
                                </div>
                              </div>
                              <div class="col-lg-8">
                                <h5>Question {{ addQuestionNum }}</h5>      
                              </div> 
                              <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary btn-sm btn-block float-end" >Save Question</button>                                    
                              </div>          
                              <div class="col-lg-1">                               
                                <button type="button" class="btn btn-danger btn-sm btn-block" @click="toAddStateMethod()">Cancel</button>             
                              </div>                                                                                                                                                      
                            </div> 
                            <div class="form-group row">                              
                                <label class="col-lg-1 col-form-label" for="form6Example3">Question Type</label>
                                <div class="col-lg-2">
                                  <select class="form-select" aria-label="Select" v-model="addQuesType">                                  
                                    <option value="0" >True or False</option>
                                    <option value="1" >Multiple Choice</option>                             
                                  </select>       
                                </div>                                                     
                            </div>                                               
                             <div class="form-group row">
                              <label class="col-lg-1 col-form-label" for="form6Example3">Question</label>
                              <div class="col-lg-11">
                                <input type="text" id="form6Example3" class="form-control" v-model="addQuestionStr" required/>   
                              </div>                          
                            </div>                                                                                                      
                            <div class="form-group row" v-if="addQuesType==0">                              
                                <label class="col-lg-1 col-form-label" for="form6Example3">Answers</label>
                                <div class="col-lg-2">
                                  <select class="form-select" aria-label="Select" v-model="addCorrectAnswer">                                  
                                    <option value="0">True</option>
                                    <option value="1">False</option>                             
                                  </select>       
                                </div>                                                     
                            </div>    
                            <div class="form-group row" v-else-if="addQuesType==1">                              
                                <label class="col-lg-1 col-form-label" for="form6Example3">Answers</label>
                                <div class="col-lg-2">
                                  <button type="button" data-bs-target="#myModal" data-bs-toggle="modal" class="btn btn-success btn-sm btn-block">View Answers</button>                  
                                </div>                                                     
                            </div>                            
                              <div class="modal fade" id="myModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Answers for Multiple Choice</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="row gx-3 mb-3">                            
                                      <div class="col-md-6">
                                          <label class="small mb-1"  >Options Count</label>
                                          <select class="form-select" aria-label="Select" v-model="optionCount">                                  
                                            <option value="2">2</option>
                                            <option value="3">3</option>  
                                            <option value="4">4</option>                                                        
                                          </select>     
                                      </div>                          
                                      <div class="col-md-6">
                                          <label class="small mb-1" >Correct Option</label>
                                          <select class="form-select" aria-label="Select" v-model="addCorrectAnswer">                                  
                                            <option value="0">A.</option>
                                            <option value="1">B.</option>                             
                                            <option value="2" v-if="optionCount>=3">C.</option>                             
                                            <option value="3" v-if="optionCount>=4">D.</option>                             
                                          </select>     
                                      </div>
                                     </div>     
                                      <div class="mb-3">
                                          <label class="small mb-1">A. First Option</label>
                                          <input class="form-control"  type="text"  v-model="addOption1">
                                      </div>                                                                                                                                                                                        
                                      <div class="mb-3">
                                          <label class="small mb-1">B. Second Option</label>
                                          <input class="form-control"  type="text"  v-model="addOption2" >
                                      </div> 
                                      <div class="mb-3" v-if="optionCount>=3">
                                          <label class="small mb-1">C. Third Option</label>
                                          <input class="form-control"  type="text"  v-model="addOption3" >
                                      </div> 
                                      <div class="mb-3" v-if="optionCount>=4">
                                          <label class="small mb-1" >D. Fourth Option</label>
                                          <input class="form-control" type="text"  v-model="addOption4">
                                      </div>                                                                                                                                                                                                                                                                                                  
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-primary" @click="" data-bs-dismiss="modal">Save</button>                                                                                                                         
                                    </div>
                                  </div>
                                </div>
                              </div>      
                            <div class="form-group row">
                              <label class="col-lg-1 col-form-label" for="form6Example3">Explanation</label>
                              <div class="col-lg-11">
                                 <textarea class="form-control" id="form6Example7" rows="4" v-model="addDescription" required/>
                              </div>
                            </div>                                                                               
                          </form>     
                        </div>                                                                                               
                      </div>   
                      <div class="col-lg-2" v-if="toAddState==false">
                        <button type="submit" class="btn btn-success btn-block" @click="toAddStateMethod()"> + Add question</button>              
                      </div>                  
                  </Tab>                 
                  <Tab :isSelected="selected === 'Result'">
                    <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Looks like you don’t have any Quiz Results</h4>                    
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
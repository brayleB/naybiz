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
          selected: 'Quiz'
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
        },
        async getQuestions() {    					            
          await useQuestionStore().displayQuestions()
          if(useQuestionStore().response['status']==true){   
            this.questions = useQuestionStore().question_list
          } 			                           			
        }, 
      },
      created() {                
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
            <TabNav :tabs="['Quiz', 'Result', 'Trash']" :selected="selected" @selected="setSelected">
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
                              <div class="col-lg-2">
                                <h5>Question {{ index + 1}} </h5>      
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
                                <label class="col-lg-1 col-form-label" for="form6Example3">Answer</label>
                                <div class="col-lg-2">
                                  <select class="form-select" aria-label="Select" >                                  
                                    <option value="1">True</option>
                                    <option value="2">False</option>                             
                                  </select>       
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
                      </div>   
                      <div class="col-lg-">
                                <button type="submit" class="btn btn-success btn-block"> + Add question</button>              
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
                  <Tab :isSelected="selected === 'Trash'">
                    <div class="emptycon d-flex align-items-center justify-content-center">                             
                        <div class="center-block text-center">
                           <img class="img-responsive img-center" src="../../../images/icon-empty.png">
                            <h4>Empty</h4>                    
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
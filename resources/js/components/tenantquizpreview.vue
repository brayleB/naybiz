<script>
 import {useUserStore} from '../store/user';
 import {useQuestionStore} from '../store/questions'
    export default {                        
        methods: {                
             async getQuestions() {  										            
              await useQuestionStore().displayQuestions()
              if(useQuestionStore().response['status']==true){   
					  	this.questionLength = useQuestionStore().question_list.length             
              } 			                           			
            },                                       
        },              
        created() {                
            this.getQuestions()                
        }, 
		data(){
			return{
				questionLength:null,
				time:null,				
			}			
		}  			  
    }
</script>
<template>	
	<main class="app">				
		<div class="d-flex align-items-center justify-content-center" v-if="!tenants_list_new || !tenants_list_new.length">
			<div class="center-block text-center">
				<h1 class="head mb-5">Naybiz Community Quiz</h1>
				<img class="img-responsive img-center mb-5" src="../../images/houseicon.png">
				<div class="container mb-4">
					<div class="row">						
						<div class="col">
							<h4>{{ this.questionLength }} Exercises</h4>   
						</div>
					</div>
				</div>				
				<RouterLink to="/tenantquiz"><button class="btn btn-success" type="button" @click="removeOcc()">Proceed</button></RouterLink>                 
			</div>                                              
		</div> 	
		
	</main>
</template>

<style>



.app {
    background: url('../../images/bg-register-1.jpg')no-repeat;	
	display: flex;
	flex-direction: column;
	align-items: center;
	padding-top: 5rem;
	height: 100vh; 	
}
.app .head {
	font-size: 2.5rem;
	margin-bottom: 2rem;
    color:black
}
.quiz {
	background-color: white;
	padding: 1.2rem;
	width: 100%;
	max-width: 640px;
    border-radius: .5rem;
	box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
}
.quiz-info {
	display: flex;
	justify-content: space-between;
	margin-bottom: 1rem;
}

.quiz-info .question {  
    color: #033085;
	font-size: 1.3rem;
    border: none;
    background-color: white;
}
.quiz-explanation {
    margin-top: 1rem;
	display: flex;
	justify-content: space-between;
	margin-bottom: 1rem;
}

.quiz-explanation .question-explanation-text {  
    color: #001335;  
}
.quiz-info.score {   
	color: #FFF;
	font-size: 1.25rem;
}
.options {
	margin-bottom: 1rem;
}
.option {
	padding: .5rem;
	display: block;
	background-color: #1760E8;
	margin-bottom: 0.5rem;
	border-radius: 0.5rem;
	cursor: pointer;
    color:white
}
.option:hover {
	background-color: #043796;
}
.option.correct {
	background-color: #2cce7d;
}
.option.wrong {
	background-color: #ff5a5f;
}
.option:last-of-type {
	margin-bottom: 0;
}
.option.disabled {
	opacity: 0.5;
}
.option input {
	display: none;
}
.click {
	appearance: none;
	outline: none;
	border: none;
	cursor: pointer;
	background-color: #2cce7d;
	color: #2d213f;	
	font-size: 1.2rem;
}
.click:disabled {
	opacity: 0.5;
}
.result-finish {
    color:black
}
.result-finish-score {
    color:black
}
</style>

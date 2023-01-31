<script>
 import {useUserStore} from '../store/user';
 import {useQuestionStore} from '../store/questions'
 import Modal from './modal/modal.vue';
 import { ref } from "vue";
    export default { 		
		components: {
			Modal,
		},                       
        methods: {                
             async getQuestions() {  										            
              await useQuestionStore().displayQuestions(this.$route.query['hoa_id'])
              if(useQuestionStore().response['status']==true){   
					  	this.questionLength = useQuestionStore().question_list.length             
              } 			                           			
            }, 
			
        }, 		
		setup(){
			const modalActive = ref(true);
			const toggleModal = () => {
				modalActive.value = !modalActive.value;
			};
			return { modalActive, toggleModal };
		} ,           
        created() {      			         
            this.getQuestions()                
        }, 
		data(){
			return{
				questionLength:null,
				time:null,				
			}			
		} ,
		
		mounted() {					
			// this.$swal.fire({
			// 	icon: 'warning',
			// 	title: 'Naybiz Community Rules and Regulations', 
			// 	text:'The House Rules and Regulations, (hereafter referred to as “HOUSE RULES”), adopted by the Board of Trustees of the Condominium Corporation pursuant to the Master Deed with Declaration of Restrictions (the “Master Deed”), govern and regulate the use and occupancy of the individual units and common areas to: ensure the efficient and orderly management and operation of the condominium buildings, for the health, safety and welfare of all residents; ensure the right to the peaceful and quiet enjoyment of all residents of their respective units and the common areas; maintain the aesthetic appearance and soundness of the structures and facilities within the premises; and enhance the value of the property. All owners/lessees, occupants of the building, guests, visitors, building personnel, contractors and service providers are required to follow and comply with the governing House Rules to avoid inconvenience and embarrassment as a consequence of violation/s to the provisions of the House Rules.',
			// 	confirmButtonText: 'Accept',
			// 	confirmButtonColor: '#1760E8'                            
			// }).then(async (result) => { 
			// 	if (result.isConfirmed) {  
									
			// 	}
			// })
		}		  
    }
</script>
<template>
	<div class="home">
	  <Modal @close="toggleModal" :modalActive="modalActive">
		<div class="modal-content border-0">
			<div class="modal-body">   
				<div class="center-block text-center">				
				<img class="img-responsive img-center mb-5" src="../../images/glass-icon.png">
				<div class="container mb-4">
					<div class="row mb-5">						
						<div class="col">
							<h5>Naybiz Community Rules and Regulations</h5>   
						</div>
					</div>
					<div class="row">						
						<div class="col">
							<p>The House Rules and Regulations, (hereafter referred to as “HOUSE RULES”), adopted by the Board of Trustees of the Condominium Corporation pursuant to the Master Deed with Declaration of Restrictions (the “Master Deed”), govern and regulate the use and occupancy of the individual units and common areas to: ensure the efficient and orderly management and operation of the condominium buildings, for the health, safety and welfare of all residents; ensure the right to the peaceful and quiet enjoyment of all residents of their respective units and the common areas; maintain the aesthetic appearance and soundness of the structures and facilities within the premises; and enhance the value of the property. All owners/lessees, occupants of the building, guests, visitors, building personnel, contractors and service providers are required to follow and comply with the governing House Rules to avoid inconvenience and embarrassment as a consequence of violation/s to the provisions of the House Rules.</p>   
						</div>
					</div>
				</div>				
				<button class="btn btn-primary" type="button" @click="toggleModal">Accept</button>   
			</div> 
			</div>		
		</div>
	  </Modal>  
	</div>
	<main class="app">			
		<div class="d-flex align-items-center justify-content-center" v-if="!tenants_list_new || !tenants_list_new.length">
			<div class="center-block text-center">
				<h1 class="head mb-5">Community Quiz</h1>
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

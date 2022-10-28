<script setup>
import {useQuestionStore} from '../store/questions'
import { ref, computed } from 'vue'

const createJsonQuestion = []
const length = useQuestionStore().question_list.length	
console.log(useQuestionStore().question_list)
for(var i=0;i<length;i++){
	createJsonQuestion.push(	
		{   		
			question: useQuestionStore().question_list[i]["question"],
			answer: useQuestionStore().question_list[i]["answer"],
			options: JSON.parse(useQuestionStore().question_list[i]["options"]),	
			selected: null,	
			description: useQuestionStore().question_list[i]["description"],
		},
	)
}			
const questions = ref(createJsonQuestion)
const quizCompleted = ref(false)
const currentQuestion = ref(0)
const score = computed(() => {	
	let value = 0
	questions.value.map(q => {
		if (q.selected != null && q.answer == q.selected) {	
			value++
		}
	})
	return value
})
const getCurrentQuestion = computed(() => {let question = questions.value[currentQuestion.value]
	question.index = currentQuestion.value
	return question
})
const SetAnswer = (e) => {
	questions.value[currentQuestion.value].selected = e.target.value
	e.target.value = null
}
const NextQuestion = () => {
	if (currentQuestion.value < questions.value.length - 1) {
		currentQuestion.value++
		return
	}	
	quizCompleted.value = true
}
</script>

<template>	
	<main class="app">
		<h1 class="head mb-5">Naybiz Community Quiz</h1>				
		<section class="quiz" v-if="!quizCompleted">
			<div class="progress mb-3">
				<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
			</div>	
			<div class="quiz-info">
				<span class="question">{{ getCurrentQuestion.question }}</span>
				<!-- <span class="score">Score {{ score }}/{{ questions.length }}</span> -->
			</div>			
			<div class="options">
				<label 
					v-for="(option, index) in getCurrentQuestion.options" 
					:for="'option' + index" 
					:class="`option ${
						getCurrentQuestion.selected == index 
							? index == getCurrentQuestion.answer 
								? 'correct' 
								: 'wrong'
							: ''
					} ${
						getCurrentQuestion.selected != null &&
						index != getCurrentQuestion.selected
							? 'disabled'
							: ''
					}`">
					<input 
						type="radio" 
						:id="'option' + index" 
						:name="getCurrentQuestion.index" 
						:value="index" 
						v-model="getCurrentQuestion.selected" 
						:disabled="getCurrentQuestion.selected"
						@change="SetAnswer" 
					/>
					<span>{{ option }}</span>
				</label>
			</div>
			
			<button class="click btn btn-success"
				@click="NextQuestion" 
				:disabled="!getCurrentQuestion.selected">
				{{ 
					getCurrentQuestion.index == questions.length - 1 
						? 'Finish' 
						: getCurrentQuestion.selected == null
							? 'Select an option'
							: 'Next question'
				}}
			</button>
            <div class="quiz-explanation">                 
				<span class="question-explanation-text">
                    {{ 
                    getCurrentQuestion.selected == null 
                    ? 
                    ""    
                    :
                    getCurrentQuestion.description 
                    }}
                </span>
                

			</div>	
		</section>

		<section class="text-center" v-else>
			<h4 class="result-finish">You have finished the quiz!</h4>
			<h1 class="result-finish-score">Your score is {{ score }}/{{ questions.length }}</h1>
		</section>
	</main>
</template>

<style>



.app {
    background: url('../../images/bg-register-1.jpg')no-repeat;	
	display: flex;
	flex-direction: column;
	align-items: center;
	padding: 2rem;
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

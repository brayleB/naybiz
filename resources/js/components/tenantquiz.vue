<script setup>
import { ref, computed } from 'vue'
const questions = ref([
	// //#
	// {
	// 	question: '',
	// 	answer: 1,
	// 	options: ['True','False',],
	// 	selected: null,
   	// 	description: '',
 	// },

	//1
	{
		question: 'The HOA can issue fines if you fail to maintain the front yard.',
		answer: 1,
		options: ['True','False',],		
   		description: 'The Homeowner`s Association regularly inspects the front yards of homes in the community. If your yard is not properly maintained, the HOA may issue a monetary fine. So, you should keep the grass mowed, bushes trimmed and the area free of weeds',
 	},
	//2
	{
		question: 'For which of the following would you need to get prior approval from the Design Review Committee? ',
		answer: 3,
		options: ['a.	Painting the outside of your home','b.	Pouring a driveway extension','c.	Installing a jungle gym in your back yard', 'd.	All of the above'],
		selected: null,
   		description: 'Any type of change or modification to the exterior of your home that is visible from neighboring property must be approved by the Design Review Committee before any work starts.',
 	},
	//3
	{
		question: 'A home-based business: ',
		answer: 3,
		options: ['a.	Cannot cause traffic congestion','b.	Cannot accept large deliveries of goods','c.	Cannot involve multi-level marketing','d.	Both 1 and 2 '],
		selected: null,
   		description: 'Homeowners may conduct a business activity in the home so long as: (a) the operation of the business is not apparent by sight, sound or smell from outside the home; (b) the business activity is a legal activity and conforms to all applicable zoning ordinances; (c) the business does not involve persons coming to the Lot to purchase goods or services or the door-to-door solicitation of Owners; (d) business is conducted by the homeowner with no outside employees; (e) the business does not cause traffic congestion; (f) the business does not utilize flammable liquids or hazardous materials in quantities not customary to a residential use.',
 	},
	//4
	{
		question: 'When walking your dog in the common area you should: ',
		answer: 0,
		options: ['a.	Carry plastic bags to clean up after your pet','b.	Leave the dog poop for others to clean up',],
		selected: null,
   		description: 'Few things will draw the ire of your neighbors more than intentionally leaving your dog`s poop in the common area for others to deal with.',
 	},
	//5
	{
		question: 'You should stop paying your dues and assessments to protest actions or conduct of the HOA Board you disagree with.',
		answer: 0,
		options: ['True','False',],
		selected: null,
   		description: 'While attempting to resolve disputes with the HOA Board, you should continue to pay your dues and assessments. Unpaid assessments will accrue interest and if they remain unpaid over time, the HOA Board may force your house to be sold to pay the debt.',
 	},
	//6
	{
		question: '6.	I should use my garage and driveway before parking on the street.',
		answer: 0,
		options: ['True','False',],
		selected: null,
   		description: 'The goal of the community is to reduce street parking to prevent traffic congestion and to make room for emergency vehicles.',
 	},
	//7
	{
		question: 'I can store my boat or RV at the house',
		answer: 2,
		options: ['a.	If it is behind a fence','b.	As long as it is on the street', 'c.	None of the above '],
		selected: null,
   		description: 'No boats, RVs, trailers or campers may be kept on any lot if they are visible above the fence line.',
 	},
	//8
	{
		question: '8.	I should take my garbage cans off of the street and put them behind my fence as soon as possible after the garbage is picked up.',
		answer: 0,
		options: ['True','False',],
		selected: null,
   		description: 'Garbage cans should only be out on the curb for the shortest time reasonably necessary for collection on trash collection day.',
 	},
	//9
	{
		question: '9.	I do not need HOA Board approval before installing playground equipment in the backyard. ',
		answer: 1,
		options: ['True','False',],
		selected: null,
   		description: 'HOA Board approval is required to install any playground equipment in the backyard if it is visible above the fence line.',
 	},
	//#
	{
		question: 'All new tenants in the community must register with the HOA: ',
		answer: 3,
		options: ['a.	For emergency purposes','b.	So the HOA can include tenants on important communications about the community','c.	To prevent the tenant`s vehicles from being towed by accident','d.	All of the above'],
		selected: null,
   		description: ': It is important for the HOA to have tenants` contact information and license plate numbers so 1) the HOA knows who to contact in case of an emergency, 2) the HOA can include the tenants in important communication about the community, and 3) the HOA knows the tenant`s vehicles are legally parked in the community.',
 	},
	
])
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
const getCurrentQuestion = computed(() => {
	let question = questions.value[currentQuestion.value]
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
		<h1 class="head">Naybiz Community Quiz</h1>		
		<section class="quiz" v-if="!quizCompleted">
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
    background: url('../../images/header-bg.jpg')no-repeat;	
	display: flex;
	flex-direction: column;
	align-items: center;
	padding: 2rem;
	height: 100vh; 
}
.app .head {
	font-size: 2.5rem;
	margin-bottom: 2rem;
    color:white
}
.quiz {
	background-color: white;
	padding: 1.2rem;
	width: 100%;
	max-width: 640px;
    border-radius: .5rem;
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
    color:white
}
.result-finish-score {
    color:white
}
</style>

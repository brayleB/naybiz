<script setup>
import { ref, computed } from 'vue'
const questions = ref([
//1
  {   
	question: 'A landlord can enter your apartment anytime.',
	answer: 1,
	options: [
		'True',
		'False',	
	],
	selected: null,
    description: 'The only time a landlord can enter without notice is if there is an emergency such as a fire or water leak and you are not home. If they ask to come in and you agree, then that is legal as well.'
  },
//2
  {
	question: 'You have the right to change the locks without the landlord’s permission.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'You cannot change the locks without the landlord’s permission. They can apply to the Tribunal if you do. You may be able to negotiate with the landlord by providing a key or by paying the expenses of changing the locking system yourself.'
  },
//3
  {
	question: 'You can withhold rent if your landlord does not complete maintenance/repairs to your unit.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'You should not hold rent back for incomplete repairs. You can be brought to the Tribunal for doing so. It is recommended that you try to negotiate with the landlord first. If the landlord still does not agree then you can provide a written request to the landlord and keep a copy for your records. If this is still unsuccessful, then you may file a Tenant application about maintenance (Form T6) through the Tribunal. There is an application fee to file this form and it will not be processed unless the fee is submitted. You must give the landlord a copy of the form. The Tribunal may then order the landlord to do the needed repairs and/or compensate the tenant for any damages incurred. An application can be made against the landlord up to one year after the problem has been fixed.'
  },
//4
  {
	question: 'A landlord must give you a copy of the lease within 21 days of moving into the rental.',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'The landlord must provide you with a copy of the lease within 21 days. If there is not a lease, the landlord still needs to inform you in writing of his legal name and address within 21 days.'
  },
//5
  {
	question: 'A landlord has to give you 30 days notice when increasing the rent amount.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'Rent can be increased every 12 months as long as it is complying with the provincial guideline (2006 – 2.1%). They must give you written notice (Notice of Rent Increase Form N1) at least 90 days before the change is to take effect.'
  },
//6
  {
	question: 'A landlord can verbally tell you that you are evicted',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'A notice of eviction must be in writing (Notice to Terminate Tenancy) and must be filed with the Tribunal. The notice must be signed by the landlord, give the address of the place where you are living, state the termination date and give the reason for eviction'
  },
//7
  {
	question: 'Only a landlord can apply to the Tribunal to end the tenancy.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'There are many reasons a tenant can apply to terminate a tenancy: unlawfully enteredthe unit, withheld vital services, etc. If the tenant just wants to move out and has given appropriate notice, then they are not obligated to provide a reason.'
  },
//8
  {
	question: 'A landlord can shut off your vital services (heat, hot water), if you do not pay rent.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'A landlord cannot withhold or interfere with a reasonable supply of heat/hot water/electricity/heating oil. This even applies if you have not paid rent or have caused damage to the unit. Even if the landlord is not responsible for the utilities, they still cannot interfere with the supply. A tenant can file a T2 form (Application for Tenants Rights) to the Tribunal.'
  },
//9
  {
	question: 'You can be evicted because of the actions of your guest.',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'A landlord can file an application with the Tribunal to evict you based on the actions ofyour guest. Reasons for this can be that you or your guest has seriously impaired the safety of other people in the rental unit (this can include keeping a pet that is considered dangerous and has threatened another person). Also, your guest causing damage or committing an illegal act or carrying out an illegal business can be a reason for eviction. (These reasons also apply to the actual tenant.) '
  },
//10
  {
	question: 'A landlord can evict you to use the until for their own use or so a family member can move in',
	answer: 0,
	options: ['True','False'],
	selected: null,
    description: 'A landlord can apply to the Tribunal to evict you because they require the unit for their own use (Form N12). They may also require the unit for their child, spouse, parents or same gender partner. The landlord has to give 60 days notice in this case. This kind of eviction is seen as no-fault of the tenant.'
  },
//11
  {
	question: 'You can let someone else take over your apartment (sublet) without your landlord’s permission.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'Transferring a tenancy or “assigning” requires the permission of the landlord. The request should be done in writing. The landlord has the right to refuse the person you want to assign the unit to, but they must have a valid reason.'
  },
//12
  {
	question: 'A landlord does not always have to inform you that they are applying to the Tribunal to evict you.',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'Sometimes your landlord does not have to give you Notice to Terminate Tenancy. This can happen if: \n• your landlord claims that you gave your notice and agreed to move out and you have not moved out yet. • you did not follow a previous Tribunal order or mediation agreement (like not paying when you agreed to make payments on certain dates). • you abandoned your unit. • you moved into the unit without the landlord’s permission. • you are a superintendent and have quit or been fired.'
  },
//13
  {
	question: 'You can have as many people living with you as you want as long as you pay your rent.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'A landlord can apply to the Tribunal to evict you for overcrowding the unit. This may require you to check with local by-laws. There may also be a stipulation in the lease that you agree to not have more than a certain amount of people in the rental unit.'
  },
//14
  {
	question: 'The sheriff is the only one who can physically evict you from your apartment.',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'The sheriff is the person in charge of carrying out the eviction order. If you have not moved out by the date in the eviction order, the sheriff can have your locks changed and make you leave. Only the sheriff can physically evict you from your apartment and lock you out. The sheriff usually gives you a “Sheriff’s Notice to Vacate” which gives you time to move before you are forced out. After the sheriff evicts you, you have 48 hours to get your property from your landlord. If you do not pick up your property within this time, the landlord can sell, keep, give away or throw out anything you leave behind'
  },
//15
  {
	question: 'You can file a dispute against the eviction application',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'If your landlord gives you an application to terminate a tenancy and you do not want to move, you must write a dispute and take it or fax it to the Tribunal. This dispute must be filed within 5 days. The best way to ensure it gets there is to have someone fax it for you. You should have a copy of the Dispute of Application; it should be given to you along with a copy of the eviction application. If you did not receive one, then you can True pick one up at the local Tribunal office. A dispute can also be written without using the official form. Be sure to include your name and address, the Tribunal’s file number (on the application), your landlord’s name, the date, your signature, and the reasons for disputing the application. Make sure you keep a photocopy. Also keep a photocopy of any other documents that you may be including, such as rent receipts. Keep in mind, if you do not dispute within 5 days, the Tribunal could evict you without a hearing. Many tenants are evicted because they do not submit their dispute in time.'
  },
//16
  {
	question: 'If you are late paying your rent, your landlord does not have to accept partial payment.',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'Always clarify what day the landlord wants to receive the rent and how they want to receive it. Rent is considered overdue if the full amount is not paid by midnight on the day it is due. A landlord does not have to accept a partial payment of rent unless they want to. If a partial payment is accepted, the landlord can still take steps to collect the balance of the rent. When beginning a tenancy, always be clear on how the landlord wants to receive rent. In most cases, the tenant must deliver the rent payment to a place agreed upon or set by the landlord, like their residence or place of business. If you agree that the rent will be mailed, be sure to mail it at least 5 days in advance to ensure it is received on time. It is not advisable to mail cash, as there is no guarantee that you will get a receipt. Sending a cheque is the best way as there is a paper trail. A landlord can tell a new tenant how they want the rent to be paid (cash, cheque, money order). Post-dated cheques can be suggested, but a person cannot be refused a rental unit for refusing to give them. This problem can also be easily solved if you are on social assistance; your rent can be paid directly to the landlord by the social services agency.'
  },
//17
  {
	question: ' You can make an application to the Tribunal against your roommate.',
	answer: 1,
	options: ['True','False',],
	selected: null,
    description: 'There are 2 types of roommates: • Joint Tenants: there must be a clear intention by the tenants and the landlord to create a joint tenancy. All the co-tenants have the same rights and obligations concerning the entire rented premises. • Tenants in Common: they need not have equal interest in the premises. They have separate tenancy agreements with the landlord and are independently responsible for their own rent and obligations under the tenancy agreement. They are not responsible for the obligations of the other tenant or tenants. Disputes between co-tenants are problematic because the Tribunal has no jurisdiction over them'
  },
//18
  {
	question: 'A landlord has to pay you interest on your last month’s rent deposit.',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'A landlord must pay the tenant 6% interest on the last month’s rent deposit every year. If your landlord does not pay you the 6% interest, then you can deduct it from your rent cheque.'
  },
//19
  {
	question: 'A potential landlord can ask for more than one month’s rent as a deposit.',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'If you will be renting by the month, the deposit cannot be more than one month’s rent. If you will be renting by the week, it cannot be more than one week’s rent. This deposit is to be used only for last month’s rent, no other purpose. Your landlord can ask you to pay a deposit on keys or access cards, but this cannot be more than it would cost to replace them. All other deposits are illegal. Sometimes, landlords say that if you want to get the apartment then you have to buy something in it, such as curtains or appliances or that you must pay a damage deposit, rental fee or commission. This is illegal.'
  },
//20
  {
	question: '. A landlord can change the locks without notice as long as they provide the tenant promptly with a key',
	answer: 0,
	options: ['True','False',],
	selected: null,
    description: 'A landlord can change the locks without tenant’s consent, but they must give them a replacement key. '
  },
])
const quizCompleted = ref(false)
const currentQuestion = ref(0)
const score = computed(() => {
	let value = 0
	questions.value.map(q => {
		if (q.selected != null && q.answer == q.selected) {
			console.log('correct');
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

<template>
   
                            
        <ul class="nav nav-tabs">
            <li v-for="tab in tabs" :key="tab" class="nav-item">                    
                <button class="nav-link" :class="{ active: tab === selected}" @click="setTab(tab)">
                    {{ tab }}
                </button>
            </li>
        </ul>
                             
        <slot>
        </slot>    
</template>

<script>
    export default {
        props: {
            tabs: {
                type: Array,
                required: true,
            },
            selected: {
                type: String,
                required: true
            }
        },
        methods : {
            setTab(tab){
                this.$emit('selected', tab);
            }
        }
        
    }
</script>

<style scoped>

</style>
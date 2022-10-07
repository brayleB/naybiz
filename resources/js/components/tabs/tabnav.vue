<template>
    <section class="intro">
        <div class="bg-image h-100">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12">
                            
                                <ul class="nav nav-tabs">
                                    <li v-for="tab in tabs" :key="tab" class="nav-item">                    
                                        <button class="nav-link" :class="{ active: tab === selected}" @click="setTab(tab)">
                                            {{ tab }}
                                        </button>
                                    </li>
                                </ul>
                                </div>
                                </div>
                                </div>
                                
            </div>
        </div>
    </section>
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
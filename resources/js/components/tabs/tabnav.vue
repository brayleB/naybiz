<template>      
    <div class="con container-fluid">
        <div class="row justify-content-center">
            <div class="col-11">                               
                <ul class="nav nav-tabs">
                    <li v-for="tab in tabs" :key="tab" class="nav-item">                    
                        <button type="button" class="nav-link" :class="{ active: tab === selected}" @click="setTab(tab)">
                            {{ tab }}
                        </button>
                    </li>
                </ul>
                </div>               
            </div>
        </div>                                                                                      
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
            },                       
        },
        methods : {
            setTab(tab){
                this.$emit('selected', tab);
            }
        }
        
    }
</script>

<style scoped>
.con {
    margin-top: 1.5%;
}

.nav-link {
    border: 1px solid #1760E8;
    color: #768BB1;
    background: #ECF3FF;
}
.nav-link.active {
    background: #1760E8;
    color: #FFF;
    transform: scale(1.2);
    margin-top: -.2rem !important;
    margin-inline: .44rem !important;
}
</style>
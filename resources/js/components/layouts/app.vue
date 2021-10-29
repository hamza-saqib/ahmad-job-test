<template>
    <div>
        <router-view></router-view>        
    </div>
</template>
<script>
    import LoginHeader from './Header.vue';

    export default {
        name: 'main-app',
        data(){
            return {

            }
        },
        components: {
            LoginHeader,
        },
        computed:{
            currentUser(){
                
            },
            currentVendor(){
                
            }
        },
        mounted() {

        },
        beforeCreate(){
        }


    }
</script>

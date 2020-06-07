<template >
   <div>
<!--        
                <transition name="fade" mode="out-in">
                <keep-alive>
                </keep-alive>
                </transition> -->
                <!-- <vue-progress-bar></vue-progress-bar> -->
                
             <div v-if="loader==1">
                 <div class="text-center">
                    <div id="loader"></div>
                 </div>
             </div>
             <div v-if="loader==1">
                 <div class="text-center">
                    <div id="loader"></div>
                 </div>
             </div>
       <template v-if="authenticated">
               <Sidebar ></Sidebar>
                <div class="page active-sm">
                    <Header></Header>
                    <router-view />
                    <!-- {{profile}} -->
                    <Footer></Footer>
                </div>
           </template> 
           <template v-else>
               <!-- <vue-progress-bar></vue-progress-bar> -->
                    <Login></Login>
           </template>
         
   </div>
</template>
<script>
import {mapGetters} from 'vuex';
    import Sidebar from "../includes/NavComponent.vue";
    import Header from "../includes/HeaderComponent.vue";
    import Footer from "../includes/FooterComponent.vue";
    import Login from "../LoginComponent.vue";
    export default {
        components:{
            Sidebar,
            Header,
            Footer,
            Login,

        },
        data(){
            return{
            loader :'1',
            profile:''
            }
        },
        computed:{

            ...mapGetters({
                
                authenticated:'authenticated',
                user:'user',
                
            }),
            
            
        },
        mounted(){
           
        },
        created(){
                this.$store.dispatch('get_data').then(res=>{
                       this.profile=res.data;
                       if(res.data.status!=1){
                           this.$router.push({name: 'user.login'});
                       }else{
                           console.log('you have something wrong')
                       }
                    });
        },

    }
</script>

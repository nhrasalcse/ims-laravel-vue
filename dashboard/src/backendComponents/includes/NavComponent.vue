<template>
    <!-- Side Navbar -->
    <nav class="side-navbar CustomScrollbar _mCS_1 show-sm">
        <div class="side-navbar-wrapper">
            <!-- Sidebar Header    -->
            <div class="sidenav-header d-flex align-items-center justify-content-center">
                <!-- User Info-->
                <div class="sidenav-header-inner text-center">
                    <!-- <img v-if="user.image" :src="(user.image ? path+user.image : '')" alt="person" class="img-fluid rounded-circle"> -->
                    <h2 class="h5">{{profile.name ? profile.name : 'Enter your name'}}</h2><span>Web Developer</span>
                </div>
                <!-- Small Brand information, appears on minimized sidebar-->
                <div class="sidenav-header-logo"><a href="#" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
            </div>
            <!-- Sidebar Navigation Menus-->
            <div class="main-menu">
                <h5 class="sidenav-heading">Main</h5>
                <ul id="side-main-menu" class="side-menu list-unstyled">
<!--                <li><router-link :to="{name :'dashboard'}"><i class="icon-home"></i>Home</router-link></li>-->
                    <!-- <li><a href="/user/dashboard"><i class="icon-home"></i>Home</a></li> -->
                    <li><router-link :to="{name :'dashboard'}"><i class="icon-home"></i>Home</router-link></li>
                    <li><router-link :to="{name :'customer'}"> <i class="icon-user"></i>Customers</router-link></li>
                      <li><router-link :to="{name :'user'}"> <i class="icon-user"></i>Admin</router-link></li>
                    <li><router-link :to="{name :'stock'}"> <i class="icon-form"></i>Stock</router-link></li>
                    <!-- <li><router-link :to="{name :'table'}"> <i class="icon-grid"></i>Tables</router-link></li> -->

                    <li><a href="#product-system" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Product System</a>
                        <ul id="product-system" class="collapse list-unstyled ">
                          <li><router-link :to="{name :'category'}"> <i class="icon-form"></i>Categories</router-link></li>
                            <li><router-link :to="{name :'subCategory'}"> <i class="icon-form"></i>Sub Categories</router-link></li>
                            <li><router-link :to="{name :'brand'}"> <i class="icon-form"></i>Brands</router-link></li>
                            <li><router-link :to="{name :'suplier'}"> <i class="icon-form"></i>Supliers</router-link></li>
                            <li><router-link :to="{name :'product'}"> <i class="icon-form"></i>Products</router-link></li>
                        </ul>
                    </li>
                     <li><a href="#invoice" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Invoice System</a>
                        <ul id="invoice" class="collapse list-unstyled ">
                          <li><router-link :to="{name :'invoice'}"> <i class="icon-form"></i>Invoices</router-link></li>
                         <li><router-link :to="{name :'invoice.create'}"> <i class="icon-form"></i>Create Invoice</router-link></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="admin-menu">
                <h5 class="sidenav-heading">Second menu</h5>
               <!-- <ul id="side-admin-menu" class="side-menu list-unstyled">
                   <li> <a href="#"> <i class="icon-screen"> </i>Demo</a></li>
                   <li> <a href="#"> <i class="icon-flask"> </i>Demo
                    <div class="badge badge-info">Special</div></a></li>
                   <li> <a href=""> <i class="icon-flask"> </i>Demo</a></li>
                   <li> <a href=""> <i class="icon-picture"> </i>Demo</a></li>
               </ul> -->
            </div>
        </div>
    </nav>
</template>
<script>
  import url from '../../path'
  import {mapGetters} from 'vuex';
    export default {
        data(){
            return{
                path:url.path,
                profile:''
            }
        },
        mounted() {
        //    this.$store.dispatch('getSettings').then((response) => {
        //        this.setting = response.data;
        //        console.log(response.data)
        //    });
        },
        computed:{
                ...mapGetters({
                    user:'user'
                })
                
        },
        created(){
                    this.$store.dispatch('get_data').then(res=>{
                       this.profile=res.data;
                    });
        }
    }
</script>

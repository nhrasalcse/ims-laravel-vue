<template>

    <!-- navbar-->
    <header class="header">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><router-link :to="{name :'dashboard'}" class="navbar-brand">
                        <div class="brand-text d-none d-md-inline-block"><strong class="text-primary">Dashboard</strong></div></router-link></div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <!-- Notifications dropdown-->
                        <!-- <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-warning">12</span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                    <div class="notification d-flex justify-content-between">
                                        <div class="notification-content"><i class="fa fa-envelope"></i>You have 6 new messages </div>
                                        <div class="notification-time"><small>4 minutes ago</small></div>
                                    </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                    <div class="notification d-flex justify-content-between">
                                        <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                                        <div class="notification-time"><small>4 minutes ago</small></div>
                                    </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                    <div class="notification d-flex justify-content-between">
                                        <div class="notification-content"><i class="fa fa-upload"></i>Server Rebooted</div>
                                        <div class="notification-time"><small>4 minutes ago</small></div>
                                    </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                    <div class="notification d-flex justify-content-between">
                                        <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                                        <div class="notification-time"><small>10 minutes ago</small></div>
                                    </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-bell"></i>view all notifications                                            </strong></a></li>
                            </ul>
                        </li> --> 
                        <!-- Messages dropdown-->
                        <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                             <img :src="profile.image?path+profile.image : '/backend/img/avatar-5.jpg'" alt="person" height="30px" width="30px" class="rounded-circle">
                           </a>
                            <ul aria-labelledby="notifications" class="dropdown-menu container-fluid">
                                <li>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="profile "> 
                                            <img :src="profile.image?path+profile.image : '/backend/img/avatar-5.jpg'" alt="..." class="rounded-circle" height="100px" width="120px">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="msg-body text-center mt-2">
                                            <h3 class="h5">NH Rasal</h3>
                                            <!-- <span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small> -->
                                        </div>
                                    </div>
                                </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row" style="margin-right: 10px;">
                                        <div class="col-sm-6">
                                              <router-link   :to="{name:'about.me'}" class="btn btn-sm btn-success"><span class="d-none d-sm-inline-block">Profile</span></router-link>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="#" class="btn btn-sm btn-danger" @click.prevent="LogoutMethod"><span class="d-none d-sm-inline-block">Logout</span></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Languages dropdown    -->
                        <!-- <li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img src="/backend/img/flags/16/GB.png" alt="English"><span class="d-none d-sm-inline-block">English</span></a>
                            <ul aria-labelledby="languages" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="/backend/img/flags/16/DE.png" alt="English" class="mr-2"><span>German</span></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="/backend/img/flags/16/FR.png" alt="English" class="mr-2"><span>French                                                         </span></a></li>
                            </ul>
                        </li> -->
                        <!-- Log out-->
                        <!-- <li class="nav-item"><a href="#" class="nav-link logout"  @click.prevent="LogoutMethod"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a></li> -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>
<script>

    import Swal from 'sweetalert2';
    import {mapActions} from 'vuex';
    import {mapGetters} from 'vuex';
        import url from '../../path';
         import sweetAlart from './../../sweetalart'
    export default {
        mounted() {
            console.log('HeaderComponent is connected')
        },
        data(){
            return {
                profile :'',
                path:url.path
            }
        },
        created(){
                this.$store.dispatch('get_data').then(res=>{
                       this.profile=res.data;
                    });
        },
        computed:{
                ...mapGetters({
                    user:'user'
                })
        },
        methods:{
            ...mapActions({
                signOutAction:'signOut'
            }),
            LogoutMethod(e){
                e.preventDefault();
                Swal.fire({
            title: 'Are you sure?',
            text: "You won't be logout!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Logout!'
          }).then((result) => {
            if (result.value) {
                this.$store.dispatch('signOut').then(res=>{
                this.$router.push({name: 'user.login'});
                var msg='Your logout success';
                var vr='success'; 
                var ar='Thank you'; 
                sweetAlart.action.actionFunction(msg,vr,ar);
                }).catch(err=>{
                    console.log(err)
                    var msg='You have something wrong';
                    var vr='error'; 
                    var ar='Warning'; 
                    sweetAlart.action.actionFunction(msg,vr,ar);
                })
                }
                else{
                var msg='Thank your for your stay';
                var vr='success'; 
                var ar='Thank you'; 
                sweetAlart.action.actionFunction(msg,vr,ar);
                }
              })
            }
        }
    }
</script>

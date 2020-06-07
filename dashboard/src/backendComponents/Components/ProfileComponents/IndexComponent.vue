<template>
 <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Profile      </li>
             </ul>
         </div>
     </div>
     <section class="statistics">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-sm-12 col-md-6" >
                     <header><h1 class="h3 display">Profile </h1> </header>
                 </div>
                 <div class="col-sm-12 col-md-6 mt-4">
                     <!-- <router-link v-if="!profiles"  :to="{name:'about.create'}" class="btn btn-primary offset-md-9">Create</router-link>
                     <router-link v-if="profiles" :to="{name:'about.update',params:{id:profiles.id}}" class="btn btn-success offset-md-9">Update</router-link> -->
                 </div>
             </div>
             <!-- ======= About Section ======= -->
             <div v-if="loader==1">
                <div class="text-center">
                    <div id="loader"></div>
                </div>
            </div>
              <!-- Main content -->
    <section v-else class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="row">
                            <!-- <img src="/backend/img/avatar-5.jpg" alt="..." class="img-fluid rounded-circle"> -->
                            <img :src="profile.image ? path+profile.image : '/backend/img/avatar-5.jpg'" alt="..." class="img-fluid rounded-circle">
                           <div class="msg-body text-center mt-2">
                            <h3 class="h5">{{profile.name ? profile.name : ''}}</h3>
                            <span>{{profile.email ? profile.email : profile.phone}}</span><br>
                            <small>{{profile.address ? profile.address : ''}} </small>
                        </div>              
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Edit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Password Update</a>
                        </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="col">Name</th>
                                    <td>{{profile.name ? profile.name : ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Phone</th>
                                    <td>{{profile.phone ? profile.phone : ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Email</th>
                                    <td>{{profile.email ? profile.email : ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Address</th>
                                    <td>{{profile.address ? profile.address : ''}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Role</th>
                                    <td>Nhrasal</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <form class="form-horizontal" @submit.prevent="onSubmit" enctype="multipart/form-data">
                                 <div class="form-group row">
                                     <label class="col-sm-2"> Name</label>
                                     <div class="col-sm-6">
                                         <input type="text" v-model="profile.name" placeholder="First Name" :class="['form-control ', allerros.name ? 'is-invalid' : '' ]"  >
                                         <small class="form-text" v-if="!allerros.name">Enter Name</small>
                                         <span v-if="allerros.name " :class="[ allerros.name ? 'text-danger' :' d-none']">{{ allerros.name[0] }}</span>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-2">Email</label>
                                     <div class="col-sm-6">
                                         <input type="text" v-model="profile.email" placeholder="Contact email" :class="['form-control ', allerros.email ? 'is-invalid' : '' ]"  >
                                         <small class="form-text" v-if="!allerros.email">Enter  your contact email</small>
                                         <span v-if="allerros.email " :class="[ allerros.email ? 'text-danger' :' d-none']">{{ allerros.email[0] }}</span>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-2"> Phone</label>
                                     <div class="col-sm-6">
                                         <input type="text" v-model="profile.phone" placeholder="Enter your phone number" :class="['form-control ', allerros.phone ? 'is-invalid' : '' ]"  >
                                         <small class="form-text" v-if="!allerros.phone">Enter  your tag</small>
                                         <span v-if="allerros.phone " :class="[ allerros.phone ? 'text-danger' :' d-none']">{{ allerros.phone[0] }}</span>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-2">Address </label>
                                     <div class="col-sm-6">
                                        <textarea v-model="profile.address" placeholder="Address  details" :class="['form-control ', allerros.address ? 'is-invalid' : '' ]"></textarea>
                                        <small class="form-text" v-if="!allerros.profile_title">Enter  your address</small>
                                         <span v-if="allerros.address " :class="[ allerros.address ? 'text-danger' :' d-none']">{{ allerros.address[0] }}</span>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-2">Image</label>
                                     <div class="col-sm-6">
                                         <input id="image" type="file" placeholder=" Image" accept="image/*" :class="['form-control ', allerros.image ? 'is-invalid' : '' ]" @change="yourImage">
                                         <small class="form-text" v-if="!allerros.image">image</small>
                                         <span v-if="allerros.image" :class="['text-danger']">{{ allerros.image[0] }}</span>
                                     </div>
                                     <div class="col-sm-4">
                                         <img v-if="Image" :src="Image" class="img-thumbnail small-image" alt="" >
                                         <img v-else-if="profile.image" :src="path+profile.image" class="img-thumbnail small-image" alt="" >
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <div class="col-sm-10 offset-sm-2">
                                         <button type="submit" class="btn btn-success">Submit</button>
                                     </div>
                                 </div>
                             </form>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                             <form class="form-horizontal" @submit.prevent="onPassword" enctype="multipart/form-data">
                                 <div class="form-group row">
                                     <label class="col-sm-2">Old Password</label>
                                     <div class="col-sm-6">
                                         <input type="password" v-model="password.oldPassword" placeholder="Enter Old Password" :class="['form-control ', allerros.oldPassword ? 'is-invalid' : '' ]"  >
                                         <small class="form-text" v-if="!allerros.oldPassword">Enter  old password</small>
                                         <span v-if="allerros.oldPassword " :class="[ allerros.oldPassword ? 'text-danger' :' d-none']">{{ allerros.oldPassword[0] }}</span>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-2">New Password</label>
                                     <div class="col-sm-6">
                                         <input type="password" v-model="password.password" placeholder="New password" :class="['form-control ', allerros.password ? 'is-invalid' : '' ]"  >
                                         <small class="form-text" v-if="!allerros.password">Enter  your  new password</small>
                                         <span v-if="allerros.password " :class="[ allerros.password ? 'text-danger' :' d-none']">{{ allerros.password[0] }}</span>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-2"> Confirm Password</label>
                                     <div class="col-sm-6">
                                         <input type="password" v-model="password.password_confirmation" placeholder="Enter your confirmation Password" :class="['form-control ', allerros.password_confirmation ? 'is-invalid' : '' ]"  >
                                         <small class="form-text" v-if="!allerros.password_confirmation">Enter  Confirm password</small>
                                         <span v-if="allerros.password_confirmation " :class="[ allerros.password_confirmation ? 'text-danger' :' d-none']">{{ allerros.password_confirmation[0] }}</span>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <div class="col-sm-10 offset-sm-2">
                                         <button type="submit" class="btn btn-success">Submit</button>
                                     </div>
                                 </div>
                             </form>
                       
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
             <hr>
         </div>
     </section>
 </div>
</template>
<script>
    const axios = require('axios');
     import url from '../../../path'
     import {mapGetters} from 'vuex';
     import header from '../../../header'
     
    export default {
        mounted () {
        },
        data() {
            return {
                profile:{
                    name:'',
                    email:'',
                    phone:'',
                    address:'',
                    image:''
                },
                password:{
                        oldPassword:'',
                        password:'',
                        password_confirmation:'',
                },
                allerros: [],
                success: false,
                your_image:'',
                Image:'',
                path:url.path,
                loader:1,
            }
        },
        created(){
                this.getProfile()
        },
        methods:{
            getProfile(){
                    this.$store.dispatch('get_data').then(res=>{
                       this.profile=res.data;
                       this.loader=0;
                    });
            },
             
            yourImage(e){
                this.your_image=e.target.files[0];
                const file=e.target.files[0];
                this.your_image=file;
                if (!file){
                    this.Image='';
                }else{
                    this.Image=URL.createObjectURL(file);
                }
            },
            onSubmit(e) {
                 this.loader=1;
                e.preventDefault();
                let formData = new FormData();
                formData.append('name', this.profile.name);
                formData.append('email', this.profile.email);
                formData.append('phone', this.profile.phone);
                formData.append('address', this.profile.address);
                formData.append('image', this.your_image);
                this.$store.dispatch('update_data',formData,header)
                    .then(response => {
                        this.getProfile();
                         this.loader=0;
                            this.$swal.fire(
                                    'Thank you!',
                                    'Profile Update Success!',
                                    'success'
                                    )
                    }).catch((error) => {
                        console.log(error);
                    this.allerros = error.response.data.errors;
                    this.success = false;
                    this.$swal.fire(
                                    'Warning!',
                                    'You have something wrong!',
                                    'error'
                                    )
                });
            },
            onPassword(e){
                e.preventDefault();
                 let formData = new FormData();
                formData.append('oldPassword', this.password.oldPassword);
                formData.append('password', this.password.password);
                formData.append('password_confirmation', this.password.password_confirmation);
                this.$swal.fire({
            title: 'Are you sure?',
            text: "You want to Change Password!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
          }).then((result) => {
            if (result.value) {
                this.$store.dispatch('update_password',formData,header)
                    .then(response => {
                        if(response.data[0]=='success'){
                             this.getProfile();
                         this.loader=0;
                            this.$swal.fire(
                                    'Thank you!',
                                    'password Update Success!',
                                    'success'
                                    )
                                     this.$store.dispatch('signOut').then(res=>{
                                     this.$router.push({name: 'user.login'});
                                     })
                        }else if(response.data[0]=='newnotmatch'){
                             this.$swal.fire(
                                    'Warning!',
                                    'New Password not match',
                                    'error'
                                    )
                        }
                        else if(response.data[0]=='oldnotmatch'){
                             this.$swal.fire(
                                    'Warning!',
                                    'Current Password not match!',
                                    'error'
                                    )
                        }
                       
                    }).catch((error) => {
                        console.log(error);
                    this.allerros = error.response.data.errors;
                    this.success = false;
                    this.$swal.fire(
                                    'Warning!',
                                    'You have something wrong!',
                                    'error'
                                    )
                });
            }else{

            }
            });
                 
            }
        },
    }
</script>
<style>
    .sect-pt4 {
        padding-top: 1rem;
    }
    .title-s {
        font-weight: 600;
        color: #1e1e1e;
        font-size: 1.1rem;
    }
    .statistics p {
        font-size:1.1em;
        color: #212529;;
        margin-bottom: 5px;
    }
</style>

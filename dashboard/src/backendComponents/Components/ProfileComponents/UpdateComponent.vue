<template>
    <div>
        <!-- Breadcrumb-->
        <div class="breadcrumb-holder">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><router-link :to="{name:'dashboard'}">Home</router-link></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ul>
            </div>
        </div>
        <section class="forms">
            <div class="container-fluid">
                <!-- Page Header-->
                <header>
                    <h1 class="h3 display">Profile </h1>
                </header>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h4>Profile Update Form</h4>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" @submit.prevent="onSubmit" enctype="multipart/form-data">
                                    <input type="hidden" v-model="profile.id">
                                    <div class="form-group row">
                                        <label class="col-sm-2">First Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" v-model="profile.first_name" placeholder="Enter  First Name" :class="['form-control ', allerros.first_name ? 'is-invalid' : '' ]"  >
                                            <small class="form-text" v-if="!allerros.first_name">Enter  First Name</small>
                                            <span v-if="allerros.first_name " :class="[ allerros.first_name ? 'text-danger' :' d-none']">{{ allerros.first_name[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2">Last Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" v-model="profile.last_name" placeholder="Enter Last Name" :class="['form-control ', allerros.last_name ? 'is-invalid' : '' ]"  >
                                            <small class="form-text" v-if="!allerros.last_name">Enter  Last Name</small>
                                            <span v-if="allerros.last_name " :class="[ allerros.last_name ? 'text-danger' :' d-none']">{{ allerros.last_name[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2">Your Tags</label>
                                        <div class="col-sm-6">
                                            <input type="text" v-model="profile.profile_title" placeholder="Tags" :class="['form-control ', allerros.profile_title ? 'is-invalid' : '' ]"  >
                                            <small class="form-text" v-if="!allerros.profile_title">Enter  your tag</small>
                                            <span v-if="allerros.profile_title " :class="[ allerros.profile_title ? 'text-danger' :' d-none']">{{ allerros.profile_title[0] }}</span>
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
                                        <label class="col-sm-2">About You</label>
                                        <div class="col-sm-6">
                                            <!--                                         <teaxtarea v-model="profile.about_me_details" placeholder="About your details" :class="['form-control ', allerros.about_me_details ? 'is-invalid' : '' ]"></teaxtarea>-->
                                            <input type="text" v-model="profile.about_me_details" placeholder="About your details" :class="['form-control ', allerros.about_me_details ? 'is-invalid' : '' ]"  >
                                            <small class="form-text" v-if="!allerros.profile_title">Enter  your tag</small>
                                            <span v-if="allerros.about_me_details " :class="[ allerros.about_me_details ? 'text-danger' :' d-none']">{{ allerros.about_me_details[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2">Image</label>
                                        <div class="col-sm-6">
                                            <input id="image" type="file" placeholder=" Image" accept="image/*" :class="['form-control ', allerros.profile_image ? 'is-invalid' : '' ]" @change="yourImage">
                                            <small class="form-text" v-if="!allerros.image">image</small>
                                            <span v-if="allerros.profile_image" :class="['text-danger']">{{ allerros.profile_image[0] }}</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <img v-if="profiles.Image" :src="profiles.Image" class="img-thumbnail small-image" alt="" >
                                            <img v-else :src="path+profile.profile_image" class="img-thumbnail small-image" alt="" >
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
    </div>
</template>
<script>
    import header from "../../../header";
    import url from '../../../path'
    const axios = require('axios');
    export default {
        mounted () {
        },
        data() {
            return {
                profile:{
                    first_name:'',
                    last_name:'',
                    profile_title:'',
                    email:'',
                    phone:'',
                    about_me_details:'',
                    Image:'',
                    profile_image:''
                },
                profiles:{
                    Image:'',
                },
                allerros: [],
                success: false,
                your_image:'',
                path:url.path
            }
        },

        created() {
            this.getResults();
        },
        methods:{
            getResults() {
                let id=this.$route.params.id;
                this.$store.dispatch('edit_about',id ).then(response=>{
                    this.profile = response.data;
                    console.log(response.data)
                })
            },
            yourImage(e){
                this.your_image=e.target.files[0];
                const file=e.target.files[0];
                this.your_image=file;
                console.log(file)
                if (!file){
                    this.profiles.Image='';
                }else{
                    this.profiles.Image=URL.createObjectURL(file);
                }
            },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.profile.id);
                formData.append('first_name', this.profile.first_name);
                formData.append('last_name', this.profile.last_name);
                formData.append('profile_title', this.profile.profile_title);
                formData.append('email', this.profile.email);
                formData.append('phone', this.profile.phone);
                formData.append('about_me_details', this.profile.about_me_details);
                formData.append('profile_image', this.your_image);
                this.$store.dispatch('update_about',formData,header)
                    .then(response => {
                            this.$toasted.success('Profile Update')
                            this.$router.push({name: 'about.me'});
                    }).catch((error) => {
                    this.$swal.fire(
                                    'Error!',
                                    'You have something wrong!',
                                    'error'
                                    )
                    this.allerros = error.response.data.errors;
                    this.success = false;
                });
            },

            makeToast(variant = null,body=null, title=null) {
                this.$bvToast.toast(`${body}`, {
                    title: `${title || 'default'}`,
                    variant: variant,
                    solid: true
                });
            }
        },
    }

</script>
<style>
    .small-image{
        height: 100px;
        width: 100px;
    }
</style>

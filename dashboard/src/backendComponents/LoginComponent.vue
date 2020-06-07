<template>
    <div class="page login-page">
        <div class="container">
            <div class="form-outer text-center d-flex align-items-center">
                <div class="form-inner">
                    <div class="logo text-uppercase"><span>login</span><strong class="text-primary">Inventory</strong></div>
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p> -->
                       <!-- <p class="text-danger" v-if="user"> {{user}}</p> -->
                    <!-- <form  class="text-left form-validate" @submit.prevent="onSubmit"> -->
                        
                    <div v-if="loader==1">
                            <div class="text-center">
                                <div id="loader"></div>
                            </div>
                        </div>
                    <form  class="text-left" @submit.prevent="onSubmit">
                        <div class="form-group-material">
                            <label for="login-username" class="label-material">Email</label>
                            <input id="login-username" type="text" name="loginUsername"  data-msg="Please enter your email" class="input-material" v-model="form.email">
                            <span v-if="allerros.email" :class="['text-danger']">{{ allerros.email[0] }}</span>
                        </div>
                        <div class="form-group-material">
                            <label for="login-password" class="label-material" >Password</label>
                            <input id="login-password" type="password" name="loginPassword"  data-msg="Please enter your password" class="input-material" v-model="form.password">

                            <span v-if="allerros.password" :class="['text-danger']">{{ allerros.password[0] }}</span>
                        </div>
                        <div class="form-group text-center">  <button type="submit" class="btn btn-primary">Login</button>
                            <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                        </div>
                    </form>
                    <!-- <a href="#" class="forgot-pass">Forgot Password?</a><small>Do not have an account? </small><a href="register.html" class="signup">Signup</a> -->
                </div>
                <div class="copyrights text-center">
                    <p>Design by
                         <!-- <a href="https://bootstrapious.com/p/bootstrap-4-dashboard" class="external"> -->
                         NH Rasal</a></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import header from "../../header";
    const axios = require('axios');
    import swal from 'sweetalert2';
    export default {
        mounted(){
        },
        data() {
            return {
                allerros: [],
                form: {
                    email:'',
                    password:''
                },
                // user:'',
                success: false,
                loader:'0',
            }
        },
        methods: {
            onSubmit() {
                this.loader='1';
                 let formData = new FormData();
                formData.append('email', this.form.email);
                formData.append('password', this.form.password);
                this.$store.dispatch('LoginAuth',formData,header).then(res=>{
                    this.loader=0;
                    this.$router.push({path: '/dashboard'});
                }).catch(error=>{
                    this.allerros = error.response.data.errors;
                    
                    this.loader=0;
                    swal.fire({
                        title: 'Error!',
                        text: 'Your email or password something wrong',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    this.success = false;
                });
            },
        }
    }
</script>

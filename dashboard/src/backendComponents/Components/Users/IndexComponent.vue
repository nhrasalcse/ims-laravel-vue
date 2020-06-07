<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">user</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createuser">Add user</button></li>
             </ul> 
         </div>
     </div>
     <section>
        <div class="container-fluid">
            <div class="row justify-content-center mt-2 mb-0">
              <div>
                 <form class="form-horizontal" @submit.prevent="onSearch"  enctype="multipart/form-data">
                  <div class="form-group row">
                      <div class="col-sm-9 col-md-9">
                        <input type="text" v-model="search" placeholder="User any one information" :class="['form-control ']"  >
                    </div>
                    <div class="col-sm-3 col-md-3"><button class="btn btn-primary"><i class="fa fa-search"></i></button></div>
                  </div>
                 </form>
              </div>
            </div>
          <div class="row justify-content-center">
            <div v-if="loader==1">
                <div class="text-center">
                    <div id="loader"></div>
                </div>
            </div>
            <div v-else class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>User Table </h4>
                  <!-- {{user_role_id.role.id ? user_role_id.role.id : ''}} -->
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped myTable">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(udata,index) in users.data" :key="udata.id" class="text-center">
                          <th scope="row">{{index+1}}</th>
                          <td><img :src="udata.image ? path+udata.image : udata.gender=='M'? '/backend/img/avatar/avatarM.png' : '/backend/img/avatar/avatarF.png'" alt="" class="img-fluid rounded-circle" height="50px" width="50px"></td>
                          <td>{{udata.name ? udata.name : ''}}</td>
                          <td>{{udata.phone ? udata.phone : ''}}</td>
                          <td>{{udata.email ? udata.email : ''}}</td>
                          <td>{{udata.address ? udata.address : ''}}</td>
                          <td>
                            <table>
                              <tr>
                                <td><button  class="btn btn-outline-primary" @click.prevent="edit(udata.id)"> <i class="fa fa-edit"></i> </button></td>
                                <td><button class="btn btn-danger" @click.prevent="deleteuser(udata.id)"> <i class="fa fa-trash"></i> </button></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row d-flex justify-content-center">
                 <pagination :data="users" @pagination-change-page="getData">
                     <span slot="prev-nav">&lt; Previous</span>
                     <span slot="next-nav">Next &gt;</span>
                 </pagination>
             </div>
        </div>
    </section>
    <!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">User {{msg}}</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="form-data" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <input type="hidden" v-model="user.id">
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">User Name</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="user.name" placeholder="Enter  user Name" :class="['form-control ', allerros.name ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.name">Enter  user Name</small>
                    <span v-if="allerros.name " :class="[ allerros.name ? 'text-danger' :' d-none']">{{ allerros.name[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Email</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="user.email" placeholder="Contact email" :class="['form-control ', allerros.email ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.email">Enter  your contact email</small>
                    <span v-if="allerros.email " :class="[ allerros.email ? 'text-danger' :' d-none']">{{ allerros.email[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4"> Phone</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="user.phone" placeholder="Enter your phone number" :class="['form-control ', allerros.phone ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.phone">Enter Phone Number</small>
                    <span v-if="allerros.phone " :class="[ allerros.phone ? 'text-danger' :' d-none']">{{ allerros.phone[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4"> Gender</label>
                <div class="col-sm-12 col-md-7">
                        <label class="checkbox-inline">
                          <input id="inlineCheckbox1" v-model="user.gender" type="radio" value="M">Male
                        </label>
                        <label class="checkbox-inline">
                          <input id="inlineCheckbox2" v-model="user.gender" type="radio" value="F"> Female
                        </label>
                        <label class="checkbox-inline">
                          <input id="inlineCheckbox3" v-model="user.gender" type="radio" value="O"> Others
                        </label>
                        
                      <span v-if="allerros.phone " :class="[ allerros.gender ? 'text-danger' :' d-none']">{{ allerros.gender[0] }}</span>
              
                      </div>
                       </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Address</label>
                <div class="col-sm-12 col-md-7">
                     <!-- <input type="text" v-model="user.address" placeholder="Address " :class="['form-control ', allerros.address ? 'is-invalid' : '' ]"  > -->
                     <textarea  v-model="user.address" placeholder="Address " :class="['form-control ', allerros.address ? 'is-invalid' : '' ]" ></textarea>
                   
                    <small class="form-text" v-if="!allerros.user_title">Enter Address</small>
                    <span v-if="allerros.address " :class="[ allerros.address ? 'text-danger' :' d-none']">{{ allerros.address[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Password</label>
                <div class="col-sm-12 col-md-7">
                     <input type="password" v-model="user.password" placeholder="password " :class="['form-control ', allerros.password ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.user_title">Enter password</small>
                    <span v-if="allerros.password " :class="[ allerros.password ? 'text-danger' :' d-none']">{{ allerros.password[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Role</label>
                <div class="col-sm-12 col-md-7">
                  <select v-model="user.role" :class="['form-control ', allerros.role ? 'is-invalid' : '' ]">
                      <option value="">Select</option>
                      <option v-for="roleData in role" :value="roleData.id" >{{roleData.name ? roleData.name : ''}}</option>
                  </select>
                  <span v-if="allerros.role " :class="[ allerros.role ? 'text-danger' :' d-none']">{{ allerros.role[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Image</label>
                <div class="col-sm-12 col-md-4">
                    <input ref="imageInput" id="image" type="file" placeholder=" Image" accept="image/*" :class="['form-control ', allerros.image ? 'is-invalid' : '' ]" @change="yourImage">
                    <small class="form-text" v-if="!allerros.image">image</small>
                    <span v-if="allerros.image" :class="['text-danger']">{{ allerros.image[0] }}</span>
                </div>
                <div class="col-sm-4">
                    <img v-if="user.Image" :src="user.Image" class="img-thumbnail small-image" alt="" >
                    <img v-if="user.image" :src="path+user.image" class="img-thumbnail small-image" alt="" >
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-success">{{msg}}</button>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
</div>
</template>
<script>
    import header from "../../../header";
    const axios = require('axios');
    import sweetAlart from './../../../sweetalart'
    import url from './../../../path'
    export default {
        mounted () {
        },
        data() {
            return {
                user:{
                    id:'',
                    name:'',
                    gender:'',
                    email:'',
                    phone:'',
                    address:'',
                    Image:'',
                    image:'',
                    password:'',
                    role:'',
                },
                users:{
                    name:'',
                    email:'',
                    gender:'',
                    phone:'',
                    address:'',
                    Image:'',
                    image:''
                },
                search:'',
                allerros: [],
                success: false,
                your_image:'',
                path:url.path,
                loader:0,
                msg:'',
                datable:false,
                role:[],
                user_role_id:[],
            }
        },
        created(){
          this.getData();
          this.getRoleData();
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getUser',page).then(res=>{
                this.users=res.data;
                this.loader=0;
                    $("#formModal").modal('hide')
                    //  this.datable= $('.myTable').DataTable({});
              })
          },
          getRoleData(){
              this.$store.dispatch('getRole').then(res=>{
                this.role=res.data;
              })
          },
          edit(id){
            this.msg='Update';
            this.formReset();
             this.user_role_id=[];
            this.$store.dispatch('editUser',id).then(res=>{
                this.user=res.data[0];
                this.user_role_id=res.data[1];
                 $("#formModal").modal('show')
              });
            
          },
          createuser(){
              this.formReset();
              this.user_role_id=[];
              this.msg='Create';
              $("#formModal").modal('show')
          },
            yourImage(e){
                this.your_image=e.target.files[0];
                const file=e.target.files[0];
                this.your_image=file;
                // this.user.image=''
                if (!file){
                    this.user.Image='';
                }else{
                  console.log(file)
                  this.user.image='';
                  this.user.Image=URL.createObjectURL(file);
                }
            },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.user.id);
                formData.append('name', this.user.name);
                formData.append('email', this.user.email);
                formData.append('phone', this.user.phone);
                formData.append('gender', this.user.gender);
                formData.append('address', this.user.address);
                formData.append('role', this.user.role);
                formData.append('password', this.user.password);
                formData.append('image', this.your_image);
                if(this.user.id){
                  this.$store.dispatch('updateUser',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='User Update Success';
                            var vr='success'; 
                            var ar='Thank you'; 
                          sweetAlart.action.actionFunction(msg,vr,ar);
                             this.formReset();
                             this.getData();
                        }
                    }).catch((error) => {
                        console.log(error);
                    this.allerros = error.response.data.errors;
                    this.success = false;
                    var msg='you have something wrong';
                    var vr='error'; 
                    var ar='Warning'; 
                   sweetAlart.action.actionFunction(msg,vr,ar);
                });
                }else{
                this.$store.dispatch('createUser',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='Create Success';
                            var vr='success'; 
                            var ar='Thank you'; 
                          sweetAlart.action.actionFunction(msg,vr,ar);
                             this.formReset();
                             this.getData();
                        }
                    }).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
                    var msg='you have something wrong';
                    var vr='error'; 
                    var ar='Warning'; 
                   sweetAlart.action.actionFunction(msg,vr,ar);
                });
                }
            },
            deleteuser(id){
             this.$swal.fire({
            title: 'Are you sure?',
            text: "You won't be Delete!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete!'
          }).then((result) => {
            if (result.value) {
            this.$store.dispatch('deleteUser',id).then(res=>{
              // this.users.splice(this.users.indexOf(id),1);
              var msg='Delete Success';
              var vr='success'; 
              var ar='Thank you'; 
              sweetAlart.action.actionFunction(msg,vr,ar);
              // this.formReset();
              this.getData();
            })
            }else{
              var msg='Delete Canceled';
              var vr='success'; 
              var ar='Thank you'; 
              sweetAlart.action.actionFunction(msg,vr,ar);
              // this.formReset();
              this.getData();
            }
            })
            },
            onSearch(e){
              let formData = new FormData();
                formData.append('query', this.search);
              this.$store.dispatch('searchUser',formData,header)
                    .then(response => {
                        // this.users=response.data;
                        console.log(response.data)
                })
            },
            formReset(){
                this.user.id='';
                this.user.name='';
                // this.user.details='';
                this.user.email='';
                this.user.phone='';
                this.user.gender='';
                this.user.address='';
                this.user.role='';
                this.$refs.imageInput.value = null
                this.user.Image='';
                this.user.image=false;
                this.allerros='';
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
.modal-header {
    background: #999;
    color: #fff;
}
.modal-footer {
    background: #999;
    color: #fff;
}

</style>
<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Customer</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createCustomer">Add Customer</button></li>
             </ul> 
         </div>
     </div>
     <section>
        <div class="container-fluid">
            <div class="row justify-content-center mt-2 mb-0">
              <div>
                 <form class="form-horizontal" id="form-data" @submit.prevent="onSearch"  enctype="multipart/form-data">
                  <div class="form-group row">
                      <div class="col-sm-9 col-md-9">
                        <input type="text" v-model="search" placeholder="Customer any one information" :class="['form-control ']"  >
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
                  <h4>Customer Table </h4>
                  
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
                        <tr v-for="(cdata,index) in customers.data" :key="cdata.id" class="text-center">
                          <th scope="row">{{index+1}}</th>
                          <td><img :src="cdata.image ? path+cdata.image : cdata.gender=='M'? '/backend/img/avatar/avatarM.png' : '/backend/img/avatar/avatarF.png'" alt="" class="img-fluid rounded-circle" height="50px" width="50px"></td>
                          <td>{{cdata.name ? cdata.name : ''}}</td>
                          <td>{{cdata.phone ? cdata.phone : ''}}</td>
                          <td>{{cdata.email ? cdata.email : ''}}</td>
                          <td>{{cdata.address ? cdata.address : ''}}</td>
                          <td>
                            <table>
                              <tr>
                                <td><button  class="btn btn-outline-primary" @click.prevent="edit(cdata.id)"> <i class="fa fa-edit"></i> </button></td>
                                <td><button class="btn btn-danger" @click.prevent="deleteCustomer(cdata.id)"> <i class="fa fa-trash"></i> </button></td>
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
                 <pagination :data="customers" @pagination-change-page="getData">
                     <span slot="prev-nav">&lt; Previous</span>
                     <span slot="next-nav">Next &gt;</span>
                 </pagination>
             </div>
        </div>
    </section>
    <!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Customer {{msg}}</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal"  @submit.prevent="onSubmit" enctype="multipart/form-data">
            <input type="hidden" v-model="customer.id">
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Customer Name</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="customer.name" placeholder="Enter  Customer Name" :class="['form-control ', allerros.name ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.name">Enter  Customer Name</small>
                    <span v-if="allerros.name " :class="[ allerros.name ? 'text-danger' :' d-none']">{{ allerros.name[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Email</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="customer.email" placeholder="Contact email" :class="['form-control ', allerros.email ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.email">Enter  your contact email</small>
                    <span v-if="allerros.email " :class="[ allerros.email ? 'text-danger' :' d-none']">{{ allerros.email[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4"> Phone</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="customer.phone" placeholder="Enter your phone number" :class="['form-control ', allerros.phone ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.phone">Enter Phone Number</small>
                    <span v-if="allerros.phone " :class="[ allerros.phone ? 'text-danger' :' d-none']">{{ allerros.phone[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4"> Gender</label>
                <div class="col-sm-12 col-md-7">
                        <label class="checkbox-inline">
                          <input id="inlineCheckbox1" v-model="customer.gender" type="radio" value="M">Male
                        </label>
                        <label class="checkbox-inline">
                          <input id="inlineCheckbox2" v-model="customer.gender" type="radio" value="F"> Female
                        </label>
                        <label class="checkbox-inline">
                          <input id="inlineCheckbox3" v-model="customer.gender" type="radio" value="O"> Others
                        </label>
                        
                      <span v-if="allerros.phone " :class="[ allerros.gender ? 'text-danger' :' d-none']">{{ allerros.gender[0] }}</span>
              
                      </div>
                       </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Address</label>
                <div class="col-sm-12 col-md-7">
                     <input type="text" v-model="customer.address" placeholder="Addressr " :class="['form-control ', allerros.address ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.customer_title">Enter Address</small>
                    <span v-if="allerros.address " :class="[ allerros.address ? 'text-danger' :' d-none']">{{ allerros.address[0] }}</span>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Customer Details</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="customer.details" placeholder="Enter customer Details" :class="['form-control ', allerros.details ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.details">Enter  Customer Details</small>
                    <span v-if="allerros.details " :class="[ allerros.details ? 'text-danger' :' d-none']">{{ allerros.details[0] }}</span>
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
                    <img v-if="Image" :src="Image" class="img-thumbnail small-image" alt="" >
                    <img v-if="customer.image" :src="path+customer.image" class="img-thumbnail small-image" alt="" >
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
                customer:{
                    id:'',
                    name:'',
                    gender:'',
                    details:'',
                    customer_title:'',
                    email:'',
                    phone:'',
                    address:'',
                    Image:'',
                    name:'',
                    details:'',
                    customer_title:'',
                    email:'',
                    phone:'',
                    address:'',
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
                    Image:'',
            }
        },
        created(){
          this.getData();
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getCustomer',page).then(res=>{
                this.customers=res.data;
                this.loader=0;
                    $("#exampleModal").modal('hide')
                     this.datable= $('.myTable').DataTable({});
              })
          },
          edit(id){
            this.msg='Update';
            this.formReset();
            this.$store.dispatch('editCustomer',id).then(res=>{
                this.customer=res.data;
                 $("#exampleModal").modal('show')
              });
          },
          updateUpdate(){

          },
          createCustomer(){
              this.formReset();
              this.msg='Create';
              $("#exampleModal").modal('show')
          },
            yourImage(e){
                this.your_image=e.target.files[0];
                const file=e.target.files[0];
                this.your_image=file;
                // this.customer.image=''
                if (!file){
                    this.Image='';
                }else{
                  console.log(file)
                  this.customer.image='';
                  this.Image=URL.createObjectURL(file);
                }
            },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.customer.id);
                formData.append('name', this.customer.name);
                formData.append('details', this.customer.details);
                formData.append('email', this.customer.email);
                formData.append('phone', this.customer.phone);
                formData.append('gender', this.customer.gender);
                formData.append('address', this.customer.address);
                formData.append('image', this.your_image);
                if(this.customer.id){
                  this.$store.dispatch('updateCustomer',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='Update Success';
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
                this.$store.dispatch('createCustomer',formData,header)
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
                        console.log(error);
                    this.allerros = error.response.data.errors;
                    console.log(error.response.data.errors)
                    this.success = false;
                    var msg='you have something wrong';
                    var vr='error'; 
                    var ar='Warning'; 
                   sweetAlart.action.actionFunction(msg,vr,ar);
                });
                }
            },
            deleteCustomer(id){
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
            this.$store.dispatch('deleteCustomer',id).then(res=>{
              // this.customers.splice(this.customers.indexOf(id),1);
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
              this.$store.dispatch('searchCustomer',formData,header)
                    .then(response => {
                        // this.customers=response.data;
                        console.log(response.data)
                })
            },
            formReset(){
                this.customer.id='';
                this.customer.name='';
                this.customer.details='';
                this.customer.email='';
                this.customer.phone='';
                this.customer.gender='';
                this.customer.address='';
                this.$refs.imageInput.value = null
                this.customer.Image='';
                this.customer.image=false;
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
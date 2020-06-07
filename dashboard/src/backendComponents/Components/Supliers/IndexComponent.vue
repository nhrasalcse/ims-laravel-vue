<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Suplier</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createsuplier">Add suplier</button></li>
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
                        <input type="text" v-model="search" placeholder="suplier any one information" :class="['form-control ']"  >
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
                  <h4>suplier Table </h4>
                  
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
                        <tr v-for="(supdata,index) in supliers.data" :key="supdata.id">
                          <th scope="row">{{index+1}}</th>
                          <td><img :src="supdata.image ? path+supdata.image :  '/backend/img/avatar/category.png' " alt="" class="img-fluid" height="50px" width="50px"></td>
                          <td>{{supdata.name ? supdata.name : ''}}</td>
                          <td>{{supdata.phone ? supdata.phone : ''}}</td>
                          <td>{{supdata.email ? supdata.email : ''}}</td>
                          <td>{{supdata.address ? supdata.address : ''}}</td>
                          <td>
                            <table>
                              <tr>
                                <td><button  class="btn btn-outline-primary" @click.prevent="edit(supdata.id)"> <i class="fa fa-edit"></i> </button></td>
                                <td><button class="btn btn-danger" @click.prevent="deletesuplier(supdata.id)"> <i class="fa fa-trash"></i> </button></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                          <tr>
                          <th>SL</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row d-flex justify-content-center">
                 <pagination :data="supliers" @pagination-change-page="getData">
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
        <h5 class="modal-title" id="exampleModalLabel">suplier {{msg}}</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal"  @submit.prevent="onSubmit" enctype="multipart/form-data">
            <input type="hidden" v-model="suplier.id">
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Suplier Name</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="suplier.name" placeholder="Enter  suplier Name" :class="['form-control ', allerros.name ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.name">Enter  suplier Name</small>
                    <span v-if="allerros.name " :class="[ allerros.name ? 'text-danger' :' d-none']">{{ allerros.name[0] }}</span>
                </div>
            </div> <div class="form-group row">
                <label class="col-sm-12 col-md-4">Email</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="suplier.email" placeholder="Contact email" :class="['form-control ', allerros.email ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.email">Enter  your contact email</small>
                    <span v-if="allerros.email " :class="[ allerros.email ? 'text-danger' :' d-none']">{{ allerros.email[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4"> Phone</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="suplier.phone" placeholder="Enter your phone number" :class="['form-control ', allerros.phone ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.phone">Enter Phone Number</small>
                    <span v-if="allerros.phone " :class="[ allerros.phone ? 'text-danger' :' d-none']">{{ allerros.phone[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Address</label>
                <div class="col-sm-12 col-md-7">
                     <!-- <input type="text" v-model="suplier.address" placeholder="Address " :class="['form-control ', allerros.address ? 'is-invalid' : '' ]"  > -->
                    <textarea name="" id="" v-model="suplier.address" placeholder="Address " :class="['form-control ', allerros.address ? 'is-invalid' : '' ]" ></textarea>
                    <small class="form-text" v-if="!allerros.address">Enter Address</small>
                    <span v-if="allerros.address " :class="[ allerros.address ? 'text-danger' :' d-none']">{{ allerros.address[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">suplier description</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="suplier.description" placeholder="Enter suplier description" :class="['form-control ', allerros.description ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.description">Enter  suplier description</small>
                    <span v-if="allerros.description " :class="[ allerros.description ? 'text-danger' :' d-none']">{{ allerros.description[0] }}</span>
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
                    <img v-if="suplier.Image" :src="suplier.Image" class="img-thumbnail small-image" alt="" >
                    <img v-if="suplier.image" :src="path+suplier.image" class="img-thumbnail small-image" alt="" >
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
                suplier:{
                    id:'',
                    name:'',
                    description:'',
                    Image:'',
                    image:''
                },
                supliers:{
                    id:'',
                    name:'',
                    description:'',
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
            }
        },
        created(){
          this.getData();
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getSuplier',page).then(res=>{
                this.supliers=res.data;
                this.loader=0;
                    $("#exampleModal").modal('hide')
                    //  this.datable= $('.myTable').DataTable({});
              })
          },
          edit(id){
            this.msg='Update';
            this.formReset();
            this.$store.dispatch('editSuplier',id).then(res=>{
                this.suplier=res.data;
                 $("#exampleModal").modal('show')
              });
          },
          updateUpdate(){

          },
          createsuplier(){
              this.formReset();
              this.msg='Create';
              $("#exampleModal").modal('show')
          },
            yourImage(e){
                this.your_image=e.target.files[0];
                const file=e.target.files[0];
                this.your_image=file;
                // this.suplier.image=''
                if (!file){
                    this.suplier.Image='';
                }else{
                  console.log(file)
                  this.suplier.image='';
                  this.suplier.Image=URL.createObjectURL(file);
                }
            },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.suplier.id);
                formData.append('name', this.suplier.name);
                formData.append('description', this.suplier.description);
                formData.append('email', this.suplier.email);
                formData.append('phone', this.suplier.phone);
                formData.append('address', this.suplier.address);
                formData.append('image', this.your_image);
                if(this.suplier.id){
                  this.$store.dispatch('updateSuplier',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='suplier Update Success';
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
                this.$store.dispatch('createSuplier',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='suplier Create Success';
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
            deletesuplier(id){
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
            this.$store.dispatch('deleteSuplier',id).then(res=>{
              // this.supliers.splice(this.supliers.indexOf(id),1);
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
              this.$store.dispatch('searchSuplier',formData,header)
                    .then(response => {
                        // this.supliers=response.data;
                        console.log(response.data)
                })
            },
            formReset(){
                this.suplier.id='';
                this.suplier.name='';
                this.suplier.phone='';
                this.suplier.email='';
                this.suplier.address='';
                this.suplier.description='';
                this.$refs.imageInput.value = null
                this.suplier.Image='';
                this.suplier.image=false;
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
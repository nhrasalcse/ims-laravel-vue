<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Sub Category</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createsubcategory">Add subcategory</button></li>
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
                        <input type="text" v-model="search" placeholder="Sub Category any one information" :class="['form-control ']"  >
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
                  <h4>Sub Category Table </h4>
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped myTable">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Category Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(sbdata,index) in subcategorys.data" :key="sbdata.id">
                          <th scope="row">{{index+1}}</th>
                          <td><img :src="sbdata.image ? path+sbdata.image :  '/backend/img/avatar/category.png' " alt="" class="img-fluid" height="50px" width="50px"></td>
                          <td>{{sbdata.name ? sbdata.name : ''}}</td>
                          <td>{{sbdata.category.name ? sbdata.category.name : ''}}</td>
                          <td>
                            <table>
                              <tr>
                                <td><button  class="btn btn-outline-primary" @click.prevent="edit(sbdata.id)"> <i class="fa fa-edit"></i> </button></td>
                                <td><button class="btn btn-danger" @click.prevent="deletesubcategory(sbdata.id)"> <i class="fa fa-trash"></i> </button></td>
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
                <pagination :data="subcategorys" @pagination-change-page="getData">
                     <span slot="prev-nav">&lt; Previous</span>
                     <span slot="next-nav">Next &gt;</span>
                 </pagination>
             </div>
        </div>
    </section>
    <!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" category="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" category="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">subcategory {{msg}}</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal"  @submit.prevent="onSubmit" enctype="multipart/form-data">
            <input type="hidden" v-model="subcategory.id">
             <div class="form-group row">
                <label class="col-sm-12 col-md-4">Category</label>
                <div class="col-sm-12 col-md-7">
                  <select v-model="subcategory.category_id" :class="['form-control ', allerros.category ? 'is-invalid' : '' ]">
                      <option value="" selected>Select</option>
                      <option v-for="categoryData in category" :value="categoryData.id" v-if="subcategory.category_id===subcategory.category_id ? 'selected' : ''" >{{categoryData.name ? categoryData.name : ''}}</option>
                  </select>
                  <span v-if="allerros.category_id " :class="[ allerros.category_id ? 'text-danger' :' d-none']">{{ allerros.category_id[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Sub Category Name</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="subcategory.name" placeholder="Enter  Sub Category Name" :class="['form-control ', allerros.name ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.name">Enter  Sub Category Name</small>
                    <span v-if="allerros.name " :class="[ allerros.name ? 'text-danger' :' d-none']">{{ allerros.name[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Sub Category description</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="subcategory.description" placeholder="Enter Sub Category description" :class="['form-control ', allerros.description ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.description">Enter  Sub Category description</small>
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
                     <img v-if="Image" :src="Image" class="img-thumbnail small-image" alt="" >
                    <img v-else-if="subcategory.image" :src="path+subcategory.image" class="img-thumbnail small-image" alt="" >
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
                subcategory:{
                    id:'',
                    category_id:'',
                    name:'',
                    description:'',
                    image:''
                },
                subcategorys:{
                    id:'',
                    name:'',
                    category_id:'',
                    description:'',
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
                category:[],
                 Image:'',
            }
        },
        created(){
          this.getData();
          this.getCategory();
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getsubCategory',page).then(res=>{
                this.subcategorys=res.data;
                this.loader=0;
                    $("#exampleModal").modal('hide')
                     this.datable= $('.myTable').DataTable({});
              })
          },
          getCategory(){
             this.$store.dispatch('getSubeCategory').then(res=>{
                this.category=res.data;
              })
          },
          edit(id){
            this.msg='Update';
            this.formReset();
            this.$store.dispatch('editsubCategory',id).then(res=>{
                this.subcategory=res.data;
                 $("#exampleModal").modal('show')
              });
          },
          updateUpdate(){

          },
          createsubcategory(){
              this.formReset();
              this.msg='Create';
              $("#exampleModal").modal('show')
          },
            yourImage(e){
                this.your_image=e.target.files[0];
                const file=e.target.files[0];
                this.your_image=file;
                // this.subcategory.image=''
                if (!file){
                    this.Image='';
                }else{
                  console.log(file)
                  this.subcategory.image='';
                  this.Image=URL.createObjectURL(file);
                }
            },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.subcategory.id);
                formData.append('name', this.subcategory.name);
                formData.append('category_id', this.subcategory.category_id);
                formData.append('description', this.subcategory.description);
                formData.append('image', this.your_image);
                if(this.subcategory.id){
                  this.$store.dispatch('updatesubCategory',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='Sub Category Update Success';
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
                this.$store.dispatch('createsubCategory',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='subcategory Create Success';
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
            deletesubcategory(id){
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
            this.$store.dispatch('deletesubCategory',id).then(res=>{
              // this.subcategorys.splice(this.subcategorys.indexOf(id),1);
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
              this.$store.dispatch('searchsubcategory',formData,header)
                    .then(response => {
                        // this.subcategorys=response.data;
                        console.log(response.data)
                })
            },
            formReset(){
                this.subcategory.id='';
                this.subcategory.name='';
                this.subcategory.description='';
                this.$refs.imageInput.value = null
                this.Image='';
                this.subcategory.image=false;
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
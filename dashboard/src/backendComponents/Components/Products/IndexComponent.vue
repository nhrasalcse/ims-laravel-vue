<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Product</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createproduct">Add product</button></li>
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
                        <input type="text" v-model="search" placeholder="Product any one information" :class="['form-control ']"  >
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
                  <h4>Product Table </h4>
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped myTable">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Category</th>
                          <th>Sub Category</th>
                          <th>Brand</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(sbdata,index) in products.data" :key="sbdata.id">
                          <th scope="row">{{index+1}}</th>
                          <td><img :src="sbdata.image ? path+sbdata.image :  '/backend/img/avatar/category.png' " alt="" class="img-fluid" height="50px" width="50px"></td>
                          <td>{{sbdata.name ? sbdata.name : ''}}</td>
                          <td>{{sbdata.category.name ? sbdata.category.name : ''}}</td>
                          <td>{{sbdata.sub_category.name ? sbdata.sub_category.name : ''}}</td>
                          <td>{{sbdata.brand.name ? sbdata.brand.name : ''}}</td>
                          <td>
                            <table>
                              <tr>
                                <td><button  class="btn btn-outline-primary" @click.prevent="edit(sbdata.id)"> <i class="fa fa-edit"></i> </button></td>
                                <td><button class="btn btn-danger" @click.prevent="deleteproduct(sbdata.id)"> <i class="fa fa-trash"></i> </button></td>
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
                          <th>Category</th>
                          <th>Sub Category</th>
                          <th>Brand</th>
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
                 <pagination :data="products" @pagination-change-page="getData">
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
        <h5 class="modal-title" id="exampleModalLabel">Product {{msg}}</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form class="form-horizontal"  @submit.prevent="onSubmit" enctype="multipart/form-data">
            <input type="hidden" v-model="product.id">
             <div class="form-group row">
                <label class="col-sm-12 col-md-4">Category</label>
                <div class="col-sm-12 col-md-7">
                  <select v-model="product.category_id" :class="['form-control ', allerros.category ? 'is-invalid' : '' ]" @change="CategoryChange(product.category_id)">
                      <option value=" " selected>Select</option>
                      <option v-for="categoryData in category" :value="categoryData.id" v-if="product.category_id===product.category_id ? 'selected' : ''" >{{categoryData.name ? categoryData.name : ''}}</option>
                  </select>
                  <span v-if="allerros.category_id " :class="[ allerros.category_id ? 'text-danger' :' d-none']">{{ allerros.category_id[0] }}</span>
                </div>
            </div>
             <div class="form-group row">
                <label class="col-sm-12 col-md-4">Sub Category</label>
                <div class="col-sm-12 col-md-7">
                  <!-- <select v-model="product.sub_category_id" :class="['form-control ', allerros.category ? 'is-invalid' : '' ]" @change="SubCategoryChange(product.sub_category_id)"> -->
                  <select v-model="product.sub_category_id" :class="['form-control ', allerros.category ? 'is-invalid' : '' ]">
                      <option value="" selected>Select</option>
                      <option v-for="subCategoryData in subCategory" :value="subCategoryData.id" v-if="product.sub_category_id===product.sub_category_id ? 'selected' : ''" >{{subCategoryData.name ? subCategoryData.name : ''}}</option>
                  </select>
                  <span v-if="msg_sub" :class="[ msg_sub ? 'text-danger' :' d-none']">{{ msg_sub }}</span>
                  <span v-if="allerros.sub_category_id " :class="[ allerros.sub_category_id ? 'text-danger' :' d-none']">{{ allerros.sub_category_id[0] }}</span>
                </div>
            </div>  
             <div class="form-group row">
                <label class="col-sm-12 col-md-4">Brand</label>
                <div class="col-sm-12 col-md-7">
                  <select v-model="product.brand_id" :class="['form-control ', allerros.brand ? 'is-invalid' : '' ]">
                      <option value="" selected>Select</option>
                      <option v-for="brandData in brand" :value="brandData.id" v-if="product.brand_id===product.brand_id ? 'selected' : ''" >{{brandData.name ? brandData.name : ''}}</option>
                  </select>
                  <span v-if="msg_product" :class="[ msg_product ? 'text-danger' :' d-none']">{{ msg_product }}</span>
                  <span v-if="allerros.brand_id " :class="[ allerros.brand_id ? 'text-danger' :' d-none']">{{ allerros.brand_id[0] }}</span>
                </div>
            </div>  
            <div v-if="create_others==1"> 
             <div class="form-group row">
                <label class="col-sm-12 col-md-4">Suplier</label>
                <div class="col-sm-12 col-md-7">
                  <select v-model="product.suplier" :class="['form-control ', allerros.brand ? 'is-invalid' : '' ]">
                      <option value="" selected>Select</option>
                      <option v-for="suplierD in suplierData" :value="suplierD.id" v-if="product.suplier===product.suplier ? 'selected' : ''" >{{suplierD.name ? suplierD.name : ''}}</option>
                  </select>
                  <span v-if="msg_product" :class="[ msg_product ? 'text-danger' :' d-none']">{{ msg_product }}</span>
                  <span v-if="allerros.suplier " :class="[ allerros.suplier ? 'text-danger' :' d-none']">{{ allerros.suplier[0] }}</span>
                </div>
            </div>  
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Name</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.name" placeholder="Enter  Product Name" :class="['form-control ', allerros.name ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.name">Enter  Product Name</small>
                    <span v-if="allerros.name " :class="[ allerros.name ? 'text-danger' :' d-none']">{{ allerros.name[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product description</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.description" placeholder="Enter Product description" :class="['form-control ', allerros.description ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.description">Enter  Product description</small>
                    <span v-if="allerros.description " :class="[ allerros.description ? 'text-danger' :' d-none']">{{ allerros.description[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Colour</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.colour" placeholder="Enter Product colour" :class="['form-control ', allerros.colour ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.colour">Enter  Product colour</small>
                    <span v-if="allerros.colour " :class="[ allerros.colour ? 'text-danger' :' d-none']">{{ allerros.colour[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Size</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.size" placeholder="Enter Product size" :class="['form-control ', allerros.size ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.size">Enter  Product size</small>
                    <span v-if="allerros.size " :class="[ allerros.size ? 'text-danger' :' d-none']">{{ allerros.size[0] }}</span>
                </div>
            </div>
            <div v-if="create_others==1"> 
              <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product QR Code</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.product_qr_code" placeholder="Enter Product QR Code" :class="['form-control ', allerros.product_qr_code ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.product_qr_code">Enter  Product QR Code</small>
                    <span v-if="allerros.product_qr_code " :class="[ allerros.product_qr_code ? 'text-danger' :' d-none']">{{ allerros.product_qr_code[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Reguler Price</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.product_regular_price" placeholder="Enter Product Reguler Price" :class="['form-control ', allerros.product_regular_price ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.product_regular_price">Enter  Product Reguler Price</small>
                    <span v-if="allerros.product_regular_price " :class="[ allerros.product_regular_price ? 'text-danger' :' d-none']">{{ allerros.product_regular_price[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Sell Price</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.sell_price" placeholder="Enter Product Sell Price" :class="['form-control ', allerros.sell_price ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.sell_price">Enter  Product Sell Price</small>
                    <span v-if="allerros.sell_price " :class="[ allerros.sell_price ? 'text-danger' :' d-none']">{{ allerros.sell_price[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Retail Price</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.retail_price" placeholder="Enter Product Retail Price" :class="['form-control ', allerros.retail_price ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.retail_price">Enter  Product Retail Price</small>
                    <span v-if="allerros.retail_price " :class="[ allerros.retail_price ? 'text-danger' :' d-none']">{{ allerros.retail_price[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Quentity</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.quentity" placeholder="Enter Product Quentity" :class="['form-control ', allerros.quentity ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.quentity">Enter  Product Quentity</small>
                    <span v-if="allerros.quentity " :class="[ allerros.quentity ? 'text-danger' :' d-none']">{{ allerros.quentity[0] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Product Minimum Stock level</label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" v-model="product.stock_level" placeholder="Enter Product Minimum Stock level" :class="['form-control ', allerros.stock_level ? 'is-invalid' : '' ]"  >
                    <small class="form-text" v-if="!allerros.stock_level">Enter  Product Minimum Stock level</small>
                    <span v-if="allerros.stock_level " :class="[ allerros.stock_level ? 'text-danger' :' d-none']">{{ allerros.stock_level[0] }}</span>
                </div>
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
                    <img v-if="product.image" :src="path+product.image" class="img-thumbnail small-image" alt="" >
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
                product:{
                    id:'',
                    category_id:'',
                    sub_category_id:'',
                    brand_id:'',
                    name:'',
                    colour:'',
                    size:'',
                    description:'',
                    image:'',
                    product_qr_code:'',
                    suplier:'',
                    product_regular_price:'',
                    sell_price:'',
                    retail_price:'',
                    quentity:'',
                    stock_level:'',
                },
                products:{
                    id:'',
                    name:'',
                    category_id:'',
                    sub_category_id:'',
                    colour:'',
                    size:'',
                    brand_id:'',
                    description:'',
                    image:'',
                    product_qr_code:'',
                    suplier:'',
                    product_regular_price:'',
                    sell_price:'',
                    retail_price:'',
                    quentity:'',
                    stock_level:'',
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
                msg_sub:'',
                msg_product:'',
                subCategory:[],
                brand:[],
                suplierData:[],
                Image:'',
                create_others:'',
            }
        },
        created(){
          this.getData();
          this.getCategory();
          this.getSubCategory();
          this.getBrand();
          this.getSuplier();
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getProduct',page).then(res=>{
                this.products=res.data;
                this.loader=0;
                    $("#exampleModal").modal('hide')
                     this.datable= $('.myTable').DataTable({});
              })
          },
        getCategory(){
             this.$store.dispatch('getBrandCategory').then(res=>{
                this.category=res.data;
              })
          },
        getSubCategory(){
          this.$store.dispatch('getSubCategory').then(res=>{
              this.subCategory=res.data;
            })
        },
        getSuplier(){
          this.$store.dispatch('getProductSup').then(res=>{
              this.suplierData=res.data;
            })
        },
          getBrand(){
             this.$store.dispatch('getBrandData').then(res=>{
                this.brand=res.data;
              })
          },
          edit(id){
            this.msg='Update';
            this.create_others='';
            // this.suplierData=[];
            this.formReset();
            this.$store.dispatch('editProduct',id).then(res=>{
                this.product=res.data;
                 $("#exampleModal").modal('show')
              });
          },
          updateUpdate(){
            
          },
          CategoryChange(cate){
            if(cate>0){
              this.product.sub_category_id='';
            this.$store.dispatch('findSubCategory',cate ? cate : '').then(res=>{
              
               if (res.data[0] == 'nodata') {
                 console.log(res.data[0])
                  this.subCategory=[];
                  this.msg_sub='no sub category available please select another one'
               }else{
                 this.subCategory=res.data;
                  this.msg_sub=''
               }
                // console.log(res)
              }).catch((error) => {
                    this.subCategory=[];
                });
            }{
              console.log('plsease select ')
            }
          },
        //  SubCategoryChange(id){
        //    console.log(id)
        //     if(id>0){
        //       this.product.brand_id='';
        //     this.$store.dispatch('findBrand',id ? id : '').then(res=>{
              
        //        if (res.data[0] == 'nodata') {
        //          console.log(res.data[0])
        //           this.brand=[];
        //           this.msg_product='no brand available please select another one'
        //        }else{
        //          this.brand=res.data;
        //           this.msg_product=''
        //        }
        //         // console.log(res)
        //       }).catch((error) => {
        //             // this.brand=[];
        //         });
        //     }{
        //       console.log('plsease select')
        //     }
            

        //   },

          createproduct(){
              this.formReset();
              this.subCategory=[];
              // this.brand=[];
              this.msg='Create';
              this.create_others=1;
              $("#exampleModal").modal('show')
          },
            yourImage(e){
                this.your_image=e.target.files[0];
                const file=e.target.files[0];
                this.your_image=file;
                // this.product.image=''
                if (!file){
                    this.Image='';
                }else{
                  console.log(file)
                  this.product.image='';
                  this.Image=URL.createObjectURL(file);
                }
            },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.product.id);
                formData.append('name', this.product.name);
                formData.append('category_id', this.product.category_id);
                formData.append('sub_category_id', this.product.sub_category_id);
                formData.append('brand_id', this.product.brand_id);
                formData.append('description', this.product.description);
                formData.append('colour', this.product.colour);
                formData.append('size', this.product.size);
                formData.append('product_qr_code', this.product.product_qr_code);
                formData.append('suplier', this.product.suplier);
                formData.append('product_regular_price', this.product.product_regular_price);
                formData.append('sell_price', this.product.sell_price);
                formData.append('retail_price', this.product.retail_price);
                formData.append('quentity', this.product.quentity);
                formData.append('stock_level', this.product.stock_level);
                formData.append('image', this.your_image);
                if(this.product.id){
                  this.$store.dispatch('updateProduct',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='Product Update Success';
                            var vr='success'; 
                            var ar='Thank you'; 
                          sweetAlart.action.actionFunction(msg,vr,ar);
                             this.formReset();
                             this.getData();
                        }else{
                          
                      console.log(response.data[0])
                        }
                    }).catch((error) => {
                        console.log(error);
                    this.allerros = error.response.data.errors;
                    this.success = false;
                    var msg='you have something wrong';
                    var vr='error'; 
                    var ar='Warning'; 
                   sweetAlart.action.actionFunction(msg,vr,ar);
                    this.formReset();
                    this.getData();
                });
                }else{
                this.$store.dispatch('createProduct',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='Product Create Success';
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
            deleteproduct(id){
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
            this.$store.dispatch('deleteProduct',id).then(res=>{
              // this.products.splice(this.products.indexOf(id),1);
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
              this.$store.dispatch('searchProduct',formData,header)
                    .then(response => {
                        // this.products=response.data;
                        console.log(response.data)
                })
            },
            formReset(){
                this.product.id='';
                this.product.name='';
                this.product.colour='';
                this.product.size='';
                this.product.description='';
                this.product.category_id='';
                this.product.sub_category_id='';
                this.product.product_id='';
                this.$refs.imageInput.value = null
                this.Image='';
                this.product.image=false;
                this.allerros='';
                this.msg_product='';
                this.msg_sub='';
                this.product.suplier='';
                this.product.product_qr_code='';
                this.product.product_regular_price='';
                this.product.sell_price='';
                this.product.retail_price='';
                this.product.quentity='';
                this.product.stock_level='';
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
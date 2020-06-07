<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Stock</li>
                 <!-- <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createstock">Add stock</button></li> -->
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
                        <input type="text" v-model="search" placeholder="stock any one information" :class="['form-control ']"  >
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
                  <h4>Stock Table </h4>
                  
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Suplier</th>
                          <th>Available</th>
                          <th>Stock</th>
                          <th>Stock Out</th>
                          <th>Reguler Price</th>
                          <th>Retail Price</th>
                          <th>Sell Price</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(stockData,index) in stocks.data" :key="stockData.id" :class="['text-center',(stockData.stock_in-stockData.stock_out)>stockData.stock_level ? 'text-dark' : 'text-danger']">
                          <th scope="row">{{index+1}}</th>
                          <td><img :src="stockData.product.image ? path+stockData.product.image :  '/backend/img/avatar/category.png' " alt="" class="img-fluid" height="50px" width="50px"></td>
                          <td>{{stockData.product.name ? stockData.product.name : ''}}</td>
                          <td>{{stockData.suplier.name ? stockData.suplier.name : ''}}</td>
                          <td>{{stockData.stock_in-stockData.stock_out}}</td>
                          <td>{{stockData.stock_in ? stockData.stock_in : ''}}</td>
                          <td>{{stockData.stock_out ? stockData.stock_out : ''}}</td>
                          <td>{{stockData.product_regular_price ? stockData.product_regular_price : ''}}</td>
                          <td>{{stockData.retail_price ? stockData.retail_price : ''}}</td>
                          <td>{{stockData.sell_price ? stockData.sell_price : ''}}</td>
                          <td>{{(stockData.stock_in-stockData.stock_out)>stockData.stock_level ? 'Stock Available' : 'out of Stock'}}</td>
                          <td>
                            <table>
                              <tr>
                                <td><button  class="btn btn-sm btn-primary" @click.prevent="stockIn(stockData.id)">Stock</button></td>
                                <td><button  class="btn btn-sm btn-info" @click.prevent="stockIn(stockData.id)">Details</button></td>
                                <!-- <td><button class="btn btn-danger" @click.prevent="deletestock(stockData.id)"> <i class="fa fa-trash"></i> </button></td> -->
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
                          <th>Suplier</th>
                          <th>Available</th>
                          <th>Stock</th>
                          <th>Stock Out</th>
                          <th>Reguler Price</th>
                          <th>Retail Price</th>
                          <th>Sell Price</th>
                          <th>Status</th>
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
                 <pagination :data="stocks" @pagination-change-page="getData">
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
        <h5 class="modal-title" id="exampleModalLabel">Stock In</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form class="form-horizontal"  @submit.prevent="onSubmit" enctype="multipart/form-data">
            <input type="hidden" v-model="stock.id">
            <div class="form-group row">
                <label class="col-sm-12 col-md-4">Suplier</label>
                <div class="col-sm-12 col-md-7">
                  <select v-model="product.suplier" :class="['form-control ', allerros.brand ? 'is-invalid' : '' ]">
                      <option value="" selected>Select</option>
                      <option v-for="suplierD in suplierData" :value="suplierD.id" >{{suplierD.name ? suplierD.name : ''}}</option>
                  </select>
                  <span v-if="allerros.suplier " :class="[ allerros.suplier ? 'text-danger' :' d-none']">{{ allerros.suplier[0] }}</span>
                </div>
            </div>  
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
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-success">Stock In</button>
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
                stock:{
                    id:'',
                    stock_id:'',
                    suplier:'',
                    image:''
                },
                stocks:{
                    id:'',
                    stock_id:'',
                    image:''
                },
                product:{
                    suplier:'',
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
                suplierData:[],
                Image:'',
            }
        },
        created(){
          this.getData();
          this.getSuplier();
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getStock',page).then(res=>{
                this.stocks=res.data;
                this.loader=0;
                    $("#exampleModal").modal('hide')
                     this.datable= $('.myTable').DataTable({});
              })
          },
          
        getSuplier(){
          this.$store.dispatch('getProductSup').then(res=>{
              this.suplierData=res.data;
            })
        },
          stockIn(id){
            this.formReset();
            this.stock.id=id;
            $("#exampleModal").modal('show')
          },
          createstock(){
              this.formReset();
          },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.stock.id);
                 formData.append('product_qr_code', this.product.product_qr_code);
                formData.append('suplier', this.product.suplier);
                formData.append('product_regular_price', this.product.product_regular_price);
                formData.append('sell_price', this.product.sell_price);
                formData.append('retail_price', this.product.retail_price);
                formData.append('quentity', this.product.quentity);
                formData.append('stock_level', this.product.stock_level);
                this.$store.dispatch('createStock',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='Stock Update Success';
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
            },
            formReset(){
                 this.product.suplier='';
                this.product.product_qr_code='';
                this.product.product_regular_price='';
                this.product.sell_price='';
                this.product.retail_price='';
                this.product.quentity='';
                this.product.stock_level='';
                this.msg_product='';
                this.msg_sub='';
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
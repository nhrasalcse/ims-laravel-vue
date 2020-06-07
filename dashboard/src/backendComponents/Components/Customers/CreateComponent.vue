<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Invoice</li>
                 <li class="breadcrumb-item active">Create</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createinvoice">Create Invoice</button></li>
             </ul> 
         </div>
     </div>
     <section>
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <form class="form-horizontal"  @submit.prevent="onSubmit" enctype="multipart/form-data">
                    <input type="hidden" v-model="invoice.id">
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-4">Customer</label>
                        <div class="col-sm-6 col-md-4">
                          <select v-model="invoice.customer" :class="['form-control ', allerros.brand ? 'is-invalid' : '' ]">
                              <option value="" selected>Select</option>
                              <option v-for="customer in customers" :value="customer.id" >{{customer.name ? customer.name : ''}}</option>
                          </select>
                          <span v-if="allerros.customer " :class="[ allerros.customer ? 'text-danger' :' d-none']">{{ allerros.customer[0] }}</span>
                        </div>
                    </div>
                     <table class="table table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Product</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Discount</th>
                          <th>Sub Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(invoice, index) in inputs">
                          <th>{{index+1}}</th>
                          <td>
                            <select v-model="invoice.product_id" :class="['form-control ', allerros.brand ? 'is-invalid' : '' ]" @change="FindProduct(invoice.product_id)">
                              <option value="" selected>Select</option>
                              <option v-for="product in products" :value="product.product.id" >{{product.product.name ? product.product.name : ''}}</option>
                          </select>
                          </td>
                          <td>
                              <input type="text" v-model="invoice.qty" placeholder="Enter category qty" :class="['form-control ', allerros.qty ? 'is-invalid' : '' ]"  >
                          </td>
                          <td>
                              <input type="text" v-model="invoice.price" readonly placeholder="Enter category price" :class="['form-control ', allerros.price ? 'is-invalid' : '' ]"  >
                          </td>
                          <td>
                              <input type="text" v-model="invoice.discount" placeholder="Enter category discount" :class="['form-control ', allerros.discount ? 'is-invalid' : '' ]"  >
                          </td>
                          <td>
                              <input type="text" v-model="invoice.sub_total" readonly placeholder="Enter category sub total" :class="['form-control ', allerros.sub_total ? 'is-invalid' : '' ]"  >
                          </td>
                          <td>
                            <a href="#" class="btn btn-sm btn-danger" @click="deleteRow(index)"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                         <tr>
                          <th>SL</th>
                          <th>Product</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Discount</th>
                          <th>Sub Total</th>
                          <th><a href="#" class="btn btn-sm btn-success" @click.prevent="AddItem()">Add</a></th>
                        </tr>
                      </tfoot>
                     </table>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-success">invoice In</button>
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
    const axios = require('axios');
    import sweetAlart from './../../../sweetalart'
    import url from './../../../path'
    export default {
        mounted () {
          
        },
        data() {
         
            return {
                invoice:{
                    customer:'',
                    product_id:'',
                    qty:'',
                    price:'',
                    discount:'',
                    sub_total:'',
                },
                invoices:{
                    customer:'',
                    product_id:'',
                    qty:'',
                    price:'',
                    discount:'',
                    sub_total:'',
                },
                search:'',
                allerros: [],
                success: false,
                your_image:'',
                path:url.path,
                loader:0,
                invoices:[],
                customers:[],
                products:[],
                Image:'',
                  inputs: []
            }
        },
        created(){
          this.getData();
          this.getCustomerData();
          this.getProductData();
          this.FindProduct();
          this.Subtotal();
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getInvoice',page).then(res=>{
                this.invoices=res.data;
                this.loader=0;
              })
          },
          getCustomerData(){
              this.$store.dispatch('getCustomerInvoice').then(res=>{
                this.customers=res.data;
              })
          },
          getProductData(){
              this.$store.dispatch('getStockInvoice').then(res=>{
                this.products=res.data;
              })
          },
          FindProduct(id){
            console.log(id)
              this.$store.dispatch('findProduct',id).then(res=>{
                this.invoice.price=res.data.sell_price;
              })
          },
          AddItem(){
         this.inputs.push({
            product_id: '',
      })
          },

           deleteRow(index) {
               this.inputs.splice(index,1);
               console.log(index)
            },
          Subtotal(){
            console.log(this.invoice.price)
            this.invoice.sub_total=this.invoice.qty*this.invoice.price-this.invoice.discount;
          },
          createinvoice(){
              this.formReset();
          },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                formData.append('id', this.invoice.id);
                 formData.append('invoice_qr_code', this.invoice.invoice_qr_code);
                formData.append('suplier', this.invoice.suplier);
                formData.append('invoice_regular_price', this.invoice.invoice_regular_price);
                formData.append('sell_price', this.invoice.sell_price);
                formData.append('retail_price', this.invoice.retail_price);
                formData.append('quentity', this.invoice.quentity);
                formData.append('invoice_level', this.invoice.invoice_level);
                this.$store.dispatch('createinvoice',formData,header)
                    .then(response => {
                        if (response.data[0] == 'success') {
                            var msg='invoice Update Success';
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
                 this.invoice.suplier='';
                this.invoice.invoice_qr_code='';
                this.invoice.invoice_regular_price='';
                this.invoice.sell_price='';
                this.invoice.retail_price='';
                this.invoice.quentity='';
                this.invoice.invoice_level='';
                this.msg_invoice='';
                this.msg_sub='';
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
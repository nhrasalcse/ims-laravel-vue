<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Invoice</li>
                 <li class="breadcrumb-item active">Create</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createInvoices">Create Invoice</button></li>
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
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Discount</th>
                          <th>Sub Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(invoice, index) in invoices">
                          <th>{{index+1}}</th>
                          <td>
                            <select v-model="invoice.product_id[index]" :class="['form-control ', allerros.brand ? 'is-invalid' : '' ]" @change="FindProduct(invoice.product_id)">
                              <option value="" selected>Select</option>
                              <option v-for="product in products" :value="product.product.id" >{{product.product.name ? product.product.name : ''}}</option>
                          </select>
                          </td>
                          <td>
                              <input type="text" v-model="invoice.qty" placeholder="Enter quantity" :class="['form-control ', allerros.qty ? 'is-invalid' : '' ]"  >
                          </td>
                          <td>
                              <input type="text" v-model="invoice.price"  placeholder="Product price" :class="['form-control ', allerros.price ? 'is-invalid' : '' ]"  >
                          </td>
                          <td>
                          <div class="input-group mb-2">
                            <input type="number" v-model="invoice.discount" min="0" max="100" :class="['form-control ', allerros.discount ? 'is-invalid' : '' ]" placeholder="Discount">
                            <div class="input-group-prepend">
                              <div class="input-group-text">%</div>
                            </div>
                          </div>
                          </td>
                          <td>
                              <!-- <input type="text" v-model="invoice.sub_total"  placeholder="Enter category sub total" :class="['form-control ', allerros.sub_total ? 'is-invalid' : '' ]"  > -->
                              {{ decimalDigits((invoice.price * invoice.qty)-(invoice.price * invoice.qty*(invoice.discount / 100))) }}
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
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Discount</th>
                          <th>Sub Total</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                     </table>
                     <a  class="btn btn-sm btn-info text-light" @click.prevent="AddItem()">Add Item</a>
                     
                    <div class="form-group row mt-3" >
                        <div class="col-sm-6 col-md-6">
                          <table class="table table table-bordered table-striped">
                            <tr>
                                <td>Subtotal</td>
                                <td>{{ decimalDigits(subTotal) }}</td>
                            </tr>
                            <tr>
                                <td><div class="cell-with-input">Discount 
                                  
                                  <div class="input-group mb-2">
                                    <input type="number" v-model="discountRate" min="0" max="100" :class="['form-control ', allerros.discount ? 'is-invalid' : '' ]" placeholder="Discount">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">%</div>
                                    </div>
                                  </div>
                                  
                                  <!-- <input class="text-right form-control" type="number" min="0" max="100" v-model="discountRate" />% -->
                                  
                                  </div></td>
                                <td>{{ decimalDigits(discountTotal) }}</td>
                            </tr>
                            <tr>
                                <td><div class="cell-with-input">Tax
                                  <div class="input-group mb-2">
                                    <input  type="number" min="0" max="100" v-model="taxRate" :class="['form-control ', allerros.discount ? 'is-invalid' : '' ]" placeholder="Tax">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">%</div>
                                    </div>
                                  </div>
                                   <!-- <input class="text-right form-control" type="number" min="0" max="100" v-model="taxRate" />% -->
                                   </div></td>
                                <td>{{ decimalDigits(taxTotal) }}</td>
                            </tr>
                            <tr class="text-bold">
                                <td>Grand Total</td>
                                <td>{{ decimalDigits(grandTotal) }}</td>
                            </tr>
                          </table>
                        </div>
                    </div>
                     
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-success">Create Invoice</button>
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
                    product_id
                    :[],
                    qty:[],
                    price:[],
                    discount:[],
                    sub_total:[],
                },
                invoices:[
                  {product_id:[],qty:[],price:[],discount:[],sub_total:[],},
                ],
                search:'',
                allerros: [],
                success: false,
                your_image:'',
                path:url.path,
                loader:0,
                customers:[],
                products:[],
                Image:'',
                taxRate: 20,
                discountRate: 0,
                invoiceCurrency: {
                "symbol": "$",
                "name": "US Dollar",
                "symbol_native": "$",
                "decimal_digits": 2,
                "rounding": 0,
                "code": "USD",
                "name_plural": "US dollars"
            },
            }
        },
        created(){
          this.getData();
          this.getCustomerData();
          this.getProductData();
          // this.FindProduct();
          // this.Subtotal();
         
        },
        computed: {
            subTotal: function() {
                var total = this.invoices.reduce(function(accumulator, invoice) {
                    return accumulator + ((invoice.price * invoice.qty)-(invoice.price * invoice.qty*(invoice.discount / 100)));
                }, 0)
                return total;
            },
            discountTotal: function() {
                var total = this.subTotal * (this.discountRate / 100);
                return total;
            },
            taxTotal: function() {
                var total = (this.subTotal - this.discountTotal) * (this.taxRate / 100);
                return total;
            },
            grandTotal: function() {
                var total = (this.subTotal - this.discountTotal) + this.taxTotal;
                return total;
            }
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getInvoice',page).then(res=>{
                this.invoice=res.data;
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
              this.$store.dispatch('findProduct',id).then(res=>{
                this.invoice.price=res.data.sell_price;
                console.log(res)
              })
          },
          AddItem(){
         this.invoices.push(
           {product_id:[],qty:[],price:[],discount:[],sub_total:[],},
         )
          },
          deleteRow: function(index) {
                this.invoices.splice(index, 1)
            },
          decimalDigits: function(value) {
                return this.invoiceCurrency.symbol + ' ' + value.toFixed(this.invoiceCurrency.decimal_digits);
            },
          createInvoices(){
              this.formReset();
          },
            onSubmit(e) {
                e.preventDefault();
                let formData = new FormData();
                 formData.append('product_id', this.invoice.product_id);
                formData.append('customer_id', this.invoice.customer);
                formData.append('qty', this.invoice.qty);
                formData.append('sell_price', this.invoice.sell_price);
                formData.append('discount', this.invoice.discount);
                this.$store.dispatch('createInvoice',formData,header)
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
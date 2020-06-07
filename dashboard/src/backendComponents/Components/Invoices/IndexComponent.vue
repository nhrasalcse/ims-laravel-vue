<template>
    <div>
     <!-- Breadcrumb-->
     <div class="breadcrumb-holder">
         <div class="container-fluid">
             <ul class="breadcrumb">
                 <li class="breadcrumb-item"><router-link :to="{name :'dashboard'}">Home</router-link></li>
                 <li class="breadcrumb-item active">Invoice</li>
                 <li class="breadcrumb-item " ><button type="button"  class="button-burcum btn btn-sm btn-primary " @click.prevent="createInvoice">Create Invoice</button></li>
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
                          <th>Customer Name</th>
                          <th>Total Quantity</th>
                          <th>Total</th>
                          <th>Paid</th>
                          <th>Due</th>
                          <th>Date</th>
                          <th>Method</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(invoiceData,index) in invoices.data" :key="invoiceData.id" :class="['text-center',(invoiceData.stock_in-invoiceData.stock_out)>invoiceData.stock_level ? 'text-dark' : 'text-danger']">
                          <th scope="row">{{index+1}}</th>
                          <td>{{invoiceData.customer.name ? invoiceData.customer.name : ''}}</td>
                          <td>{{invoiceData.total ? invoiceData.total : ''}}</td>
                          <td>{{invoiceData.discount ? invoiceData.discount : ''}}</td>
                          <td>{{invoiceData.paid ? invoiceData.paid : ''}}</td>
                          <td>{{invoiceData.due ? invoiceData.due : ''}}</td>
                          <td>{{invoiceData.date ? invoiceData.date : ''}}</td>
                          <td>{{invoiceData.payment_method ? invoiceData.payment_method : ''}}</td>
                         <td>
                            <table>
                              <tr>
                                <td><button  class="btn btn-sm btn-primary">Details</button></td>
                                <td><button  class="btn btn-sm btn-info">Print</button></td>
                                <!-- <td><button class="btn btn-danger" @click.prevent="deletestock(invoiceData.id)"> <i class="fa fa-trash"></i> </button></td> -->
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>SL</th>
                          <th>Customer Name</th>
                          <th>Total Quantity</th>
                          <th>Total</th>
                          <th>Paid</th>
                          <th>Due</th>
                          <th>Date</th>
                          <th>Method</th>
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
                 <pagination :data="invoices" @pagination-change-page="getData">
                     <span slot="prev-nav">&lt; Previous</span>
                     <span slot="next-nav">Next &gt;</span>
                 </pagination>
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
                    id:'',
                    invoice_id:'',
                    suplier:'',
                    image:''
                },
                invoices:{
                    id:'',
                    image:''
                },
                invoice:{
                    suplier:'',
                     invoice_qr_code:'',
                    suplier:'',
                    invoice_regular_price:'',
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
         
        },
        methods:{
          getData(page=1){
            this.loader=1,
              this.$store.dispatch('getInvoice',page).then(res=>{
                this.invoices=res.data;
                this.loader=0;
                    $("#exampleModal").modal('hide')
                     this.datable= $('.myTable').DataTable({});
              })
          },
          createInvoice(){
              // this.formReset();
               this.$router.push({name: 'invoice.create'});
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
                this.$store.dispatch('createInvoice',formData,header)
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
                 this.invoice.suplier='';
                this.invoice.invoice_qr_code='';
                this.invoice.invoice_regular_price='';
                this.invoice.sell_price='';
                this.invoice.retail_price='';
                this.invoice.quentity='';
                this.invoice.stock_level='';
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
<template>
    <div>
        <!-- Counts Section -->
        <section class="dashboard-counts section-padding">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center" v-if="loader==1" >
                 <div >
                    <div class="text-center">
                        <div id="loader"></div>
                    </div>
                </div>
                </div>
                <div class="row" v-else>
                    <!-- Count item widget-->
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="wrapper count-title d-flex">
                            <div class="icon"><i class="icon-user"></i></div>
                            <div class="name"><strong class="text-uppercase">New Clients</strong><span>Last 7 days</span>
                                <div class="count-number">25</div>
                            </div>
                        </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="wrapper count-title d-flex">
                            <div class="icon"><i class="icon-padnote"></i></div>
                            <div class="name"><strong class="text-uppercase">Work Orders</strong><span>Last 5 days</span>
                                <div class="count-number">400</div>
                            </div>
                        </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="wrapper count-title d-flex">
                            <div class="icon"><i class="icon-check"></i></div>
                            <div class="name"><strong class="text-uppercase">New Quotes</strong><span>Last 2 months</span>
                                <div class="count-number">342</div>
                            </div>
                        </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="wrapper count-title d-flex">
                            <div class="icon"><i class="icon-bill"></i></div>
                            <div class="name"><strong class="text-uppercase">New Invoices</strong><span>Last 2 days</span>
                                <div class="count-number">123</div>
                            </div>
                        </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="wrapper count-title d-flex">
                            <div class="icon"><i class="icon-list"></i></div>
                            <div class="name"><strong class="text-uppercase">Open Cases</strong><span>Last 3 months</span>
                                <div class="count-number">92</div>
                            </div>
                        </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-2 col-md-4 col-6">
                        <div class="wrapper count-title d-flex">
                            <div class="icon"><i class="icon-list-1"></i></div>
                            <div class="name"><strong class="text-uppercase">New Cases</strong><span>Last 7 days</span>
                                <div class="count-number">70</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('dashboard connected');
            this.loader=0;
        },
        data(){
            return{
                loader:1,
            }
        },
    }
</script>

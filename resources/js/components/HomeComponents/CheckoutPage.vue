<template>
    <div>
        <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>checkout register</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="checkout.html">Checkout Register</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="register_area p_100">
            <div class="container">
                <div class="register_inner">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="billing_details">
                                <h2 class="reg_title">Complete Your account</h2>
                                <form class="billing_inner row">
                                    <!-- <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="cun">Country <span>*</span></label>
                                            <select class="selectpicker" id="cun">
                                                <option>Indonesia (ID)</option>
                                                <option>United State America (USA)</option>
                                                <option>Konoha (KNH)</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name">Nama Penerima<span>*</span></label>
                                            <input type="text" class="form-control" id="name" aria-describedby="name" placeholder="" v-model="transaction.user.name">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="last">Alamat Email<span>*</span></label>
                                            <input type="email" class="form-control" id="last" aria-describedby="email" v-model="transaction.user.email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="phone">Nomor Telephone <span>*</span></label>
                                                <input type="text" class="form-control" id="phone" aria-describedby="phone" v-model="phone">
                                            </div>
                                        </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="address">Alamat Lengkap<span>*</span></label>
                                            <textarea class="form-control" id="order" rows="3" v-model="address"></textarea></div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="order">Catatan Untuk Penjual<span>*</span></label>
                                            <textarea class="form-control" id="order" rows="3" v-model="transaction.notes"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="order_box_price">
                                <h2 class="reg_title">Your Order</h2>
                                <div class="payment_list">
                                    <div class="price_single_cost">
                                        <h5 v-for="item in transaction.detail" :key="item.id">{{item.cart.item.name}} <span>Rp {{item.cart.item.price * item.cart.quantity}}</span></h5>
                                        <h4>Shiping <span>Rp {{transaction.shipping}}</span></h4>
                                        <h3><span class="normal_text">Order Totals</span> <span>Rp {{transaction.total + transaction.shipping}}</span></h3>
                                    </div>
                                    <div id="accordion" role="tablist" class="price_method">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingOne">
                                                <h5 class="mb-0">
                                                    <a data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="true" aria-controls="collapseOne" @click.prevent="status = 1">
                                                    Transfer Tunai
                                                    </a>
                                                </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    Kirimkan Uang ke nomor ini [MANDIRI - xxxxxxxxxxxxxxxxxxxx]. 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingThree">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree" @click.prevent="status = 2">
                                                    cash on delivery
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="card-body">
                                                    Khusus Area Yogyakarta 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a type="submit" value="submit" class="btn subs_btn form-control" @click.prevent="placeOrder()">place order</a>
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
    data(){
        return{
            interval: null,
            transaction:{
                total: 0,
                shipping: 0,
                notes: '',
                diskon: 0,
                user:{
                    name: '',
                    email: '',
                    detail: {
                        
                    }
                },
                detail:[],
              
            },
            phone: '',
            address: '',
            status: 1,
        }
    },
    mounted(){
        this.getTransaction();
        this.$parent.refresh();
        this.interval = setInterval(() => this.$parent.refresh(), 900000);
    },
    destroyed(){
           clearInterval(this.interval);
    },
    methods:{
        getTransaction(){
                let uri = '/api/mytransaction/'+this.$route.params.token;
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.transaction = response.data;
                if(this.transaction.user.detail != null){
                    this.phone = this.transaction.user.detail.phone;
                    this.address = this.transaction.user.detail.alamat;
                }
            })
        },
        placeOrder(){
            if(this.phone == '' || this.address == '' || this.notes == ''){
                alert('Please fill the blank field');
                return;
            }
            let uri = '/api/order';
              axios.post(uri,{'phone': this.phone,'address':this.address,
                              'status': this.status, 'transaction_id': this.transaction.id,
                              'notes': this.transaction.notes},{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                this.$router.push({name: 'ConfirmOrder'});
              }).catch(error => {
                  alert('terjadi kesalahan, silahkan coba lagi');
              })
        }
    }
}
</script>
<template>
    <div>
        
        <section class="register_area p_100">
            <div class="container">
                <div class="register_inner">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="billing_details">
                                <h2 class="reg_title">Lengkapi Data Diri Anda</h2>
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
                                            <label for="name">Nama Penerima</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="name" placeholder="" v-model="transaction.user.name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="last">Alamat Email</label>
                                            <input type="email" class="form-control" id="last" aria-describedby="email" v-model="transaction.user.email" disabled>
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
                                                <label for="province">Provinsi <span>*</span></label>
                                                <input type="text" class="form-control" id="phone" aria-describedby="phone" v-model="provinsi" disabled>
                                            </div>
                                        </div>
                                    <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="phone">Kota <span>*</span></label>
                                                <input type="text" class="form-control" id="phone" aria-describedby="phone" v-model="kota" disabled>
                                            </div>
                                        </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="address">Alamat Lengkap<span>*</span></label>
                                            <textarea class="form-control" id="order" rows="3" v-model="address"></textarea>
                                            </div>
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
                                <h2 class="reg_title">Pesanan Anda</h2>
                                <div class="payment_list">
                                    <div class="price_single_cost">
                                        <h5 v-for="item in transaction.detail" :key="item.id">{{item.cart.item.name}} <span>{{price(item.cart.item.price * item.cart.quantity)}}</span></h5>
                                        <h4>Biaya Pengiriman <span>{{price(transaction.shipping)}}</span></h4>
                                        <h4>Kode Unik <span>{{unik(transaction.total)}}</span></h4>
                                        <h3><span class="normal_text">Total Pesanan</span> <span>{{price(parseInt(transaction.total) + parseInt(transaction.shipping) - parseInt(transaction.diskon))}}</span></h3>
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

                                    </div>
                                </div>
                                <a type="submit" value="submit" class="btn subs_btn form-control" @click.prevent="placeOrder()">Pesan Sekarang</a>
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
            provinsi: '',
            kota: '',
            status: 1,
        }
    },
    mounted(){
        this.getTransaction(); //mengambil data transaksi yang sudah dibuat sebelumnya.
    },
    methods:{
        price(value){
            const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
            })
            return formatter.format(value) ;
        },
        getTransaction(){ //mengambil data transaksi yang sudah dibuat sebelumnya.
                let uri = '/api/mytransaction/'+this.$route.params.token;
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.transaction = response.data;
                if(this.transaction.user.detail != null){
                    this.phone = this.transaction.user.detail.phone;
                    this.provinsi = this.transaction.user.detail.provinsi;
                    this.kota = this.transaction.user.detail.kota;
                    this.address = this.transaction.user.detail.alamat;
                }
              
            })
        },
        unik(total){
            return total.slice(-2)
        },
        placeOrder(){ //melakukan pemesanan
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
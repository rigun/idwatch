<template>
<div>
    <div v-if="cart.length > 0">
    <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>Keranjang Belanjaan</h3>
                    <ul>
                        <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                        <li><a @click.prevent="getCart()">Keranjang Belanjaan</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="shopping_cart_area p_100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart_product_list">
                            <h3 class="cart_single_title">Daftar Belanjaan</h3>
                            <div class="table-responsive-md">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Barang</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in cart" :key="item.id">
                                            <th scope="row" @click.prevent="showModal(item)" style="cursor:pointer">
                                                     <i class="icon_pencil-edit" ></i>
                                            </th>
                                            <td>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <img :src="'../itemImages/'+item.item.picture[0].filename" alt="img" width="60px;" style="height: 100% !important">
                                                    </div>
                                                    <div class="media-body">
                                                        <h4>{{item.item.name}}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><p>Rp {{item.item.price}}</p></td>
                                            <td><input type="text" :value="item.quantity" disabled></td>
                                            <td><p>Rp {{item.item.price * item.quantity}}</p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="calculate_shoping_area">
                            <h3 class="cart_single_title">Hitung biaya pengiriman anda<span><i class="icon_minus-06"></i></span></h3>
                            <div class="calculate_shop_inner">
                                    <div class="form-group col-lg-6">
                                        <select v-model="provinsi_id">
                                            <option value="-1">Pilih Provinsi Anda</option>
                                            <option v-for="provinsi in provinsis" :key="provinsi.province_id" :value="provinsi.province_id" @click.prevent="getCity()">{{provinsi.province}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6" v-if="kotas.length > 0">
                                        <select v-model="kota_id">
                                            <option value="-1">Pilih Kota Anda</option>
                                            <option v-for="kota in kotas" :key="kota.city_id" :value="kota.city_id" @click.prevent="getCost()">{{kota.type}} {{kota.city_name}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12" v-if="jne.length > 0">
                                        Silahkan pilih biaya pengiriman yang diinginkan
                                        <table>
                                            <tr>
                                                <td></td>
                                                <td>Jenis Pengiriman</td>
                                                <td>Jenis Layanan</td>
                                                <td>Biaya</td>
                                                <td>Estimasi</td>
                                            </tr>
                                            <tr v-for="(jc,index) in jne[0].costs" :key="index">
                                                <td><input type="radio" :value="jc.cost[0].value" v-model="shipping" name="cost"></td>
                                                <td>{{jc.service}}</td>
                                                <td>Rp {{jc.cost}}</td>
                                                <td>{{jc.cost[0].etd}} Hari</td>
                                            </tr>
                                            <tr v-for="(jc,index) in tiki[0].costs" :key="index">
                                                <td><input type="radio" :value="jc.cost[0].value" v-model="shipping" name="cost"></td>
                                                <td>{{jc.service}}</td>
                                                <td>Rp {{jc.cost}}</td>
                                                <td>{{jc.cost[0].etd}} Hari</td>
                                            </tr>
                                            <tr v-for="(jc,index) in pos[0].costs" :key="index">
                                                <td><input type="radio" :value="jc.cost[0].value" v-model="shipping" name="cost"></td>
                                                <td>{{jc.service}}</td>
                                                <td>Rp {{jc.cost}}</td>
                                                <td>{{jc.cost[0].etd}} Hari</td>
                                            </tr>
                                        </table>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="total_amount_area">
                            <div class="cupon_box">
                                <h3 class="cart_single_title">Kupon Diskon</h3>
                                <div class="cupon_box_inner">
                                    <input type="text" placeholder="Enter your code here" v-model="cupon">
                                    <button type="submit" class="btn btn-primary subs_btn" @click.prevent="useCupon()">Gunakan Kupon</button>
                                </div>
                            </div>
                            <div class="cart_totals">
                                <h3 class="cart_single_title">Total belanjaan</h3>
                                <div class="cart_total_inner">
                                    <ul>
                                        <li><a href="#"><span>Subtotal keranjang</span> Rp {{total}}</a></li>
                                        <li><a href="#"><span>Biaya Pengiriman</span> Rp {{shipping}}</a></li>
                                        <li v-if="diskon != 0"><a href="#"><span>Diskon</span> Rp {{diskon}}</a></li>
                                        <li><a href="#"><span>Total Bayar</span> Rp {{parseInt(total) + parseInt(shipping) - parseInt(diskon)}}</a></li>
                                    </ul>
                                </div>
                                <a class="btn btn-primary checkout_btn" @click.prevent="checkout()"><div class="loader" v-if="load ==  'Checkout'"></div> <span v-else>Lanjutkan ke pembayaran</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>
    <div v-else>
        <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>Keranjang Kosong</h3>
                    <ul>
                        <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                        <li><a @click.prevent="getCart()">Keranjang Belanjaan</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="emty_cart_area p_100">
            <div class="container">
                <div class="emty_cart_inner">
                    <i class="icon-handbag icons"></i>
                    <h3>Keranjang Anda Kosong</h3>
                    <h4>Kembali <router-link :to="{name: 'Shop', params:{type: 'All', category: 'Man'}}">Belanja</router-link> </h4>
                    <h4>atau cek <router-link :to="{name: 'CheckoutCart'}">Keranjang Checkout Anda</router-link> </h4>
                </div>
            </div>
        </section>
    </div>
    	<div id="myModal" class="modal" :class="{'show': modal}">

				 <!-- Modal content -->
				<div class="modal-content">
				<div class="modal-header">
					<h2>Apa yang anda ingin lakukan ?</h2>
					<span class="close" @click.prevent="modal = false">&times;</span>
				</div>
				<div class="modal-body">
                    <ul style="text-align: center"> 
                        <li> <img :src="'../itemImages/'+modalItem.item.picture[0].filename" alt="img" width="60px;">
                        <li><h4>{{modalItem.item.name}}</h4></li>
                        <li><div class="p_color" style="margin: auto;">
                                    <h4 class="p_d_title">Warna </h4>
                                    <ul class="color_list">
                                        <li><a @click.prevent="modalItem.color = '#1cbbb4'" :class="{'active': modalItem.color == '#1cbbb4'}"></a></li>
                                        <li><a @click.prevent="modalItem.color = '#000000'" :class="{'active': modalItem.color == '#000000'}"></a></li>
                                        <li><a @click.prevent="modalItem.color = '#00aeef'" :class="{'active': modalItem.color == '#00aeef'}"></a></li>
                                        <li><a @click.prevent="modalItem.color = '#00a99d'" :class="{'active': modalItem.color == '#00a99d'}"></a></li>
                                        <li><a @click.prevent="modalItem.color = '#e7352b'" :class="{'active': modalItem.color == '#e7352b'}"></a></li>
                                        <li><a @click.prevent="modalItem.color = '#fbf4d9'" :class="{'active': modalItem.color == '#fbf4d9'}"></a></li>
                                    </ul>
                                </div></li>
                                <li><div class="p_color" style="margin: auto;">
                                    <v-container fluid grid-list-xl>
                                        <v-layout wrap align-center>
                                                <v-select
                                                :items="['M','XL']"
                                                label="Size"
                                                outline
                                                v-model="modalItem.size"
                                                ></v-select>
                                        </v-layout>
                                    </v-container>
                                </div></li>
                        <li><p>Rp {{modalItem.item.price}}</p></li>
                        <li> <div class="custom">
                                        <button @click.prevent="decrement()" class="reduced items-count" type="button"><i class="icon_minus-06"></i></button>
                                        <input type="text" name="qty" id="sst" maxlength="12" title="Quantity:" class="input-text qty" style="text-align: center" v-model="modalItem.quantity">
                                        <button @click.prevent="increment()" class="increase items-count" type="button"><i class="icon_plus"></i></button>
                                    </div></li>
                        <li><p>Rp {{modalItem.item.price * modalItem.quantity}}</p></li>
                        
                                
                    </ul>
				</div>
				<div class="modal-footer">
					<a class="btn btn-sm btn-primary" @click.prevent="modal = false">Batal</a>
                    <router-link class="btn btn-sm btn-info" :to="{name: 'DetailPage',  params: { slug: modalItem.item.slug } }"  > Detail</router-link>
					<a class="btn btn-sm btn-warning" style="color:black !important" @click.prevent="editData(modalItem.id)"><div class="loader" v-if="load == 'Edit'"></div> <span v-else>Perbaharui</span> </a>
					<a class="btn btn-sm btn-danger" @click.prevent="deleteData(modalItem.id)"><div class="loader" v-if="load ==  'Delete'"></div> <span v-else>Hapus</span>  </a>
				</div>
				</div> 

			</div>
</div>
</template>
<style>
.show{
	display: block;
}
li{
    padding-top: 10px;
}
.color_list a{
    opacity: 0.5;
    cursor: pointer;
}
.color_list a:hover{
    opacity: 0.8;
}
.color_list .active{
    opacity: 1;
}
.p_color .bootstrap-select .dropdown-menu .dropdown-menu.inner li a{
    width: 100% !important;
    display: block !important;
}
.v-menu__content{
    left: auto !important;
    right: -10px !important;
    top: 60px !important;
}
</style>
<script>
export default {
    data(){
        return{
            interval: null,
            cart:[],
            modalItem: {
                id: -1,
                quantity: 1,
                item: {
                    name: '',
                    picture: [{
                        filename: '',
                    }
                    ]
                }

            },
            modal : false,
            load: -1,
            provinsi_id: -1,
            kota_id: -1,
            provinsis: [],
            kotas: [],
            jne: [],
            tiki: [],
            pos: [],
            shipping: 0,
            diskon: 0,
            cupon: null,
        }
    },
    mounted(){
        this.getCart(); //mengambil data keranjang
        this.interval = setInterval(() => this.$parent.refresh(), 900000); //mengeset interval refresh agar token tidak kadaluarsa
        this.getProvince();
    },
    destroyed(){
           clearInterval(this.interval); //menghapus interval
    },
    computed:{
        total(){ //menghitung total belanja
            var sum=0;
            for(let i=0;i< this.cart.length;i++){
                sum = sum + (this.cart[i].item.price * this.cart[i].quantity)
            }
            return sum;
        },
        sumOfWeight(){
            var sum=0;
            for(let i=0;i< this.cart.length;i++){
                sum = sum + parseInt(this.cart[i].item.weight)
            }
            return sum;
        }
    },
    methods:{
        useCupon(){
            let uri = '/api/cupon/'+this.cupon;
              axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  if(response.data == 0){
                      alert('Mohon Maaf, Kupon telah kadaluarsa')
                  }else{
                    alert('Kupon berhasil ditambahkan');
                    this.diskon = response.data;
                  }
              }).catch(error => {
                  this.load = -1;

              })
        },
        checkout(){ //mengarahkan ke checkout sekaligus mengirimkan data ke bagian transaksi
            this.load = 'Checkout';
            let uri = '/api/mytransaction';
              axios.post(uri,{'shipping': this.shipping,'total':this.total, 'diskon': this.diskon},{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  this.load = -1;
                  if(response.data == 0){
                      alert('Silahkan melakukan pelunasan barang pesanan sebelumnya terlebih dahulu sebelum anda dapat melakukan pemesanan lagi, terima kasih.')
                  }else{
                    this.$router.push({name: 'Checkout', params:{token: response.data}});
                  }
              }).catch(error => {
                  this.load = -1;

              })
        },
        getCost(){
            let uri = '/api/rajaongkir/'+this.kota_id+'/'+this.sumOfWeight;
            axios.get(uri).then((response) => {
                this.jne = response.data.jne;
                this.tiki = response.data.tiki;
                this.pos = response.data.pos;
            })
        },
        getProvince(){ //mengambil data provinsi dari api raja ongkir
            let uri = '/api/rajaongkir/provinsi';
            axios.get(uri).then((response) => {
                this.provinsis = response.data;
            })
        },
        getCity(){ //mengambil data kota dari api raja ongkir
            let uri = '/api/rajaongkir/kota/'+this.provinsi_id;
            axios.get(uri).then((response) => {
                this.kotas = response.data;
            })
        },
        editData(id){ //melakukan pembaharuan data pesanan
            this.load = 'Edit';
            let uri = '/api/cart/'+id;
              axios.patch(uri,this.modalItem,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  this.load = -1;
                  this.modal = false;
                this.getCart();
              }).catch(error => {
                  this.load = -1;
                  this.modal = false;
                this.getCart();
              })
        
        },
        deleteData(id){ //menghapus data pesanan
            this.load = 'Delete';
            let uri = '/api/cart/'+id;
              axios.delete(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  this.load = -1;
                  this.modal = false;
                this.getCart();
              }).catch(error => {
                  this.load = -1;
                  this.modal = false;
                this.getCart();
              })
        
        },
        decrement(){ //megurangi jumlah pesanan per barang
            if(isNaN(this.modalItem.quantity) || this.modalItem.quantity <=1){
                this.modalItem.quantity = 1
            }else{
                
                this.modalItem.quantity--;
            }
        },
        increment(){ //menambahkan jumlah pesanan per barang
            if(isNaN(this.modalItem.quantity)){
                this.modalItem.quantity = 1
            }else if(this.modalItem.quantity >= this.modalItem.item.stock){
                this.modalItem.quantity = this.modalItem.item.stock
            }else{
                this.modalItem.quantity++;
            }
        },
        getCart(){ //mengambil data keranjang
            let uri = '/api/mycart';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.cart = response.data;
                  this.$nextTick(function () { //memanggil method ketika konten selesai dirender
                      this.$parent.refresh();  //memanggil fungsi refresh pada parent
                })
            })
            
        },
        showModal(item){ //menampilkan modal edit, hapus, dan detail barang.
            this.modalItem = item;
            this.modal = true;
        }
    }
   
}
</script>
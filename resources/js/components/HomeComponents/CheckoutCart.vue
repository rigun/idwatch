<template>
<div>
    <div v-if="cart.length > 0">
    <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>Keranjang Checkout</h3>
                    <ul>
                        <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                        <li><a @click.prevent="getCart()">Keranjang Checkout</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="shopping_cart_area p_100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart_product_list">
                            <h3 class="cart_single_title">Barang Pesanan</h3>
                            <div class="table-responsive-md">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Barang</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in cart" :key="item.id">
                                            <td>
                                                <div class="media">
                                                    <div class="d-flex">
                                                        <img :src="'../itemImages/'+item.item.picture[0].filename" alt="img" width="60px;">
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
                            <h3 class="cart_single_title">Upload bukti pembayaran disini<span><i class="icon_minus-06"></i></span></h3>
                            <div class="calculate_shop_inner">
                               <input type="file" name="filename[]" id="filenames" @change="uploadFieldChange" v-if="file==null">
                               <div class="col-md-12" v-if="file!=null">
                                    <div class="filename-holder animated fadeIn" v-cloak > 
                                        <img style="width: 150px" :src="'../itemImages/'+file" alt="img">
                                        <span class="" style="background: red; cursor: pointer;" @click.prevent="removeOriginal()"><button class="btn btn-xs btn-danger"><div class="loader" v-if="loadRemove == id"></div> <span v-else>Hapus</span> </button></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="total_amount_area">
                            
                            <div class="cart_totals">
                                <h3 class="cart_single_title">Silahkan melakukan pembayaran sejumlah</h3>
                                <div class="cart_total_inner">
                                    <ul>
                                        <li><a href="#"><span>Subtotal Keranjang</span> Rp {{total}}</a></li>
                                        <li><a href="#"><span>Biaya Pengiriman</span> Rp {{shipping}}</a></li>
                                        <li><a href="#" v-if="diskon > 0"><span>Diskon</span> Rp {{diskon}}</a></li>
                                        <li><a href="#"><span>Total Bayar</span> Rp {{parseInt(total) + parseInt(shipping) - parseInt(diskon)}}</a></li>
                                    </ul>
                                </div>
                                <h3 class="cart_single_title" style="text-align: center">Apabila dalam 1 x 24 jam tidak melakukan pembayaran, maka transaksi akan dibatalkan</h3>                                
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
                    <h3>Keranjang Checkout Kosong</h3>
                    <ul>
                        <li><router-link :to="{name: 'Landing'}">Beranda</router-link></li>
                        <li><a @click.prevent="getCart()">Keranjang Checkout</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="emty_cart_area p_100">
            <div class="container">
                <div class="emty_cart_inner">
                    <i class="icon-handbag icons"></i>
                    <h3>Keranjang Chekout Anda Kosong</h3>
                    <h4>Kembali <router-link :to="{name: 'Shop', params:{type: 'All', category: 'Man'}}">Belanja</router-link> </h4>
                </div>
            </div>
        </section>
    </div>
    <!-- The Modal -->
			<div id="myModal" class="modal" :class="{'show': modal}">

				 <!-- Modal content -->
				<div class="modal-content">
				<div class="modal-header">
					<span class="close" @click.prevent="modal = false">&times;</span>
					<h2>Hapus ?</h2>
				</div>
				<div class="modal-body">
					<p>Jika anda menghapus gambar ini, maka anda tidak dapat mengembalikannya lagi.</p>
				</div>
				<div class="modal-footer">
					<a class="btn btn-sm btn-primary" @click.prevent="modal = false; loadRemove = -1;">Batal</a>
					<a class="btn btn-sm btn-danger" @click.prevent="deletePicture()">Hapus </a>
				</div>
				</div> 

			</div>
</div>
</template>
<style>
.show{
	display: block;
}
</style>
<script>
export default {
    data(){
        return{
            interval: null,
            cart:[],
            shipping: 25000,
            diskon: 0,
			 filenames: [],
            data: new FormData(),
             percentCompleted: 0, 
             id: -1,
             modal: false,
             file: null,
             loadRemove: -1,
        }
    },
    mounted(){
       this.getCart(); //mengambil data keranjang
        this.$parent.refresh(); //melakukan refresh token dari fungsi parent
        this.interval = setInterval(() => this.$parent.refresh(), 900000); //mengeset interval refresh agar token tidak kadaluarsa
        // this.getCity();
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
        }
    },
    methods:{
        
        getCart(){ // mengambil barang keranjang
            let uri = '/api/mycheckoutcart';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.cart = response.data.cart;
                this.id = response.data.id;
                this.file = response.data.file;
                this.diskon = response.data.diskon;
            })
            
        },
      
			 uploadFieldChange(e) { //mengupload bukti pembayaran berupa foto
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
					return;
                for (var i = files.length - 1; i >= 0; i--) {
                                        this.filenames.push(files[i]);
                                    }
					
                this.percentCompleted =0;
                var config = {
                    headers: { 'Content-Type': 'multipart/form-data',
                    Authorization: 'Bearer ' + localStorage.getItem('token') } ,
                    onUploadProgress: function(progressEvent) {
                        this.percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                        this.$forceUpdate();
                    }.bind(this)
                };
                if (this.filenames.length > 0) {
                    for (var i = 0; i < this.filenames.length; i++) {
                        let filename = this.filenames[i];
                        this.data.append('filename[]', filename);
                    }
                }
                // Make HTTP request to store announcement
                axios.post('/api/evidence/'+this.id, this.data, config)
                .then(function (response) {
                    this.getCart();
                }.bind(this)) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
                .catch(function (error) {
                    this.getCart();
                    alert('error');
                });
                return;
                // Reset the form to avoid copying these files multiple times into this.filenames
                document.getElementById("filenames").value = [];
			},
            removeOriginal(){ // menampilkan modal hapus foto
				this.modal = true;
				this.loadRemove = true;
			},
        deletePicture(){ // menghapus bukti pembayaran
				
				 this.loadRemove = this.id;
				let uri = '/api/evidence/'+this.id;
				axios.delete(uri,{
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				}).then((response) => {
					this.loadRemove = -1;
					this.modal = false;
					this.getCart();
				}).catch(error => {
					this.loadRemove = -1;
					this.modal = false;
					this.getCart();
				})
			},
    }
   
}
</script>
<template>
<div>
    <div v-if="cart.length > 0">
    <section class="solid_banner_area">
            <div class="container">
                <div class="solid_banner_inner">
                    <h3>shopping cart</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="shopping-cart.html">Shopping cart</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="shopping_cart_area p_100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart_product_list">
                            <h3 class="cart_single_title">Discount Cupon</h3>
                            <div class="table-responsive-md">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">product</th>
                                            <th scope="col">price</th>
                                            <th scope="col">qunatity</th>
                                            <th scope="col">total</th>
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
                            <h3 class="cart_single_title">Calculate Your Shipping<span><i class="icon_minus-06"></i></span></h3>
                            <div class="calculate_shop_inner">
                                <form class="calculate_shoping_form row" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                                    <div class="form-group col-lg-12">
                                        <select class="selectpicker">
                                            <option>Indonesia (ID)</option>
                                            <option>United State America (USA)</option>
                                            <option>Konoha (KNH)</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control" id="state" name="state" placeholder="Kota">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="text" class="form-control" id="zip" name="zip" placeholder="Kode Post">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <button type="submit" value="submit" class="btn submit_btn form-control">update totals</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="total_amount_area">
                            <div class="cupon_box">
                                <h3 class="cart_single_title">Discount Cupon</h3>
                                <div class="cupon_box_inner">
                                    <input type="text" placeholder="Enter your code here">
                                    <button type="submit" class="btn btn-primary subs_btn">apply cupon</button>
                                </div>
                            </div>
                            <div class="cart_totals">
                                <h3 class="cart_single_title">Discount Cupon</h3>
                                <div class="cart_total_inner">
                                    <ul>
                                        <li><a href="#"><span>Cart Subtotal</span> Rp 450 K</a></li>
                                        <li><a href="#"><span>Shipping</span> Rp 25 K</a></li>
                                        <li><a href="#"><span>Totals</span> Rp 475K</a></li>
                                    </ul>
                                </div>
                                <button type="submit" class="btn btn-primary update_btn">update cart</button>                                
                                <a class="btn btn-primary checkout_btn" href="checkout.html">proceed to checkout</a>
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
                    <h3>empty cart</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="track.html">Track Your Item</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="emty_cart_area p_100">
            <div class="container">
                <div class="emty_cart_inner">
                    <i class="icon-handbag icons"></i>
                    <h3>Your Cart is Empty</h3>
                    <h4>back to <a href="#">shopping</a></h4>
                </div>
            </div>
        </section>
    </div>
    	<div id="myModal" class="modal" :class="{'show': modal}">

				 <!-- Modal content -->
				<div class="modal-content">
				<div class="modal-header">
					<h2>What you want to do ?</h2>
					<span class="close" @click.prevent="modal = false">&times;</span>
				</div>
				<div class="modal-body">
                    <ul style="text-align: center"> 
                        <li> <img :src="'../itemImages/'+modalItem.item.picture[0].filename" alt="img" width="60px;">
                        <li><h4>{{modalItem.item.name}}</h4></li>
                        <li><div class="p_color" style="margin: auto;">
                                    <h4 class="p_d_title">color </h4>
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
					<a class="btn btn-sm btn-primary" @click.prevent="modal = false">Cancel</a>
					<a class="btn btn-sm btn-info" @click.prevent="editData(modalItem.id)"><div class="loader" v-if="load == 'Edit'"></div> <span v-else>Edit</span> </a>
					<a class="btn btn-sm btn-danger" @click.prevent="deleteData(modalItem.id)"><div class="loader" v-if="load ==  'Delete'"></div> <span v-else>Delete</span>  </a>
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
        }
    },
    mounted(){
        this.getCart();
        this.$parent.refresh();
        this.interval = setInterval(() => this.$parent.refresh(), 900000);
    },
    destroyed(){
           clearInterval(this.interval);
    },
    methods:{
        editData(id){
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
        deleteData(id){
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
        decrement(){
            if(isNaN(this.modalItem.quantity) || this.modalItem.quantity <=1){
                this.modalItem.quantity = 1
            }else{
                
                this.modalItem.quantity--;
            }
        },
        increment(){
            if(isNaN(this.modalItem.quantity)){
                this.modalItem.quantity = 1
            }else{
                this.modalItem.quantity+=1;
            }
        },
        getCart(){
            let uri = '/api/mycart';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.cart = response.data;
            })
            
        },
        showModal(item){
            this.modalItem = item;
            this.modal = true;
        }
    }
   
}
</script>
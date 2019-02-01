<template>
    <div>
        <section class="product_details_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="product_details_slider">
                            <div id="product_slider2" class="rev_slider" data-version="5.3.1.6">
                                <ul>	
                                    <li v-for="(pic, index) in item.picture" :key="index" :data-index="index" data-transition="scaledownfromleft" data-slotamount="default"  data-easein="default" data-easeout="default" data-masterspeed="1500"  :data-thumb="'/itemImages/'+pic.filename" data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="Umbrella" data-param1="September 7, 2015" data-param2="Alfon Much, The Precious Stones" data-description="">
                                        <img :src="'/itemImages/'+pic.filename"  alt=""  width="1920" height="1080" :data-lazyload="'/itemImages/'+pic.filename" data-bgposition="center center" data-bgfit="contain" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product_details_text">
                            <h3>{{item.name}} {{item.category.name}} | {{item.merk}} {{item.type}}</h3>
                            <!-- <ul class="p_rating">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <div class="add_review">
                                <a href="#">5 Reviews</a>
                                <a href="#">Tambahkan Review Anda</a>
                            </div> -->
                            <h6>Stok Barang Tersedia</h6>
                            <h4>{{price(item.price)}}</h4>
                            <p>{{item.description}}</p>
                            <form @submit.prevent="sendData()">
                                
                                <div class="quantity">
                                    <div class="custom">
                                        <button @click.prevent="decrement()" class="reduced items-count" type="button"><i class="icon_minus-06"></i></button>
                                        <input type="text" name="qty" id="sst" maxlength="12" title="Quantity:" class="input-text qty" style="text-align: center" v-model="cart.quantity">
                                        <button @click.prevent="increment()" class="increase items-count" type="button"><i class="icon_plus"></i></button>
                                    </div> <br>
                                    Stok Barang : {{item.stock}} <br>
                                    <button type="submit" class="add_cart_btn" v-if="$parent.token != null" ><div class="loader" v-if="load"></div> <span v-else>Tambahkan Ke Keranjang</span> </button>
                                    <button type="submit" class="add_cart_btn" v-if="$parent.token == null" @click.prevent="addToCart()"> <span>Tambahkan Ke Keranjang</span> </button>
                                </div>
                            </form>
                            
                            <!-- <div class="shareing_icon">
                                <h5>share :</h5>
                                <ul>
                                    <li><a href="#"><i class="social_facebook"></i></a></li>
                                    <li><a href="#"><i class="social_twitter"></i></a></li>
                                    <li><a href="#"><i class="social_pinterest"></i></a></li>
                                    <li><a href="#"><i class="social_instagram"></i></a></li>
                                    <li><a href="#"><i class="social_youtube"></i></a></li>
                                </ul>
                            </div> -->
                        </div>
                        <div class="product_table_details">
                            <div class="table-responsive-md">
                                <table class="table">
                                    <tbody>
                                        <!-- <tr>
                                            <th scope="row">Return Policy:</th>
                                            <td>
                                                <h6> Semua Shipment, E-mail, Resi akan dilakukan dalam jam kerja (Senin-Jumat:10am-4pm) & (Sabtu:10am-1pm).</h6>
                                                <h5>Item location:</h5>
                                                <p>Indonesia, Yogyakarta, Babarsari</p>
                                               <h5>Ships to:</h5>
                                                <p>Keseluruh Indonesia | See More details</p>
                                            </td>
                                        </tr> -->
                                        <!-- <tr>
                                            <th scope="row">Delivery:</th>
                                            <td>
                                                <p>Perkiraan Sampai ke rumah <span>Jumat 20 februari 2019</span> <br /> Atau tracking <a href="track.html">sekarang</a></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Payments:</th>
                                            <td>
                                                <a href="#"><img src="img/master-card.png" alt=""></a>
                                                <p>Kamu bisa menggunakan fasilitas asuransi saat checkout.  Perlu diingat bahwa asuransi hanya berlaku bagi paket yang hilang, dan bukan kerusakan selama pengiriman.</p>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product_description_area">
            <div class="container">
                <nav class="tab_menu">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Reviews ({{comments.length}})</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div v-for="comment in comments" :key="comment.id">
                            <h4>{{comment.user.name}}</h4>
                            <p>{{comment.comment}}</p>
                            <button class="btn btn-danger" v-if="role == 'administrator'" @click.prevent="deleteComment(comment.id)">Hapus</button>
                            <hr>
                        </div>

                        <div class="col-lg-12">

                            <div class="form-group">
                                <label for="order">Komentar</label>
                                <textarea class="form-control" id="order" rows="3" v-model="comment"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" style="margin-left: auto" @click.prevent="addComment()">Tambahkan Komentar</button>
                    </div>
                    
                </div>
            </div>
        </section>
        <section class="related_product_area">
            <div class="container">
                <div class="related_product_inner">
                    <h2 class="single_c_title">Produk yang sama</h2>
                    <div class="row">
                     
                        <div class="col-lg-3 col-sm-6" v-for="item in displayItem" :key="item.id">
                      <div class="l_product_item">
                            <div class="l_p_img">
                                 <router-link :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                <img :src="'../../../itemImages/'+item.picture[0].filename" alt="image">
                                 </router-link>
                                <h5 class="new">Baru</h5>
                            </div>
                            <div class="l_p_text">
                                <ul>
                                     <li><router-link  class="add_cart_btn" :to="{name: 'DetailPage',  params: { slug: item.slug } }" v-if="item.stock > 0" >
                                            Beli Sekarang
                                            </router-link>
                                            <a class="add_cart_btn" style="background-color: red" v-else>Stok Kosong</a></li>
                                </ul>
                                <h4>{{item.name}}</h4>
                                <h5><del></del>{{price(item.price)}}</h5>
                            </div>
                        </div>
                        </div>
                    </div>
                    <nav aria-label="Page navigation example" class="pagination_area">
                     <div class="clearfix btn-group col-md-2 offset-md-5">
                                <button type="button" class="btn btn-sm btn-outline-secondary" v-if="page != 1" @click="page--"> <i class="fa fa-angle-left" aria-hidden="true"></i> </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" v-for="pageNumber in pages.slice(page-1, page+5)" :key="pageNumber" @click="page = pageNumber"> {{pageNumber}} </button>
                                <button type="button" @click="page++" v-if="page < pages.length" class="btn btn-sm btn-outline-secondary"> <i class="fa fa-angle-right" aria-hidden="true"></i> </button>
                    </div>
                    </nav>
                </div>
            </div>
        </section>
		<div id="snackbar" :class="{'show': snackbar}">{{msg}} <a @click.prevent="snackbar = false; msg = ''" style="margin-left: 10px; color: red; text-decoration: none; cursor: pointer">X</a> </div> 

    </div>
</template>
<style>
.p_color .bootstrap-select .dropdown-menu .dropdown-menu.inner li a{
    width: 100% !important;
    display: block !important;
}
.v-menu__content{
    left: auto !important;
    right: -10px !important;
    top: 60px !important;
}
.additional-List{
    width: 100%;
}
.additional-List tr > td{
    padding: 5px;
    color: black;
}
</style>

<script>
export default {
    data(){
        return{
            item:{
                name: '',
                slug: '',
				category: 'Category',
				category_id: '',
				stock: null,
				price: null,
				type: 'Digital',
				merk: '',
                description: '',
                picture: [
                    {
                        filename: '',
                    }
                ],
                category:
                    {
                        name: ''
                    }
                
            },
            cart:{
                quantity: 1,
                item_id: -1,
            },
            snackbar: false,
             load: false,
			 msg: '',
              page: 1,
            perPage: 4,
            pages: [],
            items: [],
            comment: null,
            comments: [],
            role: localStorage.getItem('roles')
        }
    },
    created(){

    },
    mounted(){
        this.getData(); //mengambil data
    },
    watch: {
           '$route' (to, from) {

                if (from.params.slug != to.params.slug) {
                
                    return location.reload(); //mereload halaman

                }
            },
             items () {
                this.setPages(); //mengeset jumlah pagination
            }
        },
        computed: {
        displayItem () { //menampilkan data-data hasil pemotongan untuk pagination
            return this.paginate(this.items);
        }
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
        addToCart(){
            if (!confirm("Untuk dapat memesan barang ini, anda harus login terlebih dahulu")) {
               return;
            } 
            this.$router.push({name: 'LoginUser'});
        },
        deleteComment(id){ //menghapus komentar
            var config = {
                headers: { 
                Authorization: 'Bearer ' + localStorage.getItem('token') } 
            };
            // Make HTTP request to store announcement
            axios.delete('/api/comment/'+id, config)
            .then((response) =>{
                    this.load = false;
                    this.getComment();
            }) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
            .catch((error) =>{
                    this.load = false;
                    this.getComment();

            });
        },
        addComment(){ //menambahkan komentar
            var config = {
                headers: { 
                Authorization: 'Bearer ' + localStorage.getItem('token') } 
            };
            // Make HTTP request to store announcement
            axios.post('/api/comment',{'comment':this.comment, 'item_id':this.item.id}, config)
            .then((response) =>{
                    this.load = false;
                    this.getComment();
            }) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
            .catch((error) =>{
                    this.load = false;
                    this.getComment();

            });
        },
        getComment(){ //mengambil komentar
             let uri = '/api/comment/'+this.item.id;
            axios.get(uri).then((response) => {
                this.comments = response.data;
            })
        },
         getList(){ //mengambil list berdasarkan kategori
            let uri = '/api/item/All/'+this.item.category.name;
            axios.get(uri).then((response) => {
                this.items = response.data;
                console.log(response);
            })
            
        },
        setPages () { //mengeset jumlah halaman yang ditampilkan
            let numberOfPages = Math.ceil(this.items.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate (items) { //fungsi pagination
            let page = this.page;
            let perPage = this.perPage;
            let from = (page * perPage) - perPage;
            let to = (page * perPage);
            return  items.slice(from, to);
        },
        decrement(){ //mengurangi jumlah yang ingin dipesan
            if(isNaN(this.cart.quantity) || this.cart.quantity <=1){
                this.cart.quantity = 1
            }else{
                
                this.cart.quantity--;
            }
        },
        increment(){//menambah jumlah yang ingin dipesan
            if(isNaN(this.cart.quantity)){
                this.cart.quantity = 1
            }else if(this.cart.quantity >= this.item.stock){
                this.cart.quantity = this.item.stock
            }else{
                this.cart.quantity++;
            }
        },
        validate(){ //melakukan validasi data yang akan dikirimkan
			
            if(isNaN(this.cart.quantity)){
            this.msg = this.msg + ' Jumlah harus berupa angka,'
			}
			if(this.item.stock < this.cart.quantity){
				this.msg = this.msg + ' Stok tidak mencukupi pemesanan barang,'
			}

			if(this.msg != ''){
				this.snackbar = true;
				return false;
			}
			return true;
		},
        prepareFields() { //menyiapkan data yang akan dikirim
                if(!this.validate()){
					return false;
                }
                if(this.cart.quantity > this.item.stock){
                    alert('Stok tidak mencukupi pemesanan');
                    return false;
                }
                this.cart.item_id = this.item.id;
					return true;
            },
        sendData(){ //mengirimkan data
            if(!this.prepareFields()){
                return false;
            }
            console.log(this.cart.quantity > this.item.stock)
            return;
            this.percentCompleted =0;
            this.load = true;
            var config = {
                headers: { 
                Authorization: 'Bearer ' + localStorage.getItem('token') } 
            };
            axios.post('/api/cart', this.cart, config)
            .then((response) =>{
                    this.load = false;
                    this.$router.push({ name: 'Cart' })
            }) 
            .catch((error) =>{
                    this.load = false;
            });
        },
        getData(){ //mengambil data detail
            let uri = '/api/item/detail/'+this.$route.params.slug;
            axios.get(uri).then((response) => {
                this.item = response.data;
                this.$nextTick(function () {
                    this.getList();
                    this.getSlider();
                    this.getComment();
                })
            })
            
        },
        getSlider(){ //mengambil slider dan mengeset animasi slider
            ;(function($) {
    "use strict";
    
//    var nav_offset_top = $('header').height(); 
//    /*-------------------------------------------------------------------------------
//	  Navbar 
//	-------------------------------------------------------------------------------*/
//
//	//* Navbar Fixed  
//    function navbarFixed(){
//        if ( $('.main_menu_area, .search_area').length ){ 
//            $(window).scroll(function() {
//                var scroll = $(window).scrollTop();   
//                if (scroll >= nav_offset_top ) {
//                    $(".main_menu_area, .search_area").addClass("navbar_fixed");
//                } else {
//                    $(".main_menu_area, .search_area").removeClass("navbar_fixed");
//                }
//            });
//        };
//    };
//    navbarFixed();
    
    
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function main_slider(){
        if ( $('#main_slider').length ){
            $("#main_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    onHoverStop: 'off',
                    touch:{
                        touchenabled:"on"
                    },
                    arrows: {
                        style:"normal",
                        enable:false,
                        hide_onmobile:true,
                        hide_under:820,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        }
                    },
                },
                responsiveLevels:[4096,1199,992,767,480],
                gridwidth:[1170,1000,750,700,300],
                gridheight:[575,575,575,600,500],
                lazyType:"smart",
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    main_slider();
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function product_slider(){
        if ( $('#product_slider').length ){
            $("#product_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    keyboardNavigation:"off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation:"off",
                    onHoverStop:"off",
                    arrows: {
                        style:"uranus",
                        enable:true,
                        hide_onmobile:true,
                        hide_under:778,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        tmp:'',
                        left: {
                            h_align:"left",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        },
                        right: {
                            h_align:"right",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        }
                    }
                    ,
                    thumbnails: {
                        style:"erinyen",
                        enable:true,
                        width:80,
                        height:105,
                        min_width:80,
                        wrapper_padding:0,
                        wrapper_color:"#fff",
                        wrapper_opacity:"1",
                        tmp:'<span class="tp-thumb-over"></span><span class="tp-thumb-image"></span><span class="tp-thumb-title"></span>',
                        visibleAmount:10,
                        hide_onmobile:false,
                        hide_onleave:false,
                        direction:"horizontal",
                        span:true,
                        position:"outer-bottom",
                        space:17,
                        h_align:"center",
                        v_align:"top",
                        h_offset:0,
                        v_offset:0
                    }
                },
                gridwidth:370,
                gridheight:520,
                lazyType:"none",
                shadow:0,
                spinner:"spinner2",
                stopLoop:"on",
                stopAfterLoops:0,
                stopAtSlide:1,
                shuffle:"off",
                autoHeight:"off",
                disableProgressBar:"on",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    product_slider();
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function product_slider2(){
        if ( $('#product_slider2').length ){
            $("#product_slider2").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    keyboardNavigation:"on",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation:"off",
                    onHoverStop:"off",
                    touch:{
                        touchenabled:"on",
                        swipe_threshold: 75,
                        swipe_min_touches: 1,
                        swipe_direction: "horizontal",
                        drag_block_vertical: false
                    }
                    ,
                    arrows: {
                        style:"hesperiden",
                        enable:true,
                        hide_onmobile:true,
                        hide_under:778,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:200,
                        tmp:'',
                        left: {
                            h_align:"left",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        },
                        right: {
                            h_align:"right",
                            v_align:"center",
                            h_offset:20,
                            v_offset:0
                        }
                    }
                    ,
                    thumbnails: {
                        style:"gyges",
                        enable:true,
                        width:78,
                        height:104,
                        min_width:100,
                        wrapper_padding:0, 
                        wrapper_color:"#fff",
                        wrapper_opacity:"1",
                        tmp:'<span class="tp-thumb-img-wrap">  <span class="tp-thumb-image"></span></span>',
                        visibleAmount:5,
                        hide_onmobile:false,
                        hide_over:777,
                        hide_onleave:false,
                        direction:"vertical",
                        span:true,
                        position:"outer-left",
                        space:15,
                        h_align:"left",
                        v_align:"top",
                        h_offset:0,
                        v_offset:0
                    }
                    ,
                    tabs: {
                        style:"gyges",
                        enable:true,
                        width:100,
                        height:105,
                        min_width:100,
                        wrapper_padding:0,
                        wrapper_color:"#fff",
                        wrapper_opacity:"0",
                        tmp:'<div class="tp-tab-content">  <span class="tp-tab-date">{{param1}}</span>  <span class="tp-tab-title">{{title}}</span></div><div class="tp-tab-image"></div>',
                        visibleAmount: 10,
                        hide_onmobile: true,
                        hide_under:778,
                        hide_onleave:false,
                        hide_delay:200,
                        direction:"vertical",
                        span:true,
                        position:"outer-left",
                        space:0,
                        h_align:"left",
                        v_align:"top",
                        h_offset:0,
                        v_offset:0
                    }
                },
                gridwidth:370,
                gridheight:520,
                lazyType:"none",
                shadow:0,
                spinner:"spinner2",
                stopLoop:"on",
                stopAfterLoops:0,
                stopAtSlide:1,
                shuffle:"off",
                autoHeight:"off",
                disableProgressBar:"on",
                hideThumbsOnMobile:"off",
                hideSliderAtLimit:0,
                hideCaptionAtLimit:0,
                hideAllCaptionAtLilmit:0,
                debugMode:false,
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    product_slider2();
    
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function fullwidth_slider(){
        if ( $('#fullwidth_slider').length ){
            $("#fullwidth_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:5000,
                disableProgressBar:"on",
                navigation: {
                    onHoverStop: 'off',
                    touch:{
                        touchenabled:"on"
                    },
                    arrows: {
                        style:"normal",
                        enable:false,
                        hide_onmobile:true,
                        hide_under:820,
                        hide_onleave:true,
                        hide_delay:200,
                        hide_delay_mobile:1200,
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 5,
                            v_offset: 0
                        }
                    },
                },
                responsiveLevels:[4096,1320,1199,992,767,480],
                gridwidth:[1380,1170,960,720,700,300],
                gridheight:[900,900,800,700,500,500],
                lazyType:"smart",
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    fullwidth_slider();
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function home_box_slider(){
        if ( $('#home_box_slider').length ){
            $("#home_box_slider").revolution({
                sliderType:"standard",
                sliderLayout:"auto",
                delay:50000000,
                disableProgressBar:"on",
                navigation: {
                    onHoverStop: 'off',
                    touch:{
                        touchenabled:"on"
                    },
                    arrows: {
                        style:"normal",
                        enable:true,
                        hide_onmobile:true,
                        
                        left: {
                            h_align: "right",
                            v_align: "bottom",
                            h_offset: 60,
                            v_offset: 10
                        },
                        right: {
                            h_align: "right",
                            v_align: "bottom",
                            h_offset: 10,
                            v_offset: 10
                        }
                    },
                },
                responsiveLevels:[4096,1320,1199,992,767,480],
                gridwidth:[870,870,870,720,700,350],
                gridheight:[450,450,450,450,450,410],
                lazyType:"smart",
                fallbacks: {
                    simplifyAll:"off",
                    nextSlideOnWindowFocus:"off",
                    disableFocusListener:false,
                }
            })
        }
    }
    home_box_slider();
  
    
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function l_product_slider(){
        if ( $('.l_product_slider').length ){
            $('.l_product_slider').owlCarousel({
                loop:true,
                margin: 30,
                items: 4,
                nav:true,
                autoplay: true,
                smartSpeed: 1500,
                dots:false,
                navContainerClass: 'l_product_slider',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 4,
                    }
                }
            })
        }
    }
    l_product_slider();
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function home_l_product_slider(){
        if ( $('.home_l_product_slider').length ){
            $('.home_l_product_slider').owlCarousel({
                loop:true,
                margin: 30,
                items: 3,
                nav:true,
                autoplay: false,
                smartSpeed: 1500,
                dots:false,
                navContainerClass: 'home_l_product_slider',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,
                    },
                    992: {
                        items: 2,
                    },
                    1200: {
                        items: 3,
                    }
                }
            })
        }
    }
    home_l_product_slider();
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function sunglass_slider(){
        if ( $('.sunglass_slider').length ){
            $('.sunglass_slider').owlCarousel({
                loop:true,
                margin: 0,
                items: 1,
                nav:false,
                autoplay: true,
                smartSpeed: 1500,
                dots:true,
            })
        }
    }
    sunglass_slider();
    
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function fillter_slider(){
        if ( $('.fillter_slider').length ){
            $('.fillter_slider').owlCarousel({
                loop:true,
                margin: 30,
                items: 3,
                nav:true,
                autoplay: false,
                smartSpeed: 1500,
                dots:true, 
                navContainer: '.f_product_left',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    420: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    }
                }
            })
        }
    }
    fillter_slider();
    
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function fillter_p_slider(){
        if ( $('.fillter_product_slider').length ){
            $('.fillter_product_slider').owlCarousel({
                loop:true,
                margin: 30,
                items: 4,
                nav:true,
                autoplay: false,
                smartSpeed: 1500,
                dots:true, 
                navContainerClass: 'fillter_product_slider',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1199: {
                        items: 4,
                    }
                }
            })
        }
    }
    fillter_p_slider();
    
    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/
    function carousel_slider(){
        if ( $('.home_carousel_slider').length ){
            $('.home_carousel_slider').owlCarousel({
                loop:true,
                margin: 0,
                items: 5,
                nav:true,
                autoplay: false,
                smartSpeed: 1500,
                dots:true, 
                navContainer: '.home_carousel_slider',
                navText: ['<i class="arrow_carrot-left" aria-hidden="true"></i>','<i class="arrow_carrot-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 1,
                    },
                    575: {
                        items: 2,
                    },
                    800: {
                        items: 3,
                    },
                    1200: {
                        items: 5,
                    }
                }
            })
        }
    }
    carousel_slider();
    
   
    
    /*----------------------------------------------------*/
    /*  portfolio_isotope
    /*----------------------------------------------------*/
    function main_gallery(){
        if ( $('.fillter_slider_inner, .isotope_l_p_inner').length ){
            // Activate isotope in container
            $(".fillter_slider_inner, .isotope_l_p_inner").imagesLoaded( function() {
                $(".fillter_slider, .isotope_l_p_inner").isotope({
                    layoutMode: 'masonry',
                    percentPosition:true,
                    columnWidth: 1
        //            masonry: {
        //                columnWidth: '.grid-sizer, .grid-sizer_two',
        //            }            
                }); 
            }); 
        }
    }
    main_gallery();
    
    
    /*----------------------------------------------------*/
    /*  Isotope Fillter js
    /*----------------------------------------------------*/
    function portfolio_isotope(){
        if ( $('.portfolio_filter li, .fillter_l_p li').length ){
            // Add isotope click function
            $(".portfolio_filter li, .fillter_l_p li").on('click',function(){
                $(".portfolio_filter li, .fillter_l_p li").removeClass("active");
                $(this).addClass("active");

                var selector = $(this).attr("data-filter");
                $(".fillter_slider .owl-item, .isotope_l_p_inner, .fillter_product_slider .owl-item, .home_l_product_slider .owl-item").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 450,
                        easing: "linear",
                        queue: false,
                    }
                });
                return false;
            });
        }
    }
    
    portfolio_isotope();
    
    
    /*----------------------------------------------------*/
    /*  Language Flag js 
    /*----------------------------------------------------*/
    function createByJson() {
        var jsonData = [					
            {description:'Choos your payment gateway', value:'', text:'Payment Gateway'},					
            {image:'../img/icon/flag-1.png', description:'My life. My card...', value:'amex', text:'Amex'},
            {image:'../img/icon/flag-1.png', description:'It pays to Discover...', value:'Discover', text:'Discover'},
            {image:'../img/icon/flag-1.png', title:'For everything else...', description:'For everything else...', value:'Mastercard', text:'Mastercard'},
            {image:'../img/icon/flag-1.png', description:'Sorry not available...', value:'cash', text:'Cash on devlivery', disabled:true},
            {image:'../img/icon/flag-1.png', description:'All you need...', value:'Visa', text:'Visa'},
            {image:'../img/icon/flag-1.png', description:'Pay and get paid...', value:'Paypal', text:'Paypal'}
        ];
        $("#byjson").msDropDown({byJson:{data:jsonData, name:'payments2'}}).data("dd");
    }
    $(document).ready(function(e) {		
    //no use
    try {
        var pages = $("#pages").msDropdown({on:{change:function(data, ui) {
            var val = data.value;
            if(val!="")
                window.location = val;
        }}}).data("dd");

        var pagename = document.location.pathname.toString();
        pagename = pagename.split("/");
        pages.setIndexByValue(pagename[pagename.length-1]);
        $("#ver").html(msBeautify.version.msDropdown);
    } catch(e) {
    //console.log(e);	
    }
    $("#ver").html(msBeautify.version.msDropdown);

    //convert
    $(".language_drop").msDropdown({roundedBorder:false});
        createByJson();
        $("#tech").data("dd");
    });
    function showValue(h) {
        console.log(h.name, h.value);
    }
    $("#tech").change(function() {
        console.log("by jquery: ", this.value);
    })
    
    
    $(document).ready(function() {
        $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,

            fixedContentPos: false
        });
    });
    

   $(".verticalCarousel").verticalCarousel({
        currentItem: 1,
        showItems: 4,
    });
    
    
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 9000,
      values: [ 70, 9000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
    
    
    
})(jQuery)
            }
    
    }
}
</script>
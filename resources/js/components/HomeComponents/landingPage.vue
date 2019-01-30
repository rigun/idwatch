<template>
    <div>
 <!-- <section class="home_carousel_area">
        <div class="home_carousel_slider owl-carousel">
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-1.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>Jam Tangan</h3>
                        <h4>Kami Menyediakan Jam Tangan Terbaik</h4>
                        <h5>Termasuk:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-2.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>Jam Tangan</h3>
                        <h4>Kami Menyediakan Jam Tangan Terbaik</h4>
                        <h5>Termasuk:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-3.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>Jam Tangan</h3>
                        <h4>Kami Menyediakan Jam Tangan Terbaik</h4>
                        <h5>Termasuk:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-4.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>Jam Tangan</h3>
                        <h4>Kami Menyediakan Jam Tangan Terbaik</h4>
                        <h5>Termasuk:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="h_carousel_item">
                    <img src="img/home-carousel/home-c-5.jpg" alt="">
                    <div class="carousel_hover">
                        <h3>Jam Tangan</h3>
                        <h4>Kami Menyediakan Jam Tangan Terbaik</h4>
                        <h5>Termasuk:</h5>
                        <p>Adidas, Century, Everlast, Fairtex, Fighting Sports, WaveMaster, Twins, Rival</p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- <section class="fillter_latest_product">
        <div class="container">
            <div class="single_c_title">
                <h2>Produk Per Kategori</h2>
            </div>
            <div class="fillter_l_p_inner">
                <ul class="fillter_l_p">
                    <li v-for="category in categories" :key="category.id" :class="{'active': selectedCategory == category.name}" style="cursor:pointer;"><a @click.prevent="selectedCategory = category.name">{{category.name}}</a></li>
                </ul>
                <div class="row isotope_l_p_inner">
                    <div class="col-lg-3 col-md-4 col-sm-6" v-for="item in showByCategory" :key="item.id">
                        <div class="l_product_item">
                            <div class="l_p_img">
                                 <router-link :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                    <img class="img-fluid" :src="'./itemImages/'+item.picture[0].filename" alt="">
                                            </router-link>
                            </div>
                            <div class="l_p_text">
                                <ul>
                                    <li class="p_icon">   <a>
                                                     <i class="icon_piechart"></i>
                                                     </a>
                                           </li>
                                    <li><router-link  class="add_cart_btn" :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                            Detail
                                            </router-link></li>
                                    <li class="p_icon"><a href="#"><i class="icon_heart_alt"></i></a></li>
                                </ul>
                                <h4>{{item.name}}</h4>
                                <h5><del></del> Rp {{item.price}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <section class="no_sidebar_2column_area">
        <div class="container">
            <div class="two_column_product">
                <div class="row">
                       
                     <div class="col-lg-3 col-sm-6" v-for="item in items" :key="item.id">
                        <div class="l_product_item">
                            <div class="l_p_img">
                                 <router-link :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                <img :src="'./itemImages/'+item.picture[0].filename" alt="image">
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
            </div>
        </div>
    </section>
    </div>
</template>
<style>
.isotope_l_p_inner{
    height: auto !important;
    padding: 1px;
}
</style>

<script>
export default {
    data(){
        return{
             items: [],
             selectedCategory: 'Jam Tangan Pria',
             categories: [],
        }
    },
    mounted(){
        this.$nextTick(function () { //memanggil method ketika konten selesai dirender
                    this.getSlider(); //method yang dipanggil ketika selesai render
                })
            this.getCategory(); //mengambil kategori
            this.getData();//mengambil data barang   

    },
    computed:{
        showByCategory(){ //melakukan filter agar menampilkan seluruh barang per kategori
             if(this.items.length > 0) {
                    return this.items.filter((row, index) => {
                            if(index < 9){
                                return true;
                            }
                      });
                }
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
        getCategory(){ //mengambil kategori
            let uri = '/api/category';
            axios.get(uri).then((response) => {
                this.categories = response.data;
            });
		},
         getData(){ // mengambil data barang
            let uri = '/api/item';
            axios.get(uri).then((response) => {
                var items = response.data;
                this.items = _.orderBy(items, ['created_at'],['desc']);
              
            })
            
        },
        getSlider(){ // membuat animasi slider
            ;(function($) {
            "use strict";
            
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
            })(jQuery)
        }
    }
}
</script>

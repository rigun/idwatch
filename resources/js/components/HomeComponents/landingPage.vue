<template>
    <div>
 <section class="home_carousel_area">
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
    </section>

    <section class="fillter_latest_product">
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
            interval: null,
             items: [],
             selectedCategory: 'Laki-Laki',
             categories: [],
        }
    },
    created(){
        
    },
    destroyed(){
           clearInterval(this.interval); // menghapus interval
    },
    mounted(){
        this.$parent.refresh(); //memanggil fungsi refresh pada parent
        this.interval = setInterval(() => this.$parent.refresh(), 900000); // membuat interval untuk memanggil fungsi refresh
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
                            if(row.category.name == this.selectedCategory){
                                return true;
                            }
                      });
                }
        }
    },
    methods:{
        getCategory(){ //mengambil kategori
            let uri = '/api/category';
            axios.get(uri).then((response) => {
                this.categories = response.data;
            });
		},
         getData(){ // mengambil data barang
            let uri = '/api/item';
            axios.get(uri).then((response) => {
                this.items = response.data;
                
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

<template>
    <div>
        <header class="shop_header_area carousel_menu_area">
        <div class="carousel_top_header row m0">
            <div class="container">
                <div class="carousel_top_h_inner">
                    <div class="float-md-left">
                        <div class="top_header_left">

                        </div>
                    </div>
                    <div class="float-md-right">
                        <div class="top_header_middle" >
                              <router-link :to="{name: 'LoginUser'}" v-if="token == null">
                                    <i class="icon-login icons"></i> <span>Login atau Daftar</span>
                                </router-link>
                                
                                         <a slot="activator"  v-if="token != null" @click="dialog = true">
                                            <i class="icon-logout icons"></i> <span>Keluar</span>
                                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel_menu_inner">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="http://127.0.0.1:8000"><img src="http://127.0.0.1:8000/img/logo.png" alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>

                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <router-link :to="{name: 'Landing'}" class="nav-link">
                                   BERANDA
                                </router-link>
                            </li>
                              
                            <li class="nav-item dropdown submenu">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    KATEGORI <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" >
                                    <li class="nav-item" v-for="category in categories" :key="category.id"><router-link :to="{name: 'Shop', params:{type: 'All', category: category.name}}" class="nav-link"  >{{category.name}}</router-link></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'ListCategory', params:{type: 'Aksesoris', category: 'All'}}" class="nav-link">
                                   AKSESORIS
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="{name: 'ListCategory', params:{type: 'Tali jam', category: 'All'}}" class="nav-link">
                                   Tali Jam
                                </router-link>
                            </li>
                             <!-- <li class="nav-item">
                                <router-link :to="{name: 'Shop', params:{type: 'All', category: 'Jam Tangan Pria'}}" class="nav-link">
                                   BELANJA
                                </router-link>
                            </li> -->
                           
                      
                             <li class="nav-item">
                                <router-link :to="{name: 'Order'}" class="nav-link">
                                    CARA ORDER
                                </router-link>
                            </li>
                             <li class="nav-item">
                                <router-link :to="{name: 'AboutUs'}" class="nav-link">
                                    TENTANG KAMI
                                </router-link>
                            </li>
                              <li class="nav-item">
                                <router-link :to="{name: 'Contact'}" class="nav-link">
                                   KONTAK
                                </router-link>
                            </li> 
                        </ul>
                        <ul class="navbar-nav justify-content-end">
                            <li class="cart_cart" v-if="token != null" >
                                 <router-link :to="{name: 'Cart'}" class="nav-link" >
                                   <i class="icon-handbag icons"></i>
                                <span>{{count}}</span>

                                </router-link>
                            </li>
                            <li class="user_icon" v-if="token == null">
                                <router-link :to="{name: 'LoginUser'}" >
                                    <i class="icon-login icons"></i>
                                </router-link>
                                </li>
                            <li class="user_icon" v-if="token != null">

                                <v-dialog
                                    v-model="dialog"
                                    width="500"
                                    >

                                        <a slot="activator">
                                            <i class="icon-logout icons"></i>
                                        </a>


                                    <v-card>
                                        <v-card-title
                                        class="headline grey lighten-2"
                                        primary-title
                                        >
                                        Keluar
                                        </v-card-title>

                                        <v-card-text>
                                        Apakah anda yakin ingin keluar ?
                                        </v-card-text>

                                        <v-divider></v-divider>

                                        <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <a
                                            @click="dialog = false"
                                        >
                                            Batal
                                        </a>

                                            <router-link :to="{name: 'Logout'}"  >
                                                    Keluar
                                            </router-link>
                                        </v-card-actions>
                                    </v-card>
                                    </v-dialog>
                                
                                </li>

                        </ul>
                    </div>
                </nav>
                <div class="advanced_search_area">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search" v-model="search">
                        <span class="input-group-btn" v-if="search == ''">
                            <button  class="btn btn-secondary"><i class="icon-magnifier icons"></i></button>
                        </span>
                        <span class="input-group-btn" v-else>
                                <router-link :to="{name: 'SearchList', params:{search: search}}" >

                            <button  class="btn btn-secondary">
                                    <i class="icon-magnifier icons"></i>
                                    </button>
                                    </router-link>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>
  <div id="homeApp">
        <main class="homeContent">
        <transition name="fade">
        <router-view></router-view>
        </transition>
        </main>
    </div>
    <br>
    <footer class="footer_area">
        <div class="container">
            <div class="footer_widgets">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-6">
                        <aside class="f_widget f_about_widget">
                            <img src="http://127.0.0.1:8000/img/logo.png" alt="">
                            <p>ID - JAMTANGAN Merupakan Toko online jam tangan yang menjamin kepuasan pelanggan
                                dengan mengedepankan pelayanan
                            </p>
                            <h6>Media Sosial:</h6>
                            <ul>
                                <li><a href="#"><i class="social_facebook"></i></a></li>
                                <li><a href="#"><i class="social_twitter"></i></a></li>
                                <li><a href="#"><i class="social_pinterest"></i></a></li>
                                <li><a href="#"><i class="social_instagram"></i></a></li>
                                <li><a href="#"><i class="social_youtube"></i></a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <aside class="f_widget link_widget f_info_widget">
                            <div class="f_w_title">
                                <h3>Informasi</h3>
                            </div>
                            <ul>
                                <li><a href="#">Tentang Kami</a></li>
                                <li><a href="#">Delivery information</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Help Center</a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <aside class="f_widget link_widget f_service_widget">
                            <div class="f_w_title">
                                <h3>Pelayanan Pelanggan</h3>
                            </div>
                            <ul>
                                <li><a href="#">Akun Saya</a></li>
                                <li><a href="#">Riwayat Belanja</a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <aside class="f_widget link_widget f_extra_widget">
                            <div class="f_w_title">
                                <h3>Kontak</h3>
                            </div>
                            <ul>
                                <li><a href="#">xxxxxxxxxx</a></li>
                                <li><a href="#">xxxxxxxxxx</a></li>
                                <li><a href="#">xxxxxxxxxx</a></li>
                                <li><a href="#">xxxxxxxxxx</a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <aside class="f_widget link_widget f_account_widget">
                            <div class="f_w_title">
                                <h3>Pesan</h3>
                            </div>
                            <ul>
                                <li><a href="#">xxxxxxxxxx</a></li>
                                <li><a href="#">xxxxxxxxxx</a></li>
                                <li><a href="#">xxxxxxxxxx</a></li>
                                <li><a href="#">xxxxxxxxxx</a></li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>

        </div>
    </footer>
    </div>
    
</template>
<style scoped>
.dropActive{
    color: #d91522 !important;
}
</style>


<script>
export default {
    data(){
        return{
            token: localStorage.getItem('token'),
            dialog: false,
            categories: [],
             selectedCategory: 'All',
             count: 0,
             search: '',
             activeDrop: null,
             topCount: 70,
        }
    },
    mounted(){
          this.getUser(); //mengambil data pengguna
          this.getCategory(); //mengambil kategori
          
        },
        methods:{
            getCount(){
                axios.get('/api/count', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(response => {
                        if(isNaN(response.data)){
                            this.count = 0;
                        }else{
                            this.count = response.data;
                        }
                    }).catch(error => {
                        this.count = 0;
                    })  
            },
            refresh(){ //memperbaharui token JWT pengguna
                 axios.get('/api/refresh', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    localStorage.setItem('token', response.data.access_token); //membuat variable dan mengeset data kedalam penyimpanan internal browser
                    this.getUser();
                    this.$nextTick(function () {
                        this.getCount();
                    })
                }).catch(error => {
                   this.mssg = 'Login';
                });
            },
            getUser(){ //mengambil data pengguna
                axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(response => {
                        if(response.data.status == "Token is Expired" || response.data.message == 'Authorization Token not found'){
                            this.$router.push({ name: 'Logout' }) //mengarahkan ke komponen logout
                        }else {
                           this.token = localStorage.getItem('token'); //mengambil item dari penyimpanan broweser dengan variable token
                           // this.getCountBag();      
                                              
                        }
                    }).catch(error => {
                        this.mssg = 'Login';
                    })  
            },
             getCategory(){ //mengambil data kategori yang tersedia
                let uri = '/api/category';
                axios.get(uri).then((response) => {
                    this.categories = response.data;
                });
            },
        }
}
</script>
<template>
    <div>
        <section class="categories_product_main p_80">
            <div class="container">
                <div class="categories_main_inner">
                    <div class="row row_disable">
                        <div id="dashboard">
                            <main class="homeContent">
                            <transition name="fade">
                            <router-view></router-view>
                            </transition>
                            </main>
                        </div>
                        <div class="col-lg-3 float-md-right">
                            <div class="categories_sidebar">
                                <aside class="l_widgest l_p_categories_widget">
                                    <div class="l_w_title">
                                        <h3>Type</h3>
                                    </div>
                                    <ul class="navbar-nav">
                                       
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Digital
                                            <i class="icon_plus" aria-hidden="true"></i>
                                            <i class="icon_minus-06" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li class="nav-item" v-for="category in categories" :key="category.id"><router-link :to="{name: 'Shop', params:{type: 'Digital', category: category.name}}" class="nav-link" style="color: black; opacity:0.8;" >{{category.name}}</router-link></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Analog
                                            <i class="icon_plus" aria-hidden="true"></i>
                                            <i class="icon_minus-06" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li class="nav-item" v-for="category in categories" :key="category.id"><router-link :to="{name: 'Shop', params:{type: 'Analog', category: category.name}}" class="nav-link" style="color: black; opacity:0.8;" >{{category.name}}</router-link></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            All
                                            <i class="icon_plus" aria-hidden="true"></i>
                                            <i class="icon_minus-06" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li class="nav-item" v-for="category in categories" :key="category.id"><router-link :to="{name: 'Shop', params:{type: 'All', category: category.name}}" class="nav-link" style="color: black; opacity:0.8;" >{{category.name}}</router-link></li>
                                            </ul>
                                        </li>
                                        
                                        
                                    </ul>
                                </aside>
                             
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<style>
.dropdown-menu .nav-item a:hover{
    background: gray;
    opacity: 1;
    padding-left: 5px;
    transition: 0.5s;
}
.dropdown-menu  .router-link-exact-active{
    background: gray;
    opacity: 1;
    padding-left: 5px;
    transition: 0.5s;
}

</style>

<script>
export default {
    data(){
        return{
             categories: [],
             selectedCategory: null,
        }
    },
    mounted(){
        if(this.$route.params.type == null || this.$route.params.category == null){ //apabila type dan kategori pada parameter akses
            this.$router.push({name: 'Shop', params:{type : 'All', category : 'Jam Tangan Pria'}}) //akan diset default dengan type nya adalah All dan kategorinya adalah Jam Tangan Pria
        }
        this.getCategory(); //mengambil kategori
    },
    methods:{
         getCategory(){ //mengambil kategori
            let uri = '/api/category';
            axios.get(uri).then((response) => {
                this.categories = response.data;
                    this.$nextTick(function () { //memanggil method ketika konten selesai dirender
                      this.$parent.refresh();  //memanggil fungsi refresh pada parent
                })
            });
		},
    }
}
</script>
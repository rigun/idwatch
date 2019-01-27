<template>
    <div>
   

    <section class="no_sidebar_2column_area">
        <div class="container">
              <div class="showing_fillter">
                <div class="row m0">
                    <div class="first_fillter">
                        <h4>Menampilkan <span v-if="items.length != 0"> {{(page * perPage) - (perPage-1)}} Sampai  </span><span v-if="items.length > (page * perPage)">{{(page * perPage)}}</span> <span v-else> {{items.length}} </span> dari {{items.length}} Total</h4>
                    </div>
                    <div class="secand_fillter">
                        <h4>URUTKAN BERDASARKAN :</h4>
                          <select v-model="sortMethod">
                            <option value="new">Terbaru</option>
                            <option value="asc">Termurah</option>
                            <option value="desc">Termahal</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="two_column_product">
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
    </div>
</template>
<script>
export default {
    data(){
        return{
            page: 1,
            perPage: 9,
            pages: [],
            items: [],
            sortMethod: 'new',

        }
    },
    created(){
    },
    mounted(){
        if(this.$route.params.type == null || this.$route.params.category == null){ //apabila type dan kategori pada parameter akses
            this.$router.push({name: 'Shop', params:{type : 'All', category : 'All'}}) //akan diset default dengan type nya adalah All dan kategorinya adalah Jam Tangan Pria
        }
       
        this.getData(); //mengambil data

    },
    destroyed(){
    },
    watch: {
            '$route' (to, from) { //mendeteksi perubahan parameter

                if (from.params.category != to.params.category || from.params.type != to.params.type) {
                     this.page= 1;
                        this.perPage= 9;
                        this.pages= [];
                    return this.getData();

                }
            },
             items () { //mengeset jumlah page
                this.setPages();
            }
        },
    computed: {
        displayItem () { //filer dari data yang ditampilkan
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
         getData(){ //mengambil data berdasarkan kategori
            let uri = '/api/item/'+this.$route.params.type+'/All';
            axios.get(uri).then((response) => {
                this.items = response.data;
                console.log(response);
            })
            
        },
        setPages () { //mengeset jumlah page
            let numberOfPages = Math.ceil(this.items.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate (items) { //fungsi membuat pagination
            let page = this.page;
            let perPage = this.perPage;
            let from = (page * perPage) - perPage;
            let to = (page * perPage);
              if(this.sortMethod == 'new'){
                var sorted = _.orderBy(items, ['created_at'],['desc']); //mengurutkan data berdasarkan created_at
            }else{
                var sorted = _.orderBy(items, ['price'],[this.sortMethod]);
            }
            return  sorted.slice(from, to);
        }
    }
}
</script>
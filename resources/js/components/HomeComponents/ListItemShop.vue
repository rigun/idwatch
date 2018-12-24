<template>
    <div>
        <div class="col-lg-9 float-md-right">
            <div class="showing_fillter">
                <div class="row m0">
                    <div class="first_fillter">
                        <h4>Showing  <span v-if="items.length != 0"> {{(page * perPage) - (perPage-1)}} to  </span><span v-if="items.length > (page * perPage)">{{(page * perPage)}}</span> <span v-else> {{items.length}} </span>of {{items.length}} total</h4>
                    </div>
                    <div class="secand_fillter">
                        <h4>SORT BY :</h4>
                        <select v-model="sortMethod">
                            <option value="new">Terbaru</option>
                            <option value="asc">Termurah</option>
                            <option value="desc">Termahal</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="categories_product_area">
                <div class="row">
                    <div class="col-lg-4 col-sm-6" v-for="item in displayItem" :key="item.id">
                        <div class="l_product_item">
                            <div class="l_p_img">
                                 <router-link :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                <img :src="'../../../itemImages/'+item.picture[0].filename" alt="image">
                                 </router-link>
                                <h5 class="new">New</h5>
                            </div>
                            <div class="l_p_text">
                                <ul>
                                    <li class="p_icon">   <a>
                                                     <i class="icon_piechart"></i></a>
                                           </li>
                                    <li><router-link  class="add_cart_btn" :to="{name: 'DetailPage',  params: { slug: item.slug } }"  >
                                            Add To Cart
                                            </router-link></li>
                                    <li class="p_icon"><a href="#"><i class="icon_heart_alt"></i></a></li>
                                </ul>
                                <h4>{{item.name}}</h4>
                                <h5><del></del>Rp. {{item.price}}</h5>
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
        this.getData();

    },
    destroyed(){
    },
    watch: {
            '$route' (to, from) {

                if (from.params.type != to.params.type || from.params.category != to.params.category) {
                     this.page= 1;
                        this.perPage= 9;
                        this.pages= [];
                    return this.getData();

                }
            },
             items () {
                this.setPages();
            }
        },
    computed: {
        displayItem () {
            return this.paginate(this.items);
        }
    },
    methods:{
         getData(){
            let uri = '/api/item/'+this.$route.params.type+'/'+this.$route.params.category;
            axios.get(uri).then((response) => {
                this.items = response.data;
                console.log(response);
            })
            
        },
        setPages () {
            let numberOfPages = Math.ceil(this.items.length / this.perPage);
            for (let index = 1; index <= numberOfPages; index++) {
                this.pages.push(index);
            }
        },
        paginate (items) {
            let page = this.page;
            let perPage = this.perPage;
            let from = (page * perPage) - perPage;
            let to = (page * perPage);
            if(this.sortMethod == 'new'){
                var sorted = _.orderBy(items, ['created_at'],['desc']);
            }else{
                var sorted = _.orderBy(items, ['price'],[this.sortMethod]);
            }
            return  sorted.slice(from, to);
        }
    }
}
</script>
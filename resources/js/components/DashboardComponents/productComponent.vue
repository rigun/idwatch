<template>
    <div>
        
                        <div class="module">
                             
                            <div class="module-head" style="display:flex">
                                <h3>Data Barang</h3>
                                <input type="text" class="span3" style="margin-left: auto;" placeholder="name" v-model="search">
                                <button class="btn" type="button" style="height: 30px;" disabled>
                                    <i class="icon-search"></i>
                                </button>
                            </div>
                            <div class="module-head" style="display:flex">
                            <router-link :to="{name: 'AddContent'}"  class="btn btn-primary" style="align-self: center;">Tambah Barang </router-link>
                               
                                <div class="control-group" style="display: flex;align-content: center;margin: 0; margin-left: auto">
                                    <label class="control-label" for="basicinput">Filter</label>
                                    <div class="controls">
                                        <select name="" id="" v-model="merk">
                                                <option value="-">Merk </option> 
                                                <option v-for="br in brands" :key="br.id" :value="br.brand">{{br.brand}} </option> 
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>
                                                    No
                                                </center>
                                            </th>
                                            <th>
                                                <center>
                                                Nama
                                            </center>
                                            </th>
                                            <th>
                                                <center>
                                                    Gambar
                                                </center>
                                            </th>
                                            <th>
                                                <center>
                                                Harga
                                            </center>
                                            </th>
                                            <th>
                                                <center>
                                                    Merk
                                                </center>
                                            </th>
                                            <th>
                                                <center>
                                                Stock</center>
                                            </th>
                                            <th>
                                                <center>
                                                        Kategory
                                                </center>
                                                
                                            </th>
                                            <th>
                                                <center>
                                                Button Aksi
                                            </center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="gradeU" v-for="(item,index) in filterItem" :key="item.id">
                                            <td>
                                                <center>
                                                    {{index + 1}}
                                                </center>
                                            </td>
                                            <td>
                                                    <center>
                                                        {{item.name}}
                                                    </center>
                                                </td>
                                            <td>
                                                <center>
                                                <img :src="'../itemImages/' + item.picture[0].filename" width="40px" alt="images">
                                            </center>
                                            
                                            </td>
                                            <td>
                                                <center>
                                                {{price(item.price)}}
                                            </center>
                                            </td>
                                            <td>
                                                <center>
                                                    {{item.merk}}
                                                </center>
                                            </td>
                                            <td class="center">
                                                <center>
                                                {{item.stock}}
                                                </center>

                                            </td>
                                            <td>
                                                <center>
                                                   {{item.category.name}}
                                                </center>
                                            </td>
                                            <td>
                                                 <router-link :to="{name: 'DetailContent',  params: { id: item.id } }" class="btn btn-sm btn-primary" >
                                                     Detail
                                            </router-link>
                                                <a class="btn btn-sm btn-danger" @click.prevent="deleteData(item.id)"><div class="loader" v-if="load == item.id"></div> <span v-else>Hapus</span> </a>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/.module-->

    </div>
</template>
<script>
export default {
    data(){
        return{
            items: [],
            load: -1,
            search: '',
            merk: '-',
            brands: [],
        }
    },
    mounted(){
        this.getData(); //mengambil data item
        this.read(); //mengambil data brand;
    },
    computed: {
            filterItem: function(){ //filter data yang akan ditampilkan
                if(this.items.length) {
                    return this.items.filter((row, index) => {
                            if(this.search != '') return row.name.toLowerCase().includes(this.search.toLowerCase());  //menampilkan data data yang memiliki kemiripan nama dengan variable search yang diinputkan        
                            if(this.merk != '-') return row.merk.includes(this.merk);       
                            return true;
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
        read(){
			var uri = '/api/brand'
			var config = {
                headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') }
			}
			axios.get(uri,config).then(response=>{
				this.brands = response.data;
            }).catch(error =>{
            })
		},
        getData(){ //mengambil data
            let uri = '/api/itemAll';
            axios.get(uri).then((response) => {
                this.items = response.data;
                
            })
            
        },
        deleteData(id){ //menghapus data

            if (!confirm("Are you sure you want to delete this item ?")) {
               return;
            } 
            this.load = id;
            let uri = '/api/item/'+id;
              axios.delete(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  this.load = -1;

                this.getData();
              }).catch(error => {
                  this.load = -1;
                this.getData();
              })
        
        }

    }
}
</script>
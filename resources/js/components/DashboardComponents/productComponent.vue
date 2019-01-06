<template>
    <div>
        
                        <div class="module">
                             
                            <div class="module-head" style="display:flex">
                                <h3>Data Barang</h3>
                            <router-link :to="{name: 'AddContent'}"  class="btn btn-primary">Tambah Barang </router-link>
                                <input type="text" class="span3" style="margin-left: auto;" placeholder="name" v-model="search">
                                <button class="btn" type="button" style="height: 30px;" disabled>
                                    <i class="icon-search"></i>
                                </button>
                                <div class="control-group">
                                    <label class="control-label" for="basicinput">Filter</label>
                                    <div class="controls">
                                        <select name="" id="" v-model="merk">
                                                <option value="-">Merk </option> 
                                                <option>Daniel Wellington </option> 
                                                <option>Fossil </option> 
                                                <option>Alexandre Christie </option> 
                                                <option>Casio </option> 
                                                <option>Expedition </option> 
                                                <option>Fossil </option> 
                                                <option>Quicksilver </option> 
                                                <option>Seiko </option> 
                                                <option>Alba </option> 
                                                <option>Olivia Burton </option> 
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
                                                    Id
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
                                        <tr class="gradeU" v-for="item in filterItem" :key="item.id">
                                            <td>
                                                <center>
                                                    {{item.id}}
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
                                                Rp {{item.price}}
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
        }
    },
    mounted(){
        this.getData(); //mengambil data item
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
        getData(){ //mengambil data
            let uri = '/api/itemAll';
            axios.get(uri).then((response) => {
                this.items = response.data;
                  this.$nextTick(function () { //memanggil method ketika konten selesai dirender
                      this.$parent.refresh();  //memanggil fungsi refresh pada parent
                })
            })
            
        },
        deleteData(id){ //menghapus data
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
<template>
    <div>
        
                        <div class="module">
                            <div class="module-head">
                                <h3>Trash</h3>
                            </div>
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
                                        <tr class="gradeU" v-for="item in items" :key="item.id">
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
                                                <ul style="padding: 0px;margin: 0px;list-style: none;margin-left: 0;">
                                                    <li>
                                                         <a class="btn btn-sm btn-primary" href="detail.html">Detail</a>
                                                    </li>
                                                    <li>
                                                <a class="btn btn-sm btn-danger" @click.prevent="deleteData(item.id)"><div class="loader" v-if="load == item.id"></div> <span v-else>Hapus</span> </a>

                                                    </li>
                                                    <li>
                                                        <a class="btn btn-sm btn-warning" @click.prevent="restoreData(item.id)">Restore</a>
                                                    </li>
                                                </ul>

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
            interval: null,
            items: [],
            load: -1,

        }
    },
    mounted(){
            this.getData()
         
        this.$parent.refresh();
        this.interval = setInterval(() => this.$parent.refresh(), 900000);
    },
    destroyed(){
           clearInterval(this.interval);
    },
    methods:{
        getData(){
            let uri = '/api/item/trash';
            axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                this.items = response.data;
            })
            
        },
        deleteData(id){
            this.load = id;
            let uri = '/api/item/permanent/'+id;
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
        
        },
        restoreData(id){
            let uri = '/api/item/restore/'+id;
              axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  alert('Restore');
                this.getData();
              }).catch(error => {
                alert('Fail');
                this.getData();
              })
        
        }

    }
}
</script>
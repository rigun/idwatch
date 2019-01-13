<template>
    <div>
        <div class="module">
            <div class="module-head">
                <h3>Pengisian Barang</h3>
            </div>

            <div class="module-body">
                <div class="columns">
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Jumlah Transaksi (Hari Ini)</p> <br/>
                                <p class="number">{{item.T_today}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Jumlah Transaksi (Bulan Ini)</p> <br/>
                                <p class="number">{{item.T_month}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Jumlah Transaksi (Tahun Ini)</p> <br/>
                                <p class="number">{{item.T_year}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Transaksi Pending </p> <br/>
                                <p class="number">{{item.Pending}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Jumlah Barang </p> <br/>
                                <p class="number">{{item.Barang}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Pendapatan (Hari Ini) </p> <br/>
                                <p class="number">Rp. {{item.P_today}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Pendapatan (Bulan Ini) </p> <br/>
                                <p class="number">Rp. {{item.P_month}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <p class="title">Pendapatan (Tahun Ini) </p> <br/>
                                <p class="number">Rp. {{item.P_year}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</template>
<style>
    .columns{
      display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }
    .column{
        display: block;
        width: 50%;
    }
    .card{
        width: 100%;
        background-color: white;
        text-align: center;
    }
    .card-content{
        border: solid 1px whitesmoke;
        margin: 10px;
        padding: 20px;
        border-radius: 5px;
    }
    .card-content .title{
        font-size: 14px;
        font-weight: bold;
        opacity: 0.8;
    }
    .card-content .number{
        font-size: 40px;
        font-weight: bold;
    }
    @media (max-width: 600px){
        .column{
            width: 100%;
        }
    }
</style>


<script>
export default {
    data(){
        return{
            item: {
                T_today : 0,
                T_month : 0,
                T_year : 0,
                P_today : 0,
                P_month : 0,
                P_year : 0,
                pending : 0,
                barang : 0,
            },
            load: -1,

        }
    },
    mounted(){
            this.getData(); //mengambil data item yang telah dihapus
         
    },
    methods:{
        getData(){ //mengambil data 
            let uri = '/api/dashboard/graph';
            axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                this.item = response.data;
              
            })
            
        },

    }
}
</script>
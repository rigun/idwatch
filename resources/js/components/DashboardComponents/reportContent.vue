<template>
    <div>
                            
                            <div class="module">
                                <div class="module-head">
                                    <h3>Data Barang</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Id Transaksi
                                                </th>
                                                <th>
                                                    List Barang & jumlah
                                                </th>
                                                <th>
                                                    Total*
                                                </th>
                                                <th>
                                                    Metode Pembayaran
                                                </th>
                                                <th>
                                                    Tanggal Transaksi
                                                </th>
                                                <th>
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX" v-for="report in reports" :key="report.id">
                                                <td>
                                                    {{report.id}}
                                                </td>
                                                <td>
                                                    <table width="100%" style="border: none" class="inner-table">
                                                        <tr v-for="item in report.detail" :key="item.id">
                                                            <td>{{item.cart.item.name}}</td>
                                                            <td>{{item.cart.quantity}}</td>
                                                        </tr>
                                                    </table>	
                                                </td>
                                                <td>
                                                    Rp {{parseInt(report.total) + parseInt(report.shipping) - parseInt(report.diskon)}}
                                                </td>
                                                <td class="center">
                                                    <span v-if="report.status == 0">-</span>
                                                    <span v-if="report.status == 1 || report.status == 3">Transfer Tunai</span>
                                                    <span v-if="report.status == 2 || report.status == 4">Cash on delivery</span>
                                                </td>
                                                <td class="center">
                                                    {{report.created_at}}
                                                </td>
                                                <td class="center">
                                                    <span v-if="report.status < 3">Belum terverfikiasi</span>
                                                    <span v-else>Terverfikiasi</span>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            *Total berasal dari Biaya Barang + Biaya Pengiriman - Diskon.
                            <!--/.module-->
        
    </div>
</template>
<style>
.inner-table tr > td{
    border: none;
}
</style>

<script>
export default {
    data(){
        return{
            reports: [],
        }
    },
    mounted(){
        this.getReport(); //menampilkan data transaksi
    },
    methods:{
          getReport(){ //mengambil data transaksi
            let uri = '/api/report';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.reports = response.data;

                     this.$nextTick(function () { //memanggil method ketika konten selesai dirender
                      this.$parent.refresh();  //memanggil fungsi refresh pada parent
                })
            })
            
        },
    }
}
</script>
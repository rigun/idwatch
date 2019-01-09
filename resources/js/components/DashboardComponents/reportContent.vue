<template>
    <div>
                            
                            <div class="module">
                                <div class="module-head" style="display:flex">
                                    <h3>Data Barang</h3>
                                    <button class="btn btn-primary" style="margin-left: auto" @click.prevent="download()">Download</button>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                             <th> 
                                                 Id Transaksi  
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
                                                    List Barang
                                                </th>
                                                <th>
                                                    Jumlah
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div v-for="report in reports" :key="report.id">
                                            <tr>
                                                <td :rowspan="report.detail.length+1">
                                                    {{report.id}}
                                                </td>
        
                                                <td :rowspan="report.detail.length+1">
                                                    Rp {{parseInt(report.total) + parseInt(report.shipping) - parseInt(report.diskon)}}
                                                </td>
                                                <td :rowspan="report.detail.length+1">
                                                    <span v-if="report.status == 0">-</span>
                                                    <span v-if="report.status == 1 || report.status == 3">Transfer Tunai</span>
                                                    <span v-if="report.status == 2 || report.status == 4">Cash on delivery</span>
                                                </td>
                                                <td :rowspan="report.detail.length+1">
                                                    {{report.created_at}}
                                                </td>
                                            </tr>
                                             <!-- <tr v-for="item in report.detail" :key="item.id">
                                                    <td>{{item.cart.item.name}}</td>
                                                    <td>{{item.cart.quantity}}</td>
                                                </tr> -->
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            *Total berasal dari Biaya Barang + Biaya Pengiriman - Diskon.
                            <!--/.module-->
        
    </div>
</template>
<style>
table, th, td {
  border: 1px solid black;
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
          download(){ //mengambil data transaksi
            axios({
                url: '/api/report/download',
                method: 'GET',
                responseType: 'blob', // important
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token'), 'Accept': 'application/vnd.ms-excel' } 
            }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'report.xlsx');
                document.body.appendChild(link);
                link.click();
            });
            
        },
    }
}
</script>
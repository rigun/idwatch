<template>
    <div>
                            
                            <div class="module">
                                <div class="module-head" style="display:flex">
                                    <h3>Data Barang</h3>
                                    <button class="btn btn-primary" style="margin-left: auto" @click.prevent="download()">Download</button>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    No
                                                </th>
                                                <th>
                                                    List Barang
                                                </th>
                                                <th>
                                                    jumlah
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
                                                <!-- <th>
                                                    Status
                                                </th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX" v-for="(report,index) in reportsConfirm" :key="report.id" >
                                                <td>
                                                    {{index+1}}
                                                </td>
                                                <td>
                                                    <table width="100%" style="border: none" class="inner-table">
                                                        <tr v-for="item in report.detail" :key="item.id">
                                                            <td>{{item.cart.item.name}}</td>
                                                        </tr>
                                                    </table>	
                                                </td>
                                                <td>
                                                    <table width="100%" style="border: none" class="inner-table">
                                                        <tr v-for="item in report.detail" :key="item.id">
                                                            <td>{{item.cart.quantity}}</td>
                                                        </tr>
                                                    </table>	
                                                </td>
                                                <td>
                                                    {{price(parseInt(report.total))}}
                                                </td>
                                                <td class="center">
                                                    <span v-if="report.status == 0">-</span>
                                                    <span v-if="report.status == 1 || report.status == 3">Transfer Tunai</span>
                                                    <span v-if="report.status == 2 || report.status == 4">Cash on delivery</span>
                                                </td>
                                                <td class="center">
                                                    {{report.created_at}}
                                                </td>
                                              
                                            </tr>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align: right">Total :</td>
                                                <td >{{price(countTotal)}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            *Total berasal dari Biaya Barang + Biaya Pengiriman.
                            <!--/.module-->
        
    </div>
</template>
<style>
.inner-table tr > td{
    border: none;
}
.hidden{
    display: none;
}
</style>

<script>
export default {
    data(){
        return{
            reports: [],
        }
    },
    computed:{
        countTotal(){ //menghitung total belanja
            var sum=0;
            for(let i=0;i< this.reports.length;i++){
                if(this.reports[i].status > 2){
                    sum = parseInt(sum) + parseInt(this.reports[i].total)
                }
            }
            return sum;
        },
        reportsConfirm(){
            if(this.reports.length > 0){
                return this.reports.filter((row,index)=>{
                    if(row.status > 2) return true;
                })
            }
        }
    },
    mounted(){
        this.getReport(); //menampilkan data transaksi
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
          getReport(){ //mengambil data transaksi
            let uri = '/api/report';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.reports = response.data;

                  
            })
            
        },
          download(){ //mengambil data transaksi
            axios({
                url: '/api/report/download',
                method: 'GET',
                responseType: 'blob', // important
                // headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token'), 'Accept': 'application/vnd.ms-excel' } 
                headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') } 
            }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'report.pdf');
                document.body.appendChild(link);
                link.click();
            });
            
        },
    }
}
</script>
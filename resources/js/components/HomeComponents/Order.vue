<template>
    <div class="container">
            <div class="module message">
                <div class="module-head">
                    <h3>Konfirmasi Barang</h3>
                </div>
    
                <div class="module-body table">								

                    <table class="table table-message" style="background: white;">
                        <tbody>
                            <tr class="heading">
                                <td class="cell-icon"></td>
                                <td class="cell-title">List Barang</td>
                                <td class="cell-title">Jumlahnya</td>
                                <td class="cell-title">Gambar</td>
                                <td class="cell-time ">Total*</td>
                                <td class="cell-status">Status</td>
                                <td class="cell-status"></td>
                            </tr>
                            
                            <tr class="task" :class="{'resolved': confirm.status > 2}" v-for="confirm in confirms" :key="confirm.id">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>
                                    <table width="100%" style="border: none" class="inner-table">
                                                        <tr v-for="item in confirm.detail" :key="item.id">
                                                            <td>{{item.cart.item.name}}</td>
                                                        </tr>
                                                    </table>
                                                    </div></td>
                                <td class="cell-title"><div>
                                    <table width="100%" style="border: none" class="inner-table">
                                                        <tr v-for="item in confirm.detail" :key="item.id">
                                                            <td>{{item.cart.quantity}}</td>
                                                        </tr>
                                                    </table>
                                                    </div></td>
                                <td class="cell-title"><div>
                                    <table width="100%" style="border: none" class="inner-table">
                                                        <tr v-for="item in confirm.detail" :key="item.id">
                                                            <td>
                                                <img :src="'../../itemImages/' + item.cart.item.picture[0].filename" width="40px" alt="images">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    </div></td>
                                <td class="cell-time ">{{price(parseInt(confirm.total) + parseInt(confirm.shipping))}}</td>
                                <td class="cell-status hidden-phone hidden-tablet"><a v-if="confirm.status > 2" >Sudah Dikonfirmasi</a><b v-else >Belum Di konfirmasi</b></td>
                                <td>
                                    <a class="btn btn-danger">Batalkan Transaksi</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>
                <div class="module-foot">
                    *Total berasal dari Biaya Barang + Biaya Pengiriman.
                </div>
            </div>
						
    </div>
</template>
<script>
export default {
    data(){
        return{
            confirms: [
                {
                    user:{}
                }
            ],
        }
    },
    mounted(){
        this.getConfirm(); //mengambil data yang perlu dikonfirmasi
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
        getConfirm(){ // mengambil data laporan transaksi
            let uri = '/api/myhistory';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.confirms = response.data;
            
            })
        },
        
    }
}
</script>
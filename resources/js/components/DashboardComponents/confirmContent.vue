<template>
    <div>


            <div class="module message">
                <div class="module-head">
                    <h3>Konfirmasi Barang</h3>
                </div>
    
                <div class="module-body table" style="overflow-x: scroll;">								

                    <table class="table table-message">
                        <tbody>
                            <tr class="heading">
                                <td class="cell-icon"></td>
                                <td class="cell-title">List Barang</td>
                                <td class="cell-title">Jumlahnya</td>
                                <td class="cell-title">Gambar</td>
                                <td class="">Nama User</td>
                                <td class="">Alamat</td>
                                <td class="">Tanggal transaksi</td>
                                <td class="">Note</td>
                                <td class="">Nomor HP</td>
                                <td class="cell-time ">Total*</td>
                                <td class="cell-time ">Download Bukti</td>
                                <td class="cell-status">Status</td>
                                <td class="cell-status"></td>
                            </tr>
                            
                            <tr class="task" :class="{'resolved': confirm.status > 2}" v-for="confirm in confirmsList" :key="confirm.id">
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
                                <td class="cell-title"><div>{{confirm.user.name}}</div></td>
                                <td class="cell-title"><div>{{confirm.address}} <br>{{confirm.user.detail.provinsi}}<br>{{confirm.user.detail.kota}}</div></td>
                                <td class="cell-title"><div>{{confirm.created_at}}</div></td>
                                <td class="cell-title"><div>{{confirm.notes}}</div></td>
                                <td class="cell-title"><div>{{confirm.user.detail.phone}}</div></td>
                                <td class="cell-time ">{{price(parseInt(confirm.total) + parseInt(confirm.shipping) - parseInt(confirm.diskon))}}</td>
                                <td class="cell-time "><span v-if="confirm.evidence == null">-</span><span v-else><a :href="'../../itemImages/'+confirm.evidence">Download</a></span></td>
                                <td class="cell-status"><p v-if="confirm.status > 2" >Sudah Dikonfirmasi</p><b class="due" v-else @click.prevent="verifikasi(confirm.id,confirm.status)">Belum Terkonfirmasi</b></td>
                                <td class="cell-status">
                                    <a class="btn btn-danger" style="color:white" @click.prevent="deleteTransaksi(confirm.id)" v-if="confirm.status < 2">Batalkan Transaksi</a>
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
            confirms: [],
        }
    },
    mounted(){
        this.$parent.unconfirmCount();
        this.getConfirm(); //mengambil data yang perlu dikonfirmasi
    },
    computed:{
        confirmsList(){
            if(this.confirms.length > 0){
                return this.confirms.filter((row,index)=>{
                    if(row.notes != null) return true;
                })
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
        verifikasi(id,status){ //kondisi verifikasi 
            if (!confirm("Are you sure you want to confirm this payment ?")) {
               return;
            } 
            var temp;
            if(status == 1){
                temp = 3; //transaksi dipesan dengan metode transfer tunai dan sudah dikonfirmasi
            }else if(status == 3){
                temp = 1; //transaksi dipesan dengan metode transfer tunai dan belum dikonfirmasi
            }else if( status == 2){
                temp = 4; //transaksi dipesan dengan metode pembayaran secara langsung dan sudah dikonfirmasi
            }else if( status == 4){
                temp = 2; //transaksi dipesan dengan metode pembayaran secara langsung dan belum dikonfirmasi
            }else {
                temp = 0; //status apabila terjadi error pada server
            }
            let uri = '/api/verifikasi/'+id;
            axios.post(uri,{'status': temp}, {
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }
            )
                .then(function (response) {
                        this.getConfirm();
                        this.$parent.unconfirmCount(); //memanggil fungsi pada parent berupa fungsi penghitungan jumlah data yang belum dikonfirmasi 
                }.bind(this)) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
                .catch(function (error) {
						this.getConfirm();
                });
        },
        getConfirm(){ // mengambil data laporan transaksi
            let uri = '/api/report';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.confirms = response.data;
            
            })
        },
        deleteTransaksi(id){
            if(!confirm('Apakah anda yakin ingin membatalkan transaksi ini ?')){
                return;
            }
             let uri = '/api/report/'+id;
            axios.delete(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                    alert('transaksi berhasil dihapus');
                    this.getConfirm();            
            })
        }
        
    }
}
</script>
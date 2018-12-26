<template>
    <div>


            <div class="module message">
                <div class="module-head">
                    <h3>Konfirmasi Barang</h3>
                </div>
    
                <div class="module-body table">								

                    <table class="table table-message">
                        <tbody>
                            <tr class="heading">
                                <td class="cell-icon"></td>
                                <td class="cell-title">List Barang & jumlahnya</td>
                                <td class="">nama User</td>
                                <td class="">Alamat</td>
                                <td class="cell-time ">Total*</td>
                                <td class="cell-time ">Download Bukti</td>
                                <td class="cell-status hidden-phone hidden-tablet">Status</td>
                            </tr>
                            
                            <tr class="task" :class="{'resolved': confirm.status > 2}" v-for="confirm in confirms" :key="confirm.id">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>
                                    <table width="100%" style="border: none" class="inner-table">
                                                        <tr v-for="item in confirm.detail" :key="item.id">
                                                            <td>{{item.cart.item.name}}</td>
                                                            <td>{{item.cart.quantity}}</td>
                                                        </tr>
                                                    </table>
                                                    </div></td>
                                <td class="cell-title"><div>{{confirm.user.name}}</div></td>
                                <td class="cell-title"><div>{{confirm.address}}</div></td>
                                <td class="cell-time ">Rp {{parseInt(confirm.total) + parseInt(confirm.shipping) - parseInt(confirm.diskon)}}</td>
                                <td class="cell-time "><span v-if="confirm.evidence == null">-</span><span v-else><a :href="'../../itemImages/'+confirm.evidence">Download</a></span></td>
                                <td class="cell-status hidden-phone hidden-tablet"><a href="#" class="btn btn-primary" v-if="confirm.status > 2" @click.prevent="verifikasi(confirm.id,confirm.status)" >Sudah Dikonfirmasi</a><b class="due" v-else @click.prevent="verifikasi(confirm.id,confirm.status)">Belum Terkonfirmasi</b></td>
                            </tr>
                            
                            
                        </tbody>
                    </table>


                </div>
                <div class="module-foot">
                    *Total berasal dari Biaya Barang + Biaya Pengiriman - Diskon.
                </div>
            </div>
						
    </div>
</template>
<script>
export default {
    data(){
        return{
            interval: null,
            confirms: [],
        }
    },
    mounted(){
        this.getConfirm(); //mengambil data yang perlu dikonfirmasi
        this.interval = setInterval(() => this.$parent.refresh(), 900000); //mengeset interval untuk memanggil fungsi refresh
    },
    destroyed(){
           clearInterval(this.interval); //menghapus interval
    },
    methods:{
        verifikasi(id,status){ //kondisi verifikasi 
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
                  this.$nextTick(function () { //memanggil method ketika konten selesai dirender
                      this.$parent.refresh();  //memanggil fungsi refresh pada parent
                })
            })
        },
        
    }
}
</script>
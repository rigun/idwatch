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
                                <td class="cell-title">Nama Barang</td>
                                <td class="">Jumlah Barang</td>
                                <td class="">nama User</td>
                                <td class="">Alamat</td>
                                <td class="cell-status hidden-phone hidden-tablet">Status</td>
                                <td class="cell-time ">Total</td>
                            </tr>
                            <tr class="task">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>SKMEI Womans</div></td>
                                <td class="cell-title"><div>10</div></td>
                                <td class="cell-title"><div>Agung Prio Rismawan</div></td>
                                <td class="cell-title"><div>Palembang</div></td>
                                <td class="cell-status hidden-phone hidden-tablet"><b class="due">Belum Terkonfirmasi</b></td>
                                <td class="cell-time ">Rp 120.000</td>
                            </tr>
                            <tr class="task">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>SKMEI Mans</div></td>
                                <td class="cell-title"><div>5</div></td>
                                <td class="cell-title"><div>Satria Nusa Paradilaga</div></td>
                                <td class="cell-title"><div>Bekasi</div></td>
                                <td class="cell-status hidden-phone hidden-tablet"><b class="due">Belum Terkonfirmasi</b></td>
                                <td class="cell-time ">Rp 120.000</td>
                            </tr>
                            <tr class="task resolved">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>SKMEI saja</div></td>
                                <td class="cell-title"><div>1</div></td>
                                <td class="cell-title"><div>Kakanya Aga</div></td>
                                <td class="cell-title"><div>Cikarang</div></td>
                                <td class="cell-status hidden-phone hidden-tablet"><a href="#" class="btn btn-primary">Sudah Dikonfirmasi</a></td>
                                <td class="cell-time ">Rp 120.000</td>
                            </tr>
                            <tr class="task">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>SKMEI Womans</div></td>
                                <td class="cell-title"><div>10</div></td>
                                <td class="cell-title"><div>Agung Prio Rismawan</div></td>
                                <td class="cell-title"><div>Palembang</div></td>
                                <td class="cell-status hidden-phone hidden-tablet"><b class="due">Belum Terkonfirmasi</b></td>
                                <td class="cell-time ">Rp 120.000</td>
                            </tr>
                            <tr class="task">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>SKMEI Mans</div></td>
                                <td class="cell-title"><div>5</div></td>
                                <td class="cell-title"><div>Satria Nusa Paradilaga</div></td>
                                <td class="cell-title"><div>Bekasi</div></td>
                                <td class="cell-status hidden-phone hidden-tablet"><b class="due">Belum Terkonfirmasi</b></td>
                                <td class="cell-time ">Rp 120.000</td>
                            </tr>
                            <tr class="task resolved">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>SKMEI saja</div></td>
                                <td class="cell-title"><div>1</div></td>
                                <td class="cell-title"><div>Kakanya Aga</div></td>
                                <td class="cell-title"><div>Cikarang</div></td>
                                <td class="cell-status hidden-phone hidden-tablet"><a href="#" class="btn btn-primary">Sudah Dikonfirmasi</a></td>
                                <td class="cell-time ">Rp 120.000</td>
                            </tr>
                            
                        </tbody>
                    </table>


                </div>
                <div class="module-foot">
                </div>
            </div>
						
    </div>
</template>
<script>
export default {
    data(){
        return{
            interval: null,
        }
    },
    mounted(){
        this.$parent.refresh();
        this.interval = setInterval(() => this.$parent.refresh(), 900000);
    },
    destroyed(){
           clearInterval(this.interval);
    },
}
</script>
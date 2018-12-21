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
                                        <tr class="gradeU">
                                            <td>
                                                <center>
                                                    123456
                                                </center>
                                            </td>
                                            <td>
                                                    <center>
                                                        Skmei Cewek
                                                    </center>
                                                </td>
                                            <td>
                                                <center>
                                                <img src="http://127.0.0.1:8000/images/chart1.png" alt="test">
                                            </center>
                                            
                                            </td>
                                            <td>
                                                <center>
                                                Rp 150.000
                                            </center>
                                            </td>
                                            <td>
                                                <center>
                                                    Skmei
                                                </center>
                                            </td>
                                            <td class="center">
                                                <center>
                                                1</center>

                                            </td>
                                            <td>
                                                <center>
                                                    jam Wanita
                                                </center>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="detail.html">Detail</a>
                                                <a class="btn btn-sm btn-danger" href="">Hapus</a>

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
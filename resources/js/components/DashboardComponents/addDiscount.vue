<template>
    <div>


            <div class="module message">
                <div class="module-head" style="display:flex">
                    <h3>Tambahkan Diskon</h3>
                    <button class="btn btn-primary" style="margin-left: auto" @click.prevent="modal = true; type= 'new'">Tambah Kupon</button>
                </div>
    
                <div class="module-body table">								

                    <table class="table table-message">
                        <tbody>
                            <tr class="heading">
                                <td class="cell-icon"></td>
                                <td class="cell-title">Kupon Diskon</td>
                                <td class="">Potongan</td>
                                <td class="">Status</td>
                                <td class="cell-time ">Pengaturan</td>
                            </tr>
                            
                            <tr class="task" v-for="discount in discounts" :key="discount.id">
                                <td class="cell-icon"><i class="icon-checker high"></i></td>
                                <td class="cell-title"><div>{{discount.cupon}}</div></td>
                                <td class="cell-title"><div>{{discount.price}}</div></td>
                                <td class="cell-status hidden-phone hidden-tablet"><a class="btn btn-primary" v-if="discount.expire == 1" >Tersedia</a><b class="due" v-else >Kadaluarsa</b></td>
                                <td class="cell-status hidden-phone hidden-tablet"><a class="btn btn-warning" style="color: black" @click.prevent="modal = true; type = 'edit'; editData = discount" >Edit</a></td>
                            </tr>
                            
                            
                        </tbody>
                    </table>


                </div>
                <div class="module-foot">
                </div>
            </div>
						<div id="myModal" class="modal" :class="{'show': modal}">

				 <!-- Modal content -->
				<div class="modal-content">
				<div class="modal-header">
					<span class="close" @click.prevent="modal = false">&times;</span>
					<h2 v-if="type == 'new'">Tambahkan ?</h2>
					<h2 v-else>Ubah ?</h2>
				</div>
				<div class="modal-body">
                    <ul style="text-align:center; list-style: none;" v-if="type=='new'">
                        <li><input type="number" placeholder="potongan kupon" v-model="price"></li>
                        <li><input type="radio" name="expire" value="0" v-model="expire"> Kadaluarsa
                        <input type="radio" name="expire" value="1" v-model="expire"> Tersedia</li>
                    </ul>
                    <ul style="text-align:center; list-style: none;" v-else>
                        <li><input type="text" placeholder="potongan kupon" v-model="editData.cupon" disabled></li>
                        <li><input type="number" placeholder="potongan kupon" v-model="editData.price"></li>
                        <li><input type="radio" name="expire" value="0" v-model="editData.expire"> Kadaluarsa
                        <input type="radio" name="expire" value="1" v-model="editData.expire"> Tersedia</li>
                    </ul>
                    
				</div>
				<div class="modal-footer">
					<a class="btn btn-sm btn-primary" @click.prevent="modal = false; loadRemove = -1;">Cancel</a>
					<a class="btn btn-sm btn-danger" @click.prevent="addCupon()" v-if="type == 'new'">Tambahkan </a>
					<a class="btn btn-sm btn-danger" @click.prevent="hapusCupon()" v-if="type == 'edit'">Hapus </a>
					<a class="btn btn-sm btn-warning" style="color:black;" @click.prevent="editCupon()" v-if="type == 'edit'" >Edit </a>
				</div>
				</div> 

			</div>
    </div>
</template>
<style>
.show{
	display: block;
}
</style>

<script>
export default {
    data(){
        return{
            discounts: [],
             load: false,
			 modal: false,
             expire: 0,
             price: null,
             type: 'new',
             editData: null,
        }
    },
    mounted(){
        //mengambil diskon yang sudah dibuat
            this.getdiscount();
    },
    methods:{
        getdiscount(){ //mengambil kupon diskon yang sudah dibuat
            let uri = '/api/cupon/';
            axios.get(uri,{
                    headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') } 
                }).then((response) => {
                this.discounts = response.data;
           
            })
        },
        addCupon(){ //menambahkan kupon diskon
                if(this.price == '' || this.price == null || this.price == 0){
                    alert('Kupon tidak boleh kosong')
                    return;
                }
				this.load = true;
                var config = {
					headers: { 
					Authorization: 'Bearer ' + localStorage.getItem('token') } ,
                };
                axios.post('/api/cupon', {'price': this.price, 'expire': this.expire}, config)
                .then(function (response) {
						this.getdiscount();
                        this.load = false;
                        this.modal = false;
                }.bind(this)) 
                .catch(function (error) {
                        this.load = false;
                        this.modal = false;
                        
                });
        },
        editCupon(){ //memperbaharui kupon yang telah dibuat
                if(this.editData.price == '' || this.editData.price == null || this.editData.price == 0){
                    alert('Kupon tidak boleh kosong')
                    return;
                }
				this.load = true;
                var config = {
					headers: { 
					Authorization: 'Bearer ' + localStorage.getItem('token') } ,
                };
              
                axios.patch('/api/cupon/'+this.editData.id, {'price': this.editData.price, 'expire': this.editData.expire}, config)
                .then(function (response) {
						this.getdiscount();
                        this.load = false;
                        this.modal = false;
                }) 
                .catch(function (error) {
                        this.load = false;
                        this.modal = false;
                        
                });
        },
        hapusCupon(){ //menghapus kupon yang sudah dibuat
                var config = {
					headers: { 
					Authorization: 'Bearer ' + localStorage.getItem('token') } ,
                };
                axios.delete('/api/cupon/'+this.editData.id, config)
                .then(function (response) {
						this.getdiscount();
                        this.modal = false;
                }.bind(this)) 
                .catch(function (error) {
                        this.modal = false;
                        
                });
        }
        
    }
}
</script>
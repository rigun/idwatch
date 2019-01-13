<template>
    <div>
		<div class="module">
			<div class="module-head">
				<h3>Pengisian Barang</h3>
			</div>
			<div class="module-body">
				<table>
					<tr>
						<td>Nama Brand</td>
						<td>Pengaturan</td>
					</tr>
					<tr>
						<td><input type="text" v-model="brand"></td>
						<td><button class="btn btn-primary" @click.prevent="create()"> <div class="loader" v-if="load"></div> <span v-else>Add</span> </button></td>
					</tr>
					<tr v-for="br in brands" :key="br.id">
						<td>
							<span v-if="edit != br.id">{{br.brand}}</span>
							<input type="text" v-model="editBrand" v-if="edit == br.id">
						</td>
						<td>
							<button class="btn btn-info" @click.prevent="edit = br.id;editBrand = br.brand" v-if="edit != br.id">Edit</button>
							<button class="btn btn-warning" @click.prevent="update(br.id)" v-if="edit == br.id"><div class="loader" v-if="editload == br.id"></div> <span v-else>Update</span> </button>
							<button class="btn btn-primary" v-if="edit == br.id" @click.prevent="edit = -1; editBrand = ''">Cancel</button>
							<button class="btn btn-danger" v-if="edit != br.id" @click.prevent="deleteData(br.id)"><div class="loader" v-if="deleteload == br.id"></div> <span v-else>Delete</span> </button>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- <div id="snackbar" :class="{'show': snackbar}">{{msg}} <a @click.prevent="snackbar = false; msg = ''" style="margin-left: 10px; color: red; text-decoration: none; cursor: pointer">X</a> </div>  -->
    </div>
</template>
<style >
table,tr,td{
	border: solid 1px black;
}
table{
	border-collapse: collapse;
	width: 100%;
}
tr,td{
	padding: 10px;
}

</style>

<script>
export default {
    data(){
        return{
			load: false,
			editload : -1,
			deleteload: -1,
			brands :[],
			brand : '',
			edit: -1,
			editBrand: '',
        }
    },
    mounted(){
        this.read(); //mengambil kategori
    },
    methods:{
		create(){
			this.load =true;
			var uri = '/api/brand'
			var config = {
                headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') }
			}
			axios.post(uri,{brand: this.brand},config).then(response=>{
				this.read();
            }).catch(error =>{
				this.read();
				alert('coba lagi');
            })
		},
		read(){
				this.load =false;
				this.editload = -1;
			this.deleteload = -1;

			var uri = '/api/brand'

			var config = {
                headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') }
			}
			axios.get(uri,config).then(response=>{
				this.brands = response.data;
            }).catch(error =>{
            })
		},
		update(id){
				this.editload = id;
			var uri = '/api/brand/'+id;

			var config = {
                headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') }
			}
			axios.patch(uri,{brand: this.editBrand},config).then(response=>{
				this.edit = -1;
				this.editBrand = '';
				this.read();
            }).catch(error =>{
				alert('coba lagi');
            })
		},
		deleteData(id){
			 if (!confirm("Are you sure you want to delete this item ?")) {
               return;
			} 
			this.deleteload = id;
			var uri = '/api/brand/'+id;

			var config = {
                headers: { 
                    Authorization: 'Bearer ' + localStorage.getItem('token') }
			}
			axios.delete(uri,config).then(response=>{
				this.edit = -1;
				this.editBrand = '';
				this.read();
            }).catch(error =>{
				alert('coba lagi');
            })
		}
	},
}
</script>
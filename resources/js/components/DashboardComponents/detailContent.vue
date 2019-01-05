<template>
    <div>
						<div class="module">
							<div class="module-head">
								<h3>Edit Item</h3>
							</div>
							<div class="module-body">

									<form class="form-horizontal row-fluid"  enctype="multipart/form-data" @submit.prevent="sendData()">
										<div class="control-group">
												<div class="setting"></div>
												<div class="setting image_picker">
												  <div class="settings_wrap">
													<label class="drop_target">
													  <div class="image_preview">
														  
													  </div>
													   <input type="file" name="filename[]"  multiple="multiple" id="filenames" @change="uploadFieldChange">
													</label>
													<div class="settings_actions vertical"><a data-action="choose_from_uploaded"><i class="fa fa-picture-o"></i> Choose from Uploads</a></div>
													<div class="image_details">
													  <label class="input_line image_title">
														<input type="text" placeholder="Title"/>
													  </label>
													</div>
												  </div>
												</div>
										</div>
									<div class="col-md-12">
											<div class="filename-holder animated fadeIn" v-cloak v-for="(filename, index) in filenames" :key="index"> 
												<img style="width: 150px" :src="previewBarang(index)" alt="img">
												<span class="label label-primary">{{ filename.name + ' (' + Number((filename.size / 1024 / 1024).toFixed(1)) + 'MB)'}}</span> 
												<span class="" style="background: red; cursor: pointer;" @click.prevent="removefilename(filename)"><button class="btn btn-xs btn-danger">Remove</button></span>
											</div>
											<div class="filename-holder animated fadeIn" v-cloak v-for="filename in originalFile" :key="filename.id"> 
												<img style="width: 150px" :src="'../../../itemImages/'+filename.filename" alt="img">
												<span class="label label-primary">{{ filename.originalName }}</span> 
												<span class="" style="background: red; cursor: pointer;" @click.prevent="removeOriginal(filename.id)"><button class="btn btn-xs btn-danger"><div class="loader" v-if="loadRemove == filename.id"></div> <span v-else>Remove</span> </button></span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Name</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Nama barang" class="span8" v-model="item.name">
												<span class="help-inline">Minimum 5 Characters</span>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label" for="basicinput">Stock</label>
											<div class="controls">
												<input data-title="A tooltip for the input" type="number" placeholder="Jumlah Barang" data-original-title="" class="span8 tip" v-model="item.stock">
											</div>
										</div>
										<div class="control-group">
											
												<label class="control-label" for="basicinput">Merk</label>
												<select name="" id="" v-model="item.merk">
															<option>Daniel Wellington </option> 
															<option>Fossil </option> 
															<option>Alexandre Christie </option> 
															<option>Casio </option> 
															<option>Expedition </option> 
															<option>Fossil </option> 
															<option>Quicksilver </option> 
															<option>Seiko </option> 
															<option>Alba </option> 
															<option>Olivia Burton </option> 
													</select>
											</div>
											<div class="control-group">
													<label class="control-label" for="basicinput">Type</label>
													<div class="controls">
														<select v-model="item.type">
															<option value="Digital">Digital</option>
															<option value="Analog">Analog</option>
															<option value="Aksesoris">Aksesoris</option>
															<option value="Tali jam">Tali Jam</option>
														</select>
													</div>
												</div>

							
										<div class="control-group">
											<label class="control-label" for="basicinput">Price</label>
											<div class="controls">
												<div class="input-append">
													<input type="number" placeholder="00000000" class="span8" v-model="item.price"><span class="add-on">Rp</span>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Weight</label>
											<div class="controls">
												<div class="input-append">
													<input type="number" placeholder="00000000" class="span8" v-model="item.weight"><span class="add-on">Gram</span>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Category</label>
											<div class="controls">
												<div class="dropdown">
													<a class="dropdown-toggle btn" data-toggle="dropdown" >{{item.category}}<i class="icon-caret-down"></i></a>
													<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
														<li style="cursor: pointer" v-for="category in categories" :key="category.id"><a @click="item.category = category.name; item.category_id = category.id">{{category.name}}</a></li>
													</ul>
												</div>
											</div>
										</div>

										
										<div class="control-group">
											<label class="control-label" for="basicinput">Description</label>
											<div class="controls">
												<textarea class="span8" rows="5" placeholder="Deskripsi Barang anda" v-model="item.description"></textarea>
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												
												<button type="submit" class="btn btn-primary"><div class="loader" v-if="load"></div> <span v-else>Edit Form</span> </button>
												<router-link :to="{name: 'DashboardContent'}" class="btn btn-warning">Cancel</router-link>
											</div>
										</div>
									</form>
							</div>
						</div>
			<div id="myProgress" v-if="percentCompleted>0">
				<div id="myBar" :style="'width: '+percentCompleted+'%'">{{percentCompleted}}%</div>
			</div>
			<div id="snackbar" :class="{'show': snackbar}">{{msg}} <a @click.prevent="snackbar = false; msg = ''" style="margin-left: 10px; color: red; text-decoration: none; cursor: pointer">X</a> </div> 
			<!-- The Modal -->
			<div id="myModal" class="modal" :class="{'show': modal}">

				 <!-- Modal content -->
				<div class="modal-content">
				<div class="modal-header">
					<span class="close" @click.prevent="modal = false">&times;</span>
					<h2>Delete ?</h2>
				</div>
				<div class="modal-body">
					<p>If you delete this picture, you can't to restore it again</p>
				</div>
				<div class="modal-footer">
					<a class="btn btn-sm btn-primary" @click.prevent="modal = false; loadRemove = -1;">Cancel</a>
					<a class="btn btn-sm btn-danger" @click.prevent="deletePicture()">Remove </a>
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
            item:{
                name: '',
                slug: '',
				category: 'Category',
				category_id: '',
				stock: null,
				price: null,
				weight: null,
				type: 'Digital',
				merk: 'Daniel Wellington',
				description: '',
            },
			categories: [],
			 filenames: [],
			 originalFile:[],
			 data: new FormData(),
			 percentCompleted: 0, 
			 msg: '',
			 snackbar: false,
			 load: false,
			 modal: false,
			 idPicture: -1,
			 loadRemove: -1,
        }
    },
    mounted(){
        this.getData(); //mengambil data detail dari konten yang dipilih
        this.getCategory(); //mengambil kategori
    },
    methods:{
        updateSlug: function(val) { //memperbaharui slug berdasarkan nama dari item
             this.item.slug = val;
            },
            slugCopied: function(type, msg, val) { //menyalin slug
                notifications.toast(msg, {type: `is-${type}`});
            },
        getCategory(){ //mengambil kategori
            let uri = '/api/category';
            axios.get(uri).then((response) => {
                this.categories = response.data;
            });
		},
		validate(){ //validasi inputan
			if(this.filenames.length <= 0){
				this.msg = this.msg + 'Please add at least one picture,'
			}
			if(this.item.name == '' || this.item.category_id == '' ||this.item.stock == null || this.item.price == null || this.item.weight == null || this.item.merk == '' || this.item.description == ''){
				this.msg = this.msg + ' Please fill the blank field,'
			}
			if(this.item.stock < 1){
				this.msg = this.msg + ' Stock must be one or more,'
			}
			if(this.item.price <= 99999){
				this.msg = this.msg + ' Price minimum 100000'
			}
			if(this.item.price > 99999999){
				this.msg = this.msg + ' Price cant more than 99999999'
			}
			if(this.item.weight <= 9){
				this.msg = this.msg + ' Weight minimum 10'
			}
			if(this.item.weight > 999){
				this.msg = this.msg + ' Weight cant more than 999'
			}
			if(isNaN(this.item.stock)){
				this.msg = this.msg + ' Stock must be number,'
			}
			if(isNaN(this.item.price)){
				this.msg = this.msg + ' Price must be number,'
			}
			if(isNaN(this.item.weight)){
				this.msg = this.msg + ' Weight must be number,'
			}

			if(this.msg != ''){
				this.snackbar = true;
				return false;
			}
			return true;
		},
		//picture
		getfilenameSize() { //mengambil ukuran dari file yang diupload ke browser
                
                this.upload_size = 0; // Reset to beginningƒ
                this.filenames.map((item) => { this.upload_size += parseInt(item.size); });
                
                this.upload_size = Number((this.upload_size).toFixed(1));
                this.$forceUpdate();
            },
            prepareFields() { //mempersiapkan data data sebelum dikirim ke server
                if(!this.validate()){
					return false;
				}
                if (this.filenames.length > 0) {
                    for (var i = 0; i < this.filenames.length; i++) {
                        let filename = this.filenames[i];
                        this.data.append('filename[]', filename);
                    }
				}
					this.data.append('name', this.item.name);
					this.data.append('slug', this.item.slug);
					this.data.append('stock', this.item.stock);
					this.data.append('merk', this.item.merk);
					this.data.append('type', this.item.type);
					this.data.append('price', this.item.price);
					this.data.append('weight', this.item.weight);
					this.data.append('description', this.item.description);
					this.data.append('category_id', this.item.category_id);
					return true;
            },
            removefilename(filename) {// menghapus file yang telah diupload ke browser
                if(this.originalFile.length < 2 && this.filenames.length <=1){
					alert('You have to upload new picture first before you can delete this picture');
					return false;
				}
                this.filenames.splice(this.filenames.indexOf(filename), 1);
                
                this.getfilenameSize();
			},
			 uploadFieldChange(e) { //mengupload file
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
					return;
for (var i = files.length - 1; i >= 0; i--) {
						this.filenames.push(files[i]);
					}
				if(this.originalFile.length < 2 && this.filenames.length <=1){ //jika file sebelumnya kurang dari 2 dan tidak ada file baru yang terupload ke browser
					//file akan langsung diupload tanpa menyimpannya di browser
					this.percentCompleted =0;
					var config = {
						headers: { 'Content-Type': 'multipart/form-data',
						Authorization: 'Bearer ' + localStorage.getItem('token') } ,
						onUploadProgress: function(progressEvent) {
							this.percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
							this.$forceUpdate();
						}.bind(this)
					};
					if (this.filenames.length > 0) {
						for (var i = 0; i < this.filenames.length; i++) {
							let filename = this.filenames[i];
							this.data.append('filename[]', filename);
						}
					}
					this.data.append('itemId', this.$route.params.id);
					axios.post('/api/picture', this.data, config)
					.then(function (response) {
							this.resetData();
					}.bind(this)) 
					.catch(function (error) {
						alert('error');
					});
					return;
				}

                
                document.getElementById("filenames").value = [];
			},
			sendData() { //mengirim data yang sudah diinputkan
                if(!this.prepareFields()){
					return false;
				}
				this.percentCompleted =0;
				this.load = true;
                var config = {
					headers: { 'Content-Type': 'multipart/form-data',
					Authorization: 'Bearer ' + localStorage.getItem('token') } ,
                    onUploadProgress: function(progressEvent) {
                        this.percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                        this.$forceUpdate();
                    }.bind(this)
                };
                // Make HTTP request to store announcement
                axios.post('/api/item/'+this.$route.params.id, this.data, config)
                .then(function (response) {
						this.resetData();
						this.load = false;
                }.bind(this)) // Make sure we bind Vue Component object to this funtion so we get a handle of it in order to call its other methods
                .catch(function (error) {
						this.load = false;
                });
            },
            resetData() { //mengosongkan data yang telah diupload
                this.data = new FormData(); 
				this.filenames = [];
				this.getPicture();
			},
			previewBarang(index){  //menampilkan preview gambar yang telah diupload ke browser
                return URL.createObjectURL(this.filenames[index]);
			},
			 getData(){ //mengambil data item berdsarkan id
				let uri = '/api/item/'+this.$route.params.id;
				axios.get(uri).then((response) => {
					this.item = response.data;
					this.originalFile = response.data.picture;
					this.item.category = response.data.category.name;
				})
				
			},
			 getPicture(){ //mengambil gambar berdsarkan id item
				let uri = '/api/picture/'+this.$route.params.id;
				axios.get(uri,{
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				}).then((response) => {
					this.originalFile = response.data;
				})
				
			},
			deletePicture(){ //menghapus gambar yang diupload ke server
				
				 this.loadRemove = this.idPicture;
				let uri = '/api/picture/'+this.idPicture;
				axios.delete(uri,{
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				}).then((response) => {
					this.loadRemove = -1;
					this.modal = false;
					this.getPicture();
				}).catch(error => {
					this.loadRemove = -1;
					this.modal = false;
					this.getPicture();
				})
			},
			removeOriginal(id){ //mengaktifkan modal untuk menghapus gambar
				if(this.originalFile.length < 2 && this.filenames.length <=0){
					alert('You have to upload new picture first before you can delete this picture');
					return false;
				}
				this.idPicture= id;
				this.modal = true;
				this.loadRemove = id;
			},
	
	},
	computed: {
            
        }
}
</script>
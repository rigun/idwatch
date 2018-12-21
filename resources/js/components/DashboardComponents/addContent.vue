<template>
    <div>
						<div class="module">
							<div class="module-head">
								<h3>Pengisian Barang</h3>
							</div>
							<div class="module-body">

									<form class="form-horizontal row-fluid">
										<div class="control-group">
												<div class="setting"></div>
												<div class="setting image_picker">
												  <div class="settings_wrap">
													<label class="drop_target">
													  <div class="image_preview"></div>
													  <input id="inputFile" type="file"/>
													</label>
													<div class="settings_actions vertical"><a data-action="choose_from_uploaded"><i class="fa fa-picture-o"></i> Choose from Uploads</a><a class="disabled" data-action="remove_current_image"><i class="fa fa-ban"></i> Remove Current Image</a></div>
													<div class="image_details">
													  <label class="input_line image_title">
														<input type="text" placeholder="Title"/>
													  </label>
													</div>
												  </div>
												</div>
										</div>
										<div class="control-group">
												<label class="control-label" for="basicinput">ID barang</label>
												<div class="controls">
													<input type="text" id="basicinput" placeholder="ID barang" class="span8">
												</div>
											</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Nama Barang</label>
											<div class="controls">
												<input type="text" id="basicinput" placeholder="Nama barang" class="span8">
												<span class="help-inline">Minimum 5 Characters</span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="basicinput">Jumlah Barang</label>
											<div class="controls">
												<input data-title="A tooltip for the input" type="number" placeholder="Jumlah Barang" data-original-title="" class="span8 tip">
											</div>
										</div>
										<div class="control-group">
												<label class="control-label" for="basicinput">Merk Barang</label>
												<div class="controls">
													<input type="text" id="basicinput" placeholder="Merk" class="span8">
												</div>
											</div>
											<div class="control-group">
													<label class="control-label" for="basicinput">Kategori</label>
													<div class="controls">
														<input type="text" id="basicinput" placeholder="Kategory" class="span8">
													</div>
												</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Harga Barang</label>
											<div class="controls">
												<div class="input-append">
													<input type="text" placeholder="Rp.000.000,00" class="span8">
												</div>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="basicinput">Kategori Barang</label>
											<div class="controls">
												<div class="dropdown">
													<a class="dropdown-toggle btn" data-toggle="dropdown" href="#">Kategori Barang<i class="icon-caret-down"></i></a>
													<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
														<li><a href="#">Laki Laki</a></li>
														<li><a href="#">Perempuan</a></li>
														<li><a href="#">Kerja</a></li>
														<li><a href="#">Casual</a></li>
													</ul>
												</div>
											</div>
										</div>

										
										<div class="control-group">
											<label class="control-label" for="basicinput">Deskripi Barang</label>
											<div class="controls">
												<textarea class="span8" rows="5" placeholder="Deskripsi Barang anda"></textarea>
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<button type="submit" class="btn btn-primary">Submit Form</button>
											</div>
										</div>
									</form>
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
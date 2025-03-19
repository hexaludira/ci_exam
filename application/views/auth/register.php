<style>
	html, body{
		width:100%;
		height:100%;
	}
	body{
		background-image:url('<?= base_url('uploads/default/wallpaper.jpg') ?>') !important;
		background-size:cover !important;
		background-repeat:no-repeat !important;
		background-position:center center !important;
	}
	#register-main{
		flex-direction: column;
		justify-content: center;
		/* align-items: center; */
	}
    #register-box{
        background: #fff;
        padding: 20px;
        margin-right : 15%;
        margin-left : 15%;
        border-top: 0;
        color: #666;
    }
</style>
<div class="h-100 w-100 d-flex" id="register-main">
<div class="row">
	<!-- /.login-logo -->
	<div class="col-12" id="register-box">
	<h3 class="text-center mt-0 mb-4">
		<b>O</b>nline <b>E</b>xamination <b>S</b>ystem
	</h3> 
	<p class="login-box-msg">Register New User/Examinee</p>

	<!-- <div id="infoMessage" class="text-center"></div> -->

	<div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <?=form_open('register/save', array('id'=>'reg_employee'), array('method'=>'add'))?>
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input autofocus="autofocus" onfocus="this.select()" placeholder="Std ID" type="text" name="nim" class="form-control">
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input placeholder="Student's Name" type="text" name="nama" class="form-control">
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input placeholder="Email" type="email" name="email" class="form-control">
                        <small class="help-block"></small>
                    </div>
            </div>
            <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_kelamin">Gender</label>
                        <select name="jenis_kelamin" class="form-control select2">
                            <option value="">-- Choose --</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Department</label>
                        <select id="jurusan" name="jurusan" class="form-control select2">
                            <option value="" disabled selected>-- Choose --</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Class</label>
                        <select id="kelas" name="kelas" class="form-control select2">
                            <option value="">-- Choose --</option>
                        </select>
                        <small class="help-block"></small>
                    </div>
                    <div class="form-group pull-right">
                        <button type="reset" class="btn btn-flat btn-default"><i class="fa fa-rotate-left"></i> Reset</button>
                        <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-save"></i> Save</button>
                    </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
</div> <!-- Container -->

<script type="text/javascript">
	let base_url = '<?=base_url();?>';
</script>
<script src="<?=base_url()?>assets/dist/js/app/master/mahasiswa/register.js"></script>
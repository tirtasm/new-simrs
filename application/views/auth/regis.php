<body class="bg-gradient-primary">

 <div id="pasienflash" data-pasien-success="<?= $this->session->flashdata('daftar_pasien'); ?>"></div>

    <div class="container min-vh-100 align-content-center">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 px-5 pb-4  card">
                <h5 class="text-center mt-5 mb-4 text-dark font-weight-bold">FORMULIR PASIEN</h5>
                <form method="post" action="<?= base_url('auth/registrasi') ?>">
                    <div class="row mb-2">
                        <div class="col-sm-12"> <label>Nama Lengkap<span class="text-danger">*</span></label>
                        <p id="no_medis" name="no_medis" data-nomedis="<?=$pasien['no_medis']?>" hidden></p>
                            
                            <input type="text" id="nama" name="nama" class="form-control" value="<?=set_value('nama')?>">
                            <?= form_error('nama', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6"> <label>Nomor Telepon<span class="text-danger">*</span></label>
                            <input type="number" id="no_telp" name="no_telp" class="form-control" value="<?=set_value('no_telp')?>">
                            <?= form_error('no_telp', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class="col-sm-6"> <label>Tanggal Lahir<span class="text-danger">*</span></label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" value="<?=set_value('tanggal_lahir')?>">
                            <?= form_error('tanggal_lahir', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-group col-12"> <label>Alamat Lengkap<span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control"><?=set_value('alamat')?></textarea>
                            <?= form_error('alamat', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>

                    </div>
                    <div class="text-center">

                        <button type="submit" class="btn btn-primary btn-block">
                            Daftar Akun
                        </button>
                    </div>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="<?= base_url() ?>auth/login">Sudah punya akun pasien? Login</a>
                </div>
            </div>
        </div>

    </div>
    <style>
        input:focus,
        textarea:focus {
            -webkit-box-shadow: none !important;
            border: 1.4px solid #00BCD3;
        }
    </style>
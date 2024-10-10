<div class="container ">
  <div class="d-flex">
  <div class=" text-left mb-3">
    <a href="<?=base_url('pasien/')?>" class="btn btn-secondary">Kembali</a>
  </div>
  <div class="col-11">
  <?= $this->session->flashdata('message_profil'); ?>
</div>
</div>
</div>


<div class="container rounded bg-white mt-5 mb-5">
  

    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="<?=base_url('assets/img/profile/') . $user['gambar']?>"><span class="font-weight-bold mt-3"><?=$user['nama']?></span><span class="text-black-50"><?=$user['no_medis']?></span><span> </span></div>
        </div>
        <div class="col-md-9">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Edit Profil</h4>
                </div>
                <form method="post" action="<?=base_url('pasien/edit')?>">
                
                <div class="row mt-3">
                  <div class="col-md-12  mb-2"><label>Nomor Medis</label><input type="text" class="form-control"  name="no_medis" value="<?=$user['no_medis']?>" readonly></div>
                  <div class="col-md-12  mb-2"><label>Nama Lengkap</label><input type="text" class="form-control"  name="nama" value="<?=$user['nama']?>"></div>
                  <?= form_error('nama', '<small class="text-danger pl-3 mb-1">', '</small>'); ?>
                  <div class="col-md-12  mb-2"><label>Nomor Telepon</label><input type="text" class="form-control" name="no_telp" value="<?=$user['no_telp']?>"></div>
                  <?= form_error('no_telp', '<small class="text-danger pl-3 mb-1">', '</small>'); ?>
                  <div class="col-md-12  mb-2"><label>Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" value="<?=$user['tanggal_lahir']?>"></div>
                  <?= form_error('tanggal_lahir', '<small class="text-danger pl-3 mb-1">', '</small>'); ?>
                  <div class="col-md-12  mb-2"><label>Alamat</label><textarea name="alamat" id="" class="form-control"><?=$user['alamat']?></textarea></div>
                  <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="row mt-2">
                  <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary profile-button">Simpan</button></div>
                </div>
                </form>

                
            </div>
        </div>
    </div>
</div>

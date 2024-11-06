<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $judul ?></h1>
    <div id="flashdata" data-login-success="<?= $this->session->flashdata('login_success'); ?>"
        data-login-error="<?= $this->session->flashdata('login_error'); ?>"></div>
    <div class="profil-flash" data-profilflash="<?= $this->session->flashdata('message_profil'); ?>"></div>
    <div class="row">
        <div class="col-lg-8">

            <div class="form-group row">
                <label for="no_pegawai" class="col-sm-2 col-form-label" id="no_pegawai">No. Dokter</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?= $user['no_pegawai']; ?>" name="no_pegawai"
                        readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label" id="nama">Nama Lengkap</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama" value="<?= $user['nama_pegawai']; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="no_telp" class="col-sm-2 col-form-label" id="no_telp">No. Telp</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="no_telp" value="0<?= $user['no_telp']; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label" id="">Spesialisasi</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="spesialisasi" value="<?= $user['spesialisasi']; ?>"
                        readonly>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <a href="<?= base_url('pegawai/edit/') . $user['no_pegawai'] ?>"
                    class="badge mr-2 px-3 py-2 btn-primary profilModal" data-toggle="modal" data-target="#formModal"
                    data-id="<?= $user['no_pegawai'] ?>">Edit</a>
            </div>
        </div>

    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('pegawai/edit') ?>" method="post">
                        <div class="row justify-content-center">

                            <div class="col-lg-10 align-items-center ">
                                <div class="mb-3">
                                    <label for="no_pegawai" class="form-label">No. Dokter</label>
                                    <input type="text" class="form-control" value="<?= $user['no_pegawai'] ?>"
                                        id="no_pegawai" name="no_pegawai" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="<?= $user['nama_pegawai'] ?>"
                                        id="nama" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">No. Telp</label>
                                    <input type="text" class="form-control" value="0<?= $user['no_telp'] ?>"
                                        id="no_telp" name="no_telp">
                                </div>
                                <div class="mb-3">
                                    <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                    <input type="text" class="form-control" value="<?= $user['spesialisasi'] ?>"
                                        id="spesialisasi" name="spesialisasi">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="badge py-2 px-4 btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="badge mr-2 px-4 py-2  btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
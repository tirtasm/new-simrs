
<!-- i dont now if not use id="ruang" = data jquery not showing -->
<input type="hidden" id="ruang">

<div id="content-wrapper" class="p-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <form action="<?= base_url('menuadmin/tindakan'); ?>" method="POST">
            <div class="mb-4">
                <h1 class="text-gray-800"><?= $judul ?></h1>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="col">
                        <input type="text" name="search" class="form-control form-input" placeholder="Cari Nama Tindakan..." value="<?= isset($search) ? $search : '' ?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>

            <div class="btn btn-primary mb-3 btnTindakan" data-toggle="modal" data-target="#tindakanModal">Tambah
                Tindakan
            </div>
            <div class="tindakanflash" data-tindakan-flash="<?= $this->session->flashdata('tindakanflash'); ?>"
                data-error-flash="<?= $this->session->flashdata('errorflash'); ?>"></div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Jenis Tindakan</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Tindakan</th>
                                    <th class="text-center">Biaya</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($tindakan)):
                                foreach ($tindakan as $td): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $td['nama_tindakan'] ?></td>
                                            <td class="text-center">
                                                <?= $td['biaya'] == 0 ? 'Gratis' : 'Rp.' . number_format($td['biaya'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('menuadmin/edit/') . $td['id_tindakan'] ?>"
                                                    class="badge badge-warning tindakanModal" data-toggle="modal"
                                                    data-target="#tindakanModal" data-id="<?= $td['id_tindakan'] ?>">Edit</a>
                                                <a href="<?= base_url('menuadmin/deletetindakan/') . $td['id_tindakan'] ?>"
                                                    class="badge badge-danger delete">Hapus</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                    $no++;
                                endforeach; ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="9" class="text-center">Data Tidak Ditemukan</td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                        <div class="container">

                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <?= $pagination ?>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<!-- Modal -->
<div class="modal fade" id="tindakanModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanModalLabel">Tambah Jenis Tindakan</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('menuadmin/addtindakan') ?>" method="post">
                    <div class="row justify-content-center">

                        <div class="col-lg-10 align-items-center ">

                            <div class="mb-3">
                                <input type="hidden" id="id_tindakan" name="id_tindakan">
                                <label for="tindakan" class="form-label">Nama Tindakan</label>
                                <input type="text" id="tindakan" name="tindakan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="biaya" class="form-label">Biaya Layanan</label>
                                <input type="number" id="biaya" name="biaya" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
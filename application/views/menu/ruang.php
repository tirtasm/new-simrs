<div id="content-wrapper" class="r-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <form action="<?= base_url('menuadmin/ruang'); ?>" method="POST">
            <div class="mb-4">
                <h1 class="text-gray-800"><?= $judul ?></h1>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="col">
                        <input type="text" name="search" class="form-control form-input" placeholder="Cari Nama Ruang..." value="<?= isset($search) ? $search : '' ?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>


            <div class="btn btn-primary mb-3 btnAddRuang" data-toggle="modal" data-target="#ruangModal" >Tambah Ruang
            </div>
            <div class="ruangflash" data-ruang-flash="<?= $this->session->flashdata('ruangflash'); ?>"
                data-error-flash="<?= $this->session->flashdata('errorflash'); ?>"></div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Ruang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Ruang</th>
                                    <th class="text-center">Kapasitas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($ruang)):
                                foreach ($ruang as $r): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $r['nama_ruang'] ?></td>
                                            <td class="text-center"><?= $r['kapasitas'] == 0 ? '<span class="text-danger">Tidak Tersedia</span>' : $r['kapasitas'] ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('menuadmin/edit_ruang/') . $r['id_ruang'] ?>"
                                                    class="badge badge-warning ruangModal" data-toggle="modal"
                                                    data-target="#ruangModal" data-id="<?= $r['id_ruang'] ?>">Edit</a>
                                                <a href="<?= base_url('menuadmin/delete_ruang/') . $r['id_ruang'] ?>"
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
<div class="modal fade" id="ruangModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ruangModalLabel">Tambah Ruang</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('menuadmin/add_ruang') ?>" method="post">
                    <div class="row justify-content-center">

                        <div class="col-lg-10 align-items-center ">

                            <div class="mb-3">
                                <input type="hidden" id="id_ruang" name="id_ruang">
                                <label for="ruang" class="form-label">Nama Ruang</label>
                                <input type="text" class="form-control" id="ruang" name="ruang" required>
                            </div>
                            <div class="mb-3">
                                <label for="kapasitas" class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
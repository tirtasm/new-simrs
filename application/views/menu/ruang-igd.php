<style>
    .form {
        position: relative;
        display: flex;
        align-items: center;
        margin: 1% 50% 0 0%;
    }

    .form .fa-search {
        position: absolute;
        left: 10px;
        color: #9ca3af;
    }

    .form-input {
        height: 45px;
        text-indent: 33px;
        border-radius: 10px;
        flex-grow: 1;
    }

    .form button {
        height: 45px;
        width: 95px;
        margin-left: 30px;
        border-radius: 10px;
    }
</style>

<div id="content-wrapper" class="r-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <form action="<?= base_url('menuadmin/ruang_igd'); ?>" method="POST">
                <div class="mb-4">
                    <h1 class="text-gray-800"><?= $judul ?></h1>
                    <div class="form">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" class="form-control form-input"
                            placeholder="Cari Ruang..." value="<?= isset($search) ? $search : '' ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>


            <div class="btn btn-primary mb-3" data-toggle="modal" data-target="#ruangIGDModal" >Tambah Ruang IGD
            </div>
            <div class="ruangflash" data-ruang-flash="<?= $this->session->flashdata('ruangflash'); ?>"
                data-error-flash="<?= $this->session->flashdata('errorflash'); ?>"></div>

                <!-- <script>console.log('wewew')</script> -->
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Ruang IGD</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Ruang IGD</th>
                                    <th class="text-center">Kapasitas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($ruang_igd)):
                                foreach ($ruang_igd as $r): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $r['nama_ruang_igd'] ?></td>
                                            <td class="text-center"><?= $r['kapasitas'] == 0 ? '<span class="text-danger">Tidak Tersedia</span>' : $r['kapasitas'] ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('menuadmin/edit_ruang_igd/') . $r['id_ruang_igd'] ?>"
                                                    class="badge badge-warning ruangIGDModal" data-toggle="modal"
                                                    data-target="#ruangIGDModal" data-id="<?= $r['id_ruang_igd'] ?>">Edit</a>
                                                <a href="<?= base_url('menuadmin/delete_ruang_igd/') . $r['id_ruang_igd'] ?>"
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
<div class="modal fade" id="ruangIGDModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ruangIGDModalLabel">Tambah Ruang IGD</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('menuadmin/add_ruang_igd') ?>" method="post">
                    <div class="row justify-content-center">

                        <div class="col-lg-10 align-items-center ">

                            <div class="mb-3">
                                <input type="hidden" id="id_ruang_igd" name="id_ruang_igd">
                                <label for="ruang_igd" class="form-label">Nama Ruang IGD</label>
                                <input type="text" class="form-control" id="ruang_igd" name="ruang_igd" required>
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
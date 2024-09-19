`<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">


            <h1 class="h3 mb-4 text-gray-800"><?= $judul ?></h1>

            <!-- <div class="dokter-flash" data-dokterflash="<?= $this->session->flashdata('menu_flash'); ?>" data-submenu_added="<?= $this->session->flashdata('submenu_added'); ?>" data-submenu_failed="<?= $this->session->flashdata('submenu_failed'); ?>"></div> -->

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Table Dokter</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Dokter</th>
                                    <th>Nama</th>
                                    <th>Spesialisasi</th>
                                    <th>No. Telp</th>
                                    <th class="text-center">Aktif?</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($dokter as $d): ?>
                                <tbody>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $d['no_dokter'] ?></td>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= $d['spesialisasi'] ?></td>
                                        <td>0<?= $d['no_telp'] ?></td>



                                        <td class="text-center">
                                            <button class="toggle-status bg-transparent border-0"
                                                data-id="<?= $d['no_dokter']; ?>"
                                                data-is-active="<?= $d['is_active'] == 1 ? 'true' : 'false'; ?>">
                                                <?= $d['is_active'] == 1 ? '<i class="fas fa-xl text-success fa-thin fa-check"></i>' : '<i class="fas fa-xl text-danger fa-thin fa-xmark"></i>'; ?>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/deletedokter/') . $d['no_dokter'] ?>"
                                                class="badge badge-danger delete">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                                $i++;
                            endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submenuModalLabel">Add Sub Menu</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('menu/addsubmenu') ?>" method="post">
                    <div class="row justify-content-center">

                        <div class="col-lg-10 align-items-center ">
                            <div class="mb-3">
                                <input type="hidden" id="no_dokter" name="no_dokter">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                                <!-- <small class="form-text text-danger" id="menu-error"></small> -->
                            </div>
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No. Telpon</label>
                                <input type="number" class="form-control" id="no_telp" name="no_telp">
                                <!-- <small class="form-text text-danger" id="menu-error"></small> -->
                            </div>
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon</label>
                                <input type="text" class="form-control" id="icon" name="icon">
                                <!-- <small class="form-text text-danger" id="menu-error"></small> -->
                            </div>
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon</label>
                                <input type="text" class="form-control" id="icon" name="icon">
                                <!-- <small class="form-text text-danger" id="menu-error"></small> -->
                            </div>
                            <div class="mb-3 ml-4">
                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1">
                                <label for="active" class="form-check-label">Active</label>
                                <!-- <small class="form-text text-danger" id="menu-error"></small> -->
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
                <!-- <button type="button" id="editButton" class="btn btn-primary edit-button" data-id="" onclick="editMenu(this)" hidden>Edit</button> -->
            </div>
            </form>
        </div>
    </div>
</div>`
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
        height: 55px;
        text-indent: 33px;
        border-radius:  10px;
        flex-grow: 1;
    }

    .form button {
        height: 55px;
        width: 95px;
        margin-left: 30px;
        border-radius: 10px;
    }
</style>
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
        <form action="<?= base_url('admin/data_dokter'); ?>" method="POST">
                <div class="mb-4">
                    <h1 class="text-gray-800"><?= $judul ?></h1>
                    <div class="form">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" class="form-control form-input"
                            placeholder="Cari Dokter..." value="<?= isset($search) ? $search : '' ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>

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
                                    <th class="text-center">#</th>
                                    <th>No. Dokter</th>
                                    <th>Nama</th>
                                    <th>Spesialisasi</th>
                                    <th>No. Telp</th>
                                    <th class="text-center">Aktif?</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($dokter)):
                                foreach ($dokter as $d): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $d['no_pegawai'] ?></td>
                                            <td><?= $d['nama_pegawai'] ?></td>
                                            <td><?= $d['spesialisasi'] ?></td>
                                            <td>0<?= $d['no_telp'] ?></td>



                                            <td class="text-center">
                                                <button class="status_dokter bg-transparent border-0"
                                                    data-id="<?= $d['no_pegawai']; ?>"
                                                    data-is-active="<?= $d['is_active'] == 1 ? 'true' : 'false'; ?>">
                                                    <?= $d['is_active'] == 1 ? '<i class="fas fa-xl text-success fa-thin fa-check"></i>' : '<i class="fas fa-xl text-danger fa-thin fa-xmark"></i>'; ?>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('dokter/delete/') . $d['no_pegawai'] ?>"
                                                    class="badge badge-danger delete">Delete</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                    $no++;
                                endforeach; ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">Data Tidak Ditemukan</td>
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
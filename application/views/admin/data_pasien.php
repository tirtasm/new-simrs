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
<div id="content-wrapper" class="p-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <form action="<?= base_url('admin/data_pasien'); ?>" method="POST">
                <div class="mb-4">
                    <h1 class="text-gray-800"><?= $judul ?></h1>
                    <div class="form">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" class="form-control form-input"
                            placeholder="Cari Pasien..." value="<?= isset($search) ? $search : '' ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            

            <!-- <div class="dokter-flash" data-dokterflash="<?= $this->session->flashdata('menu_flash'); ?>" data-submenu_added="<?= $this->session->flashdata('submenu_added'); ?>" data-submenu_failed="<?= $this->session->flashdata('submenu_failed'); ?>"></div> -->

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Table Pasien</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>No. Medis</th>
                                    <th>Nama</th>
                                    <th>No. Telp</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Aktif?</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if(!empty($pasien)):
                            foreach ($pasien as $p): ?>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?= $no ?></td>
                                        <td><?= $p['no_medis'] ?></td>
                                        <td><?= $p['nama'] ?></td>
                                        <td><?= $p['no_telp'] ?></td>
                                        <td><?= $p['tanggal_lahir'] ?></td>
                                        <td><?= $p['alamat'] ?></td>



                                        <td class="text-center">
                                            <button class="status_pasien bg-transparent border-0"
                                            data-id="<?= $p['no_medis']; ?>"
                                                data-is-active="<?= $p['is_active'] == 1 ? 'true' : 'false'; ?>">
                                                <?= $p['is_active'] == 1 ? '<i class="fas fa-xl text-success fa-thin fa-check"></i>' : '<i class="fas fa-xl text-danger fa-thin fa-xmark"></i>'; ?>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/deleteUser/') . $p['no_medis'] ?>"
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
                    <?= $pagination?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        
    </div>
    
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

<div id="content-wrapper" class="p-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <form action="<?= base_url('menuadmin/riwayat_pasien'); ?>" method="POST">
                <div class="mb-4">
                    <h1 class="text-gray-800"><?= $judul ?></h1>
                    <div class="form">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" class="form-control form-input"
                            placeholder="Cari Riwayat Pasien..." value="<?= isset($search) ? $search : '' ?>">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>


            <div class="pasienflash" data-pasien-flash="<?= $this->session->flashdata('pasienflash'); ?>"
                data-error-flash="<?= $this->session->flashdata('errorflash'); ?>"></div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Pasien Keluar</h6>
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
                                    <th class="text-center">Tanggal Lahir</th>
                                    <th>Ruang</th>
                                    <th class="text-center">Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($pasien_keluar)):
                                foreach ($pasien_keluar as $p): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $p['no_medis'] ?></td>
                                            <td><?= $p['nama'] ?></td>
                                            <td><?= $p['no_telp'] ?></td>
                                            <td class="text-center"><?= $p['tanggal_lahir'] ?></td>
                                            <td><?= !empty($p['nama_ruang']) ? $p['nama_ruang'] :$p['nama_ruang_igd'] ?></td>
                                            <td class="text-center"><?= $p['tanggal_masuk'] ?></td>
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

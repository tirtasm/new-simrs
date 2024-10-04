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
        border-radius: 10px;
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

        <form action="<?= base_url('dokter/data_pasien'); ?>" method="POST">
    <div class="mb-4">
        <h1 class="text-gray-800"><?= $judul ?></h1>
        <div class="form">
            <i class="fa fa-search"></i>
            <input type="text" name="search" class="form-control form-input" placeholder="Cari Pasien..." value="<?= isset($search) ? $search : '' ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </div>
</form>

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
                        <th>Ruang</th>
                        <th>Tanggal Masuk</th>
                        <th>Dirawat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                    if (!empty($pasien)):
                        foreach ($pasien as $p): ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td><?= $p['no_medis'] ?></td>
                                <td><?= $p['nama'] ?></td>
                                <td><?= $p['no_telp'] ?></td>
                                <td><?= $p['tanggal_lahir'] ?></td>
                                <td><?= $p['nama_ruang'] ?></td>
                                <td><?= $p['tanggal_masuk'] ?></td>
                                <td>
                                    <?php
                                    $tanggal_masuk = new DateTime($p['tanggal_masuk']);
                                    $tanggal_keluar = new DateTime();
                                    $lama_rawat = $tanggal_keluar->diff($tanggal_masuk)->days;
                                    echo $lama_rawat . ' hari';
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $no++;
                        endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Data Tidak Ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="container">
                <?= $pagination ?>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
    <!-- /.container-fluid -->

</div>
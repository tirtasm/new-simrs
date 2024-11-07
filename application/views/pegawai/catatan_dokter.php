
<div id="content-wrapper" class="td-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <form action="<?= base_url('dokter/catatan'); ?>" method="POST">
            <div class="mb-4">
                <h1 class="text-gray-800"><?= $judul ?></h1>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="col">
                        <input type="text" name="search" class="form-control form-input" placeholder="Cari Catatan Pasien..." value="<?= isset($search) ? $search : '' ?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Tindakan Pasien</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama Dokter</th>
                                    <th>Nama Pasien</th>
                                    <th>Ruang</th>
                                    <th>Tindakan</th>
                                    <th>Tanggal Tindakan</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($catatan)):
                                foreach ($catatan as $ct): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $ct['nama_pegawai'] ?></td>
                                            <td><?= $ct['nama'] ?></td>
                                            <td><?= !empty($ct['nama_ruang_igd']) ? $ct['nama_ruang_igd'] : $ct['nama_ruang'] ?>
                                            </td>
                                            <td><?= $ct['nama_tindakan'] ?></td>
                                            <td><?= $ct['tanggal_tindakan'] ?></td>
                                            <td style="max-width:300px;">
                                                <?= $ct['catatan'] ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                    $no++;
                                endforeach; ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">Data Tidak Ditemukan</td>
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
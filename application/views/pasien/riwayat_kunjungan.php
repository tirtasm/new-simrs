<div id="content-wrapper" class="p-flex flex-column">

    <!-- Main Content -->

    <!-- Begin Page Content -->
    <div class="container-fluid">



        <!-- DataTales Example -->
        <div class="card shadow mb-4 mt-5 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Riwayat Kunjungan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>No. Medis</th>
                                <th>Nama</th>
                                <th>Ruang</th>
                                <th>Nama Dokter</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($kunjungan)):
                                foreach ($kunjungan as $p): ?>
                                    <tr>
                                        <td class="text-center"><?= $no ?></td>
                                        <td><?= $p['no_medis'] ?></td>
                                        <td><?= $p['nama'] ?></td>
                                        <td>
                                            <?php if ($p['nama_ruang_igd']): ?>
                                                <?= $p['nama_ruang_igd'] ?>
                                            <?php else: ?>
                                                <?= $p['nama_ruang'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $p['nama_pegawai'] ?></td>
                                        <td><?= $p['tanggal_visite'] ?></td>
                                        <td style="max-width:300px;"><?= $p['catatan'] ?></td>
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
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.container-fluid -->

</div>
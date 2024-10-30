<div id="content-wrapper" class="p-flex flex-column">

    <!-- Main Content -->

    <!-- Begin Page Content -->
    <div class="container-fluid">



        <!-- DataTales Example -->
        <div class="card shadow mb-4 mt-5 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Rawat Inap</h6>
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
                                        <td>
                                            <?php if ($p['nama_ruang_igd']): ?>
                                                <?= $p['nama_ruang_igd'] ?>
                                            <?php else: ?>
                                                <?= $p['nama_ruang'] ?>
                                            <?php endif; ?>
                                        </td>
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
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.container-fluid -->

</div>
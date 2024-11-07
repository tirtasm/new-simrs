<div id="content-wrapper" class="p-flex flex-column">

    <!-- Main Content -->

    <!-- Begin Page Content -->
    <div class="container-fluid">



        <!-- DataTales Example -->
        <div class="card shadow mb-4 mt-5 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Tindakan Medis</h6>
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
                                <th>Tindakan</th>
                                <th>Tanggal Tindakan</th>
                                <th>Catatan</th>
                                <th>Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($tindakan_medis)):
                                foreach ($tindakan_medis as $tm): ?>
                                    <tr>
                                        <td class="text-center"><?= $no ?></td>
                                        <td><?= $tm['no_medis'] ?></td>
                                        <td><?= $tm['nama'] ?></td>
                                        <td><?= !empty($tm['nama_ruang_igd']) ? $tm['nama_ruang_igd'] : $tm['nama_ruang'] ?>
                                            </td>
                                        <td><?= $tm['nama_pegawai'] ?></td>
                                        <td><?= $tm['nama_tindakan'] ?></td>
                                        <td><?= $tm['tanggal_tindakan'] ?></td>
                                        <td style="max-width:300px;"><?= $tm['catatan'] ?></td>
                                        <td style="min-width:120px;"><?= 'Rp ' . number_format($tm['biaya'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php
                                    $no++;
                                endforeach; ?>
                                <tr>
                                    <td colspan="8" class="text-center">Jumlah Biaya</td>

                                    <td style="min-width:120px;">
                                        <?php
                                        $total = 0;
                                        foreach ($tindakan_medis as $tm) {
                                            $total += $tm['biaya'];
                                        }
                                        echo 'Rp ' . number_format($total, 0, ',', '.');
                                        ?>
                                    
                                    </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">Data Tidak Ditemukan</td>
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
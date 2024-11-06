<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <form action="<?= base_url('pegawai/tindakan'); ?>" method="POST">
                <div class="mb-4">
                    <h1 class="text-gray-800"><?= $judul ?></h1>
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="col">
                            <input type="text" name="search" class="form-control form-input" placeholder="Cari Tindakan Pasien..." value="<?= isset($search) ? $search : '' ?>">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="tindakanflash" data-tindakan-success="<?= $this->session->flashdata('tindakan_success'); ?>" data-tindakan-failed="<?= $this->session->flashdata('tindakan_failed'); ?>"></div>
            <div class="btn btn-primary mb-3 btnTindakanDokter" data-toggle="modal" data-target="#tindakanDokterModal">Tindakan Pasien</div>
            <!-- DataTales Example -->
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
                                    <th>Nama Pasien</th>
                                    <th>Nama Dokter</th>
                                    <th>Ruang</th>
                                    <th>Tindakan</th>
                                    <th>Tanggal Tindakan</th>
                                    <th>Biaya</th>
                                    <th>Catatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                                if (!empty($v_tindakan)):
                                    foreach ($v_tindakan as $td): ?>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $td['nama'] ?></td>
                                            <td><?= $td['nama_pegawai'] ?></td>
                                            <td><?= $td['nama_ruang_igd'] ?: $td['nama_ruang'] ?></td>
                                            <td><?= $td['nama_tindakan'] ?></td>
                                            <td><?= $td['tanggal_tindakan'] ?></td>
                                            <td style="min-width:120px;" class="text-center"><?= 'Rp ' . number_format($td['biaya'], 0, ',', '.') ?></td>
                                            <td style="max-width:300px;"><?= $td['catatan'] ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('pegawai/editTindakan/') . $td['id_tindakan_pasien'] ?>" data-toggle="modal" data-target="#tindakanDokterModal" class="badge badge-warning tindakanDokterModal" data-id="<?= $td['id_tindakan_pasien'] ?>">Edit</a>
                                                <a href="<?= base_url('pegawai/deleteTindakan/') . $td['id_tindakan_pasien'] ?>" class="badge badge-danger delete">Delete</a>
                                            </td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php endforeach; ?>
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
            <div class="container">
                <?= $pagination ?>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- Modal -->
<div class="modal fade" id="tindakanDokterModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanDokterModalLabel">Tindakan Dokter</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('pegawai/addtindakan') ?>" method="post">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 align-items-center">
                            <div class="mb-3">
                                <label for="nama_pegawai" class="form-label">Nama Dokter</label>
                                <input type="hidden" id="id_visite" name="id_visite">
                                <input type="hidden" id="id_tindakan_pasien" name="id_tindakan_pasien">
                                <input type="hidden" id="no_pegawai" name="no_pegawai" value="<?= $user['no_pegawai'] ?>">
                                <input type="text" id="nama_pegawai" name="nama_pegawai" class="form-control" value="<?= $user['nama_pegawai'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                <select name="nama_pasien" id="nama_pasien" class="form-control" required>
                                    <option disabled selected hidden>---Pilih Nama Pasien---</option>
                                    <?php if (!empty($pasien)): ?>
                                        <?php foreach ($pasien as $p): ?>
                                            <option value="<?= $p['id_pasien'] ?>" data-ruang="<?= $p['nama_ruang'] ?>" data-id_ruang="<?= $p['id_ruang'] ?>" data-ruang_igd="<?= $p['nama_ruang_igd'] ?>" data-id_ruang_igd="<?= $p['id_ruang_igd'] ?>" data-id_pelayanan="<?= $p['id_pelayanan'] ?>"><?= $p['nama'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option disabled>Data Pasien Kosong</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ruang" class="form-label">Nama Ruang</label>
                                <input type="hidden" id="id_pelayanan" name="id_pelayanan" class="form-control" readonly>
                                <input type="hidden" id="id_ruang" name="id_ruang" class="form-control" readonly>
                                <input type="hidden" id="id_ruang_igd" name="id_ruang_igd" class="form-control" readonly>
                                <input type="text" id="ruang" name="ruang" class="form-control" readonly>
                                <input type="text" id="ruang_igd" name="ruang_igd" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="id_tindakan" class="form-label">Nama Tindakan</label>
                                <select name="id_tindakan" id="id_tindakan" class="form-control" required>
                                    <option disabled selected hidden>---Pilih Tindakan---</option>
                                    <?php if (!empty($tindakan)): ?>
                                        <?php foreach ($tindakan as $t): ?>
                                            <option value="<?= $t['id_tindakan'] ?>" data-biaya="<?= $t['biaya'] ?>"><?= $t['nama_tindakan'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option disabled>Data Tindakan Kosong</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_tindakan" class="form-label">Tanggal Tindakan</label>
                                <input type="date" name="tanggal_tindakan" id="tanggal_tindakan" class="form-control" value="<?= date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="biaya" class="form-label">Biaya</label>
                                <input type="text" name="biaya" id="biaya" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('id_tindakan').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('biaya').value = selectedOption.getAttribute('data-biaya');
    });

    document.getElementById('nama_pasien').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('ruang').value = selectedOption.getAttribute('data-ruang') || selectedOption.getAttribute('data-ruang_igd') || '';
        document.getElementById('id_ruang').value = selectedOption.getAttribute('data-id_ruang') || '';
        document.getElementById('id_ruang_igd').value = selectedOption.getAttribute('data-id_ruang_igd') || '';
        document.getElementById('id_pelayanan').value = selectedOption.getAttribute('data-id_pelayanan') || '';
    });
</script>
<script src="<?= base_url('assets/js/pegawai.js') ?>"></script>

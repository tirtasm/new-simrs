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

    .disabled-select {
        background-color: #e9ecef;
        opacity: 0.65;
        cursor: not-allowed;
    }
</style>
<div id="content-wrapper" class="p-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <form action="<?= base_url('dokter/visite'); ?>" method="POST">
    <div class="mb-4">
        <h1 class="text-gray-800"><?= $judul ?></h1>
        <div class="form">
            <i class="fa fa-search"></i>
            <input type="text" name="search" class="form-control form-input" placeholder="Cari Visite Pasien..." value="<?= isset($search) ? $search : '' ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </div>
</form>
            <div class="btn btn-primary mb-3 btnVisite" data-toggle="modal" data-target="#visiteModal">Visite</div>

            <div class="visiteflash" data-visite-added="<?= $this->session->flashdata('visite_success'); ?>"
                data-visite-failed="<?= $this->session->flashdata('visite_failed'); ?>"></div>

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
                                    <th>Nama Pasien</th>
                                    <th>Nama Ruang</th>
                                    <th>Nama Dokter</th>
                                    <th>Tanggal Visite</th>
                                    <th class="text-center">Catatan</th>
                                    <th class="text-center">Aksi</th>

                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($v_pasien)):
                                foreach ($v_pasien as $p): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $p['no_medis'] ?></td>
                                            <td><?= $p['nama'] ?></td>
                                            <td><?= $p['nama_ruang'] ?></td>
                                            <td><?= $p['nama_dokter'] ?></td>
                                            <td><?= $p['tanggal_visite'] ?></td>
                                            <td style="max-width:300px;">
                                                <?= $p['catatan'] ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('dokter/editvisite/') . $p['id_visite'] ?>"
                                                    class="badge badge-warning visiteModal" data-toggle="modal"
                                                    data-target="#visiteModal" data-id="<?= $p['id_visite'] ?>">Edit</a>
                                                <a href="<?= base_url('dokter/deletevisite/') . $p['id_visite'] ?>"
                                                    class="badge badge-danger delete">Hapus</a>
                                            </td>



                                        </tr>
                                    </tbody>
                                    <?php
                                    $no++;
                                endforeach; ?>
                            <?php else: ?>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center"> Tidak Ada Catatan</td>
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


<!-- Modal -->
<div class="modal fade" id="visiteModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visiteModalLabel">Visite Dokter</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('dokter/addvisite') ?>" method="post">
                    <div class="row justify-content-center">

                        <div class="col-lg-10 align-items-center ">

                            <div class="mb-3">
                                <label for="nama_dokter" class="form-label">Nama Dokter</label>
                                <input type="hidden" id="id_visite" name="id_visite">
                                <input type="hidden" id="no_dokter" name="no_dokter" value="<?= $user['no_dokter'] ?>">
                                <input type="text" id="nama_dokter" name="nama_dokter" class="form-control"
                                    value="<?= $user['nama_dokter'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                <div class="d-flex">
                                    <select name="nama_pasien" id="nama_pasien" class="form-control" required>
                                        <option value="" disabled selected hidden>---Pilih Nama Pasien---</option>
                                        <?php if (!empty($pasien)): ?>
                                            <?php foreach ($pasien as $p): ?>
                                                <option value="<?= $p['id_pasien'] ?>" data-nomor="<?= $p['no_telp'] ?>"
                                                    data-ruang="<?= $p['nama_ruang'] ?>" data-id_ruang="<?= $p['id_ruang'] ?>">
                                                    <?= $p['nama'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled>Data Pasien Kosong</option>
                                        <?php endif; ?>
                                    </select>

                                </div>
                            </div>
                            <script>

                            </script>

                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No Telp Pasien</label>
                                <input type="text" id="no_telp" name="no_telp" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="ruang" class="form-label">Nama Ruang</label>
                                <input type="hidden" id="id_ruang" name="id_ruang" class="form-control" readonly>
                                <input type="text" id="ruang" name="ruang" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_visite" class="form-label">Tanggal Visite</label>
                                <input type="date" name="tanggal_visite" id="tanggal_visite" class="form-control"
                                    value="<?= date('Y-m-d'); ?>">

                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control" rows="4"></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const selectPasien = document.getElementById('nama_pasien');
    const nomorTelp = document.getElementById('no_telp');
    const ruang = document.getElementById('ruang');
    const ruangId = document.getElementById('id_ruang');

    selectPasien.addEventListener('change', function () {
        const selectedOption = selectPasien.options[selectPasien.selectedIndex];
        const nomor = selectedOption.getAttribute('data-nomor');
        const ruangValue = selectedOption.getAttribute('data-ruang');
        const ruangValueId = selectedOption.getAttribute('data-id_ruang');       
        

        if (ruang && nomor) {
            nomorTelp.value = nomor;
            ruang.value = ruangValue;
            ruangId.value = ruangValueId;
        } else {
            nomorTelp.value = '';
            ruang.value = '';
        }
    });
    


</script>
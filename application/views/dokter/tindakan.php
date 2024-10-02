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
<div id="content-wrapper" class="td-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <form action="<?= base_url('admin/data_dokter'); ?>" method="POST">
                <div class="mb-4">
                    <h1 class="text-gray-800"><?= $judul ?></h1>
                    <div class="form">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control form-input" placeholder="Cari Pasien...">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>


            <!-- <div class="dokter-flash" data-dokterflash="<?= $this->session->flashdata('menu_flash'); ?>" data-submenu_added="<?= $this->session->flashdata('submenu_added'); ?>" data-submenu_failed="<?= $this->session->flashdata('submenu_failed'); ?>"></div> -->
            <div class="btn btn-primary mb-3 btnVisite" data-toggle="modal" data-target="#tindakanModal">Tindakan Pasien
            </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Table Tindakan Pasien</h6>
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
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($v_tindakan)):
                                foreach ($v_tindakan as $td): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $td['nama'] ?></td>
                                            <td><?= $td['nama_dokter'] ?></td>
                                            <td><?= $td['nama_ruang'] ?></td>
                                            <td><?= $td['nama_tindakan'] ?></td>
                                            <td><?= $td['tanggal_tindakan'] ?></td>
                                            <td style="max-width:300px;">
                                                <?= $td['catatan'] ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('dokter/editTindakan/') . $td['id_tindakan_pasien'] ?>"
                                                    class="badge badge-warning">Edit</a>
                                                <a href="<?= base_url('dokter/deleteTindakan/') . $td['id_tindakan_pasien'] ?>"
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
<!-- Modal -->
<div class="modal fade" id="tindakanModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanModalLabel">Tindakan Dokter</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('dokter/addtindakan') ?>" method="post">
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
                                        <option  disabled selected hidden>---Pilih Nama Pasien---</option>
                                        <?php if (!empty($pasien)): ?>
                                            <?php foreach ($pasien as $p): ?>
                                                <option value="<?= $p['id_pasien'] ?>" 
                                                    data-ruang="<?= $p['nama_ruang'] ?>" data-id_ruang="<?= $p['id_ruang'] ?>" data-id_rawat="<?=$p['id_rawat']?>">  
                                                    <?= $p['nama'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled>Data Pasien Kosong</option>
                                        <?php endif; ?>
                                    </select>

                                </div>
                            </div>
                

                            <div class="mb-3">
                                <label for="ruang" class="form-label">Nama Ruang</label>
                                <input type="hidden" id="id_rawat" name="id_rawat" class="form-control" readonly>
                                <!-- <input type="hidden" id="id_ruang" name="id_ruang" class="form-control" readonly> -->
                                <input type="text" id="ruang" name="ruang" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="id_tindakan" class="form-label">Nama Tindakan</label>
                                <div class="d-flex">
                                    <select name="id_tindakan" id="id_tindakan" class="form-control" required>
                                        <option  disabled selected hidden>---Pilih Nama Tindakan---</option>
                                        <?php if (!empty($tindakan)): ?>
                                            <?php foreach ($tindakan as $td): ?>
                                                <option value="<?= $td['id_tindakan'] ?>">
                                                    <?= $td['nama_tindakan'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled>Data Pasien Kosong</option>
                                        <?php endif; ?>
                                    </select>

                                </div>
                            </div>
                
                            <div class="mb-3">
                                <label for="tanggal_tindakan" class="form-label">Tanggal Tindakan</label>
                                <input type="date" name="tanggal_tindakan" id="tanggal_tindakan" class="form-control"
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
    const ruang = document.getElementById('ruang');
    const ruangId = document.getElementById('id_ruang');
    const rawatId = document.getElementById('id_rawat');
    
    selectPasien.addEventListener('change', function () {
        const selectedOption = selectPasien.options[selectPasien.selectedIndex];
        const ruangValue = selectedOption.getAttribute('data-ruang');
        const ruangValueId = selectedOption.getAttribute('data-id_ruang');  
        const rawatValueId = selectedOption.getAttribute('data-id_rawat');
        rawatId.value = rawatValueId;
        ruang.value = ruangValue;
        ruangId.value = ruangValueId;
    });
    
</script>
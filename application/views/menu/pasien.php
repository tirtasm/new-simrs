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

            <form action="<?= base_url('menuadmin/getpasieninap'); ?>" method="POST">
                <div class="mb-4">
                    <h1 class="text-gray-800"><?= $judul ?></h1>
                    <div class="form">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control form-input" placeholder="Cari Pasien...">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>


            <div class="btn btn-primary mb-3 btnEdit" data-toggle="modal" data-target="#pasienModal">Tambah Pasien Masuk</div>
            <div class="pasienflash" data-pasien-flash="<?= $this->session->flashdata('pasienflash'); ?>"
                data-error-flash="<?= $this->session->flashdata('errorflash'); ?>"></div>

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
                                    <th class="text-center">Tanggal Lahir</th>
                                    <th>Ruang</th>
                                    <th class="text-center">Tanggal Masuk</th>
                                    <th class="text-center">Tanggal Keluar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if (!empty($pasien)):
                                foreach ($pasien as $p): ?>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td><?= $p['no_medis'] ?></td>
                                            <td><?= $p['nama'] ?></td>
                                            <td><?= $p['no_telp'] ?></td>
                                            <td class="text-center"><?= $p['tanggal_lahir'] ?></td>
                                            <td><?= $p['nama_ruang'] ?></td>
                                            <td class="text-center"><?= $p['tanggal_masuk'] ?></td>

                                            <!-- <td><?= $p['tanggal_keluar'] ?></td> -->
                                            <?php
                                            if ($p['tanggal_keluar'] == null) {
                                                echo '<td class="text-center"><a href="' . base_url('menuadmin/keluar/') . $p['id_pasien'] . '" class="badge keluar badge-danger">keluar</a></td>';
                                            } else {
                                                echo '<td class="text-center"> <span class="text-success">' . $p['tanggal_keluar'] . ' </span> </td>';
                                            }
                                            ?>
                                            <td class="text-center">
                                                <a href="<?= base_url('menuadmin/edit/') . $p['id_pasien'] ?>"
                                                    class="badge badge-warning pasienModal" data-toggle="modal"
                                                    data-target="#pasienModal" data-id="<?= $p['id_pasien'] ?>">Edit</a>
                                            </td>
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

<!-- Modal -->
<div class="modal fade" id="pasienModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pasienModalLabel">Tambah Pasien Masuk</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('menuadmin/add') ?>" method="post">
                    <div class="row justify-content-center">

                        <div class="col-lg-10 align-items-center ">

                            <div class="mb-3">
                                <input type="hidden" id="id_pasien" name="id_pasien">
                                <label for="pasien" class="form-label">Nama Pasien</label>
                                <div class="d-flex">
                                    <select name="pasien" id="pasien" class="form-control ">
                                        <option>---Pilih Nama Pasien---</option>
                                        <?php if (!empty($pasien_not_inap)): ?>
                                            <?php foreach ($pasien_not_inap as $p): ?>

                                                <option value="<?= $p['id_pasien'] ?>" data-nomor="<?= $p['no_telp'] ?>">
                                                    <?= $p['nama'] ?>
                                                </option>

                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled>Data Pasien Kosong</option>
                                        <?php endif; ?>

                                    </select>

                                    <select name="v_pasien" id="v_pasien" class="form-control " required>
                                        <option>---Pilih Nama Pasien---</option>
                                        <?php foreach ($pasien as $p): ?>

                                            <option value="<?= $p['id_pasien'] ?>" data-nomor="<?= $p['no_telp'] ?>">
                                                <?= $p['nama'] ?>
                                            </option>

                                        <?php endforeach; ?>

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
                                <label for="role" class="form-label">Nama Ruang</label>
                                <div class="d-flex">

                                    <select name="ruang" id="ruang" class="form-control d-flex justify-content-between"
                                        required>
                                        <?php if (empty($ruang) || array_sum(array_column($ruang, 'kapasitas')) == 0): ?>
                                            <option value="">---Tidak Ada Ruang Tersedia---</option>
                                        <?php else: ?>
                                            <option value="">---Pilih Ruang---</option>
                                            <?php foreach ($ruang as $r): ?>
                                                <?php if ($r['kapasitas'] > 0): ?>
                                                    <option value="<?= $r['id_ruang'] ?>" data-kapasitas="<?= $r['kapasitas'] ?>">
                                                        <?= $r['nama_ruang'] ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div id="kapasitas-info" class="btn badge-success px-3 ml-2">Kapasitas</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                                    value="<?= date('Y-m-d'); ?>">

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

    const selectPasien = document.getElementById('pasien');
    const nomorTelp = document.getElementById('no_telp');
    selectPasien.addEventListener('change', function () {
        const selectedOption = selectPasien.options[selectPasien.selectedIndex];
        const nomor = selectedOption.getAttribute('data-nomor');
        console.log(nomor);


        if (nomor) {
            nomorTelp.value = nomor;
        } else {
            nomorTelp.value = '';
        }
    });


</script>
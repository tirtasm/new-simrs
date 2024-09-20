`<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">


            <h1 class="h3 mb-4 text-gray-800"><?= $judul ?></h1>

            <!-- <div class="dokter-flash" data-dokterflash="<?= $this->session->flashdata('menu_flash'); ?>" data-submenu_added="<?= $this->session->flashdata('submenu_added'); ?>" data-submenu_failed="<?= $this->session->flashdata('submenu_failed'); ?>"></div> -->

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Table Dokter</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>No. Dokter</th>
                                    <th>Nama</th>
                                    <th>Spesialisasi</th>
                                    <th>No. Telp</th>
                                    <th class="text-center">Aktif?</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $no = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;
                            if(!empty($dokter)):
                            foreach ($dokter as $d): ?>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?= $no ?></td>
                                        <td><?= $d['no_dokter'] ?></td>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= $d['spesialisasi'] ?></td>
                                        <td>0<?= $d['no_telp'] ?></td>



                                        <td class="text-center">
                                            <button class="toggle-status bg-transparent border-0"
                                                data-id="<?= $d['no_dokter']; ?>"
                                                data-is-active="<?= $d['is_active'] == 1 ? 'true' : 'false'; ?>">
                                                <?= $d['is_active'] == 1 ? '<i class="fas fa-xl text-success fa-thin fa-check"></i>' : '<i class="fas fa-xl text-danger fa-thin fa-xmark"></i>'; ?>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/deletedokter/') . $d['no_dokter'] ?>"
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
                    <?= $pagination?>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        
    </div>
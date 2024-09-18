<body class="bg-gradient-primary">
    <div class="container min-vh-100 align-content-center">
        <div class="row justify-content-center">

            <div class="col-lg-5">


                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">

                            <div class="col">
                                <div class="px-5 py-4">
                                    <h5 class="text-center mt-2 mb-4 text-dark font-weight-bold">LOGIN</h5>

                                    <?= $this->session->flashdata('no_medis') ?>
                                    <div id="loginflash"
                                        data-login-success="<?= $this->session->flashdata('login_success'); ?>"
                                        data-login-error="<?= $this->session->flashdata('login_error'); ?>"></div>

                                    <form method="post">
                                        <div class="col mb-2"> <label>No. Registrasi Medis<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="no_medis" name="no_medis" class="form-control"
                                                value="<?= set_value('no_medis') ?>">
                                            <?= form_error('no_medis', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="col mb-2"> <label>Tanggal Lahir<span
                                                    class="text-danger">*</span></label>
                                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                                class="form-control" value="<?= set_value('tanggal_lahir') ?>">
                                            <?= form_error('tanggal_lahir', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" id="btnLogin"
                                                class="btn btn-primary btn-block btnLogin">
                                                Login
                                            </button>
                                        </div>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url() ?>auth/forgotpassword">Lupa Kata Sandi?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url() ?>auth/registrasi">Daftar Akun
                                            Pasien!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
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
                                    <h5 class="text-center mt-2 mb-4 text-dark font-weight-bold">Halo Pegawai!</h5>

                                    
                                    <div id="flashdata" data-login-success="<?= $this->session->flashdata('login_success'); ?>" data-login-error="<?= $this->session->flashdata('login_error'); ?>"></div>
                                    
                                    
                                        

                                    <form method="post">
                                        <div class="col mb-2"> <label>No. Pegawai<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="no_pegawai" name="no_pegawai" class="form-control"
                                                value="<?= set_value('no_pegawai') ?>">
                                            <?= form_error('no_pegawai', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="col mb-2"> <label>Password<span
                                                    class="text-danger">*</span></label>
                                            <input type="password" id="password" name="password"
                                                class="form-control" value="<?= set_value('password') ?>">
                                            <?= form_error('password', '<small class="text-danger pl-2">', '</small>'); ?>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" id="btnLogin"
                                                class="btn btn-primary btn-block btnLogin">
                                                Login
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
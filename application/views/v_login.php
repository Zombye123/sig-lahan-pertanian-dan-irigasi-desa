<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SIG Lahan Pertanian</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
    
    <style>
        body.login-page { 
            background: linear-gradient(rgba(11, 26, 43, 0.85), rgba(11, 26, 43, 0.85)), 
                        url('https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }
        .card { border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .card-header { background: #17a2b8 !important; color: white; }
    </style>
</head>
<body class="hold-transition login-page">

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header text-center">
                        <h3 class="card-title w-100 font-weight-bold">
                            <i class="fas fa-lock mr-2"></i> LOGIN USER
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (validation_errors()) {
                            echo '<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-ban"></i> ' . validation_errors() . '
                                  </div>';
                        }
                        if ($this->session->flashdata('pesan')) {
                            echo '<div class="alert alert-info alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-info-circle"></i> ' . $this->session->flashdata('pesan') . '
                                  </div>';
                        }
                        echo form_open('auth/login'); 
                        ?>
                        
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-key"></i> Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="reset" class="btn btn-outline-secondary btn-block">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
</body>
</html>
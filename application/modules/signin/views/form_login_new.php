<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
  <title>Login - Sistem Data Perekonomian Sumatera Barat</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url('assets/espire/assets/images/logo/favicon.png'); ?>">

  <!-- plugins css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/espire/bower_components/bootstrap/dist/css/bootstrap.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/espire/bower_components/PACE/themes/blue/pace-theme-minimal.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/espire/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css'); ?>" />

  <!-- core css -->
  <link href="<?php echo base_url('assets/espire/assets/css/ei-icon.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/espire/assets/css/themify-icons.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/espire/assets/css/font-awesome.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/espire/assets/css/animate.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/espire/assets/css/app.css'); ?>" rel="stylesheet">
</head>

<body>
  <div class="app">
    <div class="authentication">
      <div class="sign-in-2">
        <div class="container-fluid no-pdd-horizon bg" style="background-image: url(<?php echo base_url('assets/espire/assets/images/others/img-30.jpg'); ?>)">
          <div class="row">
            <div class="col-md-10 mr-auto ml-auto">
              <div class="row">
                <div class="mr-auto ml-auto full-height height-100">
                  <div class="vertical-align full-height">
                    <div class="table-cell">
                      <div class="card">
                        <div class="card-body">
                          <div class="pdd-horizon-15 pdd-vertical-10">
                            <div class="mrg-btm-30">
                                  <img class="img-responsive inline-block pdd-right-10 border right" src="<?php echo base_url('assets/img/logosumbar.png'); ?>" width="80px" height="80px" alt="">
                                  <h1 class="inline-block pull-right no-mrg-vertical pdd-left-10">Sistem Informasi <br> Data Perekonomian</h1>
                            </div>
                            <!-- <p class="mrg-btm-15 font-size-13 text-center">Input Username and Password </p> -->
                            <?php echo form_open(site_url('signin/login'), array('class' => 'ng-pristine ng-valid', 'role' => 'form')); ?>
                            <div class="form-group">
                              <input type="text" class="form-control" placeholder="User name" name="username" id="username" value="<?php echo set_value('username'); ?>">
                              <?php echo form_error('username'); ?>
                            </div>
                            <div class="form-group">
                              <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                              <?php echo form_error('password'); ?>
                            </div>
                            <div class="mrg-top-10 checkbox font-size-13 inline-block no-mrg-vertical no-pdd-vertical">
                              <input id="agreement" name="agreement" type="checkbox">
                              <label for="agreement">Keep Me Signed In</label>
                            </div>
                            <div class="pull-right">
                              <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Login">
                            </div>
                            <div class="mrg-top-20 text-right">
                              <!-- <button class="btn btn-info">Login</button> -->
                              <!-- <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Login"> -->
                              <small>Copyright ©2021 | <a>Diskominfo Provinsi SUMBAR</a></small>
                            </div>
                            <?php echo form_close(); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- build:js assets/js/vendor.js -->
  <!-- plugins js -->
  <script src="<?php echo base_url('assets/espire/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/espire/bower_components/popper.js/dist/umd/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/espire/bower_components/bootstrap/dist/js/bootstrap.js'); ?>"></script>
  <script src="<?php echo base_url('assets/espire/bower_components/PACE/pace.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/espire/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.js'); ?>"></script>
  <!-- endbuild -->

  <!-- build:js assets/js/app.min.js -->
  <!-- core js -->
  <script src="<?php echo base_url('assets/espire/assets/js/app.js'); ?>"></script>
  <!-- endbuild -->

  <!-- page js -->

</body>

</html>
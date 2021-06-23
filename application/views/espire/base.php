<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <title><?php echo $page_name . " | " . $app_name; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">

    <!-- plugins css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/espire/bower_components/bootstrap/dist/css/bootstrap.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/espire/bower_components/PACE/themes/blue/pace-theme-minimal.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/espire/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css'); ?>" />

    <!-- page plugins css -->

    <!-- core css -->
    <link href="<?php echo base_url('assets/espire/assets/css/ei-icon.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/espire/assets/css/themify-icons.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/espire/assets/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/espire/assets/css/animate.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/espire/assets/css/app.css'); ?>" rel="stylesheet">

</head>

<body class="side-nav-dark">
    <div class="app">
        <div class="layout">

            <?php
            $this->load->view($sidebar);
            ?>

            <!-- Page Container START -->
            <div class="page-container">

                <?php
                $this->load->view($header);
                ?>

                <?php
                $this->load->view($content);
                ?>


                <?php
                $this->load->view($footer);
                ?>

                

            </div>
            <!-- Page Container END -->

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

    <!-- Insert your dependencies here -->

</body>

</html>
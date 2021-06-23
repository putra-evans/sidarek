<!DOCTYPE html>
<html>

<head>
    <?php echo $template['partials']['header']; ?>
</head>

<body class="side-nav-dark">
    <div class="app">
        <div class="layout">
            <!-- Side Nav START -->
            <?php echo $template['partials']['navigation']; ?>
            <!-- Side Nav END -->

            <!-- Page Container START -->
            <div class="page-container">
                <!-- Header START -->
                <div class="header navbar">
                    <div class="header-container">
                        <ul class="nav-left">
                            <li>
                                <a class="side-nav-toggle" href="javascript:void(0);">
                                    <i class="ti-view-grid"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                    <img class="profile-img img-fluid" src="<?php echo base_url('assets/espire/assets/images/user.jpg'); ?>" alt="">
                                    <div class="user-info">
                                        <span class="name pdd-right-5"><?php echo $this->app_loader->current_name(); ?></span>
                                        <i class="ti-angle-down font-size-10"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="">
                                            <i class="ti-settings pdd-right-10"></i>
                                            <span>Setting</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="ti-user pdd-right-10"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="ti-email pdd-right-10"></i>
                                            <span>Inbox</span>
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="<?php echo site_url('signin/logout') ?>">
                                            <i class="ti-power-off pdd-right-10"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Header END -->

                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="container-fluid">
                        <!-- Your content goes here -->

                        <?php echo $template['body']; ?>

                    </div>
                </div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <?php echo $template['partials']['footer']; ?>
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->

        </div>
    </div>

    <!-- build:js assets/js/vendor.js -->

    <?php echo $template['partials']['javascript']; ?>
    

</body>

</html>
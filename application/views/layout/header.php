<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Penggajian</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Penggajian</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> 
                        <span class="hidden-xs"><?php echo $this->session->userdata('nama') ?></span> <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><a href="<?php echo base_url('beranda/password') ?>"><i class="fa fa-lock"></i> Ubah Password</a></li>
                        <li class="header"><a href="<?php echo base_url('login/out') ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

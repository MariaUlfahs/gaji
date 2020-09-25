<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php if ($this->uri->segment(1)=='beranda') echo "active" ?>"><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> <span>Beranda</span></a></li>
            <li class="treeview <?php if ($this->uri->segment(1)=='master') echo "active" ?>">
                <a href="#">
                    <i class="fa fa-desktop"></i><span>Master</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
				    <li><a href="<?php echo base_url('master/karyawan') ?>"><i class="fa fa-circle-o"></i>Karyawan</a></li>
                    <li><a href="<?php echo base_url('master/jabatan') ?>"><i class="fa fa-circle-o"></i>Jabatan</a></li>
					<li><a href="<?php echo base_url('master/bagijabatan') ?>"><i class="fa fa-circle-o"></i>Pembagian Jabatan</a></li>
                    <li><a href="<?php echo base_url('master/jenistambahan') ?>"><i class="fa fa-circle-o"></i>Tambahan</a></li>
                
                    
                    
                </ul>
            </li>
            <li class="treeview <?php if ($this->uri->segment(1)=='transaksi') echo "active" ?>">
                <a href="#">
                    <i class="fa fa-money"></i><span>Transaksi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('transaksi/gaji') ?>"><i class="fa fa-circle-o"></i>Penggajian</a></li>
				<!--	<li><a href="<?php echo base_url('transaksi/penggajian') ?>"><i class="fa fa-circle-o"></i>Data Penggajian</a></li> -->
                </ul>
            </li>
            <li class="treeview <?php if ($this->uri->segment(1)=='laporan') echo "active" ?>">
                <a href="#">
                    <i class="fa fa-book"></i><span>Laporan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('laporan/penggajian') ?>"><i class="fa fa-circle-o"></i>Laporan Penggajian</a></li>
            <!--	<li><a href="<?php echo base_url('laporan/pembayaransiswa') ?>"><i class="fa fa-circle-o"></i>Pembayaran Per Mahasiswa</a></li>
                    <li><a href="<?php echo base_url('laporan/tunggakan') ?>"><i class="fa fa-circle-o"></i>Tunggakan Pembayaran</a></li>
                    <li><a href="<?php echo base_url('laporan/rekappendapatan') ?>"><i class="fa fa-circle-o"></i>Rekap Pendapatan</a></li>
                    <li><a href="<?php echo base_url('laporan/rekapdebitur') ?>"><i class="fa fa-circle-o"></i>Rekap Pendapatan Debitur</a></li>
			-->	
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

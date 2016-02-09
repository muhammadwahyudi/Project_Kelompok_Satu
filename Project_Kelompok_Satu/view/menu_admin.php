<!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <div class="user-details">
                        <div class="pull-left">
                            <img src="images/users/avatar-1.jpg" alt="" class="thumb-md img-circle">
                        </div>
                        <div class="user-info">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['s_nama']; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="profile.php"><i class="md md-face-unlock"></i> Profil<div class="ripple-wrapper"></div></a></li>
                                    <li><a href="?url=logout"><i class="md md-settings-power"></i> Logout</a></li>
                                </ul>
                            </div>

                            <p class="text-muted m-0">Pegawai gudang</p>
                    <div id="sidebar-menu">
                        <ul>
                            <li>
                                <a href="index_admin.php" class="waves-effect"><i class="ion ion-ios7-home"></i><span> Beranda </span></a>
                            </li>
                            <li>
                                <a href="barang.php" class="waves-effect"><i class="ion ion-android-folder"></i><span> Data Barang </span></a>
                            </li>
                            <li>
                                <a href="transaksi.php" class="waves-effect"><i class="ion ion-android-folder"></i><span> Transaksi </span></a>
                            </li>
                            <li>
                                <a href="pembelian.php" class="waves-effect"><i class="ion ion-android-inbox"></i><span> Pembelian </span></a>
                            </li>
                            <li>
                                <a href="penjualan.php" class="waves-effect"><i class="ion ion-android-inbox"></i><span> Penjualan </span></a>
                            </li>
                            <li>
                                <a href="admin.php" class="waves-effect"><i class="ion ion-person-add"></i><span> Tambah Admin </span></a>
                            </li>
                        </ul>
                    </div>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End --> 
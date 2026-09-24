<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../home_dosen/" class="nav-link 
             <?php if ($hal == 'beranda_dosen') {
                echo 'active';
             } ?>
             ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Beranda</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="../kelas_matkul_dosen/" class="nav-link 
             <?php if ($hal == 'kelas_dosen') {
                echo 'active';
             } ?>
             ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Kelas Matkul</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="../dosen_ganti_password/" class="nav-link 
            <?= $aktif = ($hal == 'dosen_ganti_password') ? 'active' : '' ?> ">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>Ganti Password</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Keluar</p>
            </a>
          </li>
        </ul>
</nav>
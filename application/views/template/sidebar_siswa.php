   <!-- Sidebar -->
   <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
          <img src="img/logo/logo2.png">
        </div>
        <div class="sidebar-brand-text mx-3">E-learning</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="<?= site_url('siswa/index'); ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Beranda</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('siswa/ujian'); ?>">
          <i class="fas fa-fw fa-user-circle"></i>
          <span>Ujian</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('admin/kelas'); ?>">
          <i class="fas fa-fw fa-user-circle"></i>
          <span>Kelas</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('admin/nilai'); ?>">
          <i class="fas fa-fw fa-user-circle"></i>
          <span>Nilai</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('siswa/ubah_profil'); ?>">
          <i class="fas fa-fw fa-user-circle"></i>
          <span>Profil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('utama/logout'); ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Keluar</span>
        </a>
      </li>
    </ul>
    <!-- Sidebar -->
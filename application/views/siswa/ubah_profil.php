        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ubah Profil</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Ubah Profil</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Edit Ubah Profil</h6>
                </div>
                <?php if(isset($_SESSION['success'])) alert($_SESSION['success'],'success');?>
                <div class="row">
                  <div class="col-lg-6">
                    <form action="<?= site_url('siswa/update_ubah_profil/'.$admin->is_siswa);?>" method="post" class="p-3">
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Masukan Email" required value="<?= $admin->email; ?>">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Masukan Password" required>
                      </div>
                      <hr>
                      <div class="form-group">
                        <input type="text" class="form-control" name="nama" placeholder="Masukan Nip" value="<?= $siswa->nama; ?>">
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukan Nama" value="<?= $siswa->tempat_lahir; ?>">
                      </div>
                      <div class="form-group">
                        <input type="radio" name="jk" value="1" <?php if($siswa->jk == 1) { echo 'checked';} ?>>Laki - Laki
                        <input type="radio" name="jk" value="0" <?php if($siswa->jk == 0) { echo 'checked';} ?>>Perempuan
                      </div>
                      <div class="form-group">
                        <input type="date" class="form-control" name="tgl_lahir" placeholder="Masukan Tanggal Lahir" value="<?= $siswa->tgl_lahir; ?>">
                      </div>
                      <div class="form-group">
                        <textarea name="alamat" class="form-control" placeholder="Masukan Alamat"><?= $siswa->alamat; ?></textarea>
                      </div>
                      <div class="form-group">
                        <input type="file" class="form-control" name="foto">
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-secondary">Kirim</button>
                      </div>
                    </form>
                  </div>
                  <div class="col-lg-6">
                    <?php if ($siswa->foto != null) {?>
                        <img src="<?= base_url().$siswa->foto;?>" height="300" width="300">
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!--Row-->

        </div>
        <!---Container Fluid-->
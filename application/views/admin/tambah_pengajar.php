        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengajar</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pengajar</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Tambah Akun Pengajar</h6>
                </div>
                <?php if (isset($error)) { echo $error;}?>
                <div class="row">
                  <div class="col-lg-12">
                    <form action="<?= site_url('admin/insert_pengajar');?>" method="post" class="p-3" enctype="multipart/form-data">
                      <div class="form-group">
                        <input type="text" class="form-control" name="nip" placeholder="Masukan Nip" required>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="nama" placeholder="Masukan Nama" required>
                      </div>
                      <div class="form-group">
                        <input type="radio" name="jk" value="1">Laki - Laki
                        <input type="radio" name="jk" value="0">Perempuan
                      </div>
                      <div class="form-group">
                        <textarea name="alamat" class="form-control" required placeholder="Masukan Alamat"></textarea>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukan Tempat Lahir" required>
                      </div>
                      <div class="form-group">
                        <input type="date" class="form-control" name="tgl_lahir" placeholder="Masukan Tanggal Lahir" required>
                      </div>
                      <div class="form-group">
                        <input type="file" class="form-control" name="foto" required>
                      </div>
                      <div class="form-group">
                        <select name="mapel_id" class="form-control" required>
                        <?php foreach ($mapel as $n) {?>
                            <option value="<?= $n->id; ?>"><?= $n->nama; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <hr>
                      <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Masukan Email" required>
                      </div>
                      <div class="form-group">
                        <a href="<?= site_url('admin/pengajar');?>" class="btn btn-sm btn-primary">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-secondary">Kirim</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!--Row-->

        </div>
        <!---Container Fluid-->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mapel Ajar</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Mapel Ajar</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Tambah Mapel Ajar</h6>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <form action="<?= site_url('admin/insert_mapel_ajar');?>" method="post" class="p-3">
                      <div class="form-group">
                        <select name="kelas_id" class="form-control" required>
                          <option value="">-- Pilihan Kelas --</option>
                          <?php foreach ($kelas as $k) {?>
                            <option value="<?= $k->id; ?>"><?= $k->nama;?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <select name="mapel_id" class="form-control" required>
                        <option value="">-- Pilihan Mapel --</option>
                          <?php foreach ($mapel as $k) {?>
                            <option value="<?= $k->id; ?>"><?= $k->nama;?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <select name="hari" class="form-control" required>
                        <option value="">-- Pilihan Hari --</option>
                        <?php hari(); ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <a href="<?= site_url('admin/mapel');?>" class="btn btn-sm btn-primary">Kembali</a>
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
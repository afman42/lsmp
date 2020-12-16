        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ujian Kelas <?= $kelas->kelas_nama; ?></h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Ujian Siswa</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Tambah Ujian</h6>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <form action="<?= site_url('pengajar/insert_ujian_siswa/'.$kelas->id);?>" method="post" class="p-3">
                      <div class="form-group">
                        <label>Nama Ujian</label>
                        <select name="nama_ujian" class="form-control" required>
                          <option value="">-- Pilihan Nama Ujian --</option>
                          <option value="UTS">UTS</option>
                          <option value="UAS">UAS</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Jumlah Soal</label>
                        <input type="number" name="jsoal" class="form-control" placeholder="Masukan Jumlah Soal" required>
                      </div>
                      <div class="form-group">
                          <label>Menit</label>
                          <input type="number" name="menit" class="form-control" placeholder="Masukan Menit" required>
                      </div>
                      <div class="form-group">
                        <label>Tanggal Berakhir</label>
                        <input type="datetime-local" name="tgl_expired" class="form-control" placeholder="Masukan Tanggal Berakhir" required>
                      </div>
                      <div class="form-group">
                        <a href="<?= site_url('pengajar/ujian_kelas/'.$kelas->id);?>" class="btn btn-sm btn-primary">Kembali</a>
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
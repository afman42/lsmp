        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Soal Siswa <?= $kelas->kelas_nama; ?></h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Soal Siswa</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Edit Soal</h6>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <form action="<?= site_url('pengajar/update_soal_siswa/'.$soal->id);?>" method="post" class="p-3">
                      <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="pertanyaan" id="post-content"><?= $soal->pertanyaan; ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Pilihan A</label>
                        <textarea name="pg_a" id="post-content1"><?= first_kata_tinymce($soal->pg_a,'a.'); ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Pilihan B</label>
                        <textarea name="pg_b" id="post-content2"><?= first_kata_tinymce($soal->pg_b,'b.'); ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Pilihan C</label>
                        <textarea name="pg_c" id="post-content3"><?= first_kata_tinymce($soal->pg_c,'c.'); ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Pilihan D</label>
                        <textarea name="pg_d" id="post-content4"><?= first_kata_tinymce($soal->pg_d,'d.'); ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Pilihan Jawaban</label>
                        <select name="jwb_pg" class="form-control" required>
                            <?= pilihan_jawaban($soal->jwb_pg);?>
                        </select>
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
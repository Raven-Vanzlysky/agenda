<?php

  session_start();

  // membatasi halaman sebelum login
  if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('AKSES DI TOLAK!');
            document.location.href = '../index.php';
          </script>";
    exit;
  }

  // membatasi halaman sesuai user login
  if ($_SESSION["level"] != 'Guru') {
    echo "<script>
           alert('AKSES DI TOLAK!');
           document.location.href = '../index.php';
          </script>";
    exit;
  }

  $title = 'Daftar File Agenda Guru';
  $subtitle = 'Daftar File Agenda';

  include '../layout/header.php';

  $ID = $_SESSION["id_guru"];

   // Data Akun
   if(isset($_POST['cari'])) 
   {
     $kata_cari = htmlspecialchars(strip_tags($_POST['kata_cari']));
     $data_file = select("SELECT dftr_agnd.*, hasil_guru.id_hsil, mapel.mpl, kelas.kls, jurusan.jrsn FROM dftr_agnd
     INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
     INNER JOIN mapel ON dftr_agnd.id_mapel = mapel.id_mapel
     INNER JOIN kelas ON dftr_agnd.id_kelas = kelas.id_kelas
     INNER JOIN jurusan ON dftr_agnd.id_jurusan = jurusan.id_jurusan WHERE dftr_agnd.id_guru = $ID AND id_hsil like '%$kata_cari%' OR jrsn like '%$kata_cari%' OR mpl like '%$kata_cari%' ORDER BY id_mapel ASC");
    } else {
     $data_file = select("SELECT dftr_agnd.*, hasil_guru.id_hsil, dftr_agnd.id_mapel, guru.id_guru, mapel.id_mapel, mapel.mpl, kelas.id_kelas, kelas.kls, jurusan.id_jurusan, jurusan.jrsn FROM dftr_agnd
     INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
     INNER JOIN mapel ON dftr_agnd.id_mapel = mapel.id_mapel
     INNER JOIN kelas ON dftr_agnd.id_kelas = kelas.id_kelas
     INNER JOIN guru ON dftr_agnd.id_guru = guru.id_guru
     INNER JOIN jurusan ON dftr_agnd.id_jurusan = jurusan.id_jurusan WHERE hasil_guru.id_guru = $ID");
   }
  
 
  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_absn($_POST) > 0) {
      echo "<script>
              alert('Data Absensi Berhasil Ditambahkan');
              document.location.href = 'file_manager.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Absensi Gagal Ditambahkan');
              document.location.href = 'file_manager.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_absn($_POST) > 0) {
        echo "<script>
                alert('Data Absensi Berhasil Diubah');
                document.location.href = 'file_manager.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Absensi Gagal Diubah');
                document.location.href = 'file_manager.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_absn($_POST) > 0) {
        echo "<script>
                alert('Data Absensi Berhasil Dihapus');
                document.location.href = 'file_manager.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Absensi Gagal Dihapus');
                document.location.href = 'file_manager.php';
              </script>";
    }
  }
  
?>    
        
<main class="container">

  <hr>
  <br>

  <!-- Card -->
    <div class="card animate__animated animate__zoomInDown">

      <!-- .card-header -->
      <div class="card-header">
        <h3 class="card-title"><?= $title; ?></h3>

        <form class="form" action="" method="post">
          <div class="input-group d-flex justify-content-end">
            <div class="col-md-4">
              <input type="text" class="form-control me-3" name="kata_cari" placeholder="Cari..." aria-label="Search" value="<?php if(isset($_POST['cari'])) { echo $_POST['kata_cari']; } ?>">
            </div>
            <button class="btn ms-3 btn-outline-primary me-1" type="submit" name="cari">Cari</button>
          </div>
        </form>

      </div>
      <!-- /.card-header -->

      <!-- .card-body -->
      <div class="card-body">

        <div class="table-responsive">

          <table id="table" class="table text-center table-sm table-bordered table-hover">
            <thead>
              <tr>
                <th class="bg-secondary" style="width: 5px;">No</th>
                <th class="bg-secondary" style="width: 10px;">Mata Pelajaran</th>
                <th class="bg-secondary" style="width: 5px;">Kelas</th>
                <th class="bg-secondary" style="width: 7px;">Jurusan</th>
                <th class="bg-secondary" style="width: 10px;">Opsi</th>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1; ?>
                <?php foreach ($data_file as $x) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $x['mpl']; ?></td>
                    <td><?= $x['kls']; ?></td>
                    <td><?= $x['jrsn']; ?></td>
                    
                    <td class="text-center">
                      <button type="button" class="btn btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#extraLargeModal<?= $x['id_hsil']; ?>">
                      <svg 
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                      </svg>
                        Upload File
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
          </table>

        </div>

      </div>
      <!-- /.card-body -->

    </div>
  <!-- /Card -->

  <!-- Modal Detail -->
    <?php foreach ($data_file as $x0) : ?>
        <div class="modal fade" id="extraLargeModal<?= $x0['id_hsil']; ?>" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="extraLargeModalLabel">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"/>
              </div>

              <div class="modal-body">

                  <div class="card">

                    <div class="card-header">
                      <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>

                    <div class="card-body">

                      <button type="button" class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalTambahAbsn<?= $x0['id_hsil']; ?>">
                        <svg 
                          xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Tambah
                      </button> 
                    
                      <div class="table-responsive">

                        <table id="table3" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th class="bg-secondary">No</th>
                              <th class="bg-secondary">Tanggal Upload</th>
                              <th class="bg-secondary">Nama File</th>
                              <th class="bg-secondary">Keterangan</th>
                              <th class="bg-secondary">Opsi</th>
                            </tr>
                          </thead>

                          <tbody>
                            <?php $no = 1; $id = $x0['id_hsil']; ?>
                            <?php $data_agenda = select("SELECT dftr_agnd.*, hasil_guru.*, guru.id_guru, mapel.mpl, mapel.id_mapel, kelas.kls, jurusan.jrsn
                            FROM dftr_agnd 
                            INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
                            INNER JOIN mapel ON hasil_guru.id_mapel = mapel.id_mapel
                            INNER JOIN kelas ON hasil_guru.id_kelas = kelas.id_kelas
                            INNER JOIN guru ON hasil_guru.id_guru = guru.id_guru 
                            INNER JOIN jurusan ON hasil_guru.id_jurusan = jurusan.id_jurusan 
                            WHERE dftr_agnd.id_guru = '$ID' AND dftr_agnd.id_hsil ='$id'");?>
                              <?php foreach ($data_agenda as $x1) : ?>
                                <tr>
                                  <td><?= $no++; ?></td>
                                  <td><?= $x1['tgl']; ?></td>
                                  <td><?= $x1['mtri']; ?></td>
                                  <td><?= $x1['absn']; ?></td>
                                  <td><?= $x1['ktr']; ?></td>
                                  <td class="text-center">
                                    <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbahAbsn<?= $x1['id_agnd']; ?>">
                                      <svg 
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                      </svg>  
                                      Ubah
                                    </button>

                                    <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapusAbsn<?= $x1['id_agnd']; ?>">
                                      <svg 
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                      </svg>
                                      Hapus
                                    </button>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                          </tbody>
                        </table>

                      </div>
                    
                    </div>

                  </div>

              </div>

              <div class="modal-footer">
          
              </div>
          
            </div>
          </div>
        
        </div>
      
  <!-- /Modal Detail -->

  <!-- Modal Absensi/Agenda -->
    
      <div class="modal-absen">

        <!-- Modal Tambah Absen -->
          <?php foreach ($data_file as $x2) : ?>
            <div class="modal fade" id="modalTambahAbsn<?= $x2['id_hsil'];?>" tabindex="-1" aria-labelledby="defaultModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAbsn">Tambah <?= $subtitle; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                  </div>

                  <div class="modal-body">
                  
                        <form action="" method="post" enctype="multipart/form-data">

                          <input type="hidden" name="id_agnd" value="<?= $x2['id_agnd']; ?>">
                          <input type="hidden" name="id_hsil" value="<?= $x2['id_hsil']; ?>">
                          <input type="hidden" name="id_guru" value="<?= $x2['id_guru']; ?>">
                          <input type="hidden" name="id_mapel" value="<?= $x2['id_mapel']; ?>">

                          <div class="form-floating mb-2">
                            <input type="text" name="nmfl" id="floatingInput" class="form-control" placeholder="nmfl" required>
                            <label for="floatingInput">Nama File</label>
                          </div>

                          
                          <div class="form-floating mb-2">
                            <input type="text" name="ktrf" id="floatingInput" class="form-control" placeholder="Keterangan" required>
                            <label for="floatingInput">Keterangan</label>
                          </div>
                          
                          <div class="form-group mb-2">
                            <label for="file"><b>File</b></label><br>
                            <div class="custom-file">
                              <label class="custom-file-label" for="file">Pilih file...</label>
                              <input type="file" class="custom-file-input" id="file" name="file" onchange="previewImg()" required>
                            </div>
                          </div>
                          
                        </div>

                  <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                          <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                  </div>
                        
                    </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <!-- /Modal Tambah Absen -->

        <!-- Modal Ubah Absen -->
          <?php foreach ($data_agenda as $x3) : ?>
            <div class="modal fade" id="modalUbahAbsn<?= $x3['id_agnd']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $subtitle; ?> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                  </div>

                  <div class="modal-body">

                    <form action="" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="id_agnd" value="<?= $x3['id_agnd']; ?>">

                        <div class="form-floating mb-3">
                          <input type="date" name="tgl" id="floatingInput" class="form-control" placeholder="Tanggal" value="<?= $x3['tgl']; ?>" required>
                          <label for="floatingInput">Tanggal</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input type="time" name="jam" id="floatingInput" class="form-control" placeholder="Jam" value="<?= $x3['jam']; ?>" required>
                          <label for="floatingInput">Jam</label>
                        </div>

                        <div class="form-group mb-3">
                          <label for="groupInput">Materi</label>
                          <textarea name="mtri" id="groupInput" class="form-control" placeholder="Pokok Bahasan" required><?= $x3['mtri']; ?></textarea>
                        </div>

                        <div class="form-floating mb-3">
                          <input type="text" name="absn" id="floatingInput" class="form-control" placeholder="Absen" value="<?= $x3['absn']; ?>" required>
                          <label for="floatingInput">Absen</label>
                        </div>

                        <div class="form-group mb-3">
                          <label for="groupInput">Keterangan</label>
                          <textarea name="ktr" id="groupInput" class="form-control" placeholder="Keterangan" required><?= $x3['ktr']; ?></textarea>
                        </div>

                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                  </div>
                    </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <!-- /Modal Ubah Absen -->

        <!-- Modal Hapus Absen -->
          <?php foreach ($data_agenda as $x4) : ?>
            <div class="modal fade" id="modalHapusAbsn<?= $x4['id_agnd']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $title; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                  </div>

                  <div class="modal-body">
                    <form action="" method="post">
                      <input type="hidden" name="id" value="<?= $x4['id_agnd']; ?>">
                        <p>Yakin Ingin Menghapus Absen Mata Pelajaran <?= $x4['mpl']; ?> <?= $x4['kls'] . ' ' . $x4['jrsn']; ?>.?</p>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                  </div>

                    </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <!-- /Modal Hapus Absen -->

      </div>
   
      <?php endforeach; ?>
  <!-- /Modal Absensi/Agenda -->
</main>    

<?php

  include '../layout/footer.php';

?>
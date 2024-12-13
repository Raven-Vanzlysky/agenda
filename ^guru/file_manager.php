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

  $title = 'Daftar File';

  include '../layout/header.php';

  $PK = $_SESSION["id_guru"];

  // Data Isi agenda 1
  if(isset($_POST['cari'])) 
  {
    $kata_cari = $_POST['kata_cari'];
      $data_agenda = select("SELECT dftr_agnd.*, hasil_guru.*, guru.*, mapel.*, kelas.*, jurusan.* FROM dftr_agnd
      INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
      INNER JOIN guru ON dftr_agnd.id_guru = guru.id_guru
      INNER JOIN mapel ON dftr_agnd.id_mapel = mapel.id_mapel
      INNER JOIN kelas ON dftr_agnd.id_kelas = kelas.id_kelas
      INNER JOIN jurusan ON dftr_agnd.id_jurusan = jurusan.id_jurusan WHERE dftr_agnd.id_guru = '$PK' AND kls like '%".$kata_cari."%' OR jrsn like '%".$kata_cari."%' OR mpl like '%".$kata_cari."%'");
  } else {
      $data_agenda = select("SELECT dftr_agnd.*, hasil_guru.*, guru.*, mapel.*, kelas.*, jurusan.* FROM dftr_agnd
      INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
      INNER JOIN guru ON dftr_agnd.id_guru = guru.id_guru
      INNER JOIN mapel ON dftr_agnd.id_mapel = mapel.id_mapel
      INNER JOIN kelas ON dftr_agnd.id_kelas = kelas.id_kelas
      INNER JOIN jurusan ON dftr_agnd.id_jurusan = jurusan.id_jurusan WHERE dftr_agnd.id_guru = '$PK'");
  }

  // jika tombol upload di tekan jalankan script berikut
  if (isset($_POST['upload'])) {
    if (tambah_data_upload_hg($_POST) > 0) {
      // echo "<script>
      //         alert('File Berhasil Ditambahkan');
      //         document.location.href = 'file_manager.php';
      //       </script>";
    } else {
        echo "<script>
              alert('File Gagal Ditambahkan');
              document.location.href = 'file_manager.php';
            </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_file_hg($_POST) > 0) {
        echo "<script>
                alert('Data File Berhasil Dihapus');
                document.location.href = 'file_manager.php';
              </script>";
    } else {
        echo "<script>
                alert('Data File Gagal Dihapus');
                document.location.href = 'file_manager.php';
              </script>";
    }
  }

?>    
        
<main class="container">

  <hr>
  <h1 class="animate__animated animate__fadeInLeft"><?= $_SESSION['nama'];?></h1>
  <br>

  <!-- Card -->
    <div class="card animate__animated animate__zoomInDown">

      <!-- .card-header -->
      <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title"><?= $title; ?></h3>

        <form class="form" action="" method="post">
        <div class="input-group">
          <input type="text" class="form-control me-3" name="kata_cari" placeholder="Cari..." aria-label="Search" value="<?php if(isset($_POST['cari'])) { echo $_POST['kata_cari']; } ?>">
          <button class="btn btn-outline-primary me-1" type="submit" name="cari">Cari</button>
        </div>
      </form>

      </div>
      <!-- /.card-header -->

      <!-- .card-body -->
      <div class="card-body">

        <div class="table-responsive">

          <table id="table" class="table table-sm table-bordered table-hover">
            <thead>
              <tr>
                <th class="bg-secondary">No</th>
                <th class="bg-secondary">Mata Pelajaran</th>
                <th class="bg-secondary">Kelas</th>
                <th class="bg-secondary">Jurusan</th>
                <th class="bg-secondary">Opsi</th>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1; ?>
                <?php foreach ($data_agenda as $x) : ?>
                  
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $x['mpl']; ?></td>
                    <td><?= $x['kls']; ?></td>
                    <td><?= $x['jrsn']; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#extraLargeModal<?= $x['id_agnd']; ?>">
                        <svg 
                          xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                        View Upload
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

  <!-- Modal Upload -->
    <?php foreach ($data_agenda as $x) : ?>
      <div class="modal fade" id="extraLargeModal<?= $x['id_agnd']; ?>" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="extraLargeModalLabel">File Pengajaran</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"/>
            </div>

            <div class="modal-body">

              <?php 
              
                // Data Isi agenda 2
                  $id = $x['id_agnd'] ;
                  $data_agenda0 = select("SELECT dftr_agnd.*, hasil_guru.*, guru.*, mapel.*, kelas.*, jurusan.* FROM dftr_agnd
                  INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
                  INNER JOIN guru ON dftr_agnd.id_guru = guru.id_guru
                  INNER JOIN mapel ON dftr_agnd.id_mapel = mapel.id_mapel
                  INNER JOIN kelas ON dftr_agnd.id_kelas = kelas.id_kelas
                  INNER JOIN jurusan ON dftr_agnd.id_jurusan = jurusan.id_jurusan WHERE dftr_agnd.id_guru = '$PK' AND dftr_agnd.id_agnd = '$id'");

              ?>
            <?php foreach ($data_agenda0 as $x0) : ?>
              <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_agnd" value="<?= $x0['id_agnd']; ?>">
                <input type="hidden" name="id_hsil" value="<?= $x0['id_hsil']; ?>">
                <input type="hidden" name="id_guru" value="<?= $x0['id_guru']; ?>">
                <input type="hidden" name="id_mapel" value="<?= $x0['id_mapel']; ?>">
                <input type="hidden" name="tgl_up" value="<?= date("Y-m-d"); ?>">
                
                <div class="form-floating mb-2">
                  <input type="text" name="nama_file" id="floatingInput" class="form-control" placeholder="Nama File" required>
                  <label for="floatingInput">Nama File</label>
                </div>

                <div class="form-group mb-2">
                  <label for="file"><b>File</b></label><br>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" name="file" required>
                  </div>
                </div>

                <div class="form-floating mb-2">
                  <input type="text" name="ktr" id="floatingInput" class="form-control" placeholder="Keterangan" required>
                  <label for="floatingInput">Keterangan</label>
                </div>

                <button type="submit" name="upload" class="btn btn-primary">Upload File</button>

                <hr>

                <div class="table-responsive">

                <?php

                  $no = 1 ;
                  // tampilan file
                  $data_file = select("SELECT file_agnd.*, dftr_agnd.id_agnd, hasil_guru.*,  mapel.* FROM file_agnd
                  INNER JOIN dftr_agnd ON file_agnd.id_agnd = dftr_agnd.id_agnd
                  INNER JOIN hasil_guru ON file_agnd.id_hsil = hasil_guru.id_hsil
                  INNER JOIN guru ON file_agnd.id_guru = guru.id_guru
                  INNER JOIN mapel ON file_agnd.id_mapel = mapel.id_mapel
                  WHERE file_agnd.id_guru = '$PK' AND file_agnd.id_agnd = '$id'");
                
                ?>


                <table align="center" style="width: max-content;" id="table2" class="table table-bordered table-hover">
                  
                  <thead>
                    <tr>
                      <th class="bg-secondary">No</th>
                      <th class="bg-secondary">Tanggal Upload</th>
                      <th class="bg-secondary">Nama File</th>
                      <th class="bg-secondary">Keterangan</th>
                      <th class="bg-secondary">Opsi</th>
                    </tr>
                  </thead>
                  
                  <?php foreach ($data_file as $x1) : ?>
                  <tbody>
                    <tr>
                      <td><?= $no++ ;?></td>
                      <td><?= $x1['tgl_upld'] ;?></td>
                      <td><?= $x1['nama_file'] ;?></td>
                      <td><?= $x1['ktr'] ;?></td>
                      <td>
                        <a href="../client/file/<?= $x1['file'] ;?>" target="_blank" type="button" class="btn btn-primary mb-1">
                        <svg 
                          xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                          <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z"/>
                          <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                        </svg>
                          View
                        </a>
                        <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapusFile<?= $x1['id_file']; ?>">
                          <svg 
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                          </svg>
                          Hapus
                        </button>
                      </td>
                    </tr>
                  </tbody>
                    
                  <?php endforeach; ?>
                </table>
                  
                </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              
              </form>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <!-- /Modal Upload -->

  <!-- Modal Hapus Absen -->
    <?php foreach ($data_file as $x1) : ?>
      <div class="modal fade" id="modalHapusFile<?= $x1['id_file']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $title; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"/>
            </div>

            <div class="modal-body">
              <form action="" method="post">
                <input type="hidden" name="id" value="<?= $x1['id_file']; ?>">
                <input type="hidden" name="fileLama" value="<?= $x1['file']; ?>">
                  <p>Yakin Ingin Menghapus File <?= $x1['nama_file']; ?> .?</p>
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
      
</main>    

<?php

  include '../layout/footer.php';

?>
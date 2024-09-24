<?php

  session_start();

  // membatasi halaman sebelum login
  if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('AKSES DI TOLAK!');
            document.location.href = '../login.php';
          </script>";
    exit;
  }

  // membatasi halaman sesuai user login
  if ($_SESSION["level"] != 'Guru') {
    echo "<script>
           alert('AKSES DI TOLAK!');
           document.location.href = '../login.php';
          </script>";
    exit;
  }

  $title = 'Daftar Agenda Guru';

  include '../layout/header.php';

  $PK = $_SESSION["nip"];

  // Data Isi
  if(isset($_POST['cari'])) 
  {
    $kata_cari = $_POST['kata_cari'];
    $data_hasil = select("SELECT * FROM hasil_guru WHERE (mpl like '%$kata_cari%' OR kls like '%$kata_cari%' OR jrsn like '%$kata_cari%') AND nip = '$PK' ");
  } else {
    $data_hasil = select("SELECT * FROM hasil_guru WHERE nip = '$PK'");
  }

  // jika tombol upload di tekan jalankan script berikut
  if (isset($_POST['upload'])) {
    if (tambah_data_upload_hg($_POST) > 0) {
      echo "<script>
              alert('File Berhasil Ditambahkan');
              document.location.href = 'file_manager.php';
            </script>";
    } else {
        echo "<script>
              alert('File Gagal Ditambahkan');
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

      <table id="example2" class="table table-bordered table-hover">
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
            <?php foreach ($data_hasil as $x) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $x['mpl']; ?></td>
                <td><?= $x['kls']; ?></td>
                <td><?= $x['jrsn']; ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#uploadModal<?= $x['id_hsil']; ?>">
                  <svg 
                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                    <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                  </svg>
                    Upload File
                  </button>
                  <a href="../client/file/<?= $x['file'] ;?>" type="button" class="btn btn-primary mb-1">
                  <svg 
                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                    <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                  </svg>
                    Download File
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>

  <!-- Modal Upload -->
  <?php foreach ($data_hasil as $x) : ?>
    <div class="modal fade" id="uploadModal<?= $x['id_hsil']; ?>" tabindex="-1" aria-labelledby="defaultModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="defaultModalLabel">Identitas Mata Pelajaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"/>
          </div>

          <div class="modal-body">

            <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?= $x['id_hsil']; ?>">
              <input type="hidden" name="fileLama" value="<?= $x['file']; ?>">
    
                <div class="form-group mb-2">
                <label for="file"><b>File</b></label><br>
                <div class="custom-file">
                  <label class="custom-file-label" for="file">Pilih file...</label><br>
                  <input type="file" class="custom-file-input" id="file" name="file" required>
                </div>
              </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="submit" name="upload" class="btn btn-primary">Upload File</button>
            </form>
          </div>
      
        </div>
      </div>
    </div>
  <?php endforeach; ?>
      
</main>    

<?php

  include '../layout/footer.php';

?>
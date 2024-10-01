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
  if ($_SESSION["level"] != 'Admin') {
    echo "<script>
           alert('AKSES DI TOLAK!');
           document.location.href = '../login.php';
          </script>";
    exit;
  }

  // Perjudulan
  $title = 'Administrasi';
  $subtitle = 'Tahun Ajaran';

  include '../layout/header.php';

  // Data Mapel
  if(isset($_POST['cari'])) 
  {
    $kata_cari = $_POST['kata_cari'];
    $data_thn_ajr = select("SELECT * FROM thn_ajar WHERE tahun_ajaran like '%".$kata_cari."%' ");
  } else {
    $data_thn_ajr = select("SELECT * FROM thn_ajar");
  }

  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_thnajar($_POST) > 0) {
      echo "<script>
              alert('Data Tahun Ajaran Berhasil Ditambahkan');
              document.location.href = 'admin_tahun_ajaran.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Tahun Ajaran Gagal Ditambahkan');
              document.location.href = 'admin_tahun_ajaran.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_mapel($_POST) > 0) {
        echo "<script>
                alert('Data Tahun Ajaran Berhasil Diubah');
                document.location.href = 'admin_tahun_ajaran.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Tahun Ajaran Gagal Diubah');
                document.location.href = 'admin_tahun_ajaran.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_mapel($_POST) > 0) {
        echo "<script>
                alert('Data Tahun Ajaran Berhasil Dihapus');
                document.location.href = 'admin_tahun_ajaran.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Tahun Ajaran Gagal Dihapus');
                document.location.href = 'admin_tahun_ajaran.php';
              </script>";
    }
  }
  
?>    
        
<main class="container">
  <hr>
  <h1 class="animate__animated animate__fadeInLeft"><?= $title;?></h1>
  <br>

  <!-- Card Mapel -->
  <div class="card animate__animated animate__zoomInDown">

    <!-- .card-header -->
    <div class="card-header d-flex justify-content-between align-items-center">

      <h3 class="card-title"><?= $subtitle; ?></h3>

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

      <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <svg 
          xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
        Tambah
      </button>  

      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th class="bg-secondary">No</th>
            <th class="bg-secondary">Tahun Ajaran</th>
            <th class="bg-secondary">Opsi</th>
          </tr>
        </thead>

        <tbody>
          <?php $no = 1; ?>
            <?php foreach ($data_thn_ajr as $x) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $x['tahun_ajaran']; ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $x['id_ajaran']; ?>">
                    <svg 
                      xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                      <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                    </svg> 
                    Ubah
                  </button>

                  <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $x['id_ajaran']; ?>">
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
    <!-- /.card-body -->

  </div>

  <!-- Modal Mapel -->
  <div class="modal-tahun">

    <!-- Modal Tambah Tahun Ajaran -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $subtitle; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"/>
        </div>

        <div class="modal-body">

          <form action="" method="post">

            <div class="form-floating mb-2">
              <input type="text" name="thn_ajr" id="floatingInput" class="form-control" placeholder="Tahun Ajaran" required>
              <label for="floatingInput">Tahun Ajaran</label>
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

    <!-- Modal Ubah Tahun Ajaran -->
    <?php foreach ($data_thn_ajr as $x) : ?>
    <div class="modal fade" id="modalUbah<?= $x['id_ajaran']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $subtitle; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"/>
          </div>

          <div class="modal-body">

            <form action="" method="post">
              <input type="hidden" name="id_ajr" value="<?= $x['id_ajaran']; ?>">

                <div class="form-floating mb-3">
                  <input type="text" name="thn_ajr" id="floatingInput" class="form-control" placeholder="Tahun Ajaran" value="<?= $x['tahun_ajaran']; ?>" required>
                  <label for="floatingInput">Tahun Ajaran</label>
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

    <!-- Modal Hapus Tahun Ajaran -->
    <?php foreach ($data_thn_ajr as $x) : ?>
    <div class="modal fade" id="modalHapus<?= $x['id_ajaran']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $subtitle; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                </div>

                <div class="modal-body">
                  <form action="" method="post">
                  <input type="hidden" name="id_ajr" value="<?= $x['id_ajaran']; ?>">
                    <p>Yakin Ingin Menghapus <?= $subtitle; ?> : <?= $x['tahun_ajaran']; ?>.?</p>
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
      
  </div>

</main>    

<?php

  include '../layout/footer.php';

?>
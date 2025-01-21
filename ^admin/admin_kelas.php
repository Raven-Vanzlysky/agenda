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
  if ($_SESSION["level"] != 'Admin') {
    echo "<script>
           alert('AKSES DI TOLAK!');
           document.location.href = '../index.php';
          </script>";
    exit;
  }

  // Perjudulan
  $title = 'Administrasi';
  $subtitle = 'Daftar Kelas';

  include '../layout/header.php';

  // Data Kelas
  if(isset($_POST['cari'])) 
  {
    $kata_cari = htmlspecialchars(strip_tags($_POST['kata_cari']));
    $data_kelas = select("SELECT * FROM kelas WHERE kls like '%$kata_cari%' ORDER BY kls ASC");
   } else {
    $data_kelas = select("SELECT * FROM kelas");
  }

  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_kelas($_POST) > 0) {
      echo "<script>
              alert('Data Kelas Berhasil Ditambahkan');
              document.location.href = 'admin_kelas.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Kelas Gagal Ditambahkan');
              document.location.href = 'admin_kelas.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_kelas($_POST) > 0) {
        echo "<script>
                alert('Data Kelas Berhasil Diubah');
                document.location.href = 'admin_kelas.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Kelas Gagal Diubah');
                document.location.href = 'admin_kelas.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_kelas($_POST) > 0) {
        echo "<script>
                alert('Data Kelas Berhasil Dihapus');
                document.location.href = 'admin_kelas.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Kelas Gagal Dihapus');
                document.location.href = 'admin_kelas.php';
              </script>";
    }
  }
  
?>    
        
<main class="container">
  <hr>
  <h1 class="animate__animated animate__fadeInLeft"><?= $title;?></h1>
  <br>

  <!-- Card Kelas -->
    <div class="card animate__animated animate__zoomInDown">

      <!-- .card-header -->
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><?= $subtitle; ?></h3>

        <form class="form" action="" method="post">
          <div class="input-group">
            <input type="text" class="form-control me-3" name="kata_cari" placeholder="Cari..." aria-label="Search" value="<?php if(isset($_POST['cari'])) { echo $_POST['kata_cari']; } ?>">
            <button class="btn btn-outline-primary me-1" type="submit" name="cari"><i class="bi bi-search"></i></button>
          </div>
        </form>

      </div>
      <!-- /.card-header -->

      <!-- .card-body -->
      <div class="card-body">

        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i>
          Tambah
        </button>  

        <div class="table-responsive">

          <table id="table" class="table table-sm table-bordered table-hover">
            <thead>
              <tr>
                <th class="bg-secondary">No</th>
                <th class="bg-secondary">Kelas</th>
                <th class="bg-secondary">Opsi</th>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1; ?>
                <?php foreach ($data_kelas as $x) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $x['kls']; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $x['id_kelas']; ?>">
                      <i class="bi bi-pen"></i>
                        Ubah
                      </button>

                      <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $x['id_kelas']; ?>">
                      <i class="bi bi-trash"></i>
                        Hapus
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
  <!-- //Card Kelas -->

  <!-- Modal Kelas -->
    <div class="modal-kelas">

      <!-- Modal Tambah Kelas -->
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
                    <input type="text" name="kls" id="floatingInput" class="form-control" placeholder="Kelas" required>
                    <label for="floatingInput">Kelas</label>
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
      <!-- //Modal Tambah Kelas -->

      <!-- Modal Ubah Kelas -->
        <?php foreach ($data_kelas as $x) : ?>
          <div class="modal fade" id="modalUbah<?= $x['id_kelas']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $subtitle; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                </div>

                <div class="modal-body">

                  <form action="" method="post">
                    <input type="hidden" name="id_kelas" value="<?= $x['id_kelas']; ?>">

                      <div class="form-floating mb-3">
                        <input type="text" name="kls" id="floatingInput" class="form-control" placeholder="Kelas" value="<?= $x['kls']; ?>">
                        <label for="floatingInput">Kelas</label>
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
      <!-- Modal Ubah Kelas -->

      <!-- Modal Hapus Kelas -->
        <?php foreach ($data_kelas as $x) : ?>
          <div class="modal fade" id="modalHapus<?= $x['id_kelas']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $subtitle; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                      </div>

                      <div class="modal-body">
                        <form action="" method="post">
                        <input type="hidden" name="id_kelas" value="<?= $x['id_kelas']; ?>">
                          <p>Yakin Ingin Menghapus <?= $subtitle; ?> : <?= $x['kls']; ?>.?</p>
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
      <!-- //Modal Hapus Kelas -->
        
    </div>
  <!-- //Modal Kelas -->

</main>    

<?php

  include '../layout/footer.php';

?>
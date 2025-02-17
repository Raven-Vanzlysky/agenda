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
  $subtitle = 'Daftar Jurusan';

  include '../layout/header.php';

  // Data Jurusan
  if(isset($_POST['cari'])) 
  {
    $kata_cari = htmlspecialchars(strip_tags($_POST['kata_cari']));
    $data_jurusan = select("SELECT * FROM jurusan WHERE jrsn like '%$kata_cari%' ORDER BY jrsn ASC");
   } else {
    $data_jurusan = select("SELECT * FROM jurusan");
  }

  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_jurusan($_POST) > 0) {
      echo "<script>
              alert('Data Jurusan Berhasil Ditambahkan');
              document.location.href = 'admin_jurusan.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Jurusan Gagal Ditambahkan');
              document.location.href = 'admin_jurusan.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_jurusan($_POST) > 0) {
        echo "<script>
                alert('Data Jurusan Berhasil Diubah');
                document.location.href = 'admin_jurusan.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Jurusan Gagal Diubah');
                document.location.href = 'admin_jurusan.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_jurusan($_POST) > 0) {
        echo "<script>
                alert('Data Jurusan Berhasil Dihapus');
                document.location.href = 'admin_jurusan.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Jurusan Gagal Dihapus');
                document.location.href = 'admin_jurusan.php';
              </script>";
    }
  }
  
?>    
        
<main class="container">
  <hr>
  <h1 class="animate__animated animate__fadeInLeft"><?= $title;?></h1>
  <br>

  <!-- Card Jurusan -->
   <div class="row">
   <div class="col">
      <div class="card card-center animate__animated animate__zoomInDown">

        <!-- .card-header -->
        <div class="card-header">

          <div class="card-wrap d-flex justify-content-between align-items-center">
            <h3 class="card-title"><?= $subtitle; ?></h3>

            <form class="form" action="" method="post">
              <div class="input-group">
                <input type="search" class="form-control me-3" name="kata_cari" placeholder="Cari..." aria-label="Search" value="<?php if(isset($_POST['cari'])) { echo $_POST['kata_cari']; } ?>">
                <button class="btn btn-outline-primary me-1" type="submit" name="cari"><i class="bi bi-search"></i></button>
              </div>
            </form>
          </div>

          <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
          <i class="bi bi-plus-circle"></i>
            Tambah
          </button> 

        </div>
        <!-- /.card-header -->

        <!-- .card-body -->
        <div class="card-body" style="max-height: 300px;"> 

          <div class="table-responsive">

            <table id="table" class="table table-sm table-bordered table-hover text-center">
              <thead>
                <tr>
                  <th class="bg-secondary">No</th>
                  <th class="bg-secondary">Jurusan</th>
                  <th class="bg-secondary">Opsi</th>
                </tr>
              </thead>

              <tbody>
                <?php $no = 1; ?>
                  <?php foreach ($data_jurusan as $x) : ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $x['jrsn']; ?></td>
                      <td>
                        <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $x['id_jurusan']; ?>">
                        <i class="bi bi-pen"></i>
                          Ubah
                        </button>

                        <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $x['id_jurusan']; ?>">
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
    </div>
   </div>
  <!-- //Card Jurusan -->

  <!-- Modal Jurusan -->
    <div class="modal-jurusan">

      <!-- Modal Tambah Jurusan -->
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
                    <input type="text" name="jrsn" id="floatingInput" class="form-control" placeholder="Jurusan" required>
                    <label for="floatingInput">Jurusan</label>
                  </div>

              </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                  </form>
                </div>
                
            </div>
          </div>
        </div>
      <!-- //Modal Tambah Jurusan -->

      <!-- Modal Ubah Jurusan -->
        <?php foreach ($data_jurusan as $x) : ?>
          <div class="modal fade" id="modalUbah<?= $x['id_jurusan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $subtitle; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                </div>

                <div class="modal-body">

                  <form action="" method="post">
                    <input type="hidden" name="id_jurusan" value="<?= $x['id_jurusan']; ?>">

                      <div class="form-floating mb-3">
                        <input type="text" name="jrsn" id="floatingInput" class="form-control" placeholder="Jurusan" value="<?= $x['jrsn']; ?>" required>
                        <label for="floatingInput">Jurusan</label>
                      </div>

                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                  </form>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <!-- //Modal Ubah Jurusan -->

      <!-- Modal Hapus Jurusan -->
        <?php foreach ($data_jurusan as $x) : ?>
          <div class="modal fade" id="modalHapus<?= $x['id_jurusan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $subtitle; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                      </div>

                      <div class="modal-body">
                        <form action="" method="post">
                        <input type="hidden" name="id_jurusan" value="<?= $x['id_jurusan']; ?>">
                          <p>Yakin Ingin Menghapus <?= $subtitle; ?> : <?= $x['jrsn']; ?>.?</p>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                        </form>
                      </div>

                  </div>
            </div>
          </div>
        <?php endforeach; ?>
      <!-- //Modal Hapus Jurusan -->
        
    </div>
  <!-- //Modal Jurusan -->

</main>    

<?php

  include '../layout/footer.php';

?>
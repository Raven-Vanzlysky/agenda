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
  $subtitle = 'Daftar Mapel';

  include '../layout/header.php';

  // Data Mapel
  if(isset($_POST['cari'])) 
  {
    $kata_cari = $_POST['kata_cari'];
    $data_mapel = select("SELECT * FROM mapel WHERE mpl like '%".$kata_cari."%' ");
  } else {
    $data_mapel = select("SELECT * FROM mapel");
  }

  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_mapel($_POST) > 0) {
      echo "<script>
              alert('Data Mapel Berhasil Ditambahkan');
              document.location.href = 'admin_mapel.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Mapel Gagal Ditambahkan');
              document.location.href = 'admin_mapel.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_mapel($_POST) > 0) {
        echo "<script>
                alert('Data Mapel Berhasil Diubah');
                document.location.href = 'admin_mapel.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Mapel Gagal Diubah');
                document.location.href = 'admin_mapel.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_mapel($_POST) > 0) {
        echo "<script>
                alert('Data Mapel Berhasil Dihapus');
                document.location.href = 'admin_mapel.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Mapel Gagal Dihapus');
                document.location.href = 'admin_mapel.php';
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
            <button class="btn btn-outline-primary me-1" type="submit" name="cari"><i class="bi bi-search"></i></button>
          </div>
        </form>

      </div>
      <!-- /.card-header -->

      <!-- .card-body -->
      <div class="card-body overflow-auto" style="max-height: 420px;">

        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i>
          Tambah
        </button>  

        <div class="table-responsive">

          <table id="table" class="table table-sm table-bordered table-hover">
            <thead>
              <tr>
                <th class="bg-secondary">No</th>
                <th class="bg-secondary">Mata Pelajaran</th>
                <th class="bg-secondary">Opsi</th>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1; ?>
                <?php foreach ($data_mapel as $x) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $x['mpl']; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $x['id_mapel']; ?>">
                      <i class="bi bi-pen"></i>
                        Ubah
                      </button>

                      <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $x['id_mapel']; ?>">
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
  <!-- //Card Mapel -->

  <!-- Modal Mapel -->
    <div class="modal-mapel">

      <!-- Modal Tambah Mapel -->
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
                    <input type="text" name="mpl" id="floatingInput" class="form-control" placeholder="Mata Pelajaran" required>
                    <label for="floatingInput">Mata Pelajaran</label>
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
      <!-- //Modal Tambah Mapel -->

      <!-- Modal Ubah Mapel -->
        <?php foreach ($data_mapel as $x) : ?>
          <div class="modal fade" id="modalUbah<?= $x['id_mapel']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $subtitle; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                </div>

                <div class="modal-body">

                  <form action="" method="post">
                    <input type="hidden" name="id_mapel" value="<?= $x['id_mapel']; ?>">

                      <div class="form-floating mb-3">
                        <input type="text" name="mpl" id="floatingInput" class="form-control" placeholder="Mata Pelajaran" value="<?= $x['mpl']; ?>" required>
                        <label for="floatingInput">Mata Pelajaran</label>
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
      <!-- //Modal Ubah Mapel -->

      <!-- Modal Hapus Mapel -->
        <?php foreach ($data_mapel as $x) : ?>
          <div class="modal fade" id="modalHapus<?= $x['id_mapel']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $subtitle; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                      </div>

                      <div class="modal-body">
                        <form action="" method="post">
                        <input type="hidden" name="id_mapel" value="<?= $x['id_mapel']; ?>">
                          <p>Yakin Ingin Menghapus <?= $subtitle; ?> : <?= $x['mpl']; ?>.?</p>
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
      <!-- //Modal Hapus Mapel -->
        
    </div>
  <!-- //Modal Mapel -->

</main>    

<?php

  include '../layout/footer.php';

?>
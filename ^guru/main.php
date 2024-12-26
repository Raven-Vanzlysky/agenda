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

  $title = 'Daftar Isi';

  include '../layout/header.php';

  $ID = $_SESSION["id_guru"];

  // Data Guru Mapel
  if(isset($_POST['cari'])) 
  {
    $kata_cari = htmlspecialchars(strip_tags($_POST['kata_cari']));
    $data_hasil = select("SELECT hasil_guru.id_hsil, mapel.mpl, kelas.kls, jurusan.jrsn FROM hasil_guru
    INNER JOIN mapel ON hasil_guru.id_mapel = mapel.id_mapel
    INNER JOIN kelas ON hasil_guru.id_kelas = kelas.id_kelas
    INNER JOIN jurusan ON hasil_guru.id_jurusan = jurusan.id_jurusan WHERE id_hsil like '%$kata_cari%' OR jrsn like '%$kata_cari%' OR mpl like '%$kata_cari%' ORDER BY id_mapel ASC");
   } else {
    $data_hasil = select("SELECT hasil_guru.id_hsil, mapel.mpl, kelas.kls, jurusan.jrsn FROM hasil_guru
    INNER JOIN mapel ON hasil_guru.id_mapel = mapel.id_mapel
    INNER JOIN kelas ON hasil_guru.id_kelas = kelas.id_kelas
    INNER JOIN guru ON hasil_guru.id_guru = guru.id_guru
    INNER JOIN jurusan ON hasil_guru.id_jurusan = jurusan.id_jurusan WHERE hasil_guru.id_guru = $ID");
  }

  $data_mapel = select("SELECT * FROM mapel");
  $data_kelas = select("SELECT * FROM kelas");
  $data_jurusan = select("SELECT * FROM jurusan");

  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_hg($_POST) > 0) {
      echo "<script>
              alert('Data Isi Berhasil Ditambahkan');
              document.location.href = 'main.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Isi Gagal Ditambahkan');
              document.location.href = 'main.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_hg($_POST) > 0) {
        echo "<script>
                alert('Data Isi Berhasil Diubah');
                document.location.href = 'main.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Isi Gagal Diubah');
                document.location.href = 'main.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_hg($_POST) > 0) {
        echo "<script>
                alert('Data Isi Berhasil Dihapus');
                document.location.href = 'main.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Isi Gagal Dihapus');
                document.location.href = 'main.php';
              </script>";
    }
  }
  
?>    
        
<main class="container">

  <hr>
  <br>

  <!-- Card -->

    <div class="card animate__animated animate__zoomInDown">

      <!-- card-header -->
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
      <!-- /card-header -->

      <!-- card-body -->
        <div class="card-body">

          <button type="button" class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <svg 
              xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
            Tambah
          </button>  

          <div class="table-responsive">

            <table id="table" class="table text-center table-sm table-bordered table-hover">
              <thead>
                <tr>
                  <th class="bg-secondary" style="width: 5px;">No</th>
                  <th class="bg-secondary" style="width: 10px;">Mata Pelajaran</th>
                  <th class="bg-secondary" style="width: 5px;">Kelas</th>
                  <th class="bg-secondary" style="width: 7px;">Jurusan</th>
                  <th class="bg-secondary" style="width: 20px;">Opsi</th>
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
                        <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $x['id_hsil']; ?>">
                          <svg 
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                          </svg>  
                          Ubah
                        </button>

                        <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $x['id_hsil']; ?>">
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
      <!-- /card-body -->

    </div>

  <!-- /Card -->

  <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $title; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"/>
          </div>

          <div class="modal-body">

            <form action="" method="post" enctype="multipart/form-data">

              <input type="hidden" name="id" value="<?= $ID;?>">

              <div class="form-group mb-2">
                <label for="mpl">Mapel</label>
                <select name="mpl" id="mpl" class="form-control" required>
                  <option value="">-- Pilih Mapel --</option>
                  <?php foreach ($data_mapel as $x) : ?>
                  <option value="<?= $x['id_mapel']; ?>"><?= $x['mpl']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group mb-2">
                <label for="kls">Kelas</label>
                <select name="kls" id="kls" class="form-control" required>
                  <option value="">-- Pilih Kelas --</option>
                  <?php foreach ($data_kelas as $x) : ?>
                  <option value="<?= $x['id_kelas']; ?>"><?= $x['kls']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group mb-2">
                <label for="jrsn">Jurusan</label>
                <select name="jrsn" id="jrsn" class="form-control" required>
                  <option value="">-- Pilih Jurusan --</option>
                  <?php foreach ($data_jurusan as $x) : ?>
                  <option value="<?= $x['id_jurusan']; ?>"><?= $x['jrsn']; ?></option>
                  <?php endforeach; ?>
                </select>
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
  <!-- Modal Tambah -->

  <!-- Modal Ubah Isi -->
    <?php foreach ($data_hasil as $x) : ?>
      <div class="modal fade" id="modalUbah<?= $x['id_hsil']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $title; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"/>
            </div>

            <div class="modal-body">

              <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_hsil" value="<?= $x['id_hsil']; ?>">
                <input type="hidden" name="idg" value="<?= $ID;?>">

                <div class="form-group mb-3">
                  <label for="mpl">Mata Pelajaran</label>
                  <select name="mpl" id="mpl" class="form-control" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                  <?php foreach ($data_mapel as $mapel) : ?>
                    <option value="<?= $mapel['id_mapel']; ?>" <?= $mapel['mpl'] == $x['mpl'] ? 'selected' : null ; ?>>
                      <?= $mapel['mpl']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group mb-3">
                <label for="kls">Kelas</label>
                <select name="kls" id="kls" class="form-control" required>
                  <option value="">-- Pilih Kelas --</option>
                <?php foreach ($data_kelas as $kelas) : ?>
                  <option value="<?= $kelas['id_kelas']; ?>" <?= $kelas['kls'] == $x['kls'] ? 'selected' : null ; ?>>
                    <?= $kelas['kls']; ?>
                  </option>
                <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group mb-3">
                <label for="jrsn">Jurusan</label>
                <select name="jrsn" id="jrsn" class="form-control" required>
                  <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($data_jurusan as $jurusan) : ?>
                  <option value="<?= $jurusan['id_jurusan']; ?>" <?= $jurusan['jrsn'] == $x['jrsn'] ? 'selected' : null ; ?>>
                    <?= $jurusan['jrsn']; ?>
                  </option>
                <?php endforeach; ?>
                </select>
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
  <!-- /Modal Ubah Isi -->

  <!-- Modal Hapus Mapel -->
    <?php foreach ($data_hasil as $x) : ?>
      <div class="modal fade" id="modalHapus<?= $x['id_hsil']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $title; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"/>
            </div>

            <div class="modal-body">
              <form action="" method="post">
                <input type="hidden" name="id" value="<?= $x['id_hsil']; ?>">
                  <p>Yakin Ingin Menghapus <?= $title; ?> : <?= $x['mpl']; ?>.?</p>
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
  <!-- /Modal Hapus Mapel -->
      
</main>    

<?php

  include '../layout/footer.php';

?>
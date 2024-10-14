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
  $subtitle = 'Daftar Akun';

  include '../layout/header.php';

  // Data Akun
  if(isset($_POST['cari'])) 
  {
    $kata_cari = htmlspecialchars(strip_tags($_POST['kata_cari']));
    $data_guru = select("SELECT * FROM guru WHERE nama like '%$kata_cari%' OR nip like '%$kata_cari%' ORDER BY nama ASC");
   } else {
    $data_guru = select("SELECT * FROM guru");
  }

  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_guru($_POST) > 0) {
      echo "<script>
              alert('Data Akun Berhasil Ditambahkan');
              document.location.href = 'admin_akun.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Akun Gagal Ditambahkan');
              document.location.href = 'admin_akun.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_guru($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Diubah');
                document.location.href = 'admin_akun.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Diubah');
                document.location.href = 'admin_akun.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_guru($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Dihapus');
                document.location.href = 'admin_akun.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Akun Gagal Dihapus');
                document.location.href = 'admin_akun.php';
              </script>";
    }
  }
  
?>    
        
<main class="container">
  <hr>
  <h1 class="animate__animated animate__fadeInLeft d-flex justify-content-between align-items-center"><?= $title;?> <div class="pengguna"><?= $_SESSION['nama'];?></div></h1>
  <br>

  <!-- Card Akun -->
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

        <div class="table-responsive">

          <table id="table" class="table table-sm table-bordered table-hover">
            <thead class="text-center">
              <tr>
                <th class="bg-secondary">No</th>
                <th class="bg-secondary">NIP</th>
                <th class="bg-secondary">Nama</th>
                <th class="bg-secondary">Alamat</th>
                <th class="bg-secondary">Jenis Kelamin</th>
                <th class="bg-secondary">Agama</th>
                <th class="bg-secondary">Foto</th>
                <th class="bg-secondary">Email</th>
                <th class="bg-secondary">Username</th>
                <th class="bg-secondary">Level</th>
                <th class="bg-secondary">Opsi</th>
              </tr>
            </thead>

            <tbody>
              <?php $no = 1; ?>
                <?php foreach ($data_guru as $x) : ?>
                  <tr style="height: 15px;">
                    <td><?= $no++; ?></td>
                    <td><?= $x['nip']; ?></td>
                    <td><?= $x['nama']; ?></td>
                    <td><?= $x['alamat']; ?></td>
                    <td><?= $x['jenis_kelamin']; ?></td>
                    <td><?= $x['agama']; ?></td>
                    <td><img src="../client/foto/<?= $x['foto']; ?>" alt="" width="70px" height="70px"></td>
                    <td><?= $x['email']; ?></td>
                    <td><?= $x['username']; ?></td>
                    <td><?= $x['level']; ?></td>
                    <td class="text-center">
                    
                      <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $x['id_guru']; ?>">
                        <svg 
                          xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                          <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                        </svg> 
                        Ubah
                      </button>

                      <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $x['id_guru']; ?>">
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
      <!-- /.card-body -->

    </div>
  <!-- /Card Akun -->

  <!-- Modal Akun -->
    <div class="modal-akun">

      <!-- Modal Tambah Akun -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah <?= $subtitle; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"/>
              </div>

              <div class="modal-body">

                <form action="" method="post" enctype="multipart/form-data">

                  <div class="form-floating mb-2">
                    <input type="number" name="nip" id="floatingInput" class="form-control" placeholder="NIP" required>
                    <label for="floatingInput">NIP</label>
                  </div>

                  <div class="form-floating mb-2">
                    <input type="text" name="nama" id="floatingInput" class="form-control" placeholder="Nama" required>
                    <label for="floatingInput">Nama</label>
                  </div>

                  <div class="form-floating mb-2">
                    <textarea name="alamat" id="floatingInput" class="form-control" placeholder="Alamat" required></textarea>
                  </div>

                  <div class="form-group mb-2">
                    <label for="jenis_kelamin">Jenis Kelamin</label> <br>
                    <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="Pria"> Laki - Laki
                    <input type="radio" name="jenis_kelamin" id="jenis_kelamin" value="Wanita"> Perempuan
                  </div>

                  <div class="form-group mb-2">
                    <label for="agama">Agama</label>
                    <select name="agama" id="agama" class="form-control" required>
                      <option>-- Pilih --</option>
                      <option value="Islam">Islam</option>
                      <option value="Kristen">Kristen</option>
                      <option value="Hindu">Hindu</option>
                      <option value="Budha">Budha</option>
                      <option value="Protestan">Protestan</option>
                      <option value="Konghucu">Konghucu</option>
                    </select>
                  </div>

                  <div class="form-group mb-2">
                    <label for="file"><b>Foto</b></label><br>
                    <div class="custom-file">
                      <label class="custom-file-label" for="file">Pilih gambar...</label>
                      <input type="file" class="custom-file-input" id="foto" name="foto" onchange="previewImg()" required>
                    </div>
                  </div>

                  <div class="form-floating mb-2">
                    <input type="email" name="email" id="floatingInput" class="form-control" placeholder="Email" required>
                    <label for="floatingInput">Email</label>
                  </div>

                  <div class="form-floating mb-2">
                    <input type="text" name="username" id="floatingInput" class="form-control" placeholder="Username" required>
                    <label for="floatingInput">Username</label>
                  </div>

                  <div class="form-floating mb-2">
                    <input type="password" name="password" id="floatingInput" class="form-control" placeholder="Password" required>
                    <label for="floatingInput">Password</label>
                  </div>

                  <div class="form-group mb-2">
                    <label for="level">Level</label>
                    <select name="level" id="level" class="form-control" required>
                      <option>-- Pilih --</option>
                      <option value="Admin">Admin</option>
                      <option value="Guru">Guru</option>
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
      <!-- /Modal Tambah Akun -->

      <!-- Modal Ubah Akun -->
        <?php foreach ($data_guru as $x) : ?>
          <div class="modal fade" id="modalUbah<?= $x['id_guru']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $subtitle; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                </div>

                <div class="modal-body">

                  <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_guru" value="<?= $x['id_guru']; ?>">

                      <div class="form-floating mb-3">
                        <input type="text" name="nip" id="floatingInput" class="form-control" placeholder="NIP" value="<?= $x['nip']; ?>" required>
                        <label for="floatingInput">NIP</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" name="nama" id="floatingInput" class="form-control" placeholder="Nama" value="<?= $x['nama']; ?>" required>
                        <label for="floatingInput">Nama</label>
                      </div>

                      <div class="form-floating mb-2">
                        <textarea name="alamat" id="floatingInput" class="form-control" placeholder="" required><?= $x['alamat']; ?></textarea>
                      </div>

                      <div class="form-group mb-3">
                        <label for="floatingInput">Jenis Kelamin</label><br>
                        <input type="radio" name="jenis_kelamin" id="floatingInput" value="Pria" <?php if($x['jenis_kelamin'] == 'Pria') print 'checked'; ?>> Laki - Laki
                        <input type="radio" name="jenis_kelamin" id="floatingInput" value="Wanita" <?php if($x['jenis_kelamin'] == 'Wanita') print 'checked'; ?>> Perempuan
                      </div>

                      <div class="form-group mb-3">
                        <label for="floatingInput">Agama</label>
                        <select name="agama" id="agama" class="form-control" required>
                          <option value="Islam" <?= $x['agama'] == 'Islam' ? 'selected' : null  ?>>Islam</option>
                          <option value="Kristen" <?= $x['agama'] == 'Kristen' ? 'selected' : null  ?>>Kristen</option>
                          <option value="Hindhu" <?= $x['agama'] == 'Hindhu' ? 'selected' : null  ?>>Hindhu</option>
                          <option value="Budha" <?= $x['agama'] == 'Budha' ? 'selected' : null  ?>>Budha</option>
                          <option value="Protestan" <?= $x['agama'] == 'Protestan' ? 'selected' : null  ?>>Protestan</option>
                          <option value="Konghuchu" <?= $x['agama'] == 'Konghuchu' ? 'selected' : null  ?>>Konghuchu</option>
                        </select>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="email" name="email" id="floatingInput" class="form-control" placeholder="Email" value="<?= $x['email']; ?>" required>
                        <label for="floatingInput">Email</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" name="username" id="floatingInput" class="form-control" placeholder="Username" value="<?= $x['username']; ?>" required>
                        <label for="floatingInput">Username</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="password" name="password" id="floatingInput" class="form-control" placeholder="Password" required>
                        <label for="floatingInput">Password</label>
                      </div>

                      <div class="form-group mb-3">
                        <label for="floatingInput">Level</label>
                        <select name="level" id="level" class="form-control" required>
                          <option value="Admin" <?= $x['level'] == 'Admin' ? 'selected' : null  ?>>Admin</option>
                          <option value="Guru" <?= $x['level'] == 'Guru' ? 'selected' : null  ?>>Guru</option>
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
      <!-- /Modal Ubah AKun -->

      <!-- Modal Hapus Akun -->
        <?php foreach ($data_guru as $x) : ?>
          <div class="modal fade" id="modalHapus<?= $x['id_guru']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $subtitle; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                      </div>

                      <div class="modal-body">
                        <form action="" method="post">
                        <input type="hidden" name="id_guru" value="<?= $x['id_guru']; ?>">
                        <input type="hidden" name="fotoLama" value="<?= $x['foto']; ?>">
                          <p>Yakin Ingin Menghapus <?= $subtitle; ?> : <?= $x['nama']; ?>.?</p>
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
      <!-- /Modal Hapus Akun -->
        
    </div>
  <!-- /Modal Akun -->

</main>    

<?php

  include '../layout/footer.php';

?>
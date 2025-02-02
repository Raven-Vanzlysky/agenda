<?php

  include "../config/app.php";

  $profile = $_SESSION['id_guru'];

  $myprofile  = 'Profile Saya';

  $data_profile = select("SELECT * FROM guru WHERE id_guru = '$profile'");

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubahProfile'])) {
    if (ubah_profile_guru($_POST) > 0) {
        echo "<script>
                alert('Data Akun Berhasil Diubah');
              </script>";
        header("Refresh: 0");
        exit();
    } else {
        echo "<script>
                alert('Data Akun Gagal Diubah');
              </script>";
    }
  }

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta author="&copy;Raven" content="All right has been reserved" />
    <title><?= $title; ?></title>

    <style>
      body {
        /* user-select: none; */
      }
      img {
        -webkit-user-drag: none;
      }
    </style>

    <link rel="icon" type="image/png" href="../assets/img/g1W.png"/>
    <link rel="stylesheet" href="../assets/css/style.css"/>
  
  </head>
  <body>

    <header>

      <nav id="themeNavbar" class="navbar bg-secondary navbar-expand-lg mt-1 ms-1 me-1">
        <div class="container-fluid d-flex justify-content-between align-items-center">
          
            <a class="navbar-brand animate__animated animate__bounceIn" href="https://www.instagram.com/ioreum.d?igsh=YnVrbWlwMXdkbGpo">
              <img src="../assets/img/g1.png" width="75" height="75" alt="Gambar">
            </a>
            <button 
              class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav nav-tabs me-auto mb-2 mb-lg-0">

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Menu
                  </a>
                  <ul class="dropdown-menu">

                    <?php if ($_SESSION['level'] == 'Admin') : ?>
                      <li><a class="dropdown-item" href="index.php">
                      <i class="bi bi-house-fill"></i>
                        Home
                      </a></li>
                      <li><a class="dropdown-item" href="admin_akun.php">
                      <i class="bi bi-person-circle"></i>
                        Kelola Akun
                      </a></li>
                      <li><a class="dropdown-item" href="admin_mapel.php">
                      <i class="bi bi-book"></i>
                        Kelola Mata Pelajaran
                      </a></li>
                      <li><a class="dropdown-item" href="admin_jurusan.php">
                      <i class="bi bi-tools"></i>
                        Kelola Jurusan
                      </a></li>
                      <li><a class="dropdown-item" href="admin_kelas.php">
                      <i class="bi bi-123"></i>
                        </svg>
                        Kelola Kelas
                      </a></li>
                      <li><a class="dropdown-item" href="admin_tahun_ajaran.php">
                      <i class="bi bi-calendar-day"></i>
                        Tahun Ajaran
                      </a></li>
                      <li><a class="dropdown-item" href="admin_manage_file.php">
                      <i class="bi bi-folder2-open"></i>
                        Manage File
                      </a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION['level'] == 'Guru') : ?>
                      <li><a class="dropdown-item" href="index.php">
                      <i class="bi bi-house-fill"></i>
                        Home
                      </a></li>
                      <li><a class="dropdown-item" href="main.php">
                      <i class="bi bi-journal-text"></i>
                        Mata Pelajaran
                      </a></li>
                      <li><a class="dropdown-item" href="agenda_pengajaran.php">
                      <i class="bi bi-journal-bookmark"></i>
                        Agenda Pengajaran
                      </a></li>
                    <?php endif; ?>
                    
                  
                  </ul>
                </li>

              </ul>
            
              <div>
              <?php foreach ($data_profile as $x) : ?>
                <a 
                  class="navbar-brand dropdown d-lg-inline d-block animate__animated animate__bounceIn" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="../assets/client/foto/<?= $x['foto'] ?>" class="rounded-circle border border-3 img-fluid" style="width: 50px; height: 50px; object-fit: cover;" alt="Gambar">
                </a>

                <ul style="margin-top: -10px;" class="dropdown-menu dropdown-menu-end me-3">
                  <li><button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#modalProfile<?= $x['id_guru']; ?>">
                  <i class="bi bi-person-circle"></i>
                    Profile
                  </button></li>
                  <li><a class="dropdown-item" href="#">
                  <i class="bi bi-gear-wide-connected"></i>
                    Settings
                  </a></li>
                  <li><a class="dropdown-item" href="../logout.php" onclick="return confirm('Yakin ingin keluar.?')">
                  <i class="bi bi-box-arrow-left"></i>
                    Logout
                  </a></li>
                </ul>
                
              </div>
            </div>
        </div>
      </nav>

      <div class="d-flex justify-content-between">
        
        <div class="user ms-5 ps-5 animate__animated animate__fadeInLeft">
         <h5> Pengguna : <?= $_SESSION['nama']; ?> </h5>
        </div>

        <div class="date me-5 animate__animated animate__fadeInRight">
         <?= date("l, d-F-Y"); ?>
        </div>

      </div>
      
    </header>

    <div class="modal-profile">

      <div class="modal fade" id="modalProfile<?= $x['id_guru']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $myprofile; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"/>
            </div>

            <div class="modal-body">

              <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_guru" value="<?= $x['id_guru']; ?>">
                <input type="hidden" name="fotoLama" value="<?= $x['foto']; ?>">

                  <div class="form-group mb-3">
                    <label for="file"><b>Foto</b></label><br>
                    <div class="custom-file">
                      <label class="custom-file-label" for="file">Pilih ulang gambar...</label>
                      <input type="file" class="custom-file-input" id="foto" name="foto" onchange="previewImg()" required>
                    </div>
                    <div class="mt-1">
                      <img src="../assets/client/foto/<?= $x['foto']; ?>" alt="" class="img-thumbnail img-preview" width="100px">
                    </div>
                </div>

                  <div class="form-floating mb-3">
                    <input type="text" name="username" id="floatingInput" class="form-control" placeholder="Username" value="<?= $x['username']; ?>" required>
                    <label for="floatingInput">Username</label>
                  </div>

                  <div class="form-floating mb-3">
                    <input type="password" name="password" id="floatingInput" class="form-control" placeholder="Masukan Password Baru" required>
                    <label for="floatingInput">Masukan Password Baru</label>
                  </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
              <button type="submit" name="ubahProfile" class="btn btn-primary">Ubah</button>
            </div>
              </form>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>

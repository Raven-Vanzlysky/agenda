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

  $title = 'Daftar Agenda Guru';
  $subtitle = 'Daftar Agenda';

  include '../layout/header.php';

  $ID = $_SESSION["id_guru"];

   // Data Akun
   if(isset($_POST['cari'])) 
   {
     $kata_cari = htmlspecialchars(strip_tags($_POST['kata_cari']));
     $data_hasil = select("SELECT hasil_guru.*, guru.id_guru, mapel.*, kelas.*, jurusan.* FROM hasil_guru
     INNER JOIN mapel ON hasil_guru.id_mapel = mapel.id_mapel
     INNER JOIN kelas ON hasil_guru.id_kelas = kelas.id_kelas
     INNER JOIN guru ON hasil_guru.id_guru = guru.id_guru
     INNER JOIN jurusan ON hasil_guru.id_jurusan = jurusan.id_jurusan WHERE hasil_guru.id_guru = $ID AND CONCAT(mpl, kls, jrsn) LIKE '%$kata_cari%' ORDER BY hasil_guru.id_mapel ASC");
    } else {
     $data_hasil = select("SELECT hasil_guru.*, guru.id_guru, mapel.*, kelas.*, jurusan.* FROM hasil_guru
     INNER JOIN mapel ON hasil_guru.id_mapel = mapel.id_mapel
     INNER JOIN kelas ON hasil_guru.id_kelas = kelas.id_kelas
     INNER JOIN guru ON hasil_guru.id_guru = guru.id_guru
     INNER JOIN jurusan ON hasil_guru.id_jurusan = jurusan.id_jurusan WHERE hasil_guru.id_guru = $ID");
   }
 
  // jika tombol tambah di tekan jalankan script berikut
  if (isset($_POST['tambah'])) {
    if (tambah_data_absn($_POST) > 0) {
      echo "<script>
              alert('Data Absensi Berhasil Ditambahkan');
              document.location.href = 'agenda_pengajaran.php';
            </script>";
    } else {
        echo "<script>
              alert('Data Absensi Gagal Ditambahkan');
              document.location.href = 'agenda_pengajaran.php';
            </script>";
    }
  }

  // jika tombol ubah di tekan jalankan script berikut
  if (isset($_POST['ubah'])) {
    if (ubah_data_absn($_POST) > 0) {
        echo "<script>
                alert('Data Absensi Berhasil Diubah');
                document.location.href = 'agenda_pengajaran.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Absensi Gagal Diubah');
                document.location.href = 'agenda_pengajaran.php';
              </script>";
    }
  }

  // jika tombol hapus di tekan jalankan script berikut
  if (isset($_POST['hapus'])) {
    if (hapus_data_absn($_POST) > 0) {
        echo "<script>
                alert('Data Absensi Berhasil Dihapus');
                document.location.href = 'agenda_pengajaran.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Absensi Gagal Dihapus');
                document.location.href = 'agenda_pengajaran.php';
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

          <div class="card-wrap d-flex justify-content-between align-items-center">

            <h3 class="card-title"><?= $title; ?></h3>

            <form class="form" action="" method="post">
              <div class="input-group">
                <input type="search" class="form-control me-1" name="kata_cari" placeholder="Cari..." aria-label="Search" value="<?php if(isset($_POST['cari'])) { echo $_POST['kata_cari']; } ?>">
                <button class="btn ms-1 btn-outline-info me-1" type="submit" name="cari"><i class="bi bi-search"></i></button>
              </div>
            </form>
          </div>

        </div>
      <!-- /.card-header -->

      <!-- .card-body -->
        <div class="card-body overflow-auto" style="max-height: 400px;">

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
                  <?php foreach ($data_hasil as $x) : ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $x['mpl']; ?></td>
                      <td><?= $x['kls']; ?></td>
                      <td><?= $x['jrsn']; ?></td>
                      
                      <td class="text-center">
                        <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#extraLargeModal<?= $x['id_hsil']; ?>">
                        <i class="bi bi-search"></i>
                          View Agenda
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
    <?php foreach ($data_hasil as $x0) : ?>
        <div class="modal fade" id="extraLargeModal<?= $x0['id_hsil']; ?>" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="extraLargeModalLabel">Identitas Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"/>
              </div>

              <div class="modal-body">
                    
                <div class="table-responsive">

                  <table align="center" style="width: max-content;" id="table2" class="table table-bordered table-hover">
                  
                      <tr>
                        <th style="width: 230px;" class="bg-secondary">Mapel</th>
                        
                        <td style="width: 230px;" class=""><?= $x0['mpl']; ?></td>
                      </tr>

                      <tr>
                        <th style="width: 230px;" class="bg-secondary">Kelas</th>
                        
                        <td style="width: 230px;" class=""><?= $x0['kls']; ?></td>
                      </tr>

                      <tr>
                        <th style="width: 230px;" class="bg-secondary">Jurusan</th>
                     
                        <td style="width: 230px;" class=""><?= $x0['jrsn']; ?></td>
                      </tr>
                    
                  </table>
                  
                </div>

                  <hr>

                  <div class="card">

                    <div class="card-header">

                      <h3 class="card-title"><?= $subtitle; ?></h3>

                      <button type="button" class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalTambahAbsn<?= $x0['id_hsil']; ?>">
                      <i class="bi bi-plus-circle"></i>
                        Tambah
                      </button> 
                      <a class="btn btn-sm mb-1 btn-secondary" href="cetak.php?id=<?= $x0['id_hsil']; ?>" target="_blank">
                      <i class="bi bi-printer"></i>
                        Cetak / Print
                      </a>

                    </div>

                    <div class="card-body overflow-auto" style="max-height: 400px;">
                    
                      <div class="table-responsive">

                        <table id="table3" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th class="bg-secondary text-center">No</th>
                              <th class="bg-secondary text-center">Tanggal</th>
                              <th class="bg-secondary text-center">Materi</th>
                              <th class="bg-secondary text-center">Absen</th>
                              <th class="bg-secondary text-center">Keterangan</th>
                              <th class="bg-secondary text-center">Opsi</th>
                            </tr>
                          </thead>

                          <tbody>
                            <?php $no = 1; $id = $x0['id_hsil']; ?>
                            <?php $data_agenda = select("SELECT dftr_agnd.*, hasil_guru.*, guru.id_guru, mapel.mpl, mapel.id_mapel, kelas.kls, jurusan.jrsn
                            FROM dftr_agnd 
                            INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
                            INNER JOIN mapel ON dftr_agnd.id_mapel = mapel.id_mapel
                            INNER JOIN kelas ON dftr_agnd.id_kelas = kelas.id_kelas
                            INNER JOIN guru ON dftr_agnd.id_guru = guru.id_guru 
                            INNER JOIN jurusan ON dftr_agnd.id_jurusan = jurusan.id_jurusan 
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
                                    <i class="bi bi-pen"></i> 
                                      Ubah
                                    </button>

                                    <a href="../assets/client/file/<?= $x1['file'];?>" target="_blank" class="btn btn-warning mb-1" >
                                    <i class="bi bi-download"></i>
                                        Download File
                                    </a>

                                    <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapusAbsn<?= $x1['id_agnd']; ?>">
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

                  </div>

              </div>

              <div class="modal-footer">
                <!-- Kosong? -->
              </div>
          
            </div>
          </div>
        
        </div>
      
  <!-- /Modal Detail -->

  <!-- Modal Absensi/Agenda -->
    
      <div class="modal-absen">

        <!-- Modal Tambah Absen -->
          <?php foreach ($data_hasil as $x2) : ?>
            <div class="modal fade" id="modalTambahAbsn<?= $x2['id_hsil'];?>" tabindex="-1" aria-labelledby="defaultModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAbsn">Tambah <?= $subtitle; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                  </div>

                  <div class="modal-body">
                  
                    <form action="" method="post" enctype="multipart/form-data">

                      <input type="hidden" name="id_hsil" value="<?= $x2['id_hsil']; ?>">
                      <input type="hidden" name="id_guru" value="<?= $x2['id_guru']; ?>">
                      <input type="hidden" name="id_mapel" value="<?= $x2['id_mapel']; ?>">
                      <input type="hidden" name="id_kelas" value="<?= $x2['id_kelas']; ?>">
                      <input type="hidden" name="id_jurusan" value="<?= $x2['id_jurusan']; ?>">

                      <div class="form-group mb-2">
                        <label for="groupInput">Tanggal</label>
                        <input type="date" id="groupInput" name="tgl" class="form-control" placeholder="Tanggal" required>
                      </div>

                      <div class="form-group mb-2">
                        <label for="groupInput">Jam</label>
                        <input type="time" id="groupInput" name="jam" class="form-control" placeholder="Jam" required>
                      </div>

                      <div class="form-group mb-2">
                        <textarea name="mtri" class="form-control" placeholder="Pokok Bahasan" required></textarea>
                      </div>

                      <div class="form-group mb-2">
                        <textarea name="absn" class="form-control" placeholder="Absen" required></textarea>
                      </div>

                      <div class="form-group mb-2">
                        <textarea name="ktr" class="form-control" placeholder="Keterangan" required></textarea>
                      </div>

                      <div class="form-group mb-2">
                        <label for="file"><b>File</b></label><br>
                        <div class="form-control">
                          <label for="file">Pilih file...</label>
                          <input type="file" id="file" name="file" required>
                        </div>
                      </div>
                          
                  </div>

                  <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </form>
                  </div>
                        
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <!-- /Modal Tambah Absen -->

        <!-- Modal Ubah Absen -->
          <?php foreach ($data_agenda as $x3) : ?>
            <div class="modal fade" id="modalUbahAbsn<?= $x3['id_agnd']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $subtitle; ?> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"/>
                  </div>

                  <div class="modal-body">

                    <form action="" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="id_agnd" value="<?= $x3['id_agnd']; ?>">
                      <input type="hidden" name="fileLama" value="<?= $x3['file']; ?>">

                        <div class="form-group mb-3">
                          <label for="groupInput">Tanggal</label>
                          <input type="date" id="groupInput" name="tgl" class="form-control" placeholder="Tanggal" value="<?= $x3['tgl']; ?>" required>
                        </div>

                        <div class="form-group mb-3">
                          <label for="groupInput">Jam</label>
                          <input type="time" id="groupInput" name="jam" class="form-control" placeholder="Jam" value="<?= $x3['jam']; ?>" required>
                        </div>

                        <div class="form-group mb-3">
                          <label for="groupInput">Materi</label>
                          <textarea id="groupInput" name="mtri" class="form-control" placeholder="Pokok Bahasan" required><?= $x3['mtri']; ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                          <label for="groupInput">Absen</label>
                          <textarea id="groupInput" name="absn" class="form-control" placeholder="Keterangan" required><?= $x3['absn']; ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                          <label for="groupInput">Keterangan</label>
                          <textarea id="groupInput" name="ktr" class="form-control" placeholder="Keterangan" required><?= $x3['ktr']; ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                          <label for="file"><b>File</b></label><br>
                          <div class="form-control">
                            <label for="file">Pilih ulang file...</label>
                            <input type="file" id="file" name="file">
                          </div>
                        </div>

                  </div>

                  <div class="modal-footer">
                    <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                    </form>
                  </div>
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
                      <input type="hidden" name="fileLama" value="<?= $x4['file']; ?>">
                        <p>Yakin Ingin Menghapus Absen Mata Pelajaran <?= $x4['mpl']; ?> <?= $x4['kls'] . ' ' . $x4['jrsn']; ?>.?</p>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                    </form>
                  </div>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <!-- /Modal Hapus Absen -->

      </div>
   
  <!-- /Modal Absensi/Agenda -->
      
    <?php endforeach; ?>

</main>    

<?php

  include '../layout/footer.php';

?>
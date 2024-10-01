<?php //tampil&upload

  // fungsi menampilkan
  function select($query)
  {
    // panggil koneksi database
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
  }

  // fungsi mengupload foto
  function upload_foto()
  {
    $namaFile   = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error      = $_FILES['foto']['error'];
    $tmpName    = $_FILES['foto']['tmp_name'];
    
    // check file yang diupload
    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile      = explode('.', $namaFile);
    $extensifile      = strtolower(end($extensifile));

    // check format/extensi file
    if (!in_array($extensifile, $extensifileValid)) {
        // pesan gagal
        echo "<script>
                alert('Format File Tidak Valid');
                document.location.href = 'admin_akun.php';
                </script>";
                die();
              }
              
              // check ukuran file 2 MB
              if ($ukuranFile > 2048000) {
                // pesan gagal
          echo "<script>
                alert('Ukuran File Max 2 MB');
                document.location.href = 'admin_akun.php';
              </script>";
        die();
    }

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    // pindahkan ke folder local
    move_uploaded_file($tmpName, '../client/foto/' . $namaFileBaru);
    return $namaFileBaru;
  }

  // fungsi mengupload file
  function upload_file()
  {
      $namaFile   = $_FILES['file']['name'];
      $ukuranFile = $_FILES['file']['size'];
      $error      = $_FILES['file']['error'];
      $tmpName    = $_FILES['file']['tmp_name'];
      
      // Check file yang diupload
      $extensifileValid = ['pdf', 'docx', 'xlsx'];
      $extensifile      = explode('.', $namaFile);
      $extensifile      = strtolower(end($extensifile));

      // Check format/extensi file
      if (!in_array($extensifile, $extensifileValid)) {
          // Pesan gagal
          echo "<script>
                  alert('Format File Tidak Valid');
                  document.location.href = 'admin_akun.php';
                </script>";
          die();
      }
                
      // Check ukuran file 300 MB
      if ($ukuranFile > 300000000) {
          // Pesan gagal
          echo "<script>
                  alert('Ukuran File Max 2 MB');
                  document.location.href = 'admin_akun.php';
                </script>";
          die();
      }

      // generate nama file baru
      $namaFileBaru = uniqid();
      $namaFileBaru .= '.';
      $namaFileBaru .= $extensifile;

      // Pindahkan ke folder lokal dengan nama file asli
      move_uploaded_file($tmpName, '../client/file/' . $namaFileBaru);
      return $namaFileBaru;
  }

?>

<?php //Perguruan

  // fungsi tambah akun
  function tambah_data_guru($post)
  {
    global $db;

    $nip       = strip_tags($post['nip']);
    $nama      = strip_tags($post['nama']);
    $jnis_klmn   = strip_tags($post['jenis_kelamin']);
    $agama   = strip_tags($post['agama']);
    $foto   = upload_foto();
    $email   = strip_tags($post['email']);
    $username   = strip_tags($post['username']);
    $password   = strip_tags($post['password']);
    $level   = strip_tags($post['level']);

   // check upload foto
    if (!$foto) {
      return false;
    }
    
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // query tambah data
    $query = "INSERT INTO guru VALUES('$nip','$nama', '$jnis_klmn', '$agama', '$foto', '$email', '$username', '$password', '$level')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

  // fungsi ubah akun
  function ubah_data_guru($post)
  {
    global $db;
    
    $nip         = strip_tags($post['nip']);
    $nama       = strip_tags($post['nama']);
    $jnis_klmn       = strip_tags($post['jenis_kelamin']);
    $agama       = strip_tags($post['agama']);
    $fotoLama   = strip_tags($post['fotoLama']);
    $email       = strip_tags($post['email']);
    $username   = strip_tags($post['username']);
    $password   = strip_tags($post['password']);
    $level   = strip_tags($post['level']);

    // Hapus Foto
    $filePoto = '../client/foto/' . $fotoLama;

    if (file_exists($filePoto)) {
      if (unlink($filePoto)) {
        print "Foto Berhasil Di Hapus";
      } else {
        print "Gagal Menghapus Foto";
      }
    } else {
      print "Foto Tidak Di temukan";
    }

    // check upload foto baru atau tidak
    if ($_FILES['foto']['error'] == 4) {
      $foto = $fotoLama;
    } else {
      $foto = upload_foto();
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // query ubah data
    $query = "UPDATE guru SET nama = '$nama', jenis_kelamin = '$jnis_klmn', agama = '$agama', foto = '$foto', email = '$email', username = '$username', password = '$password', level = '$level' WHERE nip = $nip";
    
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);

  }

  // fungsi menghapus data guru
  function hapus_data_guru($post)
  {
    global $db;
    
    $nip = strip_tags($post['nip']);
    $fotoLama = strip_tags($post['fotoLama']);

    // Hapus Foto
    $filePoto = '../client/foto/' . $fotoLama;

    if (file_exists($filePoto)) {
      if (unlink($filePoto)) {
        print "Foto Berhasil Di Hapus";
      } else {
        print "Gagal Menghapus Foto";
      }
    } else {
      print "Foto Tidak Di temukan";
    }
    
    // query hapus data mapel
    $query = "DELETE FROM guru WHERE nip = $nip";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

?>

<?php //Mapel

  // fungsi menambahkan data mapel
  function tambah_data_mapel($post)
  {
    global $db;

    $mapel = strip_tags($post['mpl']);  
    
    // query tambah data
    $query = "INSERT INTO mapel VALUES(null, '$mapel')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data mapel
  function ubah_data_mapel($post)
  {
    global $db;
    
    $id   = strip_tags($post['id_mapel']);
    $mapel = strip_tags($post['mpl']);
    
    // query ubah data
    $query = "UPDATE mapel SET mpl = '$mapel' WHERE id_mapel = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data mata_pljrn
  function hapus_data_mapel($post)
  {
    global $db;

    $id = strip_tags($post['id_mapel']);
    
    // query hapus data mata_pljrn
    $query = "DELETE FROM mapel WHERE id_mapel = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }


?>

<?php //Jurusan

  // fungsi menambahkan data jurusan
  function tambah_data_jurusan($post)
  {
    global $db;

    $jurusan = strip_tags($post['jrsn']);  
    
    // query tambah data
    $query = "INSERT INTO jurusan VALUES(null, '$jurusan')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data jurusan
  function ubah_data_jurusan($post)
  {
    global $db;
    
    $id   = strip_tags($post['id_jurusan']);
    $jurusan = strip_tags($post['jrsn']);
    
    // query ubah data
    $query = "UPDATE jurusan SET jrsn = '$jurusan' WHERE id_jurusan = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data mata_pljrn
  function hapus_data_jurusan($post)
  {
    global $db;

    $id = strip_tags($post['id_jurusan']);
    
    // query hapus data mata_pljrn
    $query = "DELETE FROM jurusan WHERE id_jurusan = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }


?>

<?php //Kelas

  // fungsi menambahkan data kelas
  function tambah_data_kelas($post)
  {
    global $db;

    $kelas = strip_tags($post['kls']);  
    
    // query tambah data
    $query = "INSERT INTO kelas VALUES(null, '$kelas')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data kelas
  function ubah_data_kelas($post)
  {
    global $db;
    
    $id   = strip_tags($post['id_kelas']);
    $kelas = strip_tags($post['kls']);
    
    // query ubah data
    $query = "UPDATE kelas SET kls = '$kelas' WHERE id_kelas = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data mata_pljrn
  function hapus_data_kelas($post)
  {
    global $db;

    $id = strip_tags($post['id_kelas']);
    
    // query hapus data mata_pljrn
    $query = "DELETE FROM kelas WHERE id_kelas = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

?>

<?php //Tahun Ajaran

  // fungsi menambahkan data tahun ajaran
  function tambah_data_thnajar($post)
  {
    global $db;

    $thn = strip_tags($post['thn_ajr']);  
    
    // query tambah data
    $query = "INSERT INTO thn_ajar VALUES(null, '$thn')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data tahun ajaran
  function ubah_data_thnajar($post)
  {
    global $db;
    
    $id   = strip_tags($post['id_ajr']);
    $thn = strip_tags($post['thn_ajr']);
    
    // query ubah data
    $query = "UPDATE thn_ajar SET tahun_ajaran = '$thn' WHERE id_ajaran = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data tahun ajaran
  function hapus_data_thnajar($post)
  {
    global $db;

    $id = strip_tags($post['id_ajr']);
    
    // query hapus data mata_pljrn
    $query = "DELETE FROM thn_ajar WHERE id_ajaran = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }


?>

<?php //Hasil Guru

  // fungsi menambahkan data kelas
  function tambah_data_hg($post)
  {
    global $db;

    $nip = strip_tags($post['nip']);  
    $mapel = strip_tags($post['mpl']);  
    $kelas = strip_tags($post['kls']);  
    $jurusan = strip_tags($post['jrsn']);
    
    // query tambah data
    $query = "INSERT INTO hasil_guru VALUES(null, '$nip', '$mapel', '$kelas', '$jurusan', '')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data kelas
  function ubah_data_hg($post)
  {
    global $db;
    
    $id   = strip_tags($post['id']);
    $nip   = strip_tags($post['nip']);
    $mapel = strip_tags($post['mpl']);
    $kelas = strip_tags($post['kls']);
    $jurusan = strip_tags($post['jrsn']);
    
    // query ubah data
    $query = "UPDATE hasil_guru SET mpl = '$mapel', nip = '$nip', kls = '$kelas', jrsn = '$jurusan', '' WHERE id_hsil = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data mata_pljrn
  function hapus_data_hg($post)
  {
    global $db;

    $id = strip_tags($post['id']);
    $fileLama = strip_tags($post['fileLama']);

    // Hapus Foto
    $fileApus = '../client/file/' . $fileLama;

    if (file_exists($fileApus)) {
      if (unlink($fileApus)) {
        print "File Berhasil Di Hapus";
      } else {
        print "Gagal Menghapus Foto";
      }
    } else {
      print "File Tidak Di temukan";
    }
    
    // query hapus data mata_pljrn
    $query = "DELETE FROM hasil_guru WHERE id_hsil = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

  // fungsi ubah data kelas
  function tambah_data_upload_hg($post)
  {
    global $db;
    
    $id   = strip_tags($post['id']);

    $file = upload_file();
    $fileLama = strip_tags($post['fileLama']);

    // Hapus File
    $fileApus = '../clienr/file/' . $fileLama;

    if (file_exists($fileApus)) {
      if (unlink($fileApus)) {
        print "File Berhasil Di Hapus";
      } else {
        print "Gagal Menghapus Foto";
      }
    } else {
      print "File Tidak Di temukan";
    }
    
    // query ubah data
    $query = "UPDATE hasil_guru SET file = '$file' WHERE id_hsil = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

?>

<?php //Absensi Agenda

  // fungsi menambahkan data absensi
  function tambah_data_absn($post)
  {
    global $db;

    $id_hsil   = strip_tags($post['id_hsil']);
    $tgl = strip_tags($post['tgl']);   
    $jam = strip_tags($post['jam']);  
    $mtri = strip_tags($post['mtri']);  
    $absn = strip_tags($post['absn']);  
    $ktr = strip_tags($post['ktr']);  
    
    // query tambah data
    $query = "INSERT INTO dftr_agnd VALUES(null, '$id_hsil', '$tgl', '$jam', '$mtri', '$absn', '$ktr')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data mapel
  function ubah_data_absn($post)
  {
    global $db;
    
    $id   = strip_tags($post['id']);
    $id_hsil   = strip_tags($post['id_hsil']);
    $tgl = strip_tags($post['tgl']);  
    $jam = strip_tags($post['jam']);  
    $mtri = strip_tags($post['mtri']);  
    $absn = strip_tags($post['absn']);  
    $ktr = strip_tags($post['ktr']);  
    
    // query ubah data
    $query = "UPDATE dftr_agnd SET id_hsil = '$id_hsil', tgl = '$tgl', jam = '$jam', mtri = '$mtri', absn = '$absn', ktr = '$ktr' WHERE id_agnd = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data mata_pljrn
  function hapus_data_absn($post)
  {
    global $db;

    $id = strip_tags($post['id']);
    
    // query hapus data mata_pljrn
    $query = "DELETE FROM dftr_agnd WHERE id_agnd = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

?>
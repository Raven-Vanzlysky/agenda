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

<?php //Pengguna

  // fungsi ubah foto profile
  function ubah_profile_guru($post)
  {
    global $db;
    
    $id         = htmlspecialchars(strip_tags($post['id_guru']));
    $fotoLama   = htmlspecialchars(strip_tags($post['fotoLama']));
    $username   = htmlspecialchars(strip_tags($post['username']));
    $password   = htmlspecialchars(strip_tags($post['password']));

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
    $query = "UPDATE guru SET foto = '$foto', username = '$username', password = '$password' WHERE id_guru = $id";
    
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);

  }

  // fungsi tambah akun
  function tambah_data_guru($post)
  {
    global $db;

    $nip       = htmlspecialchars(strip_tags($post['nip']));
    $nama      = htmlspecialchars(strip_tags($post['nama']));
    $alamat      = htmlspecialchars(strip_tags($post['alamat']));
    $jnis_klmn   = htmlspecialchars(strip_tags($post['jenis_kelamin']));
    $agama   = htmlspecialchars(strip_tags($post['agama']));
    $foto   = upload_foto();
    $email   = htmlspecialchars(strip_tags($post['email']));
    $username   = htmlspecialchars(strip_tags($post['username']));
    $password   = htmlspecialchars(strip_tags($post['password']));
    $level   = htmlspecialchars(strip_tags($post['level']));

   // check upload foto
    if (!$foto) {
      return false;
    }
    
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // query tambah data
    $query = "INSERT INTO guru VALUES('', '$nip', '$nama', '$alamat', '$jnis_klmn', '$agama', '$foto', '$email', '$username', '$password', '$level')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

  // fungsi ubah akun
  function ubah_data_guru($post)
  {
    global $db;
    
    $id         = htmlspecialchars(strip_tags($post['id_guru']));
    $nip         = htmlspecialchars(strip_tags($post['nip']));
    $nama       = htmlspecialchars(strip_tags($post['nama']));
    $alm       = htmlspecialchars(strip_tags($post['alamat']));
    $jnis_klmn       = htmlspecialchars(strip_tags($post['jenis_kelamin']));
    $agama       = htmlspecialchars(strip_tags($post['agama']));
    $email       = htmlspecialchars(strip_tags($post['email']));
    $username   = htmlspecialchars(strip_tags($post['username']));
    $password   = htmlspecialchars(strip_tags($post['password']));
    $level   = htmlspecialchars(strip_tags($post['level']));

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // query ubah data
    $query = "UPDATE guru SET nip = '$nip', nama = '$nama', alamat = '$alm', jenis_kelamin = '$jnis_klmn', agama = '$agama', email = '$email', username = '$username', password = '$password', level = '$level' WHERE id_guru = $id";
    
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);

  }

  // fungsi menghapus data akun
  function hapus_data_guru($post)
  {
    global $db;
    
    $id = strip_tags($post['id_guru']);
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
    $query = "DELETE FROM guru WHERE id_guru = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }

?>

<?php //Mapel

  // fungsi menambahkan data mapel
  function tambah_data_mapel($post)
  {
    global $db;

    $mapel = htmlspecialchars(strip_tags($post['mpl']));  
    
    // query tambah data
    $query = "INSERT INTO mapel VALUES(null, '$mapel')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data mapel
  function ubah_data_mapel($post)
  {
    global $db;
    
    $id   = htmlspecialchars(strip_tags($post['id_mapel']));
    $mapel = htmlspecialchars(strip_tags($post['mpl']));
    
    // query ubah data
    $query = "UPDATE mapel SET mpl = '$mapel' WHERE id_mapel = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data mapel
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

    $jurusan = htmlspecialchars(strip_tags($post['jrsn']));  
    
    // query tambah data
    $query = "INSERT INTO jurusan VALUES(null, '$jurusan')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data jurusan
  function ubah_data_jurusan($post)
  {
    global $db;
    
    $id   = htmlspecialchars(strip_tags($post['id_jurusan']));
    $jurusan = htmlspecialchars(strip_tags($post['jrsn']));
    
    // query ubah data
    $query = "UPDATE jurusan SET jrsn = '$jurusan' WHERE id_jurusan = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data kelas
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

    $kelas = htmlspecialchars(strip_tags($post['kls']));  
    
    // query tambah data
    $query = "INSERT INTO kelas VALUES(null, '$kelas')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data kelas
  function ubah_data_kelas($post)
  {
    global $db;
    
    $id   = htmlspecialchars(strip_tags($post['id_kelas']));
    $kelas = htmlspecialchars(strip_tags($post['kls']));
    
    // query ubah data
    $query = "UPDATE kelas SET kls = '$kelas' WHERE id_kelas = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data kelas
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

    $thn = htmlspecialchars(strip_tags($post['thn_ajr']));  
    $sts = htmlspecialchars(strip_tags($post['status']));  
    
    // query tambah data
    $query = "INSERT INTO thn_ajar VALUES(null, '$thn', '$sts')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data tahun ajaran
  function ubah_data_thnajar($post)
  {
    global $db;
    
    $id   = htmlspecialchars(strip_tags($post['id_ajr']));
    $thn = htmlspecialchars(strip_tags($post['thn_ajr']));
    $sts = htmlspecialchars(strip_tags($post['status']));
    
    // query ubah data
    $query = "UPDATE thn_ajar SET tahun_ajaran = '$thn', status = '$sts' WHERE id_ajaran = $id";
    
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

  // fungsi menambahkan data hasil guru
  function tambah_data_hg($post)
  {
    global $db;

    $id = strip_tags($post['id']);  
    $mapel = strip_tags($post['mpl']);  
    $kelas = strip_tags($post['kls']);  
    $jurusan = strip_tags($post['jrsn']);
    
    // query tambah data
    $query = "INSERT INTO hasil_guru VALUES(null, '$id', '$kelas', '$mapel', '$jurusan', '')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data hasil guru
  function ubah_data_hg($post)
  {
    global $db;
    
    $id   = strip_tags($post['id_hsil']);
    $idg   = strip_tags($post['idg']);
    $mapel = strip_tags($post['mpl']);
    $kelas = strip_tags($post['kls']);
    $jurusan = strip_tags($post['jrsn']);
    
    // query ubah data
    $query = "UPDATE hasil_guru SET id_guru = '$idg', id_kelas = '$kelas', id_mapel = '$mapel', id_jurusan = '$jurusan' WHERE id_hsil = '$id'";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data hasil guru
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
    $query1 = "DELETE FROM dftr_agnd WHERE id_hsil = $id";
    
    mysqli_query($db, $query);
    mysqli_query($db, $query1);
    
    return mysqli_affected_rows($db);
  }

  // fungsi tambah file
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

    $id_hsil = htmlspecialchars(strip_tags($post['id_hsil']));   
    $id_guru = htmlspecialchars(strip_tags($post['id_guru']));   
    $id_mapel = htmlspecialchars(strip_tags($post['id_mapel']));   
    $id_kelas = htmlspecialchars(strip_tags($post['id_kelas']));   
    $id_jurusan = htmlspecialchars(strip_tags($post['id_jurusan']));   
    $tgl = htmlspecialchars(strip_tags($post['tgl']));   
    $jam = htmlspecialchars(strip_tags($post['jam']));  
    $mtri = htmlspecialchars(strip_tags($post['mtri']));  
    $absn = htmlspecialchars(strip_tags($post['absn']));  
    $ktr = htmlspecialchars(strip_tags($post['ktr']));  
    
    // query tambah data
    $query = "INSERT INTO dftr_agnd VALUES(null, '$id_hsil', '$id_guru', '$id_mapel', '$id_kelas', '$id_jurusan', '$tgl', '$jam', '$mtri', '$absn', '$ktr')";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi ubah data absensi
  function ubah_data_absn($post)
  {
    global $db;
    
    $id   = htmlspecialchars(strip_tags($post['id_agnd']));
    $tgl = htmlspecialchars(strip_tags($post['tgl']));  
    $jam = htmlspecialchars(strip_tags($post['jam']));  
    $mtri = htmlspecialchars(strip_tags($post['mtri']));  
    $absn = htmlspecialchars(strip_tags($post['absn']));  
    $ktr = htmlspecialchars(strip_tags($post['ktr']));  
    
    // query ubah data
    $query = "UPDATE dftr_agnd SET tgl = '$tgl', jam = '$jam', mtri = '$mtri', absn = '$absn', ktr = '$ktr' WHERE id_agnd = $id";
    
    mysqli_query($db, $query);
    
    return mysqli_affected_rows($db);
  }
  
  // fungsi menghapus data absensi
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
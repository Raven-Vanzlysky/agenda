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

  $PK = $_SESSION["nip"];
  $NM = $_SESSION["nama"];

  $thn = select("SELECT * FROM thn_ajar WHERE status = 'Y'");

?>

<main class="container">
  
  <hr>
  <h1 class="animate__animated animate__fadeInLeft"></h1>
  <br>

  <!-- Card -->
    <div class="card bg-white text-black animate__animated animate__zoomInDown">
      
      <!-- card-header -->
      <!-- /card-header -->

      <!-- card-body -->
       <div class="row">
        <div class="col">
          <div class="card-body text-center">

            <h1>APLIKASI KEGIATAN HARIAN GURU</h1>
            <?php foreach ($thn as $t) : ?>
            <h2>TAHUN AJARAN <?= $t['tahun_ajaran'] ?> </h2>
            <?php endforeach; ?>

            <hr style="border: 1px dashed;">

            <div class="d-flex flex-column align-items-center ">

              <img src="../assets/img/g1.png" class="rounded-circle border img-fluid" height="85px" width="85px" alt="">

            </div>

            <div class="mt-3 d-grid gap-2">

              <div class="">
                  <span class="pe-1"><b>Nama</b></span><span class="pe-1">:</span><span><?= $NM; ?></span>
              </div>

              <div class="">
                  <span class="pe-1"><b>NIP</b></span><span class="pe-1">:</span><span><?= $PK; ?></span>
              </div>

              </div>

            <hr>

            <h1>SMK NEGERI COMPRENG</h1>
            <span>Jl. Raya Compreng, Mekarjaya, Kec. Compreng, Kab. Subang, Prov. Jawa Barat</span>

          </div>
        </div>
       </div>
      <!-- /card-body -->

    </div>
  <!-- /Card -->

</main>

<?php

  include '../layout/footer.php';

?>
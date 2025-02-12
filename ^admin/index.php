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
  $title = 'Home';
  $subtitle0 = 'Data Guru';
  $subtitle1 = 'Data Agenda';
  $subtitle2 = 'Data File';

  include '../layout/header.php';

  // Data table
  $j_g = mysqli_query($db, "SELECT * FROM guru");
  $j_a = mysqli_query($db, "SELECT * FROM dftr_agnd");
  $j_f = mysqli_query($db, "SELECT file FROM dftr_agnd");
  
  // Menghitung jumlah data
  $jum_gu = mysqli_num_rows($j_g);
  $jum_ag = mysqli_num_rows($j_a);
  $jum_fi = mysqli_num_rows($j_f);
  $now  = date("Y-m-d");
  $jum_ag_now = mysqli_num_rows(mysqli_query($db, "SELECT * FROM dftr_agnd WHERE tgl= '$now'"));


?>    
        
<main class="container">
  <hr>
  <h1 class="animate__animated animate__fadeInLeft d-flex justify-content-between align-items-center"><?= $title;?> </h1>
  <br>

  <div class="row pb-3">
    <div class="col">

      <!-- Card Guru -->
        <div class="card animate__animated animate__zoomInDown">

          <!-- .card-header -->
          <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title"><?= $subtitle0; ?></h3>

          </div>
          <!-- /.card-header -->

          <!-- .card-body -->
          <div class="card-body">

            <h2> Jumlah Guru : <?= $jum_gu; ?> </h2>

          </div>
          <!-- /.card-body -->

        </div>
      <!-- /Card Guru -->

    </div>

    <div class="col">

      <!-- Card Agenda -->
        <div class="card animate__animated animate__zoomInDown">

          <!-- .card-header -->
          <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title"><?= $subtitle1; ?></h3>

          </div>
          <!-- /.card-header -->

          <!-- .card-body -->
          <div class="card-body">

             <h2> Jumlah Semua Agenda : <?= $jum_ag; ?> </h2>

          </div>
          <!-- /.card-body -->

        </div>
      <!-- /Card Agenda -->

    </div>
  </div>

  <div class="row pt-3">
    <div class="col">

      <!-- Card Statistik -->
        <div class="card animate__animated animate__zoomInDown">

          <!-- .card-header -->
          <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title"><?= $subtitle2; ?></h3>

          </div>
          <!-- /.card-header -->

          <!-- .card-body -->
          <div class="card-body">

          <h2> Jumlah File : <?= $jum_fi; ?> </h2>

          </div>
          <!-- /.card-body -->

        </div>
      <!-- /Card Statistik -->

    </div>

    <div class="col">

      <!-- Card Statistik -->
        <div class="card animate__animated animate__zoomInDown">

          <!-- .card-header -->
          <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title"><?= $subtitle1; ?></h3>

          </div>
          <!-- /.card-header -->

          <!-- .card-body -->
          <div class="card-body">

          <h2> Jumlah Agenda Hari ini : <?= $jum_ag_now; ?> </h2>

          </div>
          <!-- /.card-body -->

        </div>
      <!-- /Card Statistik -->

    </div>
  </div>

</main>    

<?php

  include '../layout/footer.php';

?>
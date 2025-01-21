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
  $subtitle = 'Data Statistik';

  include '../layout/header.php';

  // Data table
  $j_g = mysqli_query($db, "SELECT * FROM guru");
  $j_a = mysqli_query($db, "SELECT * FROM dftr_agnd");
  
  // Menghitung jumlah data
  $jum_gu = mysqli_num_rows($j_g);
  $jum_ag = mysqli_num_rows($j_a);
  $now  = date("Y-m-d");
  $jum_ag_now = mysqli_num_rows(mysqli_query($db, "SELECT * FROM dftr_agnd WHERE tgl= '$now'"));


?>    
        
<main class="container">
  <hr>
  <h1 class="animate__animated animate__fadeInLeft d-flex justify-content-between align-items-center"><?= $title;?> </h1>
  <br>

  <!-- Card Statistik -->
    <div class="card animate__animated animate__zoomInDown">

      <!-- .card-header -->
      <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title"><?= $subtitle; ?></h3>

      </div>
      <!-- /.card-header -->

      <!-- .card-body -->
      <div class="card-body">

        <div class="table-responsive">
          <table style="width: max-content;" align="center" id="table" class="table table-bordered table-hover">
            <h3>
              <tr>
                <th class="bg-secondary" style="width: 230px;">Agenda Hari Ini </th> <td style="width: 230px;"> <?= $jum_ag_now; ?> </td>
              </tr>
              <tr>
                <th class="bg-secondary" style="width: 230px;">Semua Agenda </th> <td style="width: 230px;"> <?= $jum_ag; ?> </td>
              </tr>
              <tr>
                <th class="bg-secondary" style="width: 230px;">Jumlah Guru </th> <td style="width: 230px;"> <?= $jum_gu; ?> </td>
              </tr>
            </h3>
          </table>
        </div>

      </div>
      <!-- /.card-body -->

    </div>
  <!-- /Card Statistik -->

</main>    

<?php

  include '../layout/footer.php';

?>
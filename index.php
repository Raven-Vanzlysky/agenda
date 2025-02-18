<?php

  session_start();

  include 'config/app.php';

  // check apakah tombol login ditekan
  if (isset($_POST['login'])) {

    // ambil input username dan password
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // check username
    $result = mysqli_query($db, "SELECT * FROM guru WHERE username = '$username'");

    // jika ada usernya
    if (mysqli_num_rows($result) == 1) {

      // check passwordnya
      $hasil = mysqli_fetch_assoc($result);

      if (password_verify($password, $hasil['password'])) {
          // set session
          $_SESSION['login']         = true;
          $_SESSION['id_guru']       = $hasil['id_guru'];
          $_SESSION['nip']           = $hasil['nip'];
          $_SESSION['nama']          = $hasil['nama'];
          $_SESSION['jenis_kelamin'] = $hasil['jenis_kelamin'];
          $_SESSION['agama']         = $hasil['agama'];
          $_SESSION['foto']          = $hasil['foto'];
          $_SESSION['email']         = $hasil['email'];
          $_SESSION['username']      = $hasil['username'];
          $_SESSION['level']         = $hasil['level'];

          // jika login benar arahkan ke file sesuai level
          if ($hasil['level'] == 'Admin') {
            header("Location: ^admin/");
          exit;
          } else {
            header("Location: ^guru/");
          exit;
          }
      }else {
          // jika username/password salah
          $error = true;
      }
    } 
  } 

?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
      body {
        user-select: none;
      }
      img {
        -webkit-user-drag: none;
      }
    </style>
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <header>
      <div></div>
    </header>

    <main class="container d-flex justify-content-center">

      <div class="card mt-5 animate__animated animate__flipInY animate__fast" style="width: 20rem; height: 25rem;">

        <form action="" method="post">

          <div class="card-header">
            <img class="img animate__animated animate__zoomIn animate__slow" style="width: 100px; height: 100px;" src="assets/img/g1W.png" alt="">
            <h3 class="ms-3">Login</h3>
          </div>

          <div class="card-body">
            
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username" required>
              <label for="floatingInput">Username</label>
            </div>

            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
              <label for="floatingPassword">Password</label>
            </div>

            <div class="button mt-2">
              <button class="btn btn-success w-100 py-2 mb-3" type="submit" name="login">Login</button>
              <p class="mt-2 text-body-secondary text-end">&copy;Raven</p>
            </div>

          </div>

        </form>

      </div>

    </main>
    
    <footer>
      <script src="assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </footer>

  </body>
</html>
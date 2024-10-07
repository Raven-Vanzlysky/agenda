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
            header("Location: ^admin/admin_akun.php");
          exit;
          } else {
            // Buat session mapel
            $result0 = mysqli_query($db, "SELECT * FROM hasil_guru");
            $hasil0 = mysqli_fetch_assoc($result0);
            $_SESSION['id_hsil']  = $hasil0['id_hsil'];
            header("Location: ^guru/main.php");
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
<html lang="en" data-bs-theme="dark">
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
    <link rel="icon" type="image/png" href="img/favicon.ico">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
      />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
  </head>
  <body>

    <header>
      <div></div>
    </header>

    <main class="container d-flex justify-content-center">

      <div class="card mt-5 animate__animated animate__flipInY" style="width: 20rem; height: 25rem;">

        <form action="" method="post">

          <div class="card-header">
            <img class="img" style="width: 100px; height: 100px;" src="img/g1W.png" alt="">
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
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
      </script>
      <script 
        src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
      </script>
    </footer>

  </body>
</html>
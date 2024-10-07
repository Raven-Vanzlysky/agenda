<?php

  session_start();

  // membatasi halaman sebelum login
  if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('AKSES DI TOLAK!');
            document.location.href = 'index.php';
          </script>";
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Construction</title>
    <link rel="icon" type="image/png" href="img/favicon.ico">
    <style>
      body {
        background-color: black;
        user-select: none;
      }
      h1 {
        font-size: 60px;
        margin-bottom: 100px;
        margin-top: 100px;
        color: black;
      }
      .bg {
        background-color: orangered;
      }
    </style>
  </head>
  <body>
    
    <main>

      <h1 class="bg"><marquee behavior="" direction="left" scrollamount="20">UNDER CONSTRUCTION!! UNDER CONSTRUCTION!! UNDER CONSTRUCTION!!</marquee></h1>
      <h1 class="bg"><marquee behavior="" direction="right" scrollamount="20">UNDER CONSTRUCTION!! UNDER CONSTRUCTION!! UNDER CONSTRUCTION!!</marquee></h1>
      <h1 class="bg"><marquee behavior="" direction="left" scrollamount="20">UNDER CONSTRUCTION!! UNDER CONSTRUCTION!! UNDER CONSTRUCTION!!</marquee></h1>

    </main>

  </body>
</html>
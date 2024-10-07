<?php

  session_start();

  // membatasi halaman sebelum login
  if (!isset($_SESSION["login"])) {
      echo "<script>
              alert('AKSES DI TOLAK!');
              document.location.href = 'login.php';
            </script>";
      exit;
  }

  // kosongkan $_SESSION user login
  $_SESSION = [];

  session_unset();
  session_destroy();
  header("Location: index.php");

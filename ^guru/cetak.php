<?php 
require "../config/db.php";

session_start();
if (!isset($_SESSION["login"])) {
    echo "<script> 
         alert ('Anda Harus Login Terlebih Dahulu!');
            document.location.href = 'login.php';
         </script>";
        exit;
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Laporan Agenda Harian Mata Pelajaran</title>
  <link rel="icon" type="image/png" href="../assets/img/g1W.png">
	<style>
	body{
		font-family: "Arial Narrow", Arial, sans-serif;
		
	
	}
	</style>
</head>
<body>
		<?php 
	$id = $_GET['id'];
  $query = "SELECT hasil_guru.*, guru.*, mapel.mpl, mapel.id_mapel,  kelas.kls,  jurusan.jrsn
  FROM hasil_guru 
  INNER JOIN mapel ON hasil_guru.id_mapel = mapel.id_mapel
  INNER JOIN kelas ON hasil_guru.id_kelas = kelas.id_kelas
  INNER JOIN guru ON hasil_guru.id_guru = guru.id_guru 
  INNER JOIN jurusan ON hasil_guru.id_jurusan = jurusan.id_jurusan
  WHERE hasil_guru.id_guru = '$_SESSION[id_guru]' AND hasil_guru.id_hsil='$id'";
 $data = mysqli_query($db, $query);                   
 $da = mysqli_fetch_array($data);	
	 ?>

<!-- 	<center>
		 <h3><p>
	 	Agenda Mengajar Guru <br> SMKN 4 PAYAKUMBUH <br>
	 	Tahun Ajaran 2017/2018 </h3>
	 </p>
	</center> -->

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

	<table width="100%" height="100%" style="border: 2px dashed;">
  <tr>
    <td><h2><p align="center">LAPORAN KEGIATAN HARIAN GURU</p>
    <?php 
    $query = "SELECT * FROM thn_ajar WHERE status = 'Y'";
    $data = mysqli_query($db, $query);
    while($d = mysqli_fetch_array($data)){
    
    ?>
    
    <p align="center">TAHUN AJARAN <?php echo $d['tahun_ajaran'];  ?></p></h2>
    <hr style="border: 2px;">
    <br>
  <?php }  ?>
  
    <p align="center" class="style1"><img src="../assets/img/g1.png" width="200" height="180" /></p>
    <table width="200" align="center">
      <tr>
        <td><span class="style2">NAMA</span></td>
        <td><span class="style2">:</span></td>
        <td><span class="style2"><?php echo $da['nama']; ?></span></td>
      </tr>
      <tr>
        <td><span class="style2">NIP/NUPTK</span></td>
        <td><span class="style2">:</span></td>
        <td><span class="style2"><?php echo $da['nip']; ?></span></td>
      </tr>
    </table>
       <br>
    <br>
  
    <center><p><h2>SMK NEGERI COMPRENG</h2></p></center>
    <p align="center" class="style1">Jl. Raya Compreng, Mekarjaya, Kec. Compreng, Kab. Subang Prov. Jawa Barat</p>
    <p align="center" class="style1"> Email : office@smkncompreng.sch.id</p>
    <p align="center" class="style1">&nbsp; </p>
    <p align="center" class="style1">&nbsp;</p></td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>



	 <table>
	 		<tr>
	 			<td>Guru Pengampu</td>
	 			<td>:</td>
	 			<td><?php echo $da['nama']; ?></td>
	 		</tr>
	 		<tr>
	 			<td>Mata Pelajaran</td>
	 			<td>:</td>
	 			<td> <?php echo $da['mpl']; ?> </td>
	 		</tr>
	 		<tr>
	 			<td>Kelas</td>
	 			<td>:</td>
	 			<td><?php echo $da['kls']; ?></td>
	 		</tr>
       <tr>
	 			<td>Jurusan</td>
	 			<td>:</td>
	 			<td><?php echo $da['jrsn']; ?></td>
	 		</tr>
	 		<tr>
	 			<td>Dicetak Pada Tanggal</td>
	 			<td>:</td>
	 			<td> <?php echo date('d F Y'); ?> </td>
	 		</tr>
	 
	 </table>
	 <hr>
   
	<table border="2" width="100%" cellspacing="0" cellpadding="4" style="border-collapse: collapse;">
   
                      <tr height="40">
                        <th>No.</th>
                        <th>Tanggal</th>
                       <!--  <th>Kelas</th> -->
                        <th>Materi</th>
                        <th>Absen</th>
                        <th>Keterangan</th>                 
                      </tr>

                      <?php 
                      $no=1;
                      $query1 = "SELECT dftr_agnd.*,hasil_guru.id_hsil,guru.id_guru, mapel.mpl, mapel.id_mapel, kelas.kls,  jurusan.jrsn
                        FROM dftr_agnd 
                        INNER JOIN hasil_guru ON dftr_agnd.id_hsil = hasil_guru.id_hsil
                        INNER JOIN mapel ON dftr_agnd.id_mapel = mapel.id_mapel
                        INNER JOIN kelas ON dftr_agnd.id_kelas = kelas.id_kelas
                        INNER JOIN guru ON dftr_agnd.id_guru = guru.id_guru 
                        INNER JOIN jurusan ON dftr_agnd.id_jurusan = jurusan.id_jurusan 
                        WHERE dftr_agnd.id_guru = '$_SESSION[id_guru]' AND dftr_agnd.id_hsil = '$id'";
                       $data = mysqli_query($db, $query1);
                  while ( $du=mysqli_fetch_array($data)) {
                       ?>
                      <tr>
                        <td align="center"> <?=$no++; ?>.</td>
                        <td> <?=$du['tgl'];?> </td>
                        <!-- <td> <?=$du['nama'];?></td> -->
                        <!-- <td><?=$du['kls'];?></td> -->
                        <td><?=$du['mtri'];?></td>
                        <td><?=$du['absn'];?></td>
                        <td><?=$du['ktr'];?></td>
                      </tr>
                      <?php 
                       }

                       ?>
                     
                
    <?php 
    

  $sqlMapel= mysqli_query($db, "SELECT * FROM kepsek ORDER BY id_kepsek DESC LIMIT 1
     ");
       $data= mysqli_fetch_array($sqlMapel);

   ?>
     <table width="100%">
      <!--  <a href="#" class="no-print" onclick="window.print();"> <button style="height: 40px; width: 70px; background-color: dodgerblue;border:none; color: white; border-radius:7px;font-size: 17px; " type=""> Cetak</button> </a> -->
        <tr>
          <td align="right" colspan="6" rowspan="" headers="">
            <p>Subang, <?php echo date (" d F Y") ?>  <br> <br>
            Kepala Sekolah </p> <br> <br>
            <p> <?php echo $data['nama'] ?> <br>NIP. <?php echo $data['nip'] ?></p>
          </td>
        </tr>
      </table>
<?php
//otomatis muncul ketika laman di akses
echo "<script>window.print()</script>";
?>


</body>
</html>
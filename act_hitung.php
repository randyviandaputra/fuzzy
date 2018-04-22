<?php

include "Fuzzy.php";

$nilai_ipk = $_POST['ipk'];
$nilai_gaji = $_POST['gaji'];
$sampel = $_POST['centroid'];

$fuzzyObj = new Fuzzy;
$fuzzyObj->anggotaIPK($nilai_ipk);
$fuzzyObj->anggotaGaji($nilai_gaji);
$fuzzyObj->cetakMember();
echo "Rules yang di dalam inferensi : " . "<br>";
$fuzzyObj->inferensi();
echo "<br>";
$fuzzyObj->defuzzCentroid($sampel);


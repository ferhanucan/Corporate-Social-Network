<?php
ob_start();
session_start();

include 'tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


if (isset($_SESSION['uye_code'])) {

	header("Location:profil.php");

} else {

    header("Location:login/giris.php");

}

?>
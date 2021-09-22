<?php 
ob_start();
session_start();
include 'tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');

$uyecodes = $_SESSION['uye_code'];
?>


<?php 

require_once __DIR__ . '/vendor/autoload.php';

if (isset($_POST['izin_talep_pdf_olustur1'])) {

	$uye_isimpdf=$_POST['uye_isimpdf'];
	$uye_departmanpdf=$_POST['uye_departmanpdf'];
	$uye_meslekpdf=$_POST['uye_meslekpdf'];
	$talep_konupdf=$_POST['talep_konupdf'];
	$izin_baslangicpdf=$_POST['izin_baslangicpdf'];
	$izin_bitispdf=$_POST['izin_bitispdf'];

	$mpdf = new \Mpdf\Mpdf();
	$mpdf->AddPage();

	$data='<h1 style="margin-left:150px;">PERSONEL İZİN TALEP</h1>';
	$mpdf->WriteHTML($data);



	$data2='<ul>
	<strong>Adı Soyadı : </strong>'.$uye_isimpdf.'<br>
	<hr>
	<strong>Departmanı :</strong>'.$uye_departmanpdf.'<br>
	<hr>
	<strong>Meslek :</strong>'.$uye_meslekpdf.'<br>
	<hr>
	<strong>Talep Nedeni :</strong>'.$talep_konupdf.'<br>
	<hr>
	<strong>İzin Başlangıç Tarihi :</strong>'.$izin_baslangicpdf.'<br>
	<hr>
	<strong>İzin Bitiş Tarihi :</strong>'.$izin_bitispdf.'<br>
	<hr>
	<br>
	<br>
	<br>
	<strong>ONAYLAYAN ADI SOYADI<br>İMZA-KAŞE</strong>

	</ul>';
	$mpdf->WriteHTML($data2);
	$mpdf->Output();
}
?>





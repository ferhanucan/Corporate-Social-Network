<?php  

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:../../index.php"); 
  exit();
}

$yasak_kelimeler = array('Argo', 'ARGO', 'argo', 'yasakkelime','...');

?>
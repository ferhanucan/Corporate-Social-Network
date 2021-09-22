<?php  

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:../../index.php"); 
  exit();
}

function mt($gelen){
$argo = array('Argo', 'ARGO', 'argo', 'yasakkelime');
$degisen = '...';
$giden = str_replace($argo,$degisen,$gelen);
return $giden; }

?>
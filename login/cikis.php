<?php

session_start();
session_destroy();

if ($_GET['tespit']=="1") {
	header('Location:giris.php?eklenti=bulundu');
}elseif ($_GET['girisyasak']=="1") {
	header('Location:giris.php?kisabir=bakimvar');
}else {
	header('Location:giris.php?cikis=yap');
}


?>
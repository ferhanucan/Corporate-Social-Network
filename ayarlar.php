<?php error_reporting(0); ?>
<?php include 'header.php'; ?>


<?php if ($_SESSION['sessizin'] == 0) {
  header("Location:index.php"); 
  exit();
} ?>
<?php 

if ($uye_islem['uye_yetki']==3) {
  header('Location:aday_anasayfa.php');
}

 ?>


<?php 

function GetIP(){
  if(getenv("HTTP_CLIENT_IP")) {
    $ip = getenv("HTTP_CLIENT_IP");
  } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
    if (strstr($ip, ',')) {
      $tmp = explode (',', $ip);
      $ip = trim($tmp[0]);
    }
  } else {
    $ip = getenv("REMOTE_ADDR");
  }
  return $ip;
}

$fonksiyonlu_ip_adres = GetIP();
$standart_ip = $_SERVER['REMOTE_ADDR'];
$pcname=gethostbyaddr($_SERVER['REMOTE_ADDR']);
$tarayici=$_SERVER['HTTP_USER_AGENT'];

if($fonksiyonlu_ip_adres == '::1') {$fonksiyonlu_ip_adres = 'Localgiris';} else {$fonksiyonlu_ip_adres = GetIP();}
if($standart_ip == '::1') {$standart_ip = 'Localgiris';} else {$standart_ip = $_SERVER['REMOTE_ADDR'];}


$bilgiler = 'Fonksiyonlu_ip= '.$fonksiyonlu_ip_adres.' | Standart_ip= '.$standart_ip.' | PC= '.$pcname.' | Tarayci= '.$tarayici;

?>


<?php include 'menu.php';  ?>


<div class="col-md-3 col-sm-12 col-xs-12">



</div>




<div class="col-md-6 col-sm-12 col-xs-12 ortbslk" style="margin-bottom:150px;">




<div class="py-hak">
<div class="pylsm1">



<div class="ht-pylsm-bslk">

       
<table class="tableclass">
  <thead>
    <tr>
      <th class="hakkinda-tablo">
          
              Ayarlar ve gizlilik bölümü
      </th>

    </tr>
  </thead>

</table>

</div>

<div class="hak-meslek-alan">


<form method="POST" action="tkpan/database/ayar-guncelle.php">
    <?php $_SESSION['uye_code']; ?>



<div class="hakmetext">Kullanıcılar arkadaşlık isteği gönderebilsin mi ?</div>

<div class="form-group">
  <select name="gizlilik" class="form-control">
          <option <?php if ($uye_islem['uye_gizlilik'] == 1 or $uye_islem['uye_gizlilik'] == 0) { ?> selected="select" <?php } ?> value="1">Açık</option>
          <option <?php if ($uye_islem['uye_gizlilik'] == 2) { ?> selected="select" <?php } ?> value="2">Kapalı</option>
  </select>                   
</div>

<?php if ($uye_islem['uye_gizlilik'] == 1 or $uye_islem['uye_gizlilik'] == 0) { ?><div class="hknot">Arkadaşlık isteği herkese açık</div><?php }else { ?><div class="hknot">Artık yeni arkadaşlık isteği almayacaksınız !</div><?php } ?>


<br>
  <div class="form-group last">      
    <button type="submit" name="gizlilik-degistir" class="btn btn-success btn-sm fuwl">İstekleri Güncelle</button>    
  </div>
</form>





</div>



<div id="ayar-style">
  <div class="resifre-acilir-panel">

  <div class="rekey-detay">

    <h4 class="style-baslik-type">Şifre sıfırlama alanı</h4>

<form method="POST" action="tkpan/database/ayar-guncelle.php">
  <?php $_SESSION['uyebilgi'] = $bilgiler; ?>
  <?php $_SESSION['uye_code']; ?>


<div class="hakmetext">Yeni şifreniz</div>
  <div class="form-group">
        <input id="sifre" type="password" name="sifre" class="form-control password" placeholder="Yeni şifre giriniz">
  </div>

<div class="hakmetext">Yeni şifrenizi tekrar yazın</div>
  <div class="form-group">
        <input id="resifre" type="password" name="resifre" class="form-control password" placeholder="Şifreyi tekrar giriniz">
  </div>


<div class="form-group">
  <div class="checksifre">
    <input type="checkbox" id="showHide"/><label class="checksifrelabel" for="showHide" id="showHideLabel"><span>Şifreleri göster</span></label>
    <span id='message'></span>
  </div>
</div>

  <div class="form-group last">      
    <button type="submit" name="sifre-degistir" class="btn btn-success btn-sm fuwl">Şifreyi Güncelle</button>    
  </div>

</form>


  </div>
  </div>
</div>

  <div class="rekey-detay">
    <div class="resifre-buton">
    <div class="rekey-panel">
      <div class="rekey-alan">

        <table class="tableclass">

          <thead>
            <tr>
              <th class="rektab">
                
                  <div class="rekey-ayar-text">
                    Şifre değiştirme alanı ( <span class="key_txt">Aç</span> )
                  </div> 
                
              </th>

            </tr>
          </thead>

        </table>
    
      </div>
    </div>
    </div>
  </div>



</div>
</div>





</div>





<div class="col-md-3 col-sm-12 col-xs-12">


<?php include 'sag-kategori.php'; ?>



</div>



<?php include 'footer.php'; ?>

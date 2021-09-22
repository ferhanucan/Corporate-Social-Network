<!-- EN ÜST NAVBAR BAŞLANGIÇ--------------------------------------------------------------------- -->

<?php include 'header.php'; ?>

<!-- EN ÜST NAVBAR BİTİŞ--------------------------------------------------------------------- -->

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





<!-- TÜM SAYFA İÇİ BAŞLANGIÇ -->
<div class="main-content" id="panel">


    <form action="personelkayit_islem.php" method="POST">
        <?php $_SESSION['uyebilgi'] = $bilgiler; ?>
        

        <h1 style="text-align:center;" class="display-6"><svg  xmlns="http://www.w3.org/2000/svg" style="margin-bottom:7px;" width="50" height="50" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
        </svg>        PERSONEL GİRİŞ FORMU</h1>




        <div style="padding:10px; margin-bottom:80px; margin-right:100px; background:transparent;" >










            <div class="row">



                <div class="col-md-3">


                    <div class="card-body text-center  rounded-top" style="background-color:transparent;">

                        <div class="user-box">

                            <img style="height:70px; width:70px;" src="yimg/profil/eprofil.png" alt="user avatar">
                            <input type="file" name="resimekle">
                        </div><br><br><br>

                        <input type="submit" class="btn btn-success" style="margin-top:5px;" value="KAYDET" name="personel_kayit" id="personel_kayit">
                        <input type="reset" class="btn btn-danger" style="margin-top:5px;" value="TEMİZLE" name="" id="">




                    </div>



                </div>


                <div class="col-md-3">


                   <label>TC</label><input  style="font-weight:bold;" type="number" class="form-control" name="uye_tc" id="uye_tc">


                   <label>ADI</label><input type="text"  style="font-weight:bold;"class="form-control"  name="ad" id="ad">  


                   <label>SOYADI</label><input type="text" style="font-weight:bold;"  class="form-control"name="soyad" id="soyad">


                   <!-- doğum tarihi başlangıç -->
                   <label>DOĞUM TARİHİ</label>
                   <div class="row">


                    <div class="col-sm-4 col-xs-4">
                        <select id="tarih_gun" name="tarih_gun" class="form-control">
                            <option value="">Gün</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                        </select>
                    </div>

                    <div class="col-sm-4 col-xs-4">
                        <select id="tarih_ay" name="tarih_ay" class="form-control">
                            <option value="">Ay</option>
                            <option value="1">Ocak</option>
                            <option value="2">Şubat</option>
                            <option value="3">Mart</option>
                            <option value="4">Nisan</option>
                            <option value="5">Mayıs</option>
                            <option value="6">Haziran</option>
                            <option value="7">Temmuz</option>
                            <option value="8">Ağustos</option>
                            <option value="9">Eylül</option>
                            <option value="10">Ekim</option>
                            <option value="11">Kasım</option>
                            <option value="12">Aralık</option>
                        </select>
                    </div>

                    <div class="col-sm-4 col-xs-4">
                        <select id="tarih_yil" name="tarih_yil" class="form-control">
                            <option value="">Yıl</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                            <option value="1997">1997</option>
                            <option value="1996">1996</option>
                            <option value="1995">1995</option>
                            <option value="1994">1994</option>
                            <option value="1993">1993</option>
                            <option value="1992">1992</option>
                            <option value="1991">1991</option>
                            <option value="1990">1990</option>
                            <option value="1989">1989</option>
                            <option value="1988">1988</option>
                            <option value="1987">1987</option>
                            <option value="1986">1986</option>
                            <option value="1985">1985</option>
                            <option value="1984">1984</option>
                            <option value="1983">1983</option>
                            <option value="1982">1982</option>
                            <option value="1981">1981</option>
                            <option value="1980">1980</option>
                            <option value="1979">1979</option>
                            <option value="1978">1978</option>
                            <option value="1977">1977</option>
                            <option value="1976">1976</option>
                            <option value="1975">1975</option>
                            <option value="1974">1974</option>
                            <option value="1973">1973</option>
                            <option value="1972">1972</option>
                            <option value="1971">1971</option>
                            <option value="1970">1970</option>
                            <option value="1969">1969</option>
                            <option value="1968">1968</option>
                            <option value="1967">1967</option>
                            <option value="1966">1966</option>
                            <option value="1965">1965</option>
                            <option value="1964">1964</option>
                            <option value="1963">1963</option>
                            <option value="1962">1962</option>
                            <option value="1961">1961</option>
                            <option value="1960">1960</option>
                            <option value="1959">1959</option>
                            <option value="1958">1958</option>
                            <option value="1957">1957</option>
                            <option value="1956">1956</option>
                            <option value="1955">1955</option>
                            <option value="1954">1954</option>
                            <option value="1953">1953</option>
                            <option value="1952">1952</option>
                            <option value="1951">1951</option>
                            <option value="1950">1950</option>
                            <option value="1949">1949</option>
                            <option value="1948">1948</option>
                            <option value="1947">1947</option>
                            <option value="1946">1946</option>
                            <option value="1945">1945</option>
                            <option value="1944">1944</option>
                            <option value="1943">1943</option>
                            <option value="1942">1942</option>
                            <option value="1941">1941</option>
                            <option value="1940">1940</option>
                            <option value="1939">1939</option>
                            <option value="1938">1938</option>
                            <option value="1937">1937</option>
                            <option value="1936">1936</option>
                            <option value="1935">1935</option>
                            <option value="1934">1934</option>
                            <option value="1933">1933</option>
                            <option value="1932">1932</option>
                            <option value="1931">1931</option>
                            <option value="1930">1930</option>
                        </select>
                    </div>
                </div>





                <label>Cinsiyet</label>

                <select id="cinsiyet" name="cinsiyet" class="form-control">
                    <option value=""></option>
                    <option value="1">Erkek</option>
                    <option value="2">Kadın</option>
                </select>





            </div>

            

            <div class="col-md-3">




                <label>DEPARTMAN</label><select style="color:red; font-weight:bold;" id="uye_departman" name="uye_departman" class="form-control">
                    <option value=""></option>
                    <option value="MUHASEBE">MUHASEBE</option>
                    <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                    <option value="PAZARLAMA">PAZARLAMA</option>
                    <option value="AR-GE">AR-GE</option>
                    <option value="ÜRETİM">ÜRETİM</option>
                    <option value="YÖNETİM">YÖNETİM</option>
                </select>


                <label>GÖREV</label><input type="text" style=" font-weight:bold;"  class="form-control" name="uye_meslek" id="uye_meslek">



                <label>İŞE GİRİŞ TARİHİ</label><input type="date"  style="  font-weight:bold;" class="form-control"name="uye_isegiristarihi" id="uye_isegiristarihi">


                

                
                <label>TELEFON</label><input id="telefon" type="text" name="telefon" class="form-control" style="  font-weight:bold;">

                



                <label>E-MAİL</label><input id="email" type="email" name="email" class="form-control" style=" font-weight:bold;">






            </div>

            


            <div class="col-md-3">




                <label>ASKERLİK DURUMU</label><select style="font-weight:bold;" id="uye_askerlikdurum"name="uye_askerlikdurum"class="form-control">
                    <option value=""></option>
                    <option >YAPTI</option>
                    <option >TECİLLİ</option>
                    <option >MUAF</option></select>


                <label>SGK NUMARASI</label><input style="font-weight:bold;" type="number" class="form-control"  name="uye_sgkno" id="uye_sgkno">
                

               
                    <div class="row">
                        
                        <div class="col-sm-6 col-xs-4">
                            <label>ŞİFRE</label>
                            <input id="sifre" type="password" name="sifre" class="form-control password">
                        </div>
                    

                
                        
                        <div class="col-sm-6 col-xs-4">
                            <label>ŞİFRE TEKRAR</label>
                            <input id="resifre" type="password" name="resifre" class="form-control password">
                        </div>
                    </div>
                   



                </div>








            </div>






        </div>


    </form>








































 





























</div>































<?php include 'footer.php'; ?>
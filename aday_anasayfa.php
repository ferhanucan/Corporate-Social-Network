<?php error_reporting(0); ?>
<?php include 'header.php'; ?>

<?php 

if ($uye_islem['uye_yetki']==1 or $uye_islem['uye_yetki']==2  ) {
  header('Location:anasayfa.php');
}

?>

<script type="text/javascript">

  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
  })
</script>


<div class="main-content row" id="panel">






  <div style="width:2000px; margin-left:10px; margin-bottom:550px;">
    <div>
      <div class="card-body">
        <ul class="nav nav-pills nav-pills-primary nav-justified"  >
          <li class="nav-item">
            <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active show"><span class="hidden-xs">İş İlanları</span></a>
          </li>

          <li class="nav-item">
            <a href="javascript:void();" data-target="#diger" data-toggle="pill" class="nav-link"> <span class="hidden-xs">Özgeçmişim</span></a>
          </li>
          <li class="nav-item">
            <a href="javascript:void();" data-target="#egitim" data-toggle="pill" class="nav-link"> <span class="hidden-xs">Görüşmelerim</span></a>
          </li>
        </ul>






        
        <div class="tab-content ">



          <!-- İş ilanları Başlangıç -->

          <div class="tab-pane active show" id="profile">


            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="main-box clearfix">
                    <div class="table-responsive">
                      <table class="table user-list">
                        <thead>
                          <tr>
                            <th class="text-center"><span>İlan Kodu</span></th>
                            <th class="text-center"><span>Departman</span></th>
                            <th class="text-center"><span>Pozisyon</span></th>
                            <th class="text-center"><span>İlan Başlangıç Tarihi</span></th>

                            <th>&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>

                           <td class="text-center">
                            <span class="label label-default">1</span>
                          </td>

                          <td class="text-center">
                            <span class="label label-default">AR-GE</span>
                          </td>

                          <td class="text-center">
                            <span class="label label-default">Mühendis</span>
                          </td>

                          <td class="text-center">
                            <span class="label label-default">Tarih</span>
                          </td>

                          <td style="width: 20%;">
                            <a  class="table-link" data-toggle="modal" data-target="#exampleModal">
                              <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x"></i>
                                <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                              </span>
                            </a>
                            
                            <div class="modal fade  bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color:transparent;">
                              <div class="modal-dialog modal-lg" role="document" >
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">İLAN DETAYLARI</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">

                                    <ul class="list-group list-group-flush">
                                      <li class="list-group-item"><b>İlan Kodu: </b>1</li>
                                      <li class="list-group-item"><b>İlan Tarihi:</b></li>
                                      <li class="list-group-item"><b>Pozisyon :</b></li>
                                      <li class="list-group-item"><b>Şehir :</b></li>
                                      <li class="list-group-item"><b>Mesleki Nitelikler :</b></li>
                                      <li class="list-group-item"><b>İş Tanımı :</b></li>
                                      <li class="list-group-item"><b>Aday Sayısı :</b></li>
                                    </ul>




                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                                    <button type="button" class="btn btn-primary">Başvur</button>
                                  </div>
                                </div>
                              </div>
                            </div>




                            <button class="btn-success">Aktif</button>
                            

                            
                          </td>
                        </tr>







                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>




        </div>
        <!-- İş ilanları Bitiş -->










        <!-- Özgeçmişim Başlangıç -->



        <div class="tab-pane" id="diger">


          <form action="aday_islemler.php" method="POST">


         <?php $_SESSION['uye_code']; ?>





            <div style="padding:10px; margin-bottom:80px; margin-right:100px; background:transparent;" >










              <div class="row">



                <div class="col-md-3" style="margin-top:8px;">

                  <div class="card"  style="border-style:solid; border-width:1px;">
                    <div class="card-body text-center  rounded-top" style="background-color:transparent;">

                      <div class="user-box">

                        <img style="height:70px; width:70px;" src="yimg/profil/eprofil.png" alt="user avatar">
                        <input type="file" name="resimekle">
                      </div>





                    </div>
                  </div>
                  
                  <label>TC</label><input  style="font-weight:bold;" type="number" class="form-control" name="aday_tc" id="aday_tc">
                  <label>ADI</label><input type="text"  style="font-weight:bold;"class="form-control"  name="aday_ad" id="aday_ad">  
                  <label>SOYADI</label><input type="text" style="font-weight:bold;"  class="form-control"name="aday_soyad" id="aday_soyad">

                  <label>HAKKINDA</label><textarea type="text" rows="5" style="font-weight:bold; width:500px;"  class="form-control"name="aday_hakkinda" id="aday_hakkinda"></textarea>
                  <input type="submit" class="btn btn-success" style="margin-top:5px;" value="KAYDET" name="aday_kayit" id="aday_kayit">
                  <input type="reset" class="btn btn-danger" style="margin-top:5px;" value="TEMİZLE" name="" id="">




                </div>


                <div class="col-md-3">


                  <label>TELEFON</label><input id="aday_telefon" type="text" name="aday_telefon" class="form-control" style="  font-weight:bold;">





                  <label>E-MAİL</label><input id="aday_email" type="email" name="aday_email" class="form-control" style=" font-weight:bold;">





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





                  <label>CİNSİYET</label>

                  <select id="aday_cinsiyet" name="aday_cinsiyet" class="form-control">
                    <option value=""></option>
                    <option>Erkek</option>
                    <option>Kadın</option>
                  </select>

                  <label>MEDENİ HAL</label><select  id="aday_medenidurum" name="aday_medenidurum"  class="form-control">
                    <option value=""></option>
                    <option>EVLİ</option>
                    <option>BEKAR</option>

                  </select>





                </div>



                <div class="col-md-3">










                  <label>ASKERLİK DURUMU</label><select style="font-weight:bold;" id="aday_askerlikdurum"name="aday_askerlikdurum"class="form-control">
                    <option value=""></option>
                    <option >YAPTI</option>
                    <option >TECİLLİ</option>
                    <option >MUAF</option></select>



                    <label>EHLİYET</label><input id="aday_surucubelgesi" type="text" name="aday_surucubelgesi" class="form-control" style="  font-weight:bold;">

                    
                    <div class="card"  style="border-style:solid; border-width:1px;">
                      <label>OKUL</label><input id="aday_okul" type="text" name="aday_okul" class="form-control" style="  font-weight:bold;">

                      <label>BÖLÜM</label><input id="aday_bolum" type="text" name="aday_bolum" class="form-control" style="  font-weight:bold;">

                      <label>ÖĞRENİM DURUMU</label><input id="aday_egitimdurum" type="text" name="aday_egitimdurum" class="form-control" style="  font-weight:bold;">
                    </div>









                  </div>




                  <div class="col-md-3">




                    <div class="card" style="border-style:solid; border-width:1px;">

                      <label>ÖNCEKİ İŞYERİ</label><input id="aday_oncekiisyeri" type="text" name="aday_oncekiisyeri" class="form-control" style="  font-weight:bold;">


                      <label>ÇALIŞMA SÜRESİ</label><input id="aday_oncekiisyeri_sure" type="text" name="aday_oncekiisyeri_sure" class="form-control" style="  font-weight:bold;">

                      <label>POZİSYON</label><input id="aday_oncekiisyeri_pozisyon" type="text" name="aday_oncekiisyeri_pozisyon" class="form-control" style="  font-weight:bold;">

                    </div>

                    <label>UZMANLIK ALANLARI</label><input id="aday_uzmanlik" type="text" name="aday_uzmanlik" class="form-control" style="  font-weight:bold;">


                    <label>YABANCI DİL</label><input id="aday_yabancidil" type="text" name="aday_yabancidil" class="form-control" style="  font-weight:bold;">
                    
                    <div class="card" style="border-style:solid; border-width:1px;"> 
                      <label>REFERANS AD SOYAD</label><input id="aday_referans_adsoyad" type="text" name="aday_referans_adsoyad" class="form-control" style="  font-weight:bold;">

                      <label>REFERANS İLETİŞİM</label><input id="aday_referans_iletisim" type="text" name="aday_referans_iletisim" class="form-control" style="  font-weight:bold;">
                    </div>











                  </div>








                </div>






              </div>
              

            </form>






          </div>


          <!-- Özgeçmişim Bitiş -->











          <!-- Görüşmelerim Başlangıç -->

          <div class="tab-pane " id="egitim">









          </div>
          <!-- Görüşmelerim Bitiş -->








        </div>




      </div>
    </div>
  </div>













</div><!-- tüm sayfa içi bitiş -->







<?php include 'footer.php'; ?>

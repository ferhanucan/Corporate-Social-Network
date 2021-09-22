<?php include 'header.php'; error_reporting(0); ?>



<div class="main-content" id="panel">



  <div style="width:1000px; margin-left:200px; margin-bottom:550px;">
    <div>
      <div class="card-body">
        <ul class="nav nav-pills nav-pills-primary nav-justified"  >
          <li class="nav-item">
            <a href="javascript:void();"  data-target="#profile" data-toggle="pill" class="nav-link active show"><span class="hidden-xs">Onay Bekleyenler</span></a>
          </li>

          <li class="nav-item">
            <a href="javascript:void();" data-target="#diger" data-toggle="pill" class="nav-link"> <span class="hidden-xs">Onaylananlar</span></a>
          </li>
          <li class="nav-item">
            <a href="javascript:void();" data-target="#egitim" data-toggle="pill" class="nav-link"> <span class="hidden-xs">Reddedilenler</span></a>
          </li>
        </ul>

        <div class="tab-content ">



         <div class="tab-pane active show" id="profile">

          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="main-box clearfix">
                  <div class="table-responsive">


                    <table class="table user-list">
                      <thead>
                        <tr>
                          <th class="text-center"><span>ADI SOYADI</span></th>
                          <th class="text-center"><span>İZİN TÜRÜ</span></th>
                          <th class="text-center"><span>BAŞLANGIÇ</span></th>
                          <th class="text-center"><span>BİTİŞ</span></th>
                          <th class="text-center">&nbsp;</th>
                        </tr>
                      </thead>
                      <?php

                      $talep_listele = $db->prepare("SELECT * from izin_talepleri where talep_durum=0");
                      $talep_listele->execute();


                      


                      while($ta_cek=$talep_listele->fetch(PDO::FETCH_ASSOC)) { ?>







                        <?php  
                        $uye_listele = $db->prepare("SELECT * from users where uye_code=:ucoxs");
                        $uye_listele->execute(array(
                          'ucoxs' => $ta_cek['talep_kimin']
                        ));

                        $uy_cek=$uye_listele->fetch(PDO::FETCH_ASSOC);

                        ?>



                        <tbody>
                          <tr>
                            <td>
                              <img src="<?php echo $uy_cek['uye_mini_resim'] ?>" alt="">
                              <a href="#" class="user-link"><?php echo  $uy_cek['uye_ad']," ",$uy_cek['uye_soyad']; ?></a>

                            </td>
                            <td>
                              <?php echo $ta_cek['talep_konu']; ?>
                            </td>
                            <td class="text-center">
                              <span class="label label-default"><?php echo $ta_cek['izin_baslangic'] ?></span>
                            </td>
                            <td>
                              <span class="label label-default"><?php echo $ta_cek['izin_bitis'] ?></span>
                            </td>
                            <td style="width: 20%;">

                              <a  class="table-link" data-target="#exampleModal2<?php echo $ta_cek['talep_kodu'] ?>"   data-toggle="modal" >
                                <span class="fa-stack">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                  <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                </span>
                              </a>

                              <div class="modal fade  bd-example-modal-lg" id="exampleModal2<?php echo $ta_cek['talep_kodu'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" style="background-color:transparent;">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel2">İzin Talep Detayları</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">








                                      <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Adı Soyadı&emsp;<b><?php echo  $uy_cek['uye_isim'] ?></b></li>
                                        <li class="list-group-item">Departmanı&emsp;<b><?php echo  $uy_cek['uye_departman'] ?></b></li>
                                        <li class="list-group-item">Mesleği&emsp;<b><?php echo  $uy_cek['uye_meslek'] ?></b></li>
                                        <li class="list-group-item">İzin Türü&emsp;<b><?php echo $ta_cek['talep_konu'] ?></b></li>
                                        <li class="list-group-item">İzin Başlangıç&emsp;<b><?php echo $ta_cek['izin_baslangic'] ?></b></li>
                                        <li class="list-group-item">İzin Bitiş&emsp;<b><?php echo $ta_cek['izin_bitis'] ?></b></li>
                                        <li class="list-group-item">Açıklama&emsp;<b><?php echo $ta_cek['talep_mesaj'] ?></b></li>
                                        <li class="list-group-item">Talep Oluşturulma Tarihi&emsp;<b>  <?php 
                                        $zamna_ki = new DateTime($ta_cek['talep_zaman']);
                                        $unuttum_zaman = $zamna_ki->format('H:i | d.m.Y'); 
                                        echo $unuttum_zaman; 
                                        ?></b></li>
                                        <li class="list-group-item">
                                          <form action="personel-izin-gonder-islem.php" method="POST">


                                            <button type="submit" value="<?php echo $ta_cek['talep_kodu']; ?>" name="onayla1" id="onayla1" style="width:100px;" class="btn btn-success">Onayla</button> 
                                            <button type="submit" value="<?php echo $ta_cek['talep_kodu']; ?>" name="reddet1" id="reddet1" style="width:100px;" class="btn btn-danger">Reddet</button>

                                          </form>

                                        </li>


                                      </ul>



                                    </div>

                                  </div>
                                </div>
                              </div>

                              <span class="badge badge-warning">Onay Bekliyor</span>

                            </td>
                          </tr>

                        </tbody>
                      <?php }   ?>   
                    </table>


                  </div>

                </div>
              </div>
            </div>
          </div>


        </div>







        <div class="tab-pane" id="diger">

          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="main-box clearfix">
                  <div class="table-responsive">


                    <table class="table user-list">
                      <thead>
                        <tr>
                          <th class="text-center"><span>ADI SOYADI</span></th>
                          <th class="text-center"><span>İZİN TÜRÜ</span></th>
                          <th class="text-center"><span>BAŞLANGIÇ</span></th>
                          <th class="text-center"><span>BİTİŞ</span></th>
                          <th class="text-center">&nbsp;</th>
                        </tr>
                      </thead>
                      <?php

                      $talep_listele = $db->prepare("SELECT * from izin_talepleri where talep_durum=1");
                      $talep_listele->execute();


                      


                      while($ta_cek=$talep_listele->fetch(PDO::FETCH_ASSOC)) { ?>







                        <?php  
                        $uye_listele = $db->prepare("SELECT * from users where uye_code=:ucoxs");
                        $uye_listele->execute(array(
                          'ucoxs' => $ta_cek['talep_kimin']
                        ));

                        $uy_cek=$uye_listele->fetch(PDO::FETCH_ASSOC);

                        ?>



                        <tbody>
                          <tr>
                            <td>
                              <img src="<?php echo $uy_cek['uye_mini_resim'] ?>" alt="">
                              <a href="#" class="user-link"><?php echo  $uy_cek['uye_ad']," ",$uy_cek['uye_soyad']; ?></a>

                            </td>
                            <td>
                              <?php echo $ta_cek['talep_konu']; ?>
                            </td>
                            <td class="text-center">
                              <span class="label label-default"><?php echo $ta_cek['izin_baslangic'] ?></span>
                            </td>
                            <td>
                              <span class="label label-default"><?php echo $ta_cek['izin_bitis'] ?></span>
                            </td>
                            <td style="width: 20%;">

                              <a  class="table-link" data-target="#exampleModal2<?php echo $ta_cek['talep_kodu'] ?>"   data-toggle="modal" >
                                <span class="fa-stack">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                  <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                </span>
                              </a>

                              <div class="modal fade  bd-example-modal-lg" id="exampleModal2<?php echo $ta_cek['talep_kodu'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" style="background-color:transparent;">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel2">İzin Talep Detayları</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">





                                      <form action="pdf_olustur.php" method="POST">


                                        <ul class="list-group list-group-flush">
                                          <li class="list-group-item">Adı Soyadı&emsp;<b><?php echo  $uy_cek['uye_isim'] ?></b></li>
                                          <input type="hidden" name="uye_isimpdf" value="<?php echo  $uy_cek['uye_isim'] ?>">
                                          <li class="list-group-item">Departmanı&emsp;<b><?php echo  $uy_cek['uye_departman'] ?></b></li>
                                          <input type="hidden" name="uye_departmanpdf" value="<?php echo  $uy_cek['uye_departman'] ?>">
                                          <li class="list-group-item">Mesleği&emsp;<b><?php echo  $uy_cek['uye_meslek'] ?></b></li>
                                          <input type="hidden" name="uye_meslekpdf" value="<?php echo  $uy_cek['uye_meslek'] ?>">
                                          <li class="list-group-item">İzin Türü&emsp;<b><?php echo $ta_cek['talep_konu'] ?></b></li>
                                          <input type="hidden" name="talep_konupdf" value="<?php echo  $ta_cek['talep_konu'] ?>">
                                          <li class="list-group-item">İzin Başlangıç&emsp;<b><?php echo $ta_cek['izin_baslangic'] ?></b></li>
                                          <input type="hidden" name="izin_baslangicpdf" value="<?php echo  $ta_cek['izin_baslangic'] ?>">
                                          <li class="list-group-item">İzin Bitiş&emsp;<b><?php echo $ta_cek['izin_bitis'] ?></b></li>
                                           <input type="hidden" name="izin_bitispdf" value="<?php echo  $ta_cek['izin_bitis'] ?>">
                                          <li class="list-group-item">Açıklama&emsp;<b><?php echo $ta_cek['talep_mesaj'] ?></b></li>
                                          <li class="list-group-item">Talep Oluşturulma Tarihi&emsp;<b>  <?php 
                                          $zamna_ki = new DateTime($ta_cek['talep_zaman']);
                                          $unuttum_zaman = $zamna_ki->format('H:i | d.m.Y'); 
                                          echo $unuttum_zaman; 
                                          ?></b></li>
                                          <li class="list-group-item">



                                            <button type="submit" value="<?php echo $ta_cek['talep_kodu']; ?>" name="izin_talep_pdf_olustur1" id="izin_talep_pdf_olustur1" style="width:100px;" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                              <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                              <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                            </svg></button> 


                                          </form>

                                        </li>


                                      </ul>



                                    </div>

                                  </div>
                                </div>
                              </div>

                              <span class="badge badge-success">Onaylandı</span>

                            </td>
                          </tr>

                        </tbody>
                      <?php }   ?>   
                    </table>


                  </div>

                </div>
              </div>
            </div>
          </div>



        </div>





        <div class="tab-pane " id="egitim">

          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="main-box clearfix">
                  <div class="table-responsive">


                    <table class="table user-list">
                      <thead>
                        <tr>
                          <th class="text-center"><span>ADI SOYADI</span></th>
                          <th class="text-center"><span>İZİN TÜRÜ</span></th>
                          <th class="text-center"><span>BAŞLANGIÇ</span></th>
                          <th class="text-center"><span>BİTİŞ</span></th>
                          <th class="text-center">&nbsp;</th>
                        </tr>
                      </thead>
                      <?php

                      $talep_listele = $db->prepare("SELECT * from izin_talepleri where talep_durum=2");
                      $talep_listele->execute();





                      while($ta_cek=$talep_listele->fetch(PDO::FETCH_ASSOC)) { ?>







                        <?php  
                        $uye_listele = $db->prepare("SELECT * from users where uye_code=:ucoxs");
                        $uye_listele->execute(array(
                          'ucoxs' => $ta_cek['talep_kimin']
                        ));

                        $uy_cek=$uye_listele->fetch(PDO::FETCH_ASSOC);

                        ?>



                        <tbody>
                          <tr>
                            <td>
                              <img src="<?php echo $uy_cek['uye_mini_resim'] ?>" alt="">
                              <a href="#" class="user-link"><?php echo  $uy_cek['uye_ad']," ",$uy_cek['uye_soyad']; ?></a>

                            </td>
                            <td>
                              <?php echo $ta_cek['talep_konu']; ?>
                            </td>
                            <td class="text-center">
                              <span class="label label-default"><?php echo $ta_cek['izin_baslangic'] ?></span>
                            </td>
                            <td>
                              <span class="label label-default"><?php echo $ta_cek['izin_bitis'] ?></span>
                            </td>
                            <td style="width: 20%;">

                              <a  class="table-link" data-target="#exampleModal2<?php echo $ta_cek['talep_kodu'] ?>"   data-toggle="modal" >
                                <span class="fa-stack">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                  <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                </span>
                              </a>

                              <div class="modal fade  bd-example-modal-lg" id="exampleModal2<?php echo $ta_cek['talep_kodu'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" style="background-color:transparent;">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel2">İzin Talep Detayları</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">








                                      <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Adı Soyadı&emsp;<b><?php echo  $uy_cek['uye_isim'] ?></b></li>
                                        <li class="list-group-item">Departmanı&emsp;<b><?php echo  $uy_cek['uye_departman'] ?></b></li>
                                        <li class="list-group-item">Mesleği&emsp;<b><?php echo  $uy_cek['uye_meslek'] ?></b></li>
                                        <li class="list-group-item">İzin Türü&emsp;<b><?php echo $ta_cek['talep_konu'] ?></b></li>
                                        <li class="list-group-item">İzin Başlangıç&emsp;<b><?php echo $ta_cek['izin_baslangic'] ?></b></li>
                                        <li class="list-group-item">İzin Bitiş&emsp;<b><?php echo $ta_cek['izin_bitis'] ?></b></li>
                                        <li class="list-group-item">Açıklama&emsp;<b><?php echo $ta_cek['talep_mesaj'] ?></b></li>
                                        <li class="list-group-item">Talep Oluşturulma Tarihi&emsp;<b>  <?php 
                                        $zamna_ki = new DateTime($ta_cek['talep_zaman']);
                                        $unuttum_zaman = $zamna_ki->format('H:i | d.m.Y'); 
                                        echo $unuttum_zaman; 
                                        ?></b></li>



                                      </ul>



                                    </div>

                                  </div>
                                </div>
                              </div>

                              <span class="badge badge-danger">Reddedildi</span>

                            </td>
                          </tr>

                        </tbody>
                      <?php }   ?>   
                    </table>


                  </div>

                </div>
              </div>
            </div>
          </div>


        </div>








      </div>




    </div>
  </div>
</div>






















<!--
<div class="decorationn">



  <div class="des-stl-pb">



    <div class="hovdes-pan">
      <table class="tableclass">
        <thead>
          <tr>

            <th width="50%">
              <div class="text-des-konu"><span></span></div><form action="personel-izin-gonder-islem.php" method="POST">  <button type="submit" value="<?php echo $ta_cek['talep_kodu']; ?>" name="onayla1" id="onayla1">Onayla</button> 
               <button type="submit" value="<?php echo $ta_cek['talep_kodu']; ?>" name="reddet1" id="reddet1">Reddet</button> 
             </form>
             <div class="destek-isim-text"><span>Kullanıcı : </span>
              <?php $ad = $uy_cek['uye_ad']; $soyad = $uy_cek['uye_soyad'];
              echo $ad." ".$soyad; ?><?php if ($uy_cek['uye_profil_onay'] == 1) { ?><i class="fa fa-check-circle-o desonpnl onay-tooltip" aria-hidden="true" aria-hidden="true" data-toggle="tooltip" data-placement="right" ></i><?php } ?>
            </div>
          </th>


          <th width="50" class="text-right">
            <div class="des-st-style">Talep Zamanı :<span>
              <?php 
              $zamna_ki = new DateTime($ta_cek['talep_zaman']);
              $unuttum_zaman = $zamna_ki->format('H:i | d.m.Y'); 
              echo $unuttum_zaman; 
              ?>
            </span></div>

          </th>

        </tr>
      </thead>
    </table>
  </div>



</div>


</div>


-->

















</div>


<?php include 'footer.php'; ?>
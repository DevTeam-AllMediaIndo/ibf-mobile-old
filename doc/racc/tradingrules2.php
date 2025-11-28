<?php
$id_live = $_GET['id'];

    $SQL_QUERYACC = mysqli_query($db, "
        SELECT tb_racc.*
        FROM tb_racc
        WHERE tb_racc.ACC_LOGIN = '0'
        AND tb_racc.ACC_MBR = ".$user1['MBR_ID']."
        AND tb_racc.ACC_DERE = 1
        AND MD5(MD5(tb_racc.ID_ACC)) = '".$id_live."'
        LIMIT 1
    ");
    if(mysqli_num_rows($SQL_QUERYACC) > 0) {
        $RESULT_QUERYACC = mysqli_fetch_assoc($SQL_QUERYACC);
    };
    if(isset($_POST['submit_32'])){
        if(isset($_POST['aggree'])){
            if(isset($_GET['id'])){
                $aggree = $_POST['aggree'];
                if($aggree == 'Yes'){
                    mysqli_query($db, '
                        UPDATE tb_racc SET
                        tb_racc.ACC_F_TRDNGRULE = 1,
                        tb_racc.ACC_F_TRDNGRULE_PERYT = "'.$aggree.'",
                        tb_racc.ACC_F_TRDNGRULE_IP = "'.$IP_ADDRESS.'",
                        tb_racc.ACC_F_TRDNGRULE_DATE = "'.date('Y-m-d H:i:s').'"
                        WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                    ') or die (mysqli_error($db));
                    die ("<script>location.href = 'home.php?page=racc/kodeakses&id=".$id_live."'</script>");
                }else{die("<script>location.href = 'home.php?page=racc/tradingrules&id=".$id_live."'</script>");};
            } else { die ("<script>alert('please try again2');location.href = 'home.php?page=racc/tradingrules&id=".$id_live."'</>"); }
        } else { die ("<script>alert('please try again2');location.href = 'home.php?page=racc/tradingrules&id=".$id_live."'</script>"); }
    };
?>
<div class="page-title page-title-small">
    <h2>Peraturan</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<form method="post">
    <!-- <div id="menu-success-1" class="menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="310">
        <ol>
            <li>Modifikasi / Menangguhkan Aturan Perdagangan.
                <p>
                    Kami memiliki kewenangan penuh untuk memodifikasi / menangguhkan semua atau sebagian dari Peraturan Perdagangan ini dengan pemberitahuan sebelumnya kepada klien.
                </p>
            </li>
            <li>
                Hal-hal yang dilarang
                Hal-hal berikut dibawah ini dilarang oleh layanan kami,  kami memiliki kewenangan penuh untuk menolak Order tanpa pemberitahuan sebelumnya kepada klien sekali kami  menerima kondisi di bawah ini:
                <ol type="a">
                    <li>Setiap order nasabah yang jangka pendek yang luar biasa dan / atau tidak biasa/transaksi yang dilakukan secara tidak wajar dalam waktu yang berdekatan secara berlebihan dan terus menerus. maka semua transaksi yang sudah done akan dibatalkan.</li>
                    <li>Tidak dapat melakukan transaksi liquidasi 2(dua) menit setelah masuk posisi New (baru) dan atau untuk hedging.</li>
                    <li>Apabila sebelum 2 (dua) menit terjadi transaksi liquidasi setelah masuk posisi new maka dan atau untuk hedging order yang sudah executed dinyatakan tidak berlaku.</li>
                    <li>Tidak dapat melakukan transaksi liquidasi 2(dua) menit setelah masuk posisi New (baru) dan atau untuk hedging</li>
                    <li>Apabila sebelum 2 (dua) menit terjadi transaksi liquidasi setelah masuk posisi new maka dan atau untuk hedging order yang sudah executed dinyatakan tidak berlaku.</li>
                    <li>Setiap order klien / tindakan yang menyebabkan kerusakan pada layanan kami.</li>
                    <li>Setiap tindakan klien untuk modifikasi sistem kami untuk tujuan lain yang berbeda dengan tujuan awal.</li>
                    <li>Setiap tindakan nasabah yang menyerang titik lemah dari internet dan / atau sistem kami, dan menggunakan kondisi market yang tidak stabil. ( arbitrase )</li>
                    <li>Dalam hal bahwa akun klien digunakan untuk tindakan illegal.</li>
                    <li>Penggunaan Expert Advisor (segala bentuk Program atau software) tidak diterima.</li>
                    <li>Apabila terjadi Open Gap, maka posisi terbuka overnight akan diliquid secara otomatis oleh</li>
                </ol>
            </li>
        </ol>
        <a href="#" onclick="myfunc2()" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green-light">Great</a>
    </div> -->
    <div id="menu-success-1" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="305" data-menu-effect="menu-over">
        <h1 class="text-center mt-4"><i class="fa fa-3x fa-check-circle color-green-dark"></i></h1>
        <h1 class="text-center mt-3 text-uppercase font-700">All's Good</h1>
        <p class="boxed-text-l">
        You can continue with your previous actions.<br> Easy to attach these to success calls.
        </p>
        <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green-light">Great</a>
    </div>
    <div class="card card-style">
        <div class="card-body">
            <div class="row">
                <div class="col-6 text-left">
                    <strong><small><b>Formulir Nomor 107.PBK.06 </b></small></strong>
                </div>
                <div class="col-6 text-right">
                    <small>
                        Lampiran Peraturan Kepala Badan Pengawas<br>
                        Perdagangan Berjangka Komoditi<br>
                        Nomor : 107/BAPPEBTI/PER/11/2013
                    </small>
                </div>
            </div>
            <br>
            <div class="text-center"><strong>PERATURAN PERDAGANGAN (<i>TRADING RULES</i>)</strong></div>
            <br>
            <div class="clearfix"></div>
            <table>
                <tr>
                    <td>TRADING RULES</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>
                        <?php
                            if($RESULT_QUERYACC['ACC_TYPE'] == 1 && $RESULT_QUERYACC['ACC_TYPEACC'] == 'Regular'){
                                $file_pdf = 'ibf-regular-';
                        ?>
                            <span>Forex Regular</span>
                        <?php 
                            } else if($RESULT_QUERYACC['ACC_TYPE'] == 1 && $RESULT_QUERYACC['ACC_TYPEACC'] == 'Mini'){
                                $file_pdf = 'ibf-mini-';
                        ?>
                            <span>Forex Mini</span>
                        <?php } else { ?>
                            <span>Multilateral</span>
                        <?php }; ?>
                    </td>
                </tr>
                <tr>
                    <td>Biaya yang dikenakan setiap pelaksanaan transaksi</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>Maximal $50</td>
                </tr>
            </table>
            <img src="doc/pdf/<?php echo $file_pdf; ?>1.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_01" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required /> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>2.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_02" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>3.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_03" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>4.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_04" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>5.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_05" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>6.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_06" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>7.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_07" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>8.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_08" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>9.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_09" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>10.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_10" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>11.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_11" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>12.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_12" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>13.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_13" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <img src="doc/pdf/<?php echo $file_pdf; ?>14.jpg" width="100%" height="600"></img>
            <div class="text-left mb-2"><label style="cursor:pointer;"><input type="checkbox" id="cb_14" onclick="run();" class="form-check-input" style="border: 1.5px solid black !important;" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            <!-- <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_15" onclick="run1();" value="YA" required/> Saya telah membaca dan menyetujui dari semua isi perjanjian ini</label></div>  -->
            <p class="text-center mt-2">Dengan mengisi kolom "YA" di bawah ini, saya menyatakan bahwa saya telah membaca tentang PERATIRAN PERDAGANGAN (TRADING RULES), mengerti dan menerima ketentuan dalam bertransaksi</p>
            <div class="row mt-3 mb-3">
                <div class="col-6">
                    Pernyataan menerima / tidak<br>
                    <!-- <input id="spl_cb" type="radio" class="form-check-input radio_css" name="aggree" value="Yes" style="margin-top: 10px;" data-menu="menu-success-1" required> -->
                    <input id="spl_cb" type="radio" class="form-check-input radio_css" name="aggree" value="Yes" style="margin-top: 10px;" onclick="myfunc()" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                    <input type="radio" class="form-check-input radio_css" name="aggree" value="No" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak</label>
                </div>
                <div class="col-6">
                    <label>Menerima pada Tanggal</label>
                    <input type="text" readonly required value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control text-center">
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <input type="hidden" name="check" value="1">
        <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_32">Next</button>
    </div>
    
</form>
<script>
    // let spl_cb = document.getElementById('spl_cb');
    // spl_cb.addEventListener('click', function clk(elem){
    //     console.log('asd');
    //     let mdl = document.getElementById("menu-success-1");
    //     mdl.classList.add('menu-active');
    //     console.log('clicked');
    // });

    
    // let clsBtn = document.getElementsByClassName('close-menu');
    // clsBtn[0].addEventListener('click', function cls(el){
    //     elem.preventDefault();
    //     mdl.classList.remove('menu-active');
    //     console.log('berhasil');
    // });
    
    let mdl = document.getElementById("menu-success-1");

    function myfunc(){
        mdl.classList.add('menu-active');
        console.log('test');
        console.log(screen.width);
    }

    function myfunc2(){
        mdl.classList.remove('menu-active');
        console.log('test2');
    }

    

    function run(){
        if(document.getElementById("cb_01").checked == true){ 
            document.getElementById("cb_02").disabled = false; 
            document.getElementById("cb_01").scrollIntoView({behavior: "smooth", inline: "end"}); 
        } else { 
            document.getElementById("cb_02").disabled = true; 
        }
        if(document.getElementById("cb_02").checked == true){ 
            document.getElementById("cb_03").disabled = false; 
            document.getElementById("cb_02").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_03").disabled = true; 
        }
        if(document.getElementById("cb_03").checked == true){ 
            document.getElementById("cb_04").disabled = false; 
            document.getElementById("cb_03").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_04").disabled = true; 
        }
        if(document.getElementById("cb_04").checked == true){ 
            document.getElementById("cb_05").disabled = false; 
            document.getElementById("cb_04").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_05").disabled = true; 
        }
        if(document.getElementById("cb_05").checked == true){ 
            document.getElementById("cb_06").disabled = false; 
            document.getElementById("cb_05").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_06").disabled = true; 
        }
        if(document.getElementById("cb_06").checked == true){ 
            document.getElementById("cb_07").disabled = false; 
            document.getElementById("cb_06").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_07").disabled = true; 
        }
        if(document.getElementById("cb_07").checked == true){ 
            document.getElementById("cb_08").disabled = false; 
            document.getElementById("cb_07").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_08").disabled = true; 
        }
        if(document.getElementById("cb_08").checked == true){ 
            document.getElementById("cb_09").disabled = false; 
            document.getElementById("cb_08").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_09").disabled = true; 
        }
        if(document.getElementById("cb_09").checked == true){ 
            document.getElementById("cb_10").disabled = false; 
            document.getElementById("cb_09").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_10").disabled = true; 
        }
        if(document.getElementById("cb_10").checked == true){ 
            document.getElementById("cb_11").disabled = false; 
            document.getElementById("cb_10").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_11").disabled = true; 
        }
        if(document.getElementById("cb_11").checked == true){ 
            document.getElementById("cb_12").disabled = false; 
            document.getElementById("cb_11").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_12").disabled = true; 
        }
        if(document.getElementById("cb_12").checked == true){ 
            document.getElementById("cb_13").disabled = false; 
            document.getElementById("cb_12").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_13").disabled = true; 
        }
        if(document.getElementById("cb_13").checked == true){ 
            document.getElementById("cb_14").disabled = false; 
            document.getElementById("cb_13").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_14").disabled = true; 
        }
        
    }

    function run1(){
        if(document.getElementById("cb_15").checked == true){ 
            document.getElementById("cb_01").checked = true
            document.getElementById("cb_02").checked = true
            document.getElementById("cb_03").checked = true
            document.getElementById("cb_04").checked = true
            document.getElementById("cb_05").checked = true
            document.getElementById("cb_06").checked = true
            document.getElementById("cb_07").checked = true
            document.getElementById("cb_08").checked = true
            document.getElementById("cb_09").checked = true
            document.getElementById("cb_10").checked = true
            document.getElementById("cb_11").checked = true
            document.getElementById("cb_12").checked = true
            document.getElementById("cb_13").checked = true
            document.getElementById("cb_14").checked = true
            
            document.getElementById("cb_02").disabled = true;
            document.getElementById("cb_03").disabled = true;
            document.getElementById("cb_04").disabled = true;
            document.getElementById("cb_05").disabled = true;
            document.getElementById("cb_06").disabled = true;
            document.getElementById("cb_07").disabled = true;
            document.getElementById("cb_08").disabled = true;
            document.getElementById("cb_09").disabled = true;
            document.getElementById("cb_10").disabled = true;
            document.getElementById("cb_11").disabled = true;
            document.getElementById("cb_12").disabled = true;
            document.getElementById("cb_13").disabled = true;
            document.getElementById("cb_14").disabled = true;
        } else {
            
            document.getElementById("cb_01").checked = false;
            document.getElementById("cb_02").checked = false;
            document.getElementById("cb_03").checked = false;
            document.getElementById("cb_04").checked = false;
            document.getElementById("cb_05").checked = false;
            document.getElementById("cb_06").checked = false;
            document.getElementById("cb_07").checked = false;
            document.getElementById("cb_08").checked = false;
            document.getElementById("cb_09").checked = false;
            document.getElementById("cb_10").checked = false;
            document.getElementById("cb_11").checked = false;
            document.getElementById("cb_12").checked = false;
            document.getElementById("cb_13").checked = false;
            document.getElementById("cb_14").checked = false;

            document.getElementById("cb_02").disabled = false;
            document.getElementById("cb_03").disabled = false;
            document.getElementById("cb_04").disabled = false;
            document.getElementById("cb_05").disabled = false;
            document.getElementById("cb_06").disabled = false;
            document.getElementById("cb_07").disabled = false;
            document.getElementById("cb_08").disabled = false;
            document.getElementById("cb_09").disabled = false;
            document.getElementById("cb_10").disabled = false;
            document.getElementById("cb_11").disabled = false;
            document.getElementById("cb_12").disabled = false;
            document.getElementById("cb_13").disabled = false;
            document.getElementById("cb_14").disabled = false;
        }
    }
</script>

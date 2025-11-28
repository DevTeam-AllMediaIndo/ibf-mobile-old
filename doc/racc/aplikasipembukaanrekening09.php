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
        $R_LOKRMH = $RESULT_QUERYACC['ACC_F_APP_KEKYAN_RMHLKS'];
        $R_NJOP = $RESULT_QUERYACC['ACC_F_APP_KEKYAN_NJOP'];
        $R_DPSTBK = $RESULT_QUERYACC['ACC_F_APP_KEKYAN_DPST'];
        $R_JUMLAH = $RESULT_QUERYACC['ACC_F_APP_KEKYAN_NILAI'];
        $R_LAINYA = $RESULT_QUERYACC['ACC_F_APP_KEKYAN_LAIN'];
    } else {
        $R_LOKRMH = '';
        $R_NJOP = '';
        $R_DPSTBK = '';
        $R_JUMLAH = '';
        $R_LAINYA = '';
    }
    $SQL_DT = mysqli_query($db, '
        SELECT
        *
        FROM tb_racc
        WHERE tb_racc.ACC_LOGIN > "0"
        AND tb_racc.ACC_MBR = '.$user1["MBR_ID"].'
        AND tb_racc.ACC_DERE = 1
        LIMIT 1
    ') or die(mysqli_query($db));
    if(mysqli_num_rows($SQL_DT) > 0){
        $RESULT_DT = mysqli_fetch_assoc($SQL_DT);
    };
    if(isset($_POST['input_lv13'])){
       if(isset($_POST['lokrmh'])){
            if(isset($_POST['njop'])){
                if(isset($_POST['dpstbk'])){
                    if(isset($_POST['jumlah'])){
                        if(isset($_POST['lainya'])){

                            $lokrmh = form_input($_POST['lokrmh']);
                            $njop = form_input($_POST['njop']);
                            $dpstbk = form_input($_POST['dpstbk']);
                            $jumlah = form_input($_POST['jumlah']);
                            $lainya = form_input($_POST['lainya']);
                            $EXEC_SQL = mysqli_query($db,'
                                UPDATE tb_racc SET
                                    tb_racc.ACC_F_APP_KEKYAN_RMHLKS = "'.$lokrmh.'",
                                    tb_racc.ACC_F_APP_KEKYAN_NJOP = "'.$njop.'",
                                    tb_racc.ACC_F_APP_KEKYAN_DPST = "'.$dpstbk.'",
                                    tb_racc.ACC_F_APP_KEKYAN_LAIN = "'.$lainya.'",
                                    tb_racc.ACC_F_APP_KEKYAN_NILAI = "'.$jumlah.'"
                                WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                            ') or die ("<script>alert('Please try again or contact support');location.herf = 'home.php?page=racc/aplikasipembukaanrekening09&id=".$id_live."'</script>");
                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>");
    
                        }else { 
                            logerr("Parameter Ke-5 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-9 (REGOL)", $user1["MBR_ID"]);
                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-5 Tidak Lengkap')."'</script>");
                        }
                    }else { 
                        logerr("Parameter Ke-4 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-9 (REGOL)", $user1["MBR_ID"]);
                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-4 Tidak Lengkap')."'</script>");
                    }
                }else { 
                    logerr("Parameter Ke-3 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-9 (REGOL)", $user1["MBR_ID"]);
                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-3 Tidak Lengkap')."'</script>");
                }
            }else { 
                logerr("Parameter Ke-2 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-9 (REGOL)", $user1["MBR_ID"]);
                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-2 Tidak Lengkap')."'</script>");
            }
        }else { 
            logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-9 (REGOL)", $user1["MBR_ID"]);
            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-1 Tidak Lengkap')."'</script>");
        }
    }
?>
<div class="page-title page-title-small">
    <h2>Aplikasi Pembukaan Rekening</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<form method="post">
    
    <div class="card card-style">
        <div class="card-body">
            
            <div class="row">
                <!-- <div class="col-6 text-left">
                    <strong><small><b>Formulir Nomor 107.PBK.03</b></small></strong>
                </div> -->
                <!-- <div class="col-12 text-right">
                    <small>
                        Lampiran Peraturan Kepala Badan Pengawas<br>
                        Perdagangan Berjangka Komoditi<br>
                        Nomor : 107/BAPPEBTI/PER/11/2013
                    </small>
                </div> -->
                <?php include 'header_form.php'; ?>
            </div>
            <div class="text-center"><strong style="font-size: larger;">APLIKASI PEMBUKAAN REKENING TRANSAKSI SECARA ELEKTRONIK ONLINE</strong></div>
            <hr>
            <div class="text-center"><strong>DAFTAR KEKAYAAN</strong></div>
            <div class="form-group boxed">

                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">Rumah Lokasi</label>
                    <input type="text" class="form-control" id="text4b" placeholder="Masukkan lokasi rumah anda" 
                        value="<?php  
                            if($RESULT_DT["ACC_F_APP_KEKYAN_RMHLKS"] > "-1"){
                                echo $RESULT_DT["ACC_F_APP_KEKYAN_RMHLKS"];
                            }else{
                                echo $R_LOKRMH;
                            };
                        ?>" name="lokrmh" required autocomplete="off"
                    >
                </div>

                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">Nilai NJOP</label>
                    <input type="number" class="form-control" id="njop" placeholder="Masukkan NJOP nilai anda" name="njop" 
                        value="<?php
                            if($RESULT_DT["ACC_F_APP_KEKYAN_NJOP"] > -1){
                                echo $RESULT_DT["ACC_F_APP_KEKYAN_NJOP"];
                            }else{
                                echo $R_NJOP;
                            };
                        ?>" required autocomplete="off"
                    >
                </div>

                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">Deposit Bank</label>
                    <input type="number" class="form-control" id="bk_dp" placeholder="Silahkan isi '0' jika tidak memiliki" name="dpstbk" 
                        value="<?php
                            if($RESULT_DT["ACC_F_APP_KEKYAN_DPST"] > -1){
                                echo $RESULT_DT["ACC_F_APP_KEKYAN_DPST"];
                            }else{
                                echo $R_DPSTBK;
                            };
                        ?>" required autocomplete="off"
                    >
                </div>

                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" placeholder="Silahkan isi '0' jika tidak memiliki" name="jumlah" 
                        value="<?php
                            if($RESULT_DT["ACC_F_APP_KEKYAN_NILAI"] > -1){
                                echo $RESULT_DT["ACC_F_APP_KEKYAN_NILAI"];
                            }else{
                                echo $R_JUMLAH;
                            };
                        ?>" required autocomplete="off" readonly
                    >
                </div>

                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">Jumlah Kekayaan Lainnya</label>
                    <select class="form-control custom-select" id="select4b" name="lainya" required>
                        <option disabled selected value>Pilih salah satu</option>
                        <option <?php if($R_LAINYA == 'Antara Rp. 100 - 250 juta' || $RESULT_DT["ACC_F_APP_KEKYAN_LAIN"] == 'Antara Rp. 100 - 250 juta'){ echo 'selected';}?> value="Antara Rp. 100 - 250 juta">Antara Rp. 100 - 250 juta</option>
                        <option <?php if($R_LAINYA == 'Antara Rp. 250 - 500 juta' || $RESULT_DT["ACC_F_APP_KEKYAN_LAIN"] == 'Antara Rp. 250 - 500 juta'){ echo 'selected';}?> value="Antara Rp. 250 - 500 juta">Antara Rp. 250 - 500 juta</option>
                        <option <?php if($R_LAINYA == 'Di atas Rp. 500 juta' || $RESULT_DT["ACC_F_APP_KEKYAN_LAIN"] == 'Di atas Rp. 500 juta'){ echo 'selected';}?> value="Di atas Rp. 500 juta">Di atas Rp. 500 juta</option>
                        <option <?php if($R_LAINYA == 'Tidak ada' || $RESULT_DT["ACC_F_APP_KEKYAN_LAIN"] == 'Tidak ada'){ echo 'selected';}?> value="Tidak ada">Tidak ada</option>
                    </select>
                </div>

            </div>
        </div>
    </div>
    
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" name="input_lv13">Next</button>
    </div>
</form>
<script>
    let njop = document.getElementById("njop");
    let bk_dp = document.getElementById('bk_dp');
    let jumlah = document.getElementById('jumlah');
    njop.addEventListener("keyup", function(e){
        jumlah.value = Number(e.target.value) + Number(bk_dp.value);
    });
    bk_dp.addEventListener("keyup", function(e){
        jumlah.value = Number(e.target.value) + Number(njop.value);
    });
</script>
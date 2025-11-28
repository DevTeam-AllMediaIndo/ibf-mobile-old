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
        $R_INVSTG = $RESULT_QUERYACC['ACC_F_APP_KELGABURSA'];
    } else {
        $R_INVSTG = '';
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
    if(isset($_POST['input_lv9'])){
        if(isset($_POST['exp_level'])){
            $exp_level = form_input($_POST['exp_level']);
            if( $exp_level == 'Ya'){ 
                die ("<script>location.href = 'home.php?page=racc/live_033&id=".$id_live."'</script>");
            } else {
                $EXEC_SQL = mysqli_query($db,'
                    UPDATE tb_racc SET
                        tb_racc.ACC_F_APP_KELGABURSA  = "'.$exp_level.'"
                    WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                ') or die (mysql_error($db));
                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening05&id=".$id_live."'</script>");
            };
        } else { 
            logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-4 (REGOL)", $user1["MBR_ID"]);
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
        <div class="content">
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
            <div class="clearfix"></div>
            <div class="text-center"><strong>Apakah Anda memiliki anggota keluarga yang bekerja di BAPPEBTI/Bursa Berjangka/Kliring Berjangka?</strong></div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card card-style">
                <div class="card-body" style="font-size : 15px; ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault1" 
                            <?php if($R_INVSTG == 'Ya' || $RESULT_DT["ACC_F_APP_KELGABURSA"] == 'Ya'){ echo 'checked'; } ?> value="Ya" name="exp_level" required
                        >
                        <label class="form-check-label" for="radioInlineDefault1"></label>
                    </div>
                    <span>Ya</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-style">
                <div class="card-body" style="font-size : 15px; ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault2" 
                            <?php if($R_INVSTG == 'Tidak' ||  $RESULT_DT["ACC_F_APP_KELGABURSA"] == 'Tidak'){ echo 'checked'; } ?> value="Tidak" name="exp_level"
                        >
                        <label class="form-check-label" for="radioInlineDefault2"></label>
                    </div>
                    <span>Tidak</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="input_lv9">Next</button>
    </div>
</form>

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
        $R_INVSTG = $RESULT_QUERYACC['ACC_F_APP_TUJUANBUKA'];
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
    if(isset($_POST['input_lv8'])){
        if(isset($_POST['invst_goals'])){
            $invst_goals = form_input($_POST['invst_goals']);
            $EXEC_SQL = mysqli_query($db,'
                UPDATE tb_racc SET
                tb_racc.ACC_F_APP_TUJUANBUKA = "'.$invst_goals.'"
                WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
            ') or die(mysqli_error($db));
            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening03&id=".$id_live."'</script>");

        } else {
            logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-2 (REGOL)", $user1["MBR_ID"]);
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
            <div class="clearfix"></div>
            <div class="text-center"><strong>Tujuan Pembukaan Rekening</strong></div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card card-style">
                <div class="card-body" style="font-size : 15px; ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault1" <?php if($R_INVSTG == 'Lindungi Nilai' || $RESULT_DT["ACC_F_APP_TUJUANBUKA"] == 'Lindungi Nilai'){ echo 'checked'; } ?> value="Lindungi Nilai" name="invst_goals" required>
                        <label class="form-check-label" for="radioInlineDefault1"></label>
                    </div>
                    <span>Lindungi nilai</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-style">
                <div class="card-body" style="font-size : 15px; ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault2" <?php if($R_INVSTG == 'Gain' || $RESULT_DT["ACC_F_APP_TUJUANBUKA"] == 'Gain'){ echo 'checked'; } ?> value="Gain" name="invst_goals">
                        <label class="form-check-label" for="radioInlineDefault2"></label>
                    </div>
                    <span>Gain</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-style">
                <div class="card-body" style="font-size : 15px; ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault3" <?php if($R_INVSTG == 'Spekulasi' || $RESULT_DT["ACC_F_APP_TUJUANBUKA"] == 'Spekulasi'){ echo 'checked'; } ?> value="Spekulasi" name="invst_goals">
                        <label class="form-check-label" for="radioInlineDefault3"></label>
                    </div>
                    <span>Spekulasi</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-style">
                <div class="card-body" style="font-size : 15px; ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault4" <?php if($R_INVSTG == 'Lainnya' || $RESULT_DT["ACC_F_APP_TUJUANBUKA"] == 'Lainnya'){ echo 'checked'; } ?> value="Lainnya" name="invst_goals">
                        <label class="form-check-label" for="radioInlineDefault4"></label>
                    </div>
                    <span>Lainnya</span>
                </div>
            </div>
        </div>
    </div>
            
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="input_lv8">Next</button>
    </div>
</form>
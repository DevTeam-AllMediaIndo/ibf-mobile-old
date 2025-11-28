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
        $R_INVSTG = $RESULT_QUERYACC['ACC_F_APP_PENGINVT'];
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
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['input_lv9'])){
            if(isset($_POST['exp_level'])){
                $exp_level = form_input($_POST['exp_level']);
                $EXEC_SQL = mysqli_query($db,'
                    UPDATE tb_racc SET
                        tb_racc.ACC_F_APP_PENGINVT       = "Tidak",
                        tb_racc.ACC_F_PENGLAMAN_PERYT_YA = NULL
                    WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                ') or die (mysqli_error($db));
                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening04&id=".$id_live."'</script>");
                
            } else { 
                logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-3 (REGOL)", $user1["MBR_ID"]);
                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-1 Tidak Lengkap')."'</script>");
            }
        }
        if(isset($_POST['submit_yes'])){
            if(isset($_POST['peng_invt_nama'])){
                $peng_invt_nama = form_input($_POST['peng_invt_nama']);
                $EXEC_SQL = mysqli_query($db,'
                    UPDATE tb_racc SET
                        tb_racc.ACC_F_APP_PENGINVT       = "Ya",
                        tb_racc.ACC_F_PENGLAMAN_PERYT_YA = "'.$peng_invt_nama.'"
                    WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                ') or die (mysqli_error($db));
                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening04&id=".$id_live."'</script>");
            }
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
<form method="post" id="from_1">
    
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
            <div class="text-center"><strong>Pengalaman Investasi</strong></div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card card-style">
                <div class="card-body" style="font-size : 15px; ">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault1" 
                            <?php if($R_INVSTG == 'Ya' || $RESULT_DT["ACC_F_APP_PENGINVT"] == 'Ya' ){ echo 'checked'; } ?> value="Ya" name="exp_level" required
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
                            <?php if($R_INVSTG == 'Tidak' || $RESULT_DT["ACC_F_APP_PENGINVT"] == 'Tidak' ){ echo 'checked'; } ?> value="Tidak" name="exp_level"
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
<form method="post">
    <div id="menu-signin" class="menu menu-box-modal mb-3 rounded-m" data-menu-height="330" data-menu-width="310" style="border: 1px solid black">
        <div class="me-3 ms-3 mt-3">
            <div class="row">
                <div class="col-6">
                    <h1 class="font-700 mb-0">Bidang</h1>
                </div>
                <div class="col-6 text-right">
                    <h1 class="font-700 mb-0 text-danger float-right" style="float: right;">
                        <i class="fas fa-times"></i>
                    </h1>
                </div>
            </div>
    
            <div class="input-style no-borders has-icon validate-field mb-4 mt-3">
                &nbsp;
            </div>
            <div class="input-style no-borders mb-4 mt-3">
                <input type="name" class="form-control" id="form1aa" name="peng_invt_nama" placeholder="Bidang Investasi" style="border: 1px solid black"required>
                <label for="form1aa" class="color-highlight mt-1 font-500 font-11">Bidang Investasi</label>
            </div>
            <button class="btn btn-full shadow-l rounded-s text-uppercase font-900 bg-green-dark mt-4" type="submit" name="submit_yes">Submit</button>
        </div>
    </div>
</form>
<script>
    let from_1 = document.getElementById('from_1');
    from_1.addEventListener('submit', function(e){
        if(e.srcElement[0].checked){
            let ms = document.getElementById('menu-signin');
            let fas = document.querySelector('div#menu-signin .fas');
            e.preventDefault();
            ms.classList.add("menu-active");
            fas.addEventListener('click', function(ev){
                ms.classList.remove("menu-active");
                console.log('click');
            });
        }else{
            e.nextElementSibling[0].required = false;
            e.target.submit();
        }
    });
</script>
<?php
    $id_live = $_GET['id'];
    $SQL_QUERYACC = mysqli_query($db, "
    SELECT 
        tb_racc.ACC_F_APP_DRRT_NAMA,
        tb_racc.ACC_F_APP_DRRT_ALAMAT,
        tb_racc.ACC_F_APP_DRRT_TLP,
        tb_racc.ACC_F_APP_DRRT_ZIP,
        tb_racc.ACC_F_APP_DRRT_HUB
    FROM tb_racc
    WHERE tb_racc.ACC_LOGIN = '0'
    AND tb_racc.ACC_MBR = ".$user1['MBR_ID']."
    AND tb_racc.ACC_DERE = 1
    AND MD5(MD5(tb_racc.ID_ACC)) = '".$id_live."'
    LIMIT 1
    ");
    if(mysqli_num_rows($SQL_QUERYACC) > 0) {
        $RESULT_QUERYACC = mysqli_fetch_assoc($SQL_QUERYACC);
        $R_NAMA = $RESULT_QUERYACC['ACC_F_APP_DRRT_NAMA'];
        $R_ALAMAT = $RESULT_QUERYACC['ACC_F_APP_DRRT_ALAMAT'];
        $R_TLP = $RESULT_QUERYACC['ACC_F_APP_DRRT_TLP'];
        $R_ZIP = $RESULT_QUERYACC['ACC_F_APP_DRRT_ZIP'];
        $R_HUB = $RESULT_QUERYACC['ACC_F_APP_DRRT_HUB'];
    } else {
        $R_NAMA = '';
        $R_ALAMAT = '';
        $R_TLP = '';
        $R_ZIP = '';
        $R_HUB = '';
    }
    $SQL_DT = mysqli_query($db, '
        SELECT
        *
        FROM tb_racc
        WHERE tb_racc.ACC_LOGIN > "0"
        AND tb_racc.ACC_MBR = '.$user1["MBR_ID"].'
        AND tb_racc.ACC_DERE = 1
        AND MD5(MD5(tb_racc.ID_ACC)) <> "'.$id_live.'"
        LIMIT 1
    ') or die(mysqli_query($db));
    if(mysqli_num_rows($SQL_DT) > 0){
        $RESULT_DT = mysqli_fetch_assoc($SQL_DT);
    };
    if(isset($_POST['input_lv4'])) {
        if(isset($_POST['full_name'])) {
            if(isset($_POST['alamat'])) {
                if(isset($_POST['telpon'])) {
                    if(isset($_POST['hub'])) {
                        if(isset($_POST['zip'])) {
                            $full_name = form_input($_POST['full_name']);
                            $alamat = form_input($_POST['alamat']);
                            $telpon = form_input($_POST['telpon']);
                            $hub = form_input($_POST['hub']);
                            $zip = form_input($_POST['zip']);
                            $EXEC_SQL = mysqli_query($db, '
                                UPDATE tb_racc SET
                                    tb_racc.ACC_F_APP_DRRT_NAMA = "'.$full_name.'",
                                    tb_racc.ACC_F_APP_DRRT_ALAMAT  = "'.$alamat.'",
                                    tb_racc.ACC_F_APP_DRRT_TLP  = "'.$telpon.'",
                                    tb_racc.ACC_F_APP_DRRT_ZIP  = "'.$zip.'",
                                    tb_racc.ACC_F_APP_DRRT_HUB  = "'.$hub.'"
                                WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                            ') or die (mysqli_error($db));
                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening07&id=".$id_live."'</script>");

                        } else {
                            logerr("Parameter Ke-5 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-6 (REGOL)", $user1["MBR_ID"]);
                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-5 Tidak Lengkap')."'</script>"); 
                        }
                    } else {
                        logerr("Parameter Ke-4 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-6 (REGOL)", $user1["MBR_ID"]);
                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-4 Tidak Lengkap')."'</script>"); 
                    }
                } else {
                    logerr("Parameter Ke-3 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-6 (REGOL)", $user1["MBR_ID"]);
                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-3 Tidak Lengkap')."'</script>"); 
                }
            } else {
                logerr("Parameter Ke-2 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-6 (REGOL)", $user1["MBR_ID"]);
                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-2 Tidak Lengkap')."'</script>"); 
            }
        } else {
            logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-6 (REGOL)", $user1["MBR_ID"]);
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
            <div class="text-center"><strong>PIHAK YANG DIHUBUNGI DALAM KEADAAN DARURAT</strong></div>
            <div class="clearfix"></div>
            <div class="form-group boxed">
                <span>Dalam keadaan darurat, pihak yang dapat dihubungi</span>
                <div class="input-wrapper">
                    <label class="label" for="text4b">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="text4b"   placeholder="Masukkan nama pihak yang bisa di hubungi" 
                        value="<?php 
                            if(strlen($R_NAMA) > 3){
                                echo $R_NAMA;
                            }else{  echo $RESULT_DT["ACC_F_APP_DRRT_NAMA"]; };
                        ?>" name="full_name" required autocomplete="off"
                    >
                </div>
                <div class="input-wrapper mt-3 row">
                    <div class="col-8">    
                        <label class="label" for="text4b">Alamat Rumah:</label>
                        <input type="text" class="form-control" id="text4b"   placeholder="Masukkan alamat rumah pihak yang bisa di hubungi" 
                            value="<?php 
                                if(strlen($R_ALAMAT) > 3){
                                    echo $R_ALAMAT;
                                } else { echo $RESULT_DT["ACC_F_APP_DRRT_ALAMAT"]; }
                            ?>" name="alamat" required autocomplete="off"
                        >
                    </div>
                    <div class="col-4">    
                        <label class="label" for="text4b">Kode pos:</label>
                        <input type="number" class="form-control" id="text4b" min="10000" max="99999" placeholder="Masukan kode pos sesuai dengan alamat anda" 
                            value="<?php 
                                if(strlen($R_ZIP) > 3){
                                    echo $R_ZIP;
                                }else{ echo $RESULT_DT["ACC_F_APP_DRRT_ZIP"]; }
                            ?>" name="zip" required autocomplete="off"
                        >
                    </div>
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">No.Telp:</label>
                    <input type="number" class="form-control" id="text4b" placeholder="Masukkan no.telpon pihak yang bisa di hubungi / isi '0' jika tidak mempunyai nya" 
                        value="<?php 
                            if(strlen($R_TLP) > 0){
                                echo $R_TLP;
                            }else{ 
                                echo $RESULT_DT["ACC_F_APP_DRRT_TLP"];
                            }; 
                        ?>" name="telpon" required autocomplete="off"
                    >
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">Hubungan dengan anda:</label>
                    <input type="text" class="form-control" id="text4b"   placeholder="Hubungan anda dengan pihak yang bisa di hubungi / isi '-' jika tidak mempunyai nya" 
                        value="<?php 
                            if(strlen($R_HUB) > 3){
                                echo $R_HUB;
                            }else{
                                echo $RESULT_DT["ACC_F_APP_DRRT_HUB"];
                            };
                        ?>" name="hub" required autocomplete="off"
                    >
                </div>
            </div>
        </div>
    </div>
    
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="input_lv4">Next</button>
    </div>
</form>

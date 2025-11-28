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
        $R_BKNAME = $RESULT_QUERYACC['ACC_F_APP_BK_1_NAMA'];
        $R_BKBRANC = $RESULT_QUERYACC['ACC_F_APP_BK_1_CBNG'];
        $R_BKNOREK = $RESULT_QUERYACC['ACC_F_APP_BK_1_ACC'];
        $R_TLP = $RESULT_QUERYACC['ACC_F_APP_BK_1_TLP'];
        $R_JENISREK = $RESULT_QUERYACC['ACC_F_APP_BK_1_JENIS'];

        $R_BKNAME2 = $RESULT_QUERYACC['ACC_F_APP_BK_2_NAMA'];
        $R_BKBRANC2 = $RESULT_QUERYACC['ACC_F_APP_BK_2_CBNG'];
        $R_BKNOREK2 = $RESULT_QUERYACC['ACC_F_APP_BK_2_ACC'];
        $R_TLP2 = $RESULT_QUERYACC['ACC_F_APP_BK_2_TLP'];
        $R_JENISREK2 = $RESULT_QUERYACC['ACC_F_APP_BK_2_JENIS'];
        
    } else {
        $R_BKNAME = '';
        $R_BKBRANC = '';
        $R_BKNOREK = '';
        $R_TLP = '';
        $R_JENISREK = '';

        $R_BKNAME2 = '';
        $R_BKBRANC2 = '';
        $R_BKNOREK2 = '';
        $R_TLP2 = '';
        $R_JENISREK2 = '';
        
    }
    $SQL_DT = mysqli_query($db, '
        SELECT
        *
        FROM tb_racc
        WHERE tb_racc.ACC_LOGIN <> "0"
        AND tb_racc.ACC_MBR = '.$user1["MBR_ID"].'
        AND tb_racc.ACC_DERE = 1
        LIMIT 1
    ');
    if(mysqli_num_rows($SQL_DT) > 0){
        $RESULT_DT = mysqli_fetch_assoc($SQL_DT);
    } else {
        $RESULT_DT = null; // Atau bisa dihandle sesuai kebutuhan
    };
    if(isset($_POST['input_lv14'])) {
        #if(isset($_POST['bk_acc_details'])) {
            if(isset($_POST['bk_name'])) {
                if(isset($_POST['city'])) {
                    if(isset($_POST['bk_branch'])) {
                        if(isset($_POST['bk_acc_type'])) {
                            if(isset($_POST['bk_acc_number'])) {

                                if(isset($_POST['bk_name2'])) {
                                    if(isset($_POST['city2'])) {
                                        if(isset($_POST['bk_branch2'])) {
                                            if(isset($_POST['bk_acc_type2'])) {
                                                if(isset($_POST['bk_acc_number2'])) {

                                                    $bk_name = form_input($_POST['bk_name']);
                                                    $city = form_input($_POST['city']);
                                                    $bk_branch = form_input($_POST['bk_branch']);
                                                    $bk_acc_type = form_input($_POST['bk_acc_type']);
                                                    $bk_acc_number = form_input($_POST['bk_acc_number']);

                                                    $bk_name2 = form_input($_POST['bk_name2']);
                                                    $city2 = form_input($_POST['city2']);
                                                    $bk_branch2 = form_input($_POST['bk_branch2']);
                                                    $bk_acc_type2 = form_input($_POST['bk_acc_type2']);
                                                    $bk_acc_number2 = form_input($_POST['bk_acc_number2']);

                                                    $EXEC_SQL = mysqli_query($db, '
                                                        UPDATE tb_racc SET
                                                            tb_racc.ACC_F_APP_BK_1_NAMA = "'.$bk_name.'",
                                                            tb_racc.ACC_F_APP_BK_1_TLP = "'.$city.'",
                                                            tb_racc.ACC_F_APP_BK_1_CBNG = "'.$bk_branch.'",
                                                            tb_racc.ACC_F_APP_BK_1_JENIS = "'.$bk_acc_type.'",
                                                            tb_racc.ACC_F_APP_BK_1_ACC = "'.$bk_acc_number.'",
                                                            tb_racc.ACC_F_APP_BK_2_NAMA = "'.$bk_name2.'",
                                                            tb_racc.ACC_F_APP_BK_2_TLP = "'.$city2.'",
                                                            tb_racc.ACC_F_APP_BK_2_CBNG = "'.$bk_branch2.'",
                                                            tb_racc.ACC_F_APP_BK_2_JENIS = "'.$bk_acc_type2.'",
                                                            tb_racc.ACC_F_APP_BK_2_ACC = "'.$bk_acc_number2.'"
                                                        WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                                    ') or die (mysqli_error($db));

                                                    $EXEC_SQL = mysqli_query($db, '
                                                        UPDATE tb_member SET
                                                        tb_member.MBR_BK_NAME = "'.$bk_name.'",
                                                        tb_member.MBR_BK_ACC = "'.$bk_acc_number.'"
                                                        WHERE tb_member.MBR_ID = '.$user1['MBR_ID'].'
                                                    ') or die (mysqli_error($db));
                                                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."'</script>");
                                                    
                                                    
                                                } else { 
                                                    logerr("Parameter Ke-10 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                                                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                                                }
                                            } else { 
                                                logerr("Parameter Ke-9 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                                                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                                            }
                                        } else { 
                                            logerr("Parameter Ke-8 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                                        }
                                    } else { 
                                        logerr("Parameter Ke-7 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                                        die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                                    }
                                } else { 
                                    logerr("Parameter Ke-6 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                                }
                                

                            } else { 
                                logerr("Parameter Ke-5 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                            }
                        } else { 
                            logerr("Parameter Ke-4 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                        }
                    } else { 
                        logerr("Parameter Ke-3 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                        die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                    }
                } else { 
                    logerr("Parameter Ke-2 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
                }
            } else { 
                logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-10 (REGOL)", $user1["MBR_ID"]);
                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening10&id=".$id_live."'</script>"); 
            }
        #} else { die ("<script>alert('Please try again 7');location.href = './'</script>"); }
    }

/** Get Bank list */
$sqlGetBank = $db->query("SELECT * FROM tb_banklist");
$bankList = $sqlGetBank->fetch_all(MYSQLI_ASSOC) ?? [];
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
            <div class="text-center">Rekening Bank Nasabah Untuk Penyetoran dan Penarikan Margin (Hanya rekening dibawah ini yang dapat Saudara pergunakan untuk lalulintas margin)</div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="card card-style">
        <div class="card-body">
            <div class="form-group boxed">
                <!--<div class="input-wrapper">
                    <label class="label" for="select4b">Bank Account Details </label>
                    <select class="form-control custom-select" id="select4b" name="bk_acc_details">
                        <option value="">Mata Uang</option>
                        <option value="USD">USD</option>
                        <option value="IDR">IDR</option>
                    </select>
                </div><br>-->
                <div class="input-wrapper">
                    <label class="label" for="select4b">Nama Bank</label>
                    <select class="form-control custom-select" id="select4b" name="bk_name" required>
                        <option disabled selected value>Nama Bank</option>
                        <?php if($sqlGetBank) : ?>
                            <?php foreach($bankList as $bank) : ?>
                                <option <?= (strtoupper($bank['BANKLST_NAME']) == strtoupper($RESULT_DT['ACC_F_APP_BK_1_NAMA']))? "selected" : "" ?> value="<?= $bank['BANKLST_NAME'] ?>"><?= $bank['BANKLST_NAME'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK RAKYAT INDONESIA (PERSERO) Tbk'|| $R_BKNAME == 'PT BANK RAKYAT INDONESIA (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK RAKYAT INDONESIA (PERSERO) Tbk">PT BANK RAKYAT INDONESIA (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MANDIRI (PERSERO) Tbk'|| $R_BKNAME == 'PT BANK MANDIRI (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK MANDIRI (PERSERO) Tbk">PT BANK MANDIRI (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK NEGARA INDONESIA (PERSERO) Tbk'|| $R_BKNAME == 'PT BANK NEGARA INDONESIA (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK NEGARA INDONESIA (PERSERO) Tbk">PT BANK NEGARA INDONESIA (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK TABUNGAN NEGARA (PERSERO) Tbk'|| $R_BKNAME == 'PT BANK TABUNGAN NEGARA (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK TABUNGAN NEGARA (PERSERO) Tbk">PT BANK TABUNGAN NEGARA (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK DANAMON INDONESIA Tbk'|| $R_BKNAME == 'PT BANK DANAMON INDONESIA Tbk'){echo 'selected';}?> value="PT BANK DANAMON INDONESIA Tbk">PT BANK DANAMON INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK PERMATA Tbk'|| $R_BKNAME == 'PT BANK PERMATA Tbk'){echo 'selected';}?> value="PT BANK PERMATA Tbk">PT BANK PERMATA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK PERMATA SYARIAH'|| $R_BKNAME == 'PT BANK PERMATA SYARIAH'){echo 'selected';}?> value="PT BANK PERMATA SYARIAH">PT BANK PERMATA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK CENTRAL ASIA Tbk'|| $R_BKNAME == 'PT BANK CENTRAL ASIA Tbk'){echo 'selected';}?> value="PT BANK CENTRAL ASIA Tbk">PT BANK CENTRAL ASIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MAYBANK INDONESIA Tbk'|| $R_BKNAME == 'PT BANK MAYBANK INDONESIA Tbk'){echo 'selected';}?> value="PT BANK MAYBANK INDONESIA Tbk">PT BANK MAYBANK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT PAN INDONESIA BANK Tbk'|| $R_BKNAME == 'PT PAN INDONESIA BANK Tbk'){echo 'selected';}?> value="PT PAN INDONESIA BANK Tbk">PT PAN INDONESIA BANK Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK CIMB NIAGA Tbk'|| $R_BKNAME == 'PT BANK CIMB NIAGA Tbk'){echo 'selected';}?> value="PT BANK CIMB NIAGA Tbk">PT BANK CIMB NIAGA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK UOB INDONESIA'|| $R_BKNAME == 'PT BANK UOB INDONESIA'){echo 'selected';}?> value="PT BANK UOB INDONESIA">PT BANK UOB INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK OCBC NISP Tbk'|| $R_BKNAME == 'PT BANK OCBC NISP Tbk'){echo 'selected';}?> value="PT BANK OCBC NISP Tbk">PT BANK OCBC NISP Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK ARTHA GRAHA INTERNASIONAL Tbk'|| $R_BKNAME == 'PT BANK ARTHA GRAHA INTERNASIONAL Tbk'){echo 'selected';}?> value="PT BANK ARTHA GRAHA INTERNASIONAL Tbk">PT BANK ARTHA GRAHA INTERNASIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK BUMI ARTA Tbk'|| $R_BKNAME == 'PT BANK BUMI ARTA Tbk'){echo 'selected';}?> value="PT BANK BUMI ARTA Tbk">PT BANK BUMI ARTA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK HSBC INDONESIA'|| $R_BKNAME == 'PT BANK HSBC INDONESIA'){echo 'selected';}?> value="PT BANK HSBC INDONESIA">PT BANK HSBC INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK JTRUST INDONESIA Tbk'|| $R_BKNAME == 'PT BANK JTRUST INDONESIA Tbk'){echo 'selected';}?> value="PT BANK JTRUST INDONESIA Tbk">PT BANK JTRUST INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MAYAPADA INTERNATIONAL Tbk'|| $R_BKNAME == 'PT BANK MAYAPADA INTERNATIONAL Tbk'){echo 'selected';}?> value="PT BANK MAYAPADA INTERNATIONAL Tbk">PT BANK MAYAPADA INTERNATIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK OF INDIA INDONESIA Tbk'|| $R_BKNAME == 'PT BANK OF INDIA INDONESIA Tbk'){echo 'selected';}?> value="PT BANK OF INDIA INDONESIA Tbk">PT BANK OF INDIA INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MESTIKA DHARMA Tbk'|| $R_BKNAME == 'PT BANK MESTIKA DHARMA Tbk'){echo 'selected';}?> value="PT BANK MESTIKA DHARMA Tbk">PT BANK MESTIKA DHARMA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK SHINHAN INDONESIA'|| $R_BKNAME == 'PT BANK SHINHAN INDONESIA'){echo 'selected';}?> value="PT BANK SHINHAN INDONESIA">PT BANK SHINHAN INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK SINARMAS Tbk'|| $R_BKNAME == 'PT BANK SINARMAS Tbk'){echo 'selected';}?> value="PT BANK SINARMAS Tbk">PT BANK SINARMAS Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MASPION INDONESIA Tbk'|| $R_BKNAME == 'PT BANK MASPION INDONESIA Tbk'){echo 'selected';}?> value="PT BANK MASPION INDONESIA Tbk">PT BANK MASPION INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK GANESHA Tbk'|| $R_BKNAME == 'PT BANK GANESHA Tbk'){echo 'selected';}?> value="PT BANK GANESHA Tbk">PT BANK GANESHA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK ICBC INDONESIA'|| $R_BKNAME == 'PT BANK ICBC INDONESIA'){echo 'selected';}?> value="PT BANK ICBC INDONESIA">PT BANK ICBC INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK QNB INDONESIA Tbk'|| $R_BKNAME == 'PT BANK QNB INDONESIA Tbk'){echo 'selected';}?> value="PT BANK QNB INDONESIA Tbk">PT BANK QNB INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK WOORI SAUDARA INDONESIA 1906 Tbk'|| $R_BKNAME == 'PT BANK WOORI SAUDARA INDONESIA 1906 Tbk'){echo 'selected';}?> value="PT BANK WOORI SAUDARA INDONESIA 1906 Tbk">PT BANK WOORI SAUDARA INDONESIA 1906 Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MEGA Tbk'|| $R_BKNAME == 'PT BANK MEGA Tbk'){echo 'selected';}?> value="PT BANK MEGA Tbk">PT BANK MEGA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK SYARIAH INDONESIA Tbk '|| $R_BKNAME == 'PT BANK SYARIAH INDONESIA Tbk '){echo 'selected';}?> value="PT BANK SYARIAH INDONESIA Tbk ">PT BANK SYARIAH INDONESIA Tbk </option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK KB BUKOPIN Tbk'|| $R_BKNAME == 'PT BANK KB BUKOPIN Tbk'){echo 'selected';}?> value="PT BANK KB BUKOPIN Tbk">PT BANK KB BUKOPIN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK KEB HANA INDONESIA'|| $R_BKNAME == 'PT BANK KEB HANA INDONESIA'){echo 'selected';}?> value="PT BANK KEB HANA INDONESIA">PT BANK KEB HANA INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MNC INTERNASIONAL Tbk'|| $R_BKNAME == 'PT BANK MNC INTERNASIONAL Tbk'){echo 'selected';}?> value="PT BANK MNC INTERNASIONAL Tbk">PT BANK MNC INTERNASIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK RAYA INDONESIA Tbk'|| $R_BKNAME == 'PT BANK RAYA INDONESIA Tbk'){echo 'selected';}?> value="PT BANK RAYA INDONESIA Tbk">PT BANK RAYA INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK SBI INDONESIA'|| $R_BKNAME == 'PT BANK SBI INDONESIA'){echo 'selected';}?> value="PT BANK SBI INDONESIA">PT BANK SBI INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MEGA SYARIAH'|| $R_BKNAME == 'PT BANK MEGA SYARIAH'){echo 'selected';}?> value="PT BANK MEGA SYARIAH">PT BANK MEGA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK INDEX SELINDO'|| $R_BKNAME == 'PT BANK INDEX SELINDO'){echo 'selected';}?> value="PT BANK INDEX SELINDO">PT BANK INDEX SELINDO</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MAYORA'|| $R_BKNAME == 'PT BANK MAYORA'){echo 'selected';}?> value="PT BANK MAYORA">PT BANK MAYORA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk'|| $R_BKNAME == 'PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk'){echo 'selected';}?> value="PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk">PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK DBS INDONESIA'|| $R_BKNAME == 'PT BANK DBS INDONESIA'){echo 'selected';}?> value="PT BANK DBS INDONESIA">PT BANK DBS INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK RESONA PERDANIA'|| $R_BKNAME == 'PT BANK RESONA PERDANIA'){echo 'selected';}?> value="PT BANK RESONA PERDANIA">PT BANK RESONA PERDANIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MIZUHO INDONESIA'|| $R_BKNAME == 'PT BANK MIZUHO INDONESIA'){echo 'selected';}?> value="PT BANK MIZUHO INDONESIA">PT BANK MIZUHO INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK CAPITAL INDONESIA Tbk'|| $R_BKNAME == 'PT BANK CAPITAL INDONESIA Tbk'){echo 'selected';}?> value="PT BANK CAPITAL INDONESIA Tbk">PT BANK CAPITAL INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK BNP PARIBAS INDONESIA'|| $R_BKNAME == 'PT BANK BNP PARIBAS INDONESIA'){echo 'selected';}?> value="PT BANK BNP PARIBAS INDONESIA">PT BANK BNP PARIBAS INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK ANZ INDONESIA'|| $R_BKNAME == 'PT BANK ANZ INDONESIA'){echo 'selected';}?> value="PT BANK ANZ INDONESIA">PT BANK ANZ INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK IBK INDONESIA Tbk'|| $R_BKNAME == 'PT BANK IBK INDONESIA Tbk'){echo 'selected';}?> value="PT BANK IBK INDONESIA Tbk">PT BANK IBK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK ALADIN SYARIAH Tbk '|| $R_BKNAME == 'PT BANK ALADIN SYARIAH Tbk '){echo 'selected';}?> value="PT BANK ALADIN SYARIAH Tbk ">PT BANK ALADIN SYARIAH Tbk </option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK CTBC INDONESIA'|| $R_BKNAME == 'PT BANK CTBC INDONESIA'){echo 'selected';}?> value="PT BANK CTBC INDONESIA">PT BANK CTBC INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK COMMONWEALTH'|| $R_BKNAME == 'PT BANK COMMONWEALTH'){echo 'selected';}?> value="PT BANK COMMONWEALTH">PT BANK COMMONWEALTH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK BTPN Tbk'|| $R_BKNAME == 'PT BANK BTPN Tbk'){echo 'selected';}?> value="PT BANK BTPN Tbk">PT BANK BTPN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK VICTORIA SYARIAH'|| $R_BKNAME == 'PT BANK VICTORIA SYARIAH'){echo 'selected';}?> value="PT BANK VICTORIA SYARIAH">PT BANK VICTORIA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK JABAR BANTEN SYARIAH'|| $R_BKNAME == 'PT BANK JABAR BANTEN SYARIAH'){echo 'selected';}?> value="PT BANK JABAR BANTEN SYARIAH">PT BANK JABAR BANTEN SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT KROM BANK INDONESIA Tbk'|| $R_BKNAME == 'PT KROM BANK INDONESIA Tbk'){echo 'selected';}?> value="PT KROM BANK INDONESIA Tbk">PT KROM BANK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK JASA JAKARTA'|| $R_BKNAME == 'PT BANK JASA JAKARTA'){echo 'selected';}?> value="PT BANK JASA JAKARTA">PT BANK JASA JAKARTA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK NEO COMMERCE Tbk'|| $R_BKNAME == 'PT BANK NEO COMMERCE Tbk'){echo 'selected';}?> value="PT BANK NEO COMMERCE Tbk">PT BANK NEO COMMERCE Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK DIGITAL BCA'|| $R_BKNAME == 'PT BANK DIGITAL BCA'){echo 'selected';}?> value="PT BANK DIGITAL BCA">PT BANK DIGITAL BCA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK NATIONALNOBU Tbk'|| $R_BKNAME == 'PT BANK NATIONALNOBU Tbk'){echo 'selected';}?> value="PT BANK NATIONALNOBU Tbk">PT BANK NATIONALNOBU Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK INA PERDANA Tbk'|| $R_BKNAME == 'PT BANK INA PERDANA Tbk'){echo 'selected';}?> value="PT BANK INA PERDANA Tbk">PT BANK INA PERDANA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK PANIN DUBAI SYARIAH Tbk'|| $R_BKNAME == 'PT BANK PANIN DUBAI SYARIAH Tbk'){echo 'selected';}?> value="PT BANK PANIN DUBAI SYARIAH Tbk">PT BANK PANIN DUBAI SYARIAH Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT Bank Panin Indonesia Tbk'|| $R_BKNAME == 'PT Bank Panin Indonesia Tbk'){echo 'selected';}?> value="PT Bank Panin Indonesia Tbk">PT Bank Panin Indonesia Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT PRIMA MASTER BANK'|| $R_BKNAME == 'PT PRIMA MASTER BANK'){echo 'selected';}?> value="PT PRIMA MASTER BANK">PT PRIMA MASTER BANK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK KB BUKOPIN SYARIAH '|| $R_BKNAME == 'PT BANK KB BUKOPIN SYARIAH '){echo 'selected';}?> value="PT BANK KB BUKOPIN SYARIAH ">PT BANK KB BUKOPIN SYARIAH </option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK SAHABAT SAMPOERNA'|| $R_BKNAME == 'PT BANK SAHABAT SAMPOERNA'){echo 'selected';}?> value="PT BANK SAHABAT SAMPOERNA">PT BANK SAHABAT SAMPOERNA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK OKE INDONESIA Tbk'|| $R_BKNAME == 'PT BANK OKE INDONESIA Tbk'){echo 'selected';}?> value="PT BANK OKE INDONESIA Tbk">PT BANK OKE INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK AMAR INDONESIA'|| $R_BKNAME == 'PT BANK AMAR INDONESIA'){echo 'selected';}?> value="PT BANK AMAR INDONESIA">PT BANK AMAR INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK SEABANK INDONESIA'|| $R_BKNAME == 'PT BANK SEABANK INDONESIA'){echo 'selected';}?> value="PT BANK SEABANK INDONESIA">PT BANK SEABANK INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK BCA SYARIAH'|| $R_BKNAME == 'PT BANK BCA SYARIAH'){echo 'selected';}?> value="PT BANK BCA SYARIAH">PT BANK BCA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK JAGO TBK'|| $R_BKNAME == 'PT BANK JAGO TBK'){echo 'selected';}?> value="PT BANK JAGO TBK">PT BANK JAGO TBK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk'|| $R_BKNAME == 'PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk'){echo 'selected';}?> value="PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk">PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MULTIARTA SENTOSA'|| $R_BKNAME == 'PT BANK MULTIARTA SENTOSA'){echo 'selected';}?> value="PT BANK MULTIARTA SENTOSA">PT BANK MULTIARTA SENTOSA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK FAMA INTERNASIONAL'|| $R_BKNAME == 'PT BANK FAMA INTERNASIONAL'){echo 'selected';}?> value="PT BANK FAMA INTERNASIONAL">PT BANK FAMA INTERNASIONAL</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MANDIRI TASPEN'|| $R_BKNAME == 'PT BANK MANDIRI TASPEN'){echo 'selected';}?> value="PT BANK MANDIRI TASPEN">PT BANK MANDIRI TASPEN</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK VICTORIA INTERNATIONAL Tbk'|| $R_BKNAME == 'PT BANK VICTORIA INTERNATIONAL Tbk'){echo 'selected';}?> value="PT BANK VICTORIA INTERNATIONAL Tbk">PT BANK VICTORIA INTERNATIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT ALLO BANK INDONESIA '|| $R_BKNAME == 'PT ALLO BANK INDONESIA '){echo 'selected';}?> value="PT ALLO BANK INDONESIA ">PT ALLO BANK INDONESIA </option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD JAWA BARAT DAN BANTEN Tbk'|| $R_BKNAME == 'PT BPD JAWA BARAT DAN BANTEN Tbk'){echo 'selected';}?> value="PT BPD JAWA BARAT DAN BANTEN Tbk">PT BPD JAWA BARAT DAN BANTEN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD DKI'|| $R_BKNAME == 'PT BPD DKI'){echo 'selected';}?> value="PT BPD DKI">PT BPD DKI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD DAERAH ISTIMEWA YOGYAKARTA'|| $R_BKNAME == 'PT BPD DAERAH ISTIMEWA YOGYAKARTA'){echo 'selected';}?> value="PT BPD DAERAH ISTIMEWA YOGYAKARTA">PT BPD DAERAH ISTIMEWA YOGYAKARTA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD JAWA TENGAH'|| $R_BKNAME == 'PT BPD JAWA TENGAH'){echo 'selected';}?> value="PT BPD JAWA TENGAH">PT BPD JAWA TENGAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD JAWA TIMUR Tbk'|| $R_BKNAME == 'PT BPD JAWA TIMUR Tbk'){echo 'selected';}?> value="PT BPD JAWA TIMUR Tbk">PT BPD JAWA TIMUR Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD JAMBI'|| $R_BKNAME == 'PT BPD JAMBI'){echo 'selected';}?> value="PT BPD JAMBI">PT BPD JAMBI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK ACEH SYARIAH'|| $R_BKNAME == 'PT BANK ACEH SYARIAH'){echo 'selected';}?> value="PT BANK ACEH SYARIAH">PT BANK ACEH SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD SUMATERA UTARA'|| $R_BKNAME == 'PT BPD SUMATERA UTARA'){echo 'selected';}?> value="PT BPD SUMATERA UTARA">PT BPD SUMATERA UTARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK NAGARI'|| $R_BKNAME == 'PT BANK NAGARI'){echo 'selected';}?> value="PT BANK NAGARI">PT BANK NAGARI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD RIAU KEPRI SYARIAH '|| $R_BKNAME == 'PT BPD RIAU KEPRI SYARIAH '){echo 'selected';}?> value="PT BPD RIAU KEPRI SYARIAH ">PT BPD RIAU KEPRI SYARIAH </option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG'|| $R_BKNAME == 'PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG'){echo 'selected';}?> value="PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG">PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD LAMPUNG'|| $R_BKNAME == 'PT BPD LAMPUNG'){echo 'selected';}?> value="PT BPD LAMPUNG">PT BPD LAMPUNG</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD KALIMANTAN SELATAN'|| $R_BKNAME == 'PT BPD KALIMANTAN SELATAN'){echo 'selected';}?> value="PT BPD KALIMANTAN SELATAN">PT BPD KALIMANTAN SELATAN</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD KALIMANTAN BARAT'|| $R_BKNAME == 'PT BPD KALIMANTAN BARAT'){echo 'selected';}?> value="PT BPD KALIMANTAN BARAT">PT BPD KALIMANTAN BARAT</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA'|| $R_BKNAME == 'PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA'){echo 'selected';}?> value="PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA">PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD KALIMANTAN TENGAH'|| $R_BKNAME == 'PT BPD KALIMANTAN TENGAH'){echo 'selected';}?> value="PT BPD KALIMANTAN TENGAH">PT BPD KALIMANTAN TENGAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD SULAWESI SELATAN DAN SULAWESI BARAT'|| $R_BKNAME == 'PT BPD SULAWESI SELATAN DAN SULAWESI BARAT'){echo 'selected';}?> value="PT BPD SULAWESI SELATAN DAN SULAWESI BARAT">PT BPD SULAWESI SELATAN DAN SULAWESI BARAT</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD SULAWESI UTARA DAN GORONTALO'|| $R_BKNAME == 'PT BPD SULAWESI UTARA DAN GORONTALO'){echo 'selected';}?> value="PT BPD SULAWESI UTARA DAN GORONTALO">PT BPD SULAWESI UTARA DAN GORONTALO</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK NTB SYARIAH'|| $R_BKNAME == 'PT BANK NTB SYARIAH'){echo 'selected';}?> value="PT BANK NTB SYARIAH">PT BANK NTB SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD BALI'|| $R_BKNAME == 'PT BPD BALI'){echo 'selected';}?> value="PT BPD BALI">PT BPD BALI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD NUSA TENGGARA TIMUR'|| $R_BKNAME == 'PT BPD NUSA TENGGARA TIMUR'){echo 'selected';}?> value="PT BPD NUSA TENGGARA TIMUR">PT BPD NUSA TENGGARA TIMUR</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD MALUKU DAN MALUKU UTARA'|| $R_BKNAME == 'PT BPD MALUKU DAN MALUKU UTARA'){echo 'selected';}?> value="PT BPD MALUKU DAN MALUKU UTARA">PT BPD MALUKU DAN MALUKU UTARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD PAPUA'|| $R_BKNAME == 'PT BPD PAPUA'){echo 'selected';}?> value="PT BPD PAPUA">PT BPD PAPUA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD BENGKULU'|| $R_BKNAME == 'PT BPD BENGKULU'){echo 'selected';}?> value="PT BPD BENGKULU">PT BPD BENGKULU</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD SULAWESI TENGAH'|| $R_BKNAME == 'PT BPD SULAWESI TENGAH'){echo 'selected';}?> value="PT BPD SULAWESI TENGAH">PT BPD SULAWESI TENGAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD SULAWESI TENGGARA'|| $R_BKNAME == 'PT BPD SULAWESI TENGGARA'){echo 'selected';}?> value="PT BPD SULAWESI TENGGARA">PT BPD SULAWESI TENGGARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD BANTEN Tbk'|| $R_BKNAME == 'PT BPD BANTEN Tbk'){echo 'selected';}?> value="PT BPD BANTEN Tbk">PT BPD BANTEN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'CITIBANK, N.A.'|| $R_BKNAME == 'CITIBANK, N.A.'){echo 'selected';}?> value="CITIBANK, N.A.">CITIBANK, N.A.</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'JP MORGAN CHASE BANK, NA'|| $R_BKNAME == 'JP MORGAN CHASE BANK, NA'){echo 'selected';}?> value="JP MORGAN CHASE BANK, NA">JP MORGAN CHASE BANK, NA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'BANK OF AMERICA, N.A'|| $R_BKNAME == 'BANK OF AMERICA, N.A'){echo 'selected';}?> value="BANK OF AMERICA, N.A">BANK OF AMERICA, N.A</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'BANGKOK BANK PCL'|| $R_BKNAME == 'BANGKOK BANK PCL'){echo 'selected';}?> value="BANGKOK BANK PCL">BANGKOK BANK PCL</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'MUFG BANK, LTD'|| $R_BKNAME == 'MUFG BANK, LTD'){echo 'selected';}?> value="MUFG BANK, LTD">MUFG BANK, LTD</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'STANDARD CHARTERED BANK'|| $R_BKNAME == 'STANDARD CHARTERED BANK'){echo 'selected';}?> value="STANDARD CHARTERED BANK">STANDARD CHARTERED BANK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'DEUTSCHE BANK AG'|| $R_BKNAME == 'DEUTSCHE BANK AG'){echo 'selected';}?> value="DEUTSCHE BANK AG">DEUTSCHE BANK AG</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'BANK OF CHINA (HONG KONG) LIMITED'|| $R_BKNAME == 'BANK OF CHINA (HONG KONG) LIMITED'){echo 'selected';}?> value="BANK OF CHINA (HONG KONG) LIMITED">BANK OF CHINA (HONG KONG) LIMITED</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK MUAMALAT INDONESIA TBK'|| $R_BKNAME == 'PT BANK MUAMALAT INDONESIA TBK'){echo 'selected';}?> value="PT BANK MUAMALAT INDONESIA TBK">PT BANK MUAMALAT INDONESIA TBK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPD JAWA TIMUR SYARIAH Tbk'|| $R_BKNAME == 'PT BPD JAWA TIMUR SYARIAH Tbk'){echo 'selected';}?> value="PT BPD JAWA TIMUR SYARIAH Tbk">PT BPD JAWA TIMUR SYARIAH Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BPR KARYAJATNIKA SADAYA (BPR KS)'|| $R_BKNAME == 'PT BPR KARYAJATNIKA SADAYA (BPR KS)'){echo 'selected';}?> value="PT BPR KARYAJATNIKA SADAYA (BPR KS)">PT BPR KARYAJATNIKA SADAYA (BPR KS)</option> -->
                    </select>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">Cabang</label>
                        <input type="text" class="form-control" id="text4b" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_BK_1_CBNG"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_BK_1_CBNG"];
                                }else{
                                    echo $R_BKBRANC;
                                }; 
                            ?>" placeholder="" name="bk_branch" required autocomplete="off"
                        >
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">Nomor A/C</label>
                        <input type="number" class="form-control" id="text4b" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_BK_1_ACC"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_BK_1_ACC"];
                                }else{
                                    echo $R_BKNOREK;
                                };
                            ?>" placeholder="" name="bk_acc_number" required autocomplete="off"
                        >
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">No. Telp</label>
                        <input type="number" class="form-control" placeholder="Masukkan nomor telepon anda / isi '0' jika tidak mempunyai nya" id="text4b"  placeholder="" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_BK_1_TLP"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_BK_1_TLP"];
                                }else{ 
                                    echo $R_TLP;
                                }; 
                            ?>" name="city" required autocomplete="off"
                        >
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="input-wrapper">
                <label class="label" for="select4b">Jenis Rekening</label>
                    <select class="form-control custom-select" id="select4b" name="bk_acc_type" required>
                        <option disabled selected value>Jenis Rekening</option>
                        <option <?php if($RESULT_DT["ACC_F_APP_BK_1_JENIS"] == 'Giro'|| $R_JENISREK == 'Giro'){echo 'selected';}?> value="Giro">Giro</option>
                        <option <?php if($RESULT_DT["ACC_F_APP_BK_1_JENIS"] == 'Tabungan'|| $R_JENISREK == 'Tabungan'){echo 'selected';}?> value="Tabungan">Tabungan</option>
                        <option <?php if($RESULT_DT["ACC_F_APP_BK_1_JENIS"] == 'Lainya'|| $R_JENISREK == 'Lainya'){echo 'selected';}?> value="Lainya">Lainya</option>
                    </select>
                </div>
                <!--
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">Nama Pemilik Rekening</label>
                        <input type="text" value="<?php echo $user1['MBR_NAME'] ?>" class="form-control" id="text4b" readonly  placeholder="" name="bk_acc_owner">
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
    <div class="card card-style">
        <div class="card-body">
            <div class="form-group boxed">
                <!--<div class="input-wrapper">
                    <label class="label" for="select4b">Bank Account Details </label>
                    <select class="form-control custom-select" id="select4b" name="bk_acc_details">
                        <option value="">Mata Uang</option>
                        <option value="USD">USD</option>
                        <option value="IDR">IDR</option>
                    </select>
                </div><br>-->
                <div class="input-wrapper">
                    <label class="label" for="select4b">Nama Bank</label>
                    <select class="form-control custom-select" id="select4b" name="bk_name2">
                        <option selected value="">Nama Bank</option>
                        <?php if($sqlGetBank) : ?>
                            <?php foreach($bankList as $bank) : ?>
                                <option <?= (strtoupper($bank['BANKLST_NAME']) == strtoupper($RESULT_DT['ACC_F_APP_BK_1_NAMA']))? "selected" : "" ?> value="<?= $bank['BANKLST_NAME'] ?>"><?= $bank['BANKLST_NAME'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK RAKYAT INDONESIA (PERSERO) Tbk' || $R_BKNAME2 == 'PT BANK RAKYAT INDONESIA (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK RAKYAT INDONESIA (PERSERO) Tbk">PT BANK RAKYAT INDONESIA (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MANDIRI (PERSERO) Tbk' || $R_BKNAME2 == 'PT BANK MANDIRI (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK MANDIRI (PERSERO) Tbk">PT BANK MANDIRI (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK NEGARA INDONESIA (PERSERO) Tbk' || $R_BKNAME2 == 'PT BANK NEGARA INDONESIA (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK NEGARA INDONESIA (PERSERO) Tbk">PT BANK NEGARA INDONESIA (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK TABUNGAN NEGARA (PERSERO) Tbk' || $R_BKNAME2 == 'PT BANK TABUNGAN NEGARA (PERSERO) Tbk'){echo 'selected';}?> value="PT BANK TABUNGAN NEGARA (PERSERO) Tbk">PT BANK TABUNGAN NEGARA (PERSERO) Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK DANAMON INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK DANAMON INDONESIA Tbk'){echo 'selected';}?> value="PT BANK DANAMON INDONESIA Tbk">PT BANK DANAMON INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK PERMATA Tbk' || $R_BKNAME2 == 'PT BANK PERMATA Tbk'){echo 'selected';}?> value="PT BANK PERMATA Tbk">PT BANK PERMATA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_1_NAMA'] == 'PT BANK PERMATA SYARIAH'|| $R_BKNAME == 'PT BANK PERMATA SYARIAH'){echo 'selected';}?> value="PT BANK PERMATA SYARIAH">PT BANK PERMATA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK CENTRAL ASIA Tbk' || $R_BKNAME2 == 'PT BANK CENTRAL ASIA Tbk'){echo 'selected';}?> value="PT BANK CENTRAL ASIA Tbk">PT BANK CENTRAL ASIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MAYBANK INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK MAYBANK INDONESIA Tbk'){echo 'selected';}?> value="PT BANK MAYBANK INDONESIA Tbk">PT BANK MAYBANK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT PAN INDONESIA BANK Tbk' || $R_BKNAME2 == 'PT PAN INDONESIA BANK Tbk'){echo 'selected';}?> value="PT PAN INDONESIA BANK Tbk">PT PAN INDONESIA BANK Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK CIMB NIAGA Tbk' || $R_BKNAME2 == 'PT BANK CIMB NIAGA Tbk'){echo 'selected';}?> value="PT BANK CIMB NIAGA Tbk">PT BANK CIMB NIAGA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK UOB INDONESIA' || $R_BKNAME2 == 'PT BANK UOB INDONESIA'){echo 'selected';}?> value="PT BANK UOB INDONESIA">PT BANK UOB INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK OCBC NISP Tbk' || $R_BKNAME2 == 'PT BANK OCBC NISP Tbk'){echo 'selected';}?> value="PT BANK OCBC NISP Tbk">PT BANK OCBC NISP Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK ARTHA GRAHA INTERNASIONAL Tbk' || $R_BKNAME2 == 'PT BANK ARTHA GRAHA INTERNASIONAL Tbk'){echo 'selected';}?> value="PT BANK ARTHA GRAHA INTERNASIONAL Tbk">PT BANK ARTHA GRAHA INTERNASIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK BUMI ARTA Tbk' || $R_BKNAME2 == 'PT BANK BUMI ARTA Tbk'){echo 'selected';}?> value="PT BANK BUMI ARTA Tbk">PT BANK BUMI ARTA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK HSBC INDONESIA' || $R_BKNAME2 == 'PT BANK HSBC INDONESIA'){echo 'selected';}?> value="PT BANK HSBC INDONESIA">PT BANK HSBC INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK JTRUST INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK JTRUST INDONESIA Tbk'){echo 'selected';}?> value="PT BANK JTRUST INDONESIA Tbk">PT BANK JTRUST INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MAYAPADA INTERNATIONAL Tbk' || $R_BKNAME2 == 'PT BANK MAYAPADA INTERNATIONAL Tbk'){echo 'selected';}?> value="PT BANK MAYAPADA INTERNATIONAL Tbk">PT BANK MAYAPADA INTERNATIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK OF INDIA INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK OF INDIA INDONESIA Tbk'){echo 'selected';}?> value="PT BANK OF INDIA INDONESIA Tbk">PT BANK OF INDIA INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MESTIKA DHARMA Tbk' || $R_BKNAME2 == 'PT BANK MESTIKA DHARMA Tbk'){echo 'selected';}?> value="PT BANK MESTIKA DHARMA Tbk">PT BANK MESTIKA DHARMA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK SHINHAN INDONESIA' || $R_BKNAME2 == 'PT BANK SHINHAN INDONESIA'){echo 'selected';}?> value="PT BANK SHINHAN INDONESIA">PT BANK SHINHAN INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK SINARMAS Tbk' || $R_BKNAME2 == 'PT BANK SINARMAS Tbk'){echo 'selected';}?> value="PT BANK SINARMAS Tbk">PT BANK SINARMAS Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MASPION INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK MASPION INDONESIA Tbk'){echo 'selected';}?> value="PT BANK MASPION INDONESIA Tbk">PT BANK MASPION INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK GANESHA Tbk' || $R_BKNAME2 == 'PT BANK GANESHA Tbk'){echo 'selected';}?> value="PT BANK GANESHA Tbk">PT BANK GANESHA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK ICBC INDONESIA' || $R_BKNAME2 == 'PT BANK ICBC INDONESIA'){echo 'selected';}?> value="PT BANK ICBC INDONESIA">PT BANK ICBC INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK QNB INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK QNB INDONESIA Tbk'){echo 'selected';}?> value="PT BANK QNB INDONESIA Tbk">PT BANK QNB INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK WOORI SAUDARA INDONESIA 1906 Tbk' || $R_BKNAME2 == 'PT BANK WOORI SAUDARA INDONESIA 1906 Tbk'){echo 'selected';}?> value="PT BANK WOORI SAUDARA INDONESIA 1906 Tbk">PT BANK WOORI SAUDARA INDONESIA 1906 Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MEGA Tbk' || $R_BKNAME2 == 'PT BANK MEGA Tbk'){echo 'selected';}?> value="PT BANK MEGA Tbk">PT BANK MEGA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK SYARIAH INDONESIA Tbk )' || $R_BKNAME2 == 'PT BANK SYARIAH INDONESIA Tbk )'){echo 'selected';}?> value="PT BANK SYARIAH INDONESIA Tbk )">PT BANK SYARIAH INDONESIA Tbk )</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK KB BUKOPIN Tbk' || $R_BKNAME2 == 'PT BANK KB BUKOPIN Tbk'){echo 'selected';}?> value="PT BANK KB BUKOPIN Tbk">PT BANK KB BUKOPIN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK KEB HANA INDONESIA' || $R_BKNAME2 == 'PT BANK KEB HANA INDONESIA'){echo 'selected';}?> value="PT BANK KEB HANA INDONESIA">PT BANK KEB HANA INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MNC INTERNASIONAL Tbk' || $R_BKNAME2 == 'PT BANK MNC INTERNASIONAL Tbk'){echo 'selected';}?> value="PT BANK MNC INTERNASIONAL Tbk">PT BANK MNC INTERNASIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK RAYA INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK RAYA INDONESIA Tbk'){echo 'selected';}?> value="PT BANK RAYA INDONESIA Tbk">PT BANK RAYA INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK SBI INDONESIA' || $R_BKNAME2 == 'PT BANK SBI INDONESIA'){echo 'selected';}?> value="PT BANK SBI INDONESIA">PT BANK SBI INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MEGA SYARIAH' || $R_BKNAME2 == 'PT BANK MEGA SYARIAH'){echo 'selected';}?> value="PT BANK MEGA SYARIAH">PT BANK MEGA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK INDEX SELINDO' || $R_BKNAME2 == 'PT BANK INDEX SELINDO'){echo 'selected';}?> value="PT BANK INDEX SELINDO">PT BANK INDEX SELINDO</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MAYORA' || $R_BKNAME2 == 'PT BANK MAYORA'){echo 'selected';}?> value="PT BANK MAYORA">PT BANK MAYORA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk'){echo 'selected';}?> value="PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk">PT BANK CHINA CONSTRUCTION BANK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK DBS INDONESIA' || $R_BKNAME2 == 'PT BANK DBS INDONESIA'){echo 'selected';}?> value="PT BANK DBS INDONESIA">PT BANK DBS INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK RESONA PERDANIA' || $R_BKNAME2 == 'PT BANK RESONA PERDANIA'){echo 'selected';}?> value="PT BANK RESONA PERDANIA">PT BANK RESONA PERDANIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MIZUHO INDONESIA' || $R_BKNAME2 == 'PT BANK MIZUHO INDONESIA'){echo 'selected';}?> value="PT BANK MIZUHO INDONESIA">PT BANK MIZUHO INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK CAPITAL INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK CAPITAL INDONESIA Tbk'){echo 'selected';}?> value="PT BANK CAPITAL INDONESIA Tbk">PT BANK CAPITAL INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK BNP PARIBAS INDONESIA' || $R_BKNAME2 == 'PT BANK BNP PARIBAS INDONESIA'){echo 'selected';}?> value="PT BANK BNP PARIBAS INDONESIA">PT BANK BNP PARIBAS INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK ANZ INDONESIA' || $R_BKNAME2 == 'PT BANK ANZ INDONESIA'){echo 'selected';}?> value="PT BANK ANZ INDONESIA">PT BANK ANZ INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK IBK INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK IBK INDONESIA Tbk'){echo 'selected';}?> value="PT BANK IBK INDONESIA Tbk">PT BANK IBK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK ALADIN SYARIAH Tbk )' || $R_BKNAME2 == 'PT BANK ALADIN SYARIAH Tbk )'){echo 'selected';}?> value="PT BANK ALADIN SYARIAH Tbk )">PT BANK ALADIN SYARIAH Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK CTBC INDONESIA' || $R_BKNAME2 == 'PT BANK CTBC INDONESIA'){echo 'selected';}?> value="PT BANK CTBC INDONESIA">PT BANK CTBC INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK COMMONWEALTH' || $R_BKNAME2 == 'PT BANK COMMONWEALTH'){echo 'selected';}?> value="PT BANK COMMONWEALTH">PT BANK COMMONWEALTH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK BTPN Tbk' || $R_BKNAME2 == 'PT BANK BTPN Tbk'){echo 'selected';}?> value="PT BANK BTPN Tbk">PT BANK BTPN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK VICTORIA SYARIAH' || $R_BKNAME2 == 'PT BANK VICTORIA SYARIAH'){echo 'selected';}?> value="PT BANK VICTORIA SYARIAH">PT BANK VICTORIA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK JABAR BANTEN SYARIAH' || $R_BKNAME2 == 'PT BANK JABAR BANTEN SYARIAH'){echo 'selected';}?> value="PT BANK JABAR BANTEN SYARIAH">PT BANK JABAR BANTEN SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT KROM BANK INDONESIA Tbk' || $R_BKNAME2 == 'PT KROM BANK INDONESIA Tbk'){echo 'selected';}?> value="PT KROM BANK INDONESIA Tbk">PT KROM BANK INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK JASA JAKARTA' || $R_BKNAME2 == 'PT BANK JASA JAKARTA'){echo 'selected';}?> value="PT BANK JASA JAKARTA">PT BANK JASA JAKARTA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK NEO COMMERCE Tbk' || $R_BKNAME2 == 'PT BANK NEO COMMERCE Tbk'){echo 'selected';}?> value="PT BANK NEO COMMERCE Tbk">PT BANK NEO COMMERCE Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK DIGITAL BCA' || $R_BKNAME2 == 'PT BANK DIGITAL BCA'){echo 'selected';}?> value="PT BANK DIGITAL BCA">PT BANK DIGITAL BCA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK NATIONALNOBU Tbk' || $R_BKNAME2 == 'PT BANK NATIONALNOBU Tbk'){echo 'selected';}?> value="PT BANK NATIONALNOBU Tbk">PT BANK NATIONALNOBU Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK INA PERDANA Tbk' || $R_BKNAME2 == 'PT BANK INA PERDANA Tbk'){echo 'selected';}?> value="PT BANK INA PERDANA Tbk">PT BANK INA PERDANA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK PANIN DUBAI SYARIAH Tbk' || $R_BKNAME2 == 'PT BANK PANIN DUBAI SYARIAH Tbk'){echo 'selected';}?> value="PT BANK PANIN DUBAI SYARIAH Tbk">PT BANK PANIN DUBAI SYARIAH Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT Bank Panin Indonesia Tbk' || $R_BKNAME2 == 'PT Bank Panin Indonesia Tbk'){echo 'selected';}?> value="PT Bank Panin Indonesia Tbk">PT Bank Panin Indonesia Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT PRIMA MASTER BANK' || $R_BKNAME2 == 'PT PRIMA MASTER BANK'){echo 'selected';}?> value="PT PRIMA MASTER BANK">PT PRIMA MASTER BANK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK KB BUKOPIN SYARIAH )' || $R_BKNAME2 == 'PT BANK KB BUKOPIN SYARIAH )'){echo 'selected';}?> value="PT BANK KB BUKOPIN SYARIAH )">PT BANK KB BUKOPIN SYARIAH </option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK SAHABAT SAMPOERNA' || $R_BKNAME2 == 'PT BANK SAHABAT SAMPOERNA'){echo 'selected';}?> value="PT BANK SAHABAT SAMPOERNA">PT BANK SAHABAT SAMPOERNA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK OKE INDONESIA Tbk' || $R_BKNAME2 == 'PT BANK OKE INDONESIA Tbk'){echo 'selected';}?> value="PT BANK OKE INDONESIA Tbk">PT BANK OKE INDONESIA Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK AMAR INDONESIA' || $R_BKNAME2 == 'PT BANK AMAR INDONESIA'){echo 'selected';}?> value="PT BANK AMAR INDONESIA">PT BANK AMAR INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK SEABANK INDONESIA' || $R_BKNAME2 == 'PT BANK SEABANK INDONESIA'){echo 'selected';}?> value="PT BANK SEABANK INDONESIA">PT BANK SEABANK INDONESIA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK BCA SYARIAH' || $R_BKNAME2 == 'PT BANK BCA SYARIAH'){echo 'selected';}?> value="PT BANK BCA SYARIAH">PT BANK BCA SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK JAGO TBK' || $R_BKNAME2 == 'PT BANK JAGO TBK'){echo 'selected';}?> value="PT BANK JAGO TBK">PT BANK JAGO TBK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk' || $R_BKNAME2 == 'PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk'){echo 'selected';}?> value="PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk">PT BANK TABUNGAN PENSIUNAN NASIONAL SYARIAH Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MULTIARTA SENTOSA' || $R_BKNAME2 == 'PT BANK MULTIARTA SENTOSA'){echo 'selected';}?> value="PT BANK MULTIARTA SENTOSA">PT BANK MULTIARTA SENTOSA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK FAMA INTERNASIONAL' || $R_BKNAME2 == 'PT BANK FAMA INTERNASIONAL'){echo 'selected';}?> value="PT BANK FAMA INTERNASIONAL">PT BANK FAMA INTERNASIONAL</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MANDIRI TASPEN' || $R_BKNAME2 == 'PT BANK MANDIRI TASPEN'){echo 'selected';}?> value="PT BANK MANDIRI TASPEN">PT BANK MANDIRI TASPEN</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK VICTORIA INTERNATIONAL Tbk' || $R_BKNAME2 == 'PT BANK VICTORIA INTERNATIONAL Tbk'){echo 'selected';}?> value="PT BANK VICTORIA INTERNATIONAL Tbk">PT BANK VICTORIA INTERNATIONAL Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT ALLO BANK INDONESIA )' || $R_BKNAME2 == 'PT ALLO BANK INDONESIA )'){echo 'selected';}?> value="PT ALLO BANK INDONESIA )">PT ALLO BANK INDONESIA )</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD JAWA BARAT DAN BANTEN Tbk' || $R_BKNAME2 == 'PT BPD JAWA BARAT DAN BANTEN Tbk'){echo 'selected';}?> value="PT BPD JAWA BARAT DAN BANTEN Tbk">PT BPD JAWA BARAT DAN BANTEN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD DKI' || $R_BKNAME2 == 'PT BPD DKI'){echo 'selected';}?> value="PT BPD DKI">PT BPD DKI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD DAERAH ISTIMEWA YOGYAKARTA' || $R_BKNAME2 == 'PT BPD DAERAH ISTIMEWA YOGYAKARTA'){echo 'selected';}?> value="PT BPD DAERAH ISTIMEWA YOGYAKARTA">PT BPD DAERAH ISTIMEWA YOGYAKARTA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD JAWA TENGAH' || $R_BKNAME2 == 'PT BPD JAWA TENGAH'){echo 'selected';}?> value="PT BPD JAWA TENGAH">PT BPD JAWA TENGAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD JAWA TIMUR Tbk' || $R_BKNAME2 == 'PT BPD JAWA TIMUR Tbk'){echo 'selected';}?> value="PT BPD JAWA TIMUR Tbk">PT BPD JAWA TIMUR Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD JAMBI' || $R_BKNAME2 == 'PT BPD JAMBI'){echo 'selected';}?> value="PT BPD JAMBI">PT BPD JAMBI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK ACEH SYARIAH' || $R_BKNAME2 == 'PT BANK ACEH SYARIAH'){echo 'selected';}?> value="PT BANK ACEH SYARIAH">PT BANK ACEH SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD SUMATERA UTARA' || $R_BKNAME2 == 'PT BPD SUMATERA UTARA'){echo 'selected';}?> value="PT BPD SUMATERA UTARA">PT BPD SUMATERA UTARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK NAGARI' || $R_BKNAME2 == 'PT BANK NAGARI'){echo 'selected';}?> value="PT BANK NAGARI">PT BANK NAGARI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD RIAU KEPRI SYARIAH )' || $R_BKNAME2 == 'PT BPD RIAU KEPRI SYARIAH )'){echo 'selected';}?> value="PT BPD RIAU KEPRI SYARIAH )">PT BPD RIAU KEPRI SYARIAH )</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG' || $R_BKNAME2 == 'PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG'){echo 'selected';}?> value="PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG">PT BPD SUMATERA SELATAN DAN BANGKA BELITUNG</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD LAMPUNG' || $R_BKNAME2 == 'PT BPD LAMPUNG'){echo 'selected';}?> value="PT BPD LAMPUNG">PT BPD LAMPUNG</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD KALIMANTAN SELATAN' || $R_BKNAME2 == 'PT BPD KALIMANTAN SELATAN'){echo 'selected';}?> value="PT BPD KALIMANTAN SELATAN">PT BPD KALIMANTAN SELATAN</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD KALIMANTAN BARAT' || $R_BKNAME2 == 'PT BPD KALIMANTAN BARAT'){echo 'selected';}?> value="PT BPD KALIMANTAN BARAT">PT BPD KALIMANTAN BARAT</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA' || $R_BKNAME2 == 'PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA'){echo 'selected';}?> value="PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA">PT BPD KALIMANTAN TIMUR DAN KALIMANTAN UTARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD KALIMANTAN TENGAH' || $R_BKNAME2 == 'PT BPD KALIMANTAN TENGAH'){echo 'selected';}?> value="PT BPD KALIMANTAN TENGAH">PT BPD KALIMANTAN TENGAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD SULAWESI SELATAN DAN SULAWESI BARAT' || $R_BKNAME2 == 'PT BPD SULAWESI SELATAN DAN SULAWESI BARAT'){echo 'selected';}?> value="PT BPD SULAWESI SELATAN DAN SULAWESI BARAT">PT BPD SULAWESI SELATAN DAN SULAWESI BARAT</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD SULAWESI UTARA DAN GORONTALO' || $R_BKNAME2 == 'PT BPD SULAWESI UTARA DAN GORONTALO'){echo 'selected';}?> value="PT BPD SULAWESI UTARA DAN GORONTALO">PT BPD SULAWESI UTARA DAN GORONTALO</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK NTB SYARIAH' || $R_BKNAME2 == 'PT BANK NTB SYARIAH'){echo 'selected';}?> value="PT BANK NTB SYARIAH">PT BANK NTB SYARIAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD BALI' || $R_BKNAME2 == 'PT BPD BALI'){echo 'selected';}?> value="PT BPD BALI">PT BPD BALI</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD NUSA TENGGARA TIMUR' || $R_BKNAME2 == 'PT BPD NUSA TENGGARA TIMUR'){echo 'selected';}?> value="PT BPD NUSA TENGGARA TIMUR">PT BPD NUSA TENGGARA TIMUR</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD MALUKU DAN MALUKU UTARA' || $R_BKNAME2 == 'PT BPD MALUKU DAN MALUKU UTARA'){echo 'selected';}?> value="PT BPD MALUKU DAN MALUKU UTARA">PT BPD MALUKU DAN MALUKU UTARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD PAPUA' || $R_BKNAME2 == 'PT BPD PAPUA'){echo 'selected';}?> value="PT BPD PAPUA">PT BPD PAPUA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD BENGKULU' || $R_BKNAME2 == 'PT BPD BENGKULU'){echo 'selected';}?> value="PT BPD BENGKULU">PT BPD BENGKULU</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD SULAWESI TENGAH' || $R_BKNAME2 == 'PT BPD SULAWESI TENGAH'){echo 'selected';}?> value="PT BPD SULAWESI TENGAH">PT BPD SULAWESI TENGAH</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD SULAWESI TENGGARA' || $R_BKNAME2 == 'PT BPD SULAWESI TENGGARA'){echo 'selected';}?> value="PT BPD SULAWESI TENGGARA">PT BPD SULAWESI TENGGARA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD BANTEN Tbk' || $R_BKNAME2 == 'PT BPD BANTEN Tbk'){echo 'selected';}?> value="PT BPD BANTEN Tbk">PT BPD BANTEN Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'CITIBANK, N.A.' || $R_BKNAME2 == 'CITIBANK, N.A.'){echo 'selected';}?> value="CITIBANK, N.A.">CITIBANK, N.A.</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'JP MORGAN CHASE BANK, NA' || $R_BKNAME2 == 'JP MORGAN CHASE BANK, NA'){echo 'selected';}?> value="JP MORGAN CHASE BANK, NA">JP MORGAN CHASE BANK, NA</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'BANK OF AMERICA, N.A' || $R_BKNAME2 == 'BANK OF AMERICA, N.A'){echo 'selected';}?> value="BANK OF AMERICA, N.A">BANK OF AMERICA, N.A</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'BANGKOK BANK PCL' || $R_BKNAME2 == 'BANGKOK BANK PCL'){echo 'selected';}?> value="BANGKOK BANK PCL">BANGKOK BANK PCL</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'MUFG BANK, LTD' || $R_BKNAME2 == 'MUFG BANK, LTD'){echo 'selected';}?> value="MUFG BANK, LTD">MUFG BANK, LTD</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'STANDARD CHARTERED BANK' || $R_BKNAME2 == 'STANDARD CHARTERED BANK'){echo 'selected';}?> value="STANDARD CHARTERED BANK">STANDARD CHARTERED BANK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'DEUTSCHE BANK AG' || $R_BKNAME2 == 'DEUTSCHE BANK AG'){echo 'selected';}?> value="DEUTSCHE BANK AG">DEUTSCHE BANK AG</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'BANK OF CHINA (HONG KONG) LIMITED' || $R_BKNAME2 == 'BANK OF CHINA (HONG KONG) LIMITED'){echo 'selected';}?> value="BANK OF CHINA (HONG KONG) LIMITED">BANK OF CHINA (HONG KONG) LIMITED</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BANK MUAMALAT INDONESIA TBK'|| $R_BKNAME2 == 'PT BANK MUAMALAT INDONESIA TBK'){echo 'selected';}?> value="PT BANK MUAMALAT INDONESIA TBK">PT BANK MUAMALAT INDONESIA TBK</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPD JAWA TIMUR SYARIAH Tbk'|| $R_BKNAME2 == 'PT BPD JAWA TIMUR SYARIAH Tbk'){echo 'selected';}?> value="PT BPD JAWA TIMUR SYARIAH Tbk">PT BPD JAWA TIMUR SYARIAH Tbk</option>
                        <option <?php //if($RESULT_DT['ACC_F_APP_BK_2_NAMA'] == 'PT BPR KARYAJATNIKA SADAYA (BPR KS)'|| $R_BKNAME2 == 'PT BPR KARYAJATNIKA SADAYA (BPR KS)'){echo 'selected';}?> value="PT BPR KARYAJATNIKA SADAYA (BPR KS)">PT BPR KARYAJATNIKA SADAYA (BPR KS)</option> -->
                    </select>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">Cabang</label>
                        <input type="text" class="form-control" id="text4b" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_BK_2_CBNG"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_BK_2_CBNG"];
                                }else{
                                    echo $R_BKBRANC2;
                                };
                            ?>" placeholder="" name="bk_branch2" autocomplete="off"
                        >
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">Nomor A/C</label>
                        <input type="number" class="form-control" id="text4b" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_BK_2_ACC"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_BK_2_ACC"];
                                }else{
                                    echo $R_BKNOREK2;
                                };
                            ?>" placeholder="" name="bk_acc_number2" autocomplete="off"
                        >
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">No. Telp</label>
                        <input type="number" class="form-control" id="text4b"  placeholder="" placeholder="Masukkan nomor telepon anda / isi '0' jika tidak mempunyai nya" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_BK_2_TLP"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_BK_2_TLP"];
                                }else{
                                    echo $R_TLP2;
                                }; 
                            ?>" name="city2" autocomplete="off"
                        >
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>
                <div class="input-wrapper">
                <label class="label" for="select4b">Jenis Rekening</label>
                    <select class="form-control custom-select" id="select4b" name="bk_acc_type2">
                        <option value="-">Jenis Rekening</option>
                        <option <?php if($RESULT_DT["ACC_F_APP_BK_2_JENIS"] == 'Giro'|| $R_JENISREK2 == 'Giro'){echo 'selected';}?> value="Giro">Giro</option>
                        <option <?php if($RESULT_DT["ACC_F_APP_BK_2_JENIS"] == 'Tabungan'|| $R_JENISREK2 == 'Tabungan'){echo 'selected';}?> value="Tabungan">Tabungan</option>
                        <option <?php if($RESULT_DT["ACC_F_APP_BK_2_JENIS"] == 'Lainya'|| $R_JENISREK2 == 'Lainya'){echo 'selected';}?> value="Lainya">Lainya</option>
                    </select>
                </div>
                <!--
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">Nama Pemilik Rekening</label>
                        <input type="text" value="<?php echo $user1['MBR_NAME'] ?>" class="form-control" id="text4b" readonly  placeholder="" name="bk_acc_owner">
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="input_lv14">Next</button>
    </div>
</form>
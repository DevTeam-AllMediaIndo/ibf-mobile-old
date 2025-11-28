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
        $R_PEKERJAAN = $RESULT_QUERYACC['ACC_F_APP_KRJ_TYPE'];
        $R_NAMAUSAHA = $RESULT_QUERYACC['ACC_F_APP_KRJ_NAMA'];
        $R_USAHA = $RESULT_QUERYACC['ACC_F_APP_KRJ_BDNG'];
        $R_JABATAN = $RESULT_QUERYACC['ACC_F_APP_KRJ_JBTN'];
        $R_LAMAKER = $RESULT_QUERYACC['ACC_F_APP_KRJ_LAMA'];
        $R_LAMAKERSBLM = $RESULT_QUERYACC['ACC_F_APP_KRJ_LAMASBLM'];
        $R_ALAMATKNTR = $RESULT_QUERYACC['ACC_F_APP_KRJ_ALAMAT'];
        $R_ZIP = $RESULT_QUERYACC['ACC_F_APP_KRJ_ZIP'];
        $R_TLPKNTR = $RESULT_QUERYACC['ACC_F_APP_KRJ_TLP'];
        $R_FAXKNTR = $RESULT_QUERYACC['ACC_F_APP_KRJ_FAX'];
    } else {
        $R_PEKERJAAN = '';
        $R_NAMAUSAHA = '';
        $R_USAHA = '';
        $R_JABATAN = '';
        $R_LAMAKER = '';
        $R_LAMAKERSBLM = '';
        $R_ALAMATKNTR = '';
        $R_ZIP = '';
        $R_TLPKNTR = '';
        $R_FAXKNTR = '';
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
        if(isset($_POST['curr_occupt'])){
            if(isset($_POST['perusahaan'])){
                if(isset($_POST['usaha'])){
                    if(isset($_POST['jabatan'])){
                        if(isset($_POST['lamabekerja'])){
                            if(isset($_POST['lamabekerjasblm'])){
                                if(isset($_POST['alamatkntr'])){
                                    if(isset($_POST['zip'])){
                                        if(isset($_POST['tlpkntr'])){
                                            if(isset($_POST['faxkntr'])){

                                                $curr_occupt = form_input($_POST['curr_occupt']);
                                                if($curr_occupt == 'Lainnya'){
                                                    if(isset($_POST['nma_krj_othr'])){
                                                        $curr_occupt = form_input($_POST['nma_krj_othr']);
                                                    }
                                                }

                                                $perusahaan = form_input($_POST['perusahaan']);
                                                $usaha = form_input($_POST['usaha']);
                                                $jabatan = form_input($_POST['jabatan']);
                                                $lamabekerja = form_input($_POST['lamabekerja']);
                                                $lamabekerjasblm = form_input($_POST['lamabekerjasblm']);
                                                $alamatkntr = form_input($_POST['alamatkntr']);
                                                $zip = form_input($_POST['zip']);
                                                $tlpkntr = form_input($_POST['tlpkntr']);
                                                $faxkntr = form_input($_POST['faxkntr']);
                                                $EXEC_SQL = mysqli_query($db,'
                                                    UPDATE tb_racc SET
                                                        tb_racc.ACC_F_APP_KRJ_NAMA = "'.$perusahaan.'",
                                                        tb_racc.ACC_F_APP_KRJ_BDNG = "'.$usaha.'",
                                                        tb_racc.ACC_F_APP_KRJ_JBTN = "'.$jabatan.'",
                                                        tb_racc.ACC_F_APP_KRJ_LAMA = "'.$lamabekerja.'",
                                                        tb_racc.ACC_F_APP_KRJ_LAMASBLM = "'.$lamabekerjasblm.'",
                                                        tb_racc.ACC_F_APP_KRJ_ALAMAT = "'.$alamatkntr.'",
                                                        tb_racc.ACC_F_APP_KRJ_ZIP = "'.$zip.'",
                                                        tb_racc.ACC_F_APP_KRJ_TLP = "'.$tlpkntr.'",
                                                        tb_racc.ACC_F_APP_KRJ_FAX = "'.$faxkntr.'",
                                                        tb_racc.ACC_F_APP_KRJ_TYPE = "'.$curr_occupt.'"
                                                    WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                                ') or die ("<script>alert('Please Try Again or Contact Support');location.href = 'home.php?page=racc/aplikasipembukaanrekening07&id=".$id_live."' </script>");
                                                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening08&id=".$id_live."'</script>");

                                            }else { 
                                                logerr("Parameter Ke-10 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                                                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-10 Tidak Lengkap')."'</script>");
                                            }
                                        }else { 
                                            logerr("Parameter Ke-9 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-9 Tidak Lengkap')."'</script>");
                                        }
                                    }else { 
                                        logerr("Parameter Ke-8 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-8 Tidak Lengkap')."'</script>");} 

                                }else { 
                                    logerr("Parameter Ke-7 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-7 Tidak Lengkap')."'</script>");
                                }
                            }else { 
                                logerr("Parameter Ke-6 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-6 Tidak Lengkap')."'</script>");
                            }
                        }else { 
                            logerr("Parameter Ke-5 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-5 Tidak Lengkap')."'</script>");
                        }
                    }else { 
                        logerr("Parameter Ke-4 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-4 Tidak Lengkap')."'</script>");
                    }
                }else { 
                    logerr("Parameter Ke-3 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-3 Tidak Lengkap')."'</script>");
                }
            }else { 
                logerr("Parameter Ke-2 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-2 Tidak Lengkap')."'</script>");
            }
        }else { 
            logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-7 (REGOL)", $user1["MBR_ID"]);
            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-1 Tidak Lengkap')."'</script>");
        }
    }
?>
<style>
    .div_placholder{
        float: right;
        text-align: right;
        font-size: smaller;
        font-weight: bold;
        font-style: italic;
    }
</style>
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
            <div class="section">
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
                <div class="text-center"><strong>PEKERJAAN</strong></div>
                <div class="clearfix"></div>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label" for="select4b">Pekerjaan</label>
                        <select class="form-control custom-select" id="pkrjn" name="curr_occupt" required>
                            <option selected disabled value="">Pekerjaan anda sekarang</option>
                            <option <?php if($R_PEKERJAAN == 'Swasta'      || $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  == 'Swasta'){ echo 'selected';}?> value="Swasta">Swasta</option>
                            <option <?php if($R_PEKERJAAN == 'Wiraswasta'  || $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  == 'Wiraswasta'){ echo 'selected';}?> value="Wiraswasta">Wiraswasta</option>
                            <option <?php if($R_PEKERJAAN == 'Ibu RT'      || $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  == 'Ibu RT'){ echo 'selected';}?> value="Ibu RT">Ibu RT</option>
                            <option <?php if($R_PEKERJAAN == 'Profesional' || $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  == 'Profesional'){ echo 'selected';}?> value="Profesional">Profesional</option>
                            <option <?php if($R_PEKERJAAN == 'ASN'         || $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  == 'ASN'){ echo 'selected';}?> value="ASN">ASN</option>
                            <option <?php if($R_PEKERJAAN == 'Mahasiswa'   || $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  == 'Mahasiswa'){ echo 'selected';}?> value="Mahasiswa">Mahasiswa</option>
                            <option 
                                <?php 
                                    if(
                                        (
                                            (
                                                $R_PEKERJAAN != 'Swasta' && 
                                                $R_PEKERJAAN != 'Wiraswasta' && 
                                                $R_PEKERJAAN != 'Ibu RT' && 
                                                $R_PEKERJAAN != 'Profesional' && 
                                                $R_PEKERJAAN != 'ASN' 
                                                && $R_PEKERJAAN != 'Mahasiswa'
                                            ) || 
                                            (
                                                $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  != 'Swasta' && 
                                                $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  != 'Wiraswasta' && 
                                                $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  != 'Ibu RT' && 
                                                $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  != 'Profesional' && 
                                                $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  != 'Profesional' &&  
                                                $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  != 'ASN' && 
                                                $RESULT_DT["ACC_F_APP_KRJ_TYPE"]  != 'Mahasiswa'
                                            )
                                        ) && (strlen($R_PEKERJAAN) >= 3 || strlen($RESULT_DT["ACC_F_APP_KRJ_TYPE"]) >= 3)
                                    ){ echo 'selected'; $visible = 'unset';}else{ $visible = 'hidden'; };
                                ?> value="Lainnya">Lainnya
                            </option>
                        </select>
                    </div>
                    <div class="input-wrapper mt-3" id="nma_krj_othr_div" style="content-visibility: <?php echo $visible; ?>;">
                        <div class="label">
                            <div style="float: left;">Pekerjaan Lainnya</div>
                        </div>
                        <input type="text" minlength="3" class="form-control" id="nma_krj_othr" placeholder="Masukkan pekerjaan lainnya anda" 
                            value="<?php 
                                if($RESULT_DT["ACC_F_APP_KRJ_TYPE"] > "-1"){ 
                                    echo $RESULT_DT["ACC_F_APP_KRJ_TYPE"];
                                }else{ 
                                    echo $R_PEKERJAAN;
                                };
                            ?>" name="nma_krj_othr" required autocomplete="off"
                        >
                    </div>
                    <div class="input-wrapper mt-3">
                        <div class="label">
                            <div style="float: left;">Nama Perusahaan</div>
                            <div class="div_placholder">Masukkan nama perusahaan anda</div>
                        </div>
                        <input type="text" minlength="3" class="form-control" id="text4b" placeholder="Masukkan nama perusahaan anda" 
                            value="<?php 
                                if($RESULT_DT["ACC_F_APP_KRJ_NAMA"] > "-1"){ 
                                    echo $RESULT_DT["ACC_F_APP_KRJ_NAMA"];
                                }else{ 
                                    echo $R_NAMAUSAHA;
                                };
                            ?>" name="perusahaan" required autocomplete="off"
                        >
                    </div>
                    <div class="input-wrapper mt-3">
                        <div class="label">
                            <div style="float: left;">Bidang Usaha</div>
                            <div class="div_placholder">Masukkan bidang usaha anda</div>
                        </div>
                        <input type="text" minlength="3" class="form-control" id="text4b" placeholder="Masukkan bidang usaha anda" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_KRJ_BDNG"] > '-1'){ 
                                    echo $RESULT_DT["ACC_F_APP_KRJ_BDNG"];
                                }else{
                                    echo $R_USAHA;
                                };
                            ?>" name="usaha" required autocomplete="off"
                        >
                    </div>
                    <div class="input-wrapper mt-3">
                        <div class="label">
                            <div style="float: left;">Jabatan</div>
                            <div class="div_placholder">Masukkan jabatan anda sekarang</div>
                        </div>
                        <input type="text" class="form-control" id="select4b" name="jabatan" required placeholder="Jabatan">
                        <!-- <select class="form-control custom-select" id="select4b" name="jabatan" required>
                            <option disabled selected value="">Jabatan apa yang sedang anda jabat sekarang ini</option>
                            <option <php if($R_JABATAN == "Staff" || $RESULT_DT["ACC_F_APP_KRJ_JBTN"] == "Staff"){ echo 'selected';}?> value="Staff">Staff</option>
                            <option <php if($R_JABATAN == "Manager" || $RESULT_DT["ACC_F_APP_KRJ_JBTN"] == "Manager"){ echo 'selected';}?> value="Manager">Manager</option>
                            <option <php if($R_JABATAN == "Owner" || $RESULT_DT["ACC_F_APP_KRJ_JBTN"] == "Owner"){ echo 'selected';}?> value="Owner">Owner</option>
                            <option <php if($R_JABATAN == "Direksi" || $RESULT_DT["ACC_F_APP_KRJ_JBTN"] == "Direksi"){ echo 'selected';}?> value="Direksi">Direksi</option>
                            <option <php if($R_JABATAN == "Lainya" || $RESULT_DT["ACC_F_APP_KRJ_JBTN"] == "Lainya"){ echo 'selected';}?> value="Lainya">Lainya</option>
                        </select> -->
                    </div>
                    <div class="input-wrapper row mt-3">
                        <div class="col-6">
                            <label class="label" for="text4b">Lama Bekerja</label>
                            <input type="text" class="form-control" id="text4b" placeholder="Berapa lama anda bekerja di perusahaan sekarang" 
                                value="<?php
                                    if($RESULT_DT["ACC_F_APP_KRJ_LAMA"] > "-1"){
                                        echo $RESULT_DT["ACC_F_APP_KRJ_LAMA"];
                                    }else{
                                        echo $R_LAMAKER;
                                    };
                                ?>" name="lamabekerja" required autocomplete="off"
                            >
                        </div>
                        <div class="col-6">
                            <label class="label" for="text4b">Kantor sebelumnya</label>
                            <input type="text" class="form-control" id="text4b" placeholder="Berapa lama anda bekerja di perusahaan sebelumnya" 
                                value="<?php
                                    if($RESULT_DT["ACC_F_APP_KRJ_LAMASBLM"] > "-1"){
                                        echo $RESULT_DT["ACC_F_APP_KRJ_LAMASBLM"];
                                    }else{
                                        echo $R_LAMAKERSBLM;
                                    };
                                ?>" name="lamabekerjasblm" required autocomplete="off"
                            >
                        </div>
                    </div>
                    <div class="input-wrapper mt-3">
                        <div class="label">
                            <div style="float: left;">Alamat Kantor</div>
                            <div class="div_placholder">Masukan alamat kantor anda yang sekarang</div>
                        </div>
                        <input type="text" minlength="3" class="form-control" id="text4b" placeholder="Masukan alamat kantor anda yang sekarang" name="alamatkntr" 
                            value="<?php
                                if($RESULT_DT["ACC_F_APP_KRJ_ALAMAT"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_KRJ_ALAMAT"];
                                }else{
                                    echo $R_ALAMATKNTR;
                                };
                            ?>" required autocomplete="off"
                        >
                    </div>
                    <div class="input-wrapper mt-3">
                        <label class="label" for="text4b">Kode pos</label>
                        <input type="number" class="form-control" id="text4b" min="10000" max="99999" placeholder="Masukan Kode pos anda yang sekarang" name="zip" 
                            value="<?php 
                                if($RESULT_DT["ACC_F_APP_KRJ_ZIP"] > -1){
                                    echo $RESULT_DT["ACC_F_APP_KRJ_ZIP"];
                                }else{
                                    echo $R_ZIP;
                                };
                            ?>" required autocomplete="off"
                        >
                    </div>
                    <div class="input-wrapper mt-3">
                        <label class="label" for="text4b">No. Tlp Kantor</label>
                        <input type="number" class="form-control" id="text4b" placeholder="Masukkan nomor telepon kantor anda / isi '0' jika tidak mempunyai nya" 
                            value="<?php 
                                if($RESULT_DT["ACC_F_APP_KRJ_TLP"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_KRJ_TLP"] ;
                                }else{
                                    echo $R_TLPKNTR;
                                }; 
                            ?>" name="tlpkntr" required autocomplete="off">
                    </div>
                    <div class="input-wrapper mt-3">
                        <label class="label" for="text4b">No. Faksimili</label>
                        <input type="number" class="form-control" id="text4b" placeholder="Masukkan nomor faksimili kantor anda / isi '0' jika tidak mempunyai nya" 
                            value="<?php 
                                if($RESULT_DT["ACC_F_APP_KRJ_FAX"] > "-1"){
                                    echo $RESULT_DT["ACC_F_APP_KRJ_FAX"];
                                }else{ 
                                    echo $R_FAXKNTR;
                                };
                            ?>" name="faxkntr"  autocomplete="off" required
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="input_lv13">Next</button>
    </div>
</form>
<script>
    let pkrjn = document.getElementById('pkrjn');
    pkrjn.addEventListener('change', function(e){
        console.log(e.target[7].selected);
        let nma_krj_othr_div = document.getElementById('nma_krj_othr_div');
        let nma_krj_othr     = document.getElementById('nma_krj_othr');
        if(e.target[7].selected){
            // console.log(nma_krj_othr_div.style.cssText);
            nma_krj_othr_div.style.cssText = 'content-visibility: unset;';
            nma_krj_othr.required = true;
            console.log(nma_krj_othr.required);
        }else{
            nma_krj_othr_div.style.cssText = 'content-visibility: hidden;';
            nma_krj_othr.required = false;
            console.log(nma_krj_othr.required);
        }
    });
</script>
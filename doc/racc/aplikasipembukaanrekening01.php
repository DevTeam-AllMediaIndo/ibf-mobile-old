
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
        $R_NPWP = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_NPWP'];
        $R_KELAMIN = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_KELAMIN'];
        $R_OWNER = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_STSRMH'];
        $R_IBUKAN = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_IBU'];
        $R_STSKAWIN = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_STSKAWIN'];
        $R_SUAMINISTRI = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_NAMAISTRI'];
        $R_TLPRMH = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_TLP'];
        $R_FAX = $RESULT_QUERYACC['ACC_F_APP_PRIBADI_FAX'];
    } else {
        $R_NPWP = '';
        $R_KELAMIN = '';
        $R_OWNER = '';
        $R_IBUKAN = '';
        $R_STSKAWIN = '';
        $R_SUAMINISTRI = '';
        $R_TLPRMH = '';
        $R_FAX = '';
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

    if(isset($_POST['input_lv4'])) {
        if(isset($_POST['full_name'])) {
            if(isset($_POST['Phone_number'])) {
                if(isset($_POST['idnt_type'])) {
                    if(isset($_POST['idnt_number'])) {
                        if(isset($_POST['birth_date'])) {
                            if(isset($_POST['birth_place'])) {
                                if(isset($_POST['gender_type'])) {
                                    if(isset($_POST['address_name'])) {
                                        if(isset($_POST['zip'])) {
                                            if(isset($_POST['ownership'])) {
                                                if(isset($_POST['idnt_npwp'])) {
                                                    if(isset($_POST['sps_details'])) {
                                                        if(isset($_POST['nama_ibukandung'])) {
                                                                                        
                                                            $full_name = form_input($_POST['full_name']);
                                                            $Phone_number = form_input($_POST['Phone_number']);
                                                            $idnt_type = form_input($_POST['idnt_type']);
                                                            $idnt_number = form_input($_POST['idnt_number']);
                                                            $birth_date = form_input($_POST['birth_date']);
                                                            $birth_place = form_input($_POST['birth_place']);
                                                            $gender_type = form_input($_POST['gender_type']);
                                                            $address_name = form_input($_POST['address_name']);
                                                            $zip = form_input($_POST['zip']);
                                                            $ownership = form_input($_POST['ownership']);
                                                            $idnt_npwp = form_input($_POST['idnt_npwp']);
                                                            $sps_details = form_input($_POST['sps_details']);
                                                            $nama_ibukandung = form_input($_POST['nama_ibukandung']);
                                                            $nama_suamiistri = form_input($_POST['nama_suamiistri']);
                                                            $tlp_rmh = form_input($_POST['tlp_rmh']);
                                                            $faksmail = form_input($_POST['faksmail']);
                            
                                                            $EXEC_SQL = mysqli_query($db, '
                                                                UPDATE tb_racc SET
                                                                    tb_racc.ACC_F_APP_PRIBADI_NAMA = "'.$full_name.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_HP = "'.$Phone_number.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_TYPEID  = "'.$idnt_type.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_ID  = "'.$idnt_number.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_KELAMIN = "'.$gender_type.'", 
                                                                    tb_racc.ACC_F_APP_PRIBADI_ALAMAT = "'.$address_name.'", 
                                                                    tb_racc.ACC_F_APP_PRIBADI_ZIP = '.$zip.', 
                                                                    tb_racc.ACC_F_APP_PRIBADI_STSRMH = "'.$ownership.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_NPWP = "'.$idnt_npwp.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_TGLLHR = "'.$birth_date.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_TMPTLHR = "'.$birth_place.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_STSKAWIN = "'.$sps_details.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_IBU  = "'.$nama_ibukandung.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_TLP  = "'.$tlp_rmh.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_FAX  = "'.$faksmail.'",
                                                                    tb_racc.ACC_F_APP_PRIBADI_NAMAISTRI  = "'.$nama_suamiistri.'"
                                                                WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                                            ') or die (mysqli_error($db));
                                                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening02&id&id=".$id_live."'</script>");

                                                        } else { 
                                                            logerr("Parameter Ke-13 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-13 Tidak Lengkap')."'</script>"); 
                                                        }
                                                    } else { 
                                                        logerr("Parameter Ke-12 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-12 Tidak Lengkap')."'</script>"); 
                                                    }
                                                } else { 
                                                    logerr("Parameter Ke-11 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-11 Tidak Lengkap')."'</script>"); 
                                                }
                                            } else { 
                                                logerr("Parameter Ke-10 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-10 Tidak Lengkap')."'</script>"); 
                                            }
                                        } else { 
                                            logerr("Parameter Ke-9 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-9 Tidak Lengkap')."'</script>"); 
                                        }
                                    } else { 
                                        logerr("Parameter Ke-8 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-8 Tidak Lengkap')."'</script>"); 
                                    }
                                } else { 
                                    logerr("Parameter Ke-7 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-7 Tidak Lengkap')."'</script>"); 
                                }
                            } else { 
                                logerr("Parameter Ke-6 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-6 Tidak Lengkap')."'</script>"); 
                            }
                        } else { 
                            logerr("Parameter Ke-5 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-5 Tidak Lengkap')."'</script>"); 
                        }
                    } else { 
                        logerr("Parameter Ke-4 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-4 Tidak Lengkap')."'</script>"); 
                    }
                } else { 
                    logerr("Parameter Ke-3 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-3 Tidak Lengkap')."'</script>"); 
                }
            } else { 
                logerr("Parameter Ke-2 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
                die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-2 Tidak Lengkap')."'</script>"); 
            }
        } else { 
            logerr("Parameter Ke-1 Tidak Lengkap", "Aplikasi Pembukaan Rekening Hal-1 (REGOL)", $user1["MBR_ID"]);
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
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label class="label" for="text4b">Kode Nasabah:</label>
                </div>
            </div>
            <div class="text-center"><strong>DATA PRIBADI</strong></div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label class="label" for="text4b">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="text4b" value="<?php echo $user1['MBR_NAME'] ?>" placeholder="Masukkan nama lengkap anda" name="full_name">
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Tempat Lahir:</label>
                    <input type="text" class="form-control" id="text4b" value="<?php echo $user1['MBR_TMPTLAHIR'] ?>" placeholder="masukkan tempat lahir anda" required name="birth_place">
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Tanggal Lahir:</label>
                    <input type="date" max="<?php echo date('Y-m-d', strtotime('-21 years')) ?>" class="form-control" id="text4b" value="<?php echo date_format(date_create($user1['MBR_TGLLAHIR']),"Y-m-d"); ?>" required name="birth_date">
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">Jenis Identitas <span class="text-danger">*</span>) :</label>
                    <select class="form-control custom-select" id="idt_type" onchange="GetSelectedTextValue2(this)" required name="idnt_type" style="font-size: 12px;">
                        <option disabled selected value>Jenis Identitas</option>
                        <option <?php if($user1['MBR_TYPE_IDT'] == 'KTP'){ echo 'selected'; } ?> value="KTP">KTP</option>
                        <option <?php if($user1['MBR_TYPE_IDT'] == 'Passport'){ echo 'selected'; } ?> value="Passport">Passport</option>
                    </select>
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">No. Identitas:</label>
                    <input type="text" class="form-control" id="no_idt" value="<?php echo $user1['MBR_NO_IDT'] ?>" placeholder="Masukkan nomor identitas" required name="idnt_number">
                    <small class="text-danger" id="error-idt"></small>
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">No. NPWP <span class="text-danger">*</span>) :</label>
                    <input type="text" class="form-control" maxlength="16" minlength="15" id="text4b" pattern="[0-9]*" placeholder="Format hanya angka" title="format hanya angka" 
                        value="<?php 
                            if($RESULT_DT["ACC_F_APP_PRIBADI_NPWP"] > "0"){
                                echo $RESULT_DT["ACC_F_APP_PRIBADI_NPWP"];
                            }else{
                                echo $R_NPWP;
                            }
                        ?>" required name="idnt_npwp"
                    >
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Jenis Kelamin:</label>
                    <select class="form-control custom-select" id="select4b" required name="gender_type" style="font-size: 12px;">
                        <option disabled selected value>Jenis Kelamin</option>
                        <option <?php if($R_KELAMIN == 'Laki-laki' || $RESULT_DT["ACC_F_APP_PRIBADI_KELAMIN"] == 'Laki-laki'){ echo 'selected'; } ?> value="Laki-laki">Laki-laki</option>
                        <option <?php if($R_KELAMIN == 'Perempuan' || $RESULT_DT["ACC_F_APP_PRIBADI_KELAMIN"] == 'Perempuan'){ echo 'selected'; } ?> value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Nama Ibu kandung:</label>
                    <input type="text" class="form-control" id="text4b" placeholder="Masukan nama ibu kandung anda" 
                        value="<?php 
                            if($RESULT_DT["ACC_F_APP_PRIBADI_IBU"] > "0"){
                                echo $RESULT_DT["ACC_F_APP_PRIBADI_IBU"];
                            }else{
                                echo $R_IBUKAN;
                            } 
                        ?>" required name="nama_ibukandung" autocomplete="off"
                    >
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Status Perkawinan:</label>
                    <select class="form-control custom-select" id="sts_kawin" name="sps_details" onchange="GetSelectedTextValue(this)" required>
                        <option disabled selected value>Status perkawinan anda</option>
                        <option <?php if($R_STSKAWIN == 'Tidak Kawin' || $RESULT_DT["ACC_F_APP_PRIBADI_STSKAWIN"] == 'Tidak Kawin'){ echo 'selected'; } ?> value="Tidak Kawin">Tidak Kawin</option>
                        <option <?php if($R_STSKAWIN == 'Kawin' || $RESULT_DT["ACC_F_APP_PRIBADI_STSKAWIN"] == 'Kawin'){ echo 'selected'; } ?> value="Kawin">Kawin</option>
                        <option <?php if($R_STSKAWIN == 'Janda' || $RESULT_DT["ACC_F_APP_PRIBADI_STSKAWIN"] == 'Janda'){ echo 'selected'; } ?> value="Janda">Janda</option>
                        <option <?php if($R_STSKAWIN == 'Duda' || $RESULT_DT["ACC_F_APP_PRIBADI_STSKAWIN"] == 'Duda'){ echo 'selected'; } ?> value="Duda">Duda</option>
                    </select>
                </div>
                <div class="input-wrapper mt-3" id="div_kawin">
                    <label class="label" for="select4b">Nama Istri/Suami <span class="text-danger">*</span>) :</label>
                    <input type="text" class="form-control" id="nama_suamiistri" 
                        value="<?php 
                            if($RESULT_DT["ACC_F_APP_PRIBADI_NAMAISTRI"] > "0"){
                                echo $RESULT_DT["ACC_F_APP_PRIBADI_NAMAISTRI"];
                            }else{
                                echo $R_SUAMINISTRI;
                            } 
                        ?>" required name="nama_suamiistri" autocomplete="off"
                    >
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Alamat Rumah:</label>
                    <input type="text" class="form-control" id="text4b" value="<?php echo $user1['MBR_ADDRESS'] ?>" placeholder="Masukan Alamat Rumah Anda Sesuai KTP" required name="address_name">
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Kode Pos:</label>
                    <input type="number" class="form-control" id="text4b" value="<?php echo $user1['MBR_ZIP'] ?>" min="10000" max="99999"  placeholder="masukkan kode pos" required name="zip">
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">No. Telp Rumah:</label>
                    <input type="number" class="form-control" id="text4b" 
                        value="<?php 
                            if($RESULT_DT["ACC_F_APP_PRIBADI_TLP"] > "-1"){
                                echo $RESULT_DT["ACC_F_APP_PRIBADI_TLP"];
                            }else { 
                                echo $R_TLPRMH;
                            }; 
                        ?>" placeholder="Isi '0' apabila anda tidak memiliki nya" required name="tlp_rmh" autocomplete="off"
                    >
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">No. Faksimili Rumah:</label>
                    <input type="number" class="form-control" id="text4b" 
                        value="<?php 
                            if($RESULT_DT["ACC_F_APP_PRIBADI_FAX"] > "-1"){
                                echo $RESULT_DT["ACC_F_APP_PRIBADI_FAX"];
                            } else { 
                                echo $R_FAX;
                            }; 
                        ?>" placeholder="Isi '0' apabila anda tidak memiliki nya" required name="faksmail" autocomplete="off"
                    >
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="text4b">No. Telp Handphone:</label>
                    <input type="text" class="form-control" id="text4b" value="<?php if($user1['MBR_PHONE'] == ""){} else { echo $user1['MBR_PHONE'];}; ?>" <?php if(strlen($user1['MBR_PHONE']) > 3){ echo 'readonly'; } ?> placeholder="Pastikan nomor anda memiliki nomor whatsapp" name="Phone_number">
                </div>
                <div class="input-wrapper mt-3">
                    <label class="label" for="select4b">Status Kepemilikan Rumah</label>
                    <select class="form-control custom-select" id="select4b" required name="ownership" style="font-size: 12px;">
                        <option disabled selected value>Status Kepemilikan</option>
                        <option <?php if($R_OWNER == 'Pribadi' || $RESULT_DT["ACC_F_APP_PRIBADI_STSRMH"] == 'Pribadi'){ echo 'selected'; } ?> value="Pribadi">Pribadi</option>
                        <option <?php if($R_OWNER == 'Keluarga' || $RESULT_DT["ACC_F_APP_PRIBADI_STSRMH"] == 'Keluarga'){ echo 'selected'; } ?> value="Keluarga">Keluarga</option>
                        <option <?php if($R_OWNER == 'Sewa' || $RESULT_DT["ACC_F_APP_PRIBADI_STSRMH"] == 'Sewa'){ echo 'selected'; } ?> value="Sewa">Sewa</option>
                        <option <?php if($R_OWNER == 'Lainnya' || $RESULT_DT["ACC_F_APP_PRIBADI_STSRMH"] == 'Lainnya'){ echo 'selected'; } ?> value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="btn-next" name="input_lv4">Next</button>
    </div>
</form>
<script>
    GetSelectedTextValue(sts_kawin);
    function GetSelectedTextValue(sts_kawin) {
        var selVal = sts_kawin.value;
        var div_kawin = document.getElementById("div_kawin");
        if(selVal == 'Tidak Kawin' || selVal == 'Janda' || selVal == 'Duda'){
            div_kawin.style.display = 'none';
            document.getElementById("nama_suamiistri").required = false;
        } else {
            div_kawin.style.display = 'block';
            document.getElementById("nama_suamiistri").required = true;
        }
    };
    
    GetSelectedTextValue2(idt_type);
    function GetSelectedTextValue2(idt_type) {
        var selVal = idt_type.value;
        var no_idt = document.getElementById("no_idt");
        var err_message = document.querySelector('#error-idt');
        var min_length  = 8;
        var max_length  = 16;

        if(selVal == 'Passport'){
            min_length = 8;
            max_length = 16;
            console.log('Passport')
            document.getElementById('no_idt').type='text';
            document.getElementById("no_idt").maxLength = max_length;
            document.getElementById("no_idt").minLength = min_length;
            // document.getElementById("no_idt").maxLength = "16";
            // document.getElementById("no_idt").minLength = "8";
        } else {
            min_length = 16;
            max_length = 16;
            console.log('KTP')
            document.getElementById('no_idt').type='number';
            // document.getElementById("no_idt").max = "9999999999999999";
            // document.getElementById("no_idt").min = "1000000000000000";
        };
        
        no_idt.addEventListener('keyup', function(evt) {
            if(no_idt.value.length < min_length) {
                // err_message.innerHTML = 'No Identitas tidak boleh lebih dari '+max_length+' digit';
                err_message.innerHTML = `No Identitas minimal ${min_length} digit, dan tidak boleh lebih dari ${max_length} digit`;
                document.querySelector('#btn-next').disabled = true;
                
            }else if(no_idt.value.length > max_length) {
                // err_message.innerHTML = 'No Identitas harus lebih dari '+min_length+' digit';
                err_message.innerHTML = `No Identitas minimal ${min_length} digit, dan tidak boleh lebih dari ${max_length} digit`;
                document.querySelector('#btn-next').disabled = true;
            }
            else {
                err_message.innerHTML = '';
                document.querySelector('#btn-next').disabled = false;
            }
        });
    };

</script>
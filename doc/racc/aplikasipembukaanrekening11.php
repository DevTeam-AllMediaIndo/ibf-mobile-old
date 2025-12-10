<?php
    require 'vendor/autoload.php';
    require_once __DIR__ . "/../../FileUpload.php";

    // use Aws\S3\S3Client;

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
        $ACC_F_APP_FILE_TYPE = $RESULT_QUERYACC['ACC_F_APP_FILE_TYPE'];
        $ACC_F_APP_FILE_IMG = $RESULT_QUERYACC['ACC_F_APP_FILE_IMG'];
        $ACC_F_APP_FILE_IMG2 = $RESULT_QUERYACC['ACC_F_APP_FILE_IMG2'];
        $ACC_F_APP_FILE_FOTO = $RESULT_QUERYACC['ACC_F_APP_FILE_FOTO'];
        $ACC_F_APP_FILE_ID = $RESULT_QUERYACC['ACC_F_APP_FILE_ID'];
    } else {
        $ACC_F_APP_FILE_TYPE = '';
        $ACC_F_APP_FILE_IMG = '';
        $ACC_F_APP_FILE_IMG2 = '';
        $ACC_F_APP_FILE_FOTO = '';
        $ACC_F_APP_FILE_ID = '';
    }

	// AWS Info
	// $region = 'ap-southeast-1';
	// $bucketName = 'allmediaindo-2';
	// $folder = 'ibftrader';
	// $IAM_KEY = 'AKIASPLPQWHJMMXY2KPR';
	// $IAM_SECRET = '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';

    $newfilename1 = round(microtime(true));
    
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
    if(isset($_POST['submit_05'])){
        if(isset($_POST['aggree'])){
            if(isset($_POST['idnt_type'])){
                $aggree = ($_POST["aggree"]);
                $type = form_input($_POST['idnt_type']);
                if($aggree == 'Yes'){
                    if(strlen($ACC_F_APP_FILE_IMG) > 0 && strlen($ACC_F_APP_FILE_FOTO) > 0 && strlen($ACC_F_APP_FILE_ID) > 0){
                        mysqli_query($db, '
                            UPDATE tb_racc SET
                            tb_racc.ACC_F_APP = 1,
                            tb_racc.ACC_F_APP_FILE_TYPE = "'.$type.'",
                            tb_racc.ACC_F_APP_IP = "'.$IP_ADDRESS.'",
                            tb_racc.ACC_F_APP_PERYT = "'.$aggree.'",
                            tb_racc.ACC_F_APP_DATE = "'.date('Y-m-d H:i:s').'"
                            WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                        ') or die (mysqli_error($db));
                        die ("<script>location.href = 'home.php?page=racc/disclosure2&id=".$id_live."'</script>");
                    }else{
                        $s5_6_doc1_sts = 0;
                        $s5_6_fotoself_sts = 0;
                        $s5_6_fotoid_sts = 0;
                        if(isset($_FILES["s5_6_doc1"]) && $_FILES["s5_6_doc1"]["error"] == 0){
                            
                            $s5_6_doc1_name = $_FILES["s5_6_doc1"]["name"];
                            $s5_6_doc1_type = $_FILES["s5_6_doc1"]["type"];
                            $s5_6_doc1_size = $_FILES["s5_6_doc1"]["size"];
                            
                            $s5_6_doc1_ext = pathinfo($s5_6_doc1_name, PATHINFO_EXTENSION);
                            
                            if($s5_6_doc1_size < 5000000) {
                                if(array_key_exists($s5_6_doc1_ext, $allowed)){
                                    if(in_array($s5_6_doc1_type, $allowed)){
                                        
                                        /** Upload Image */
                                        $uploadImage = FileUpload::aws()->upload_single($_FILES['s5_6_doc1'], "document");
                                        if(!is_array($uploadImage) || !array_key_exists("filename", $uploadImage)) {
                                            $errorMessage = $uploadImage ?? "Gagal Upload Image";
                                            logerr($errorMessage, "Document", $user1["MBR_ID"]);
                                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('There was an error uploading the file.')."'</script>");
                                        }

                                        mysqli_query($db, '
                                            UPDATE tb_racc SET
                                            tb_racc.ACC_F_APP_FILE_IMG = "'.$uploadImage['filename'].'"
                                            WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                        ') or die (mysqli_error($db));
                                        $s5_6_doc1_sts = -1;
                                    } else { 
                                        logerr("Type File Tidak Sesuai. Bagian Dokumen Pendukung 1", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                        die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Error: There was a problem uploading your file. Please try again.')."'</script>"); 
                                    }
                                } else { 
                                    logerr("Extensi File Tidak Sesuai. Bagian Dokumen Pendukung 1", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Only *.jpg, *.jpeg, *.png')."'</script>"); 
                                }
                            } else { 
                                logerr("Ukuran File Melebihi Jumlah Kapasitas Maximal. Bagian Dokumen Pendukung 1", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Maximum 5 MB.')."'</script>"); 
                            }
                        }
    
                        if(isset($_FILES["s5_6_doc2"]) && $_FILES["s5_6_doc2"]["error"] == 0){
                            
                            $s5_6_doc2_name = $_FILES["s5_6_doc2"]["name"];
                            $s5_6_doc2_type = $_FILES["s5_6_doc2"]["type"];
                            $s5_6_doc2_size = $_FILES["s5_6_doc2"]["size"];
                            
                            $s5_6_doc2_ext = pathinfo($s5_6_doc2_name, PATHINFO_EXTENSION);
                            
                            if($s5_6_doc2_size < 5000000) {
                                if(array_key_exists($s5_6_doc2_ext, $allowed)){
                                    if(in_array($s5_6_doc2_type, $allowed)){
                                        /** Upload Image */
                                        $uploadImage = FileUpload::aws()->upload_single($_FILES['s5_6_doc2'], "document");
                                        if(!is_array($uploadImage) || !array_key_exists("filename", $uploadImage)) {
                                            $errorMessage = $uploadImage ?? "Gagal Upload Image";
                                            logerr($errorMessage, "Document", $user1["MBR_ID"]);
                                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('There was an error uploading the file.')."'</script>");
                                        }
                                        
                                        mysqli_query($db, '
                                            UPDATE tb_racc SET
                                            tb_racc.ACC_F_APP_FILE_IMG2 = "'.$uploadImage['filename'].'"
                                            WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                        ') or die (mysqli_error($db));
                                        $s5_6_doc2_sts = -1;
                                    } else {
                                        logerr("Type File Tidak Sesuai. Bagian Dokumen Pendukung 2", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                        die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Error: There was a problem uploading your file. Please try again.')."'</script>"); 
                                    }
                                } else {
                                    logerr("Extensi File Tidak Sesuai. Bagian Dokumen Pendukung 2", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Only *.jpg, *.jpeg, *.png')."'</script>"); 
                                }
                            } else {
                                logerr("Ukuran File Melebihi Jumlah Kapasitas Maximal. Bagian Dokumen Pendukung 2", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Maximum 5 MB.')."'</script>"); 
                            }
                        }
    
                        
                        if(isset($_FILES["s5_6_fotoself"]) && $_FILES["s5_6_fotoself"]["error"] == 0){
                            
                            $s5_6_fotoself_name = $_FILES["s5_6_fotoself"]["name"];
                            $s5_6_fotoself_type = $_FILES["s5_6_fotoself"]["type"];
                            $s5_6_fotoself_size = $_FILES["s5_6_fotoself"]["size"];
                            
                            $s5_6_fotoself_ext = pathinfo($s5_6_fotoself_name, PATHINFO_EXTENSION);
                            
                            if($s5_6_fotoself_size < 5000000) {
                                if(array_key_exists($s5_6_fotoself_ext, $allowed)){
                                    if(in_array($s5_6_fotoself_type, $allowed)){
                                        /** Upload Image */
                                        $uploadImage = FileUpload::aws()->upload_single($_FILES['s5_6_fotoself'], "foto_selfie");
                                        if(!is_array($uploadImage) || !array_key_exists("filename", $uploadImage)) {
                                            $errorMessage = $uploadImage ?? "Gagal Upload Image";
                                            logerr($errorMessage, "Foto selfie", $user1["MBR_ID"]);
                                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('There was an error uploading the file.')."'</script>");
                                        }
                                        
                                        mysqli_query($db, '
                                            UPDATE tb_racc SET
                                            tb_racc.ACC_F_APP_FILE_FOTO = "'.$uploadImage["filename"].'"
                                            WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                        ') or die (mysqli_error($db));
                                        $s5_6_fotoself_sts = -1;
                                    } else {
                                        logerr("Type File Tidak Sesuai. Bagian Photo Selfie", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                        die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Error: There was a problem uploading your file. Please try again.')."'</script>"); 
                                    }
                                } else {
                                    logerr("Extensi File Tidak Sesuai. Bagian Photo Selfie", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Only *.jpg, *.jpeg, *.png')."'</script>"); 
                                }
                            } else {
                                logerr("Ukuran File Melebihi Jumlah Kapasitas Maximal. Bagian Photo Selfie", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Maximum 5 MB.')."'</script>"); 
                            }
                        }
    
                        if(isset($_FILES["s5_6_fotoid"]) && $_FILES["s5_6_fotoid"]["error"] == 0){
                            
                            $s5_6_fotoid_name = $_FILES["s5_6_fotoid"]["name"];
                            $s5_6_fotoid_type = $_FILES["s5_6_fotoid"]["type"];
                            $s5_6_fotoid_size = $_FILES["s5_6_fotoid"]["size"];
                            
                            $s5_6_fotoid_ext = pathinfo($s5_6_fotoid_name, PATHINFO_EXTENSION);
                            
                            if($s5_6_fotoid_size < 5000000) {
                                if(array_key_exists($s5_6_fotoid_ext, $allowed)){
                                    if(in_array($s5_6_fotoid_type, $allowed)){
                                        /** Upload Image */
                                        $uploadImage = FileUpload::aws()->upload_single($_FILES['s5_6_fotoid'], "ktp_passport");
                                        if(!is_array($uploadImage) || !array_key_exists("filename", $uploadImage)) {
                                            $errorMessage = $uploadImage ?? "Gagal Upload Image";
                                            logerr($errorMessage, "Foto KTP/Passport", $user1["MBR_ID"]);
                                            die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('There was an error uploading the file.')."'</script>");
                                        }
                                        mysqli_query($db, '
                                            UPDATE tb_racc SET
                                            tb_racc.ACC_F_APP_FILE_ID = "'.$uploadImage["filename"].'"
                                            WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                        ') or die (mysqli_error($db));
                                        $s5_6_fotoid_sts = -1;
                                    } else {
                                        logerr("Type File Tidak Sesuai. Bagian Photo Data Diri", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                        die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Error: There was a problem uploading your file. Please try again.')."'</script>"); 
                                    }
                                } else {
                                    logerr("Extensi File Tidak Sesuai. Bagian Photo Data Diri", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Only *.jpg, *.jpeg, *.png')."'</script>"); 
                                }
                            } else {
                                logerr("Ukuran File Melebihi Jumlah Kapasitas Maximal. Bagian Photo Data Diri", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                die ("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('Maximum 5 MB.')."'</script>"); 
                            }
                        }
                        
                        if(strlen($ACC_F_APP_FILE_IMG) > 0){
                            $s5_6_doc1_sts = -1;
                        }
                        if(strlen($ACC_F_APP_FILE_FOTO) > 0){
                            $s5_6_fotoself_sts = -1;
                        }
                        if(strlen($ACC_F_APP_FILE_ID) > 0){
                            $s5_6_fotoid_sts = -1;
                        }
                        
                        if($s5_6_doc1_sts == -1){
                            if($s5_6_fotoself_sts == -1){
                                if($s5_6_fotoid_sts == -1){
                                    mysqli_query($db, '
                                        UPDATE tb_racc SET
                                            tb_racc.ACC_F_APP = 1,
                                            tb_racc.ACC_F_APP_FILE_TYPE = "'.$type.'",
                                            tb_racc.ACC_F_APP_IP = "'.$IP_ADDRESS.'",
                                            tb_racc.ACC_F_APP_PERYT = "'.$aggree.'",
                                            tb_racc.ACC_F_APP_DATE = "'.date('Y-m-d H:i:s').'"
                                        WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                    ') or die (mysqli_error($db));
                                    die ("<script>location.href = 'home.php?page=racc/disclosure2&id=".$id_live."'</script>");
                                } else {
                                    logerr("Data Diri Belum Terupload", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                    die("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('pastikan untuk mengupload KTP/Passport.')."'</script>"); 
                                }
                            } else {
                                logerr("Photo Selfie Belum Terupload", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                                die("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('pastikan untuk mengupload Foto Terbaru.')."'</script>"); 
                            }
                        } else {
                            logerr("Dokumen Pendukung 1 Belum Terupload", "Aplikasi Pembukaan Rekening Hal-11 (REGOL)", $user1["MBR_ID"]);
                            die("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."&notif=".base64_encode('pastikan untuk mengupload Dokument Pendukung.')."'</script>"); 
                        }
                    };
                } else { die("<script>location.href = 'home.php?page=racc/aplikasipembukaanrekening11&id=".$id_live."'</script>"); };
            };
        };
    };
?>
<div class="page-title page-title-small">
    <h2>Aplikasi Pembukaan Rekening</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>

<?php if(isset($_GET['notif'])){ $notif = base64_decode($_GET['notif']); ?>
    <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert">
        <span class="alert-icon"><i class="fa fa-bell font-18"></i></span>
        <strong class="alert-icon-text"><?php echo $notif; ?>.</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
    </div>
<?php }; ?>
<form method="post" enctype="multipart/form-data">
    <div class="card card-style">
        <div class="card-body">
            <div class="section-title">Upload Foto Diri dengan KTP, Foto KTP, dan Foto NPWP</div>
            <span>Gambar harus jelas dan tidak terpotong, Bad quality photo may lead to long verfication process or rjection. File maksimal 5 MB dengan format Jpeg atau PNG</span>
        </div>
    </div>
    
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
            <div class="text-center"><strong>DOCUMENT PENDUKUNG YANG DI LAMPIRKAN</strong></div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="card card-style mt-2">
        <div class="card-body">
            <strong style="font-size: larger;">Pilih Document Pendukung<span style="color:red;">*)</span></strong>
            <select class="form-control custom-select" id="select4b" required name="idnt_type" style="font-size: 12px;">
                <option disabled selected value>Pilih Salah Satu</option>
                <option <?php if($ACC_F_APP_FILE_TYPE == 'Cover Buku Tabungan'){ echo 'selected'; } ?> value="Cover Buku Tabungan">Cover Buku Tabungan (Recommended)</option>
                <option <?php if($ACC_F_APP_FILE_TYPE == 'Tagihan Kartu Kredit'){ echo 'selected'; } ?> value="Tagihan Kartu Kredit">Tagihan Kartu Kredit</option>
                <option <?php if($ACC_F_APP_FILE_TYPE == 'Tagihan Listrik / Air'){ echo 'selected'; } ?> value="Tagihan Listrik / Air">Tagihan Listrik / Air</option>
                <option <?php if($ACC_F_APP_FILE_TYPE == 'Scan Kartu NPWP'){ echo 'selected'; } ?> value="Scan Kartu NPWP">Scan Kartu NPWP</option>
                <option <?php if($ACC_F_APP_FILE_TYPE == 'Rekening Koran Bank'){ echo 'selected'; } ?> value="Rekening Koran Bank">Rekening Koran Bank</option>
                <option <?php if($ACC_F_APP_FILE_TYPE == 'PBB / BPJS'){ echo 'selected'; } ?> value="PBB / BPJS">PBB / BPJS</option>
                <option <?php if($ACC_F_APP_FILE_TYPE == 'Lainnya'){ echo 'selected'; } ?> value="Lainnya">Lainnya</option>
            </select>
            <hr>
            <div class="input-wrapper mt-3">
                <?php if($ACC_F_APP_FILE_IMG == ''){ ?>
                    <input type="file" id="fileuploadInput1" accept=".png, .jpg, .jpeg" required name="s5_6_doc1">
                <?php } else { ?>
                    <img src="<?php echo FileUpload::aws()->awsFile($ACC_F_APP_FILE_IMG) ?>" width="100%">
                    <hr>
                    <!-- <input type="file" accept=".png, .jpg, .jpeg" name="s5_6_doc1"> -->
                <?php }; ?>
                <small>Hasil Scan (Lampirkan)</small><br>
                <small style="color:red;">Maksimal ukuran file 5 MB.</small><br>
                <small style="color:red;">ext hanya .png, .jpg, .jpeg.</small>
            </div>
        </div>
    </div>
    <div class="card card-style mt-2">
        <div class="card-body">
            <strong style="font-size: larger;">Dokument Pendukung Lainnya</strong>
            <hr>
            <div class="input-wrapper mt-3">
                <?php if($ACC_F_APP_FILE_IMG2 == ''){ ?>
                    <input type="file" id="fileuploadInput1" accept=".png, .jpg, .jpeg" name="s5_6_doc2">
                <?php } else { ?>
                    <img src="<?php echo FileUpload::aws()->awsFile($ACC_F_APP_FILE_IMG2) ?>" width="100%">
                    <hr>
                    <!-- <input type="file" accept=".png, .jpg, .jpeg" name="s5_6_doc2"> -->
                <?php }; ?>
                <small>Hasil Scan (Lampirkan)</small><br>
                <small style="color:red;">Maksimal ukuran file 5 MB.</small><br>
                <small style="color:red;">ext hanya .png, .jpg, .jpeg.</small>
            </div>
        </div>
    </div>
    <div class="card card-style mt-2">
        <div class="card-body">
            <strong style="font-size: larger;">Foto Terbaru<span style="color:red;">*)</span></strong>
            <hr>
            <div class="input-wrapper mt-3">
                <?php if($ACC_F_APP_FILE_FOTO == ''){ ?>
                    <input type="file" id="fileuploadInput1" accept=".png, .jpg, .jpeg" required name="s5_6_fotoself">
                <?php } else { ?>
                    <img src="<?php echo FileUpload::aws()->awsFile($ACC_F_APP_FILE_FOTO) ?>" width="100%">
                    <hr>
                    <!-- <input type="file" accept=".png, .jpg, .jpeg" name="s5_6_fotoself"> -->
                <?php }; ?>
                <small>Hasil Scan (Lampirkan)</small><br>
                <small style="color:red;">Maksimal ukuran file 5 MB.</small><br>
                <small style="color:red;">ext hanya .png, .jpg, .jpeg.</small>
            </div>
        </div>
    </div>
    <div class="card card-style mt-2">
        <div class="card-body">
            <strong style="font-size: larger;">KTP/Passpor<span style="color:red;">*)</span></strong>
            <hr>
            <div class="input-wrapper mt-3">
                <?php if($ACC_F_APP_FILE_ID == ''){ ?>
                    <input type="file" id="fileuploadInput1" accept=".png, .jpg, .jpeg" required name="s5_6_fotoid">
                <?php } else { ?>
                    <img src="<?php echo FileUpload::aws()->awsFile($ACC_F_APP_FILE_ID) ?>" width="100%">
                    <hr>
                    <!-- <input type="file" accept=".png, .jpg, .jpeg" name="s5_6_fotoid"> -->
                <?php }; ?>
                <small>Hasil Scan (Lampirkan)</small><br>
                <small style="color:red;">Maksimal ukuran file 5 MB.</small><br>
                <small style="color:red;">ext hanya .png, .jpg, .jpeg.</small>
            </div>
        </div>
    </div>
    
    <div class="card card-style mt-2">
        <div class="card-body">
            Dengan mengisi KOLOM "YA" di bawah ini, saya menyatakan bahwa semua informasi dan semua dokumen 
            yang saya lampirkan dalam APLIKASI PEMBUKAAN REKENING TRANSAKSI SECARA ELEKTRONIK ONLINE adalah 
            benar dan tepat, saya akan bertanggung jawab penuh apabila dikemudian hari terjadi sesuatu hal 
            sehubungan dengan ketidakbenaran data yang saya berikan.
            
            <div class="row mt-3 mb-3">
                <div class="col-6">
                    Pernyataan Kebenaran dan tanggung jawab<br>
                    <input type="radio" class="form-check-input radio_css" name="aggree" value="Yes" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                    <input type="radio" class="form-check-input radio_css" name="aggree" value="No" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak</label>
                </div>
                <div class="col-6">
                    <label>Menyatakan pada Tanggal</label>
                    <input type="text" readonly required value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control text-center">
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_05">Next</button>
    </div>
</form>
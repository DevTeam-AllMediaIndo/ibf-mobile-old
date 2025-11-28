<?php

require 'vendor/autoload.php';
use Aws\S3\S3Client;
// AWS Info
// $region = 'ap-southeast-1';
// $bucketName = 'allmediaindo-2';
// $folder = 'ibftrader';
// $IAM_KEY = 'AKIASPLPQWHJMMXY2KPR';
// $IAM_SECRET = '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';

$s3 = new Aws\S3\S3Client([
    'region'  => $region,
    'version' => 'latest',
    'credentials' => [
        'key'    => $IAM_KEY,
        'secret' => $IAM_SECRET,
    ]
]);	

$id_live = $_GET['id'];

$newfilename1 = round(microtime(true));
$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");

    if(isset($_POST['dp_submit'])){
        if(isset($_POST['id']) && isset($_POST['amount']) && isset($_POST['bank']) && isset($_POST['bank_option'])){
            $SQL_FND = mysqli_query($db,'
                SELECT
                    tb_racc.ACC_RATE,
                    tb_racc.ACC_CURR
                FROM tb_racc
                WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                LIMIT 1
            ');
            if(mysqli_num_rows($SQL_FND) > 0){
                $RSLT_FND = mysqli_fetch_assoc($SQL_FND);
                if($RSLT_FND['ACC_RATE'] == 0){ $rate = 10000;} else {$rate = $RSLT_FND['ACC_RATE'];}
            }
            
            if($RSLT_FND['ACC_RATE'] == 0){
                $curr_idr = 0;
                $curr = number_format($amount, 2);
                $curr_lg = 'USD';
                $curr_ag = '$';
            }else{
                $curr_idr = number_format($amount, 0);
                $curr = number_format($amount, 0);
                $curr_lg = 'IDR';
                $curr_ag = 'Rp.';
            }
            
            $id = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['id']))));
            $amount = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['amount']))));
            $bank = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['bank']))));
            $bank_option = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['bank_option']))));
            $amount = str_replace(' ', '', $amount);
            $amount = str_replace((($RSLT_FND["ACC_CURR"] == 'IDR') ? 'Rp.' : '$'), '', $amount);
            $amount = str_replace('.', '', $amount);
            $amount = round($amount, 0);
            if($amount >= 10000){
                if(strtolower($bank_option) == 'bank 1'){
                    $DPWD_BANKSRC = 1;
                } else {
                    $DPWD_BANKSRC = 2;
                }
                if(isset($_FILES["dps_proof"]) && $_FILES["dps_proof"]["error"] == 0){

                    $newfilename1 = round(microtime(true));

                    $s5_6_doc1_name = $_FILES["dps_proof"]["name"];
                    $s5_6_doc1_type = $_FILES["dps_proof"]["type"];
                    
                    $s5_6_doc1_ext = pathinfo($s5_6_doc1_name, PATHINFO_EXTENSION);
                    if(array_key_exists($s5_6_doc1_ext, $allowed)){
                        if(in_array($s5_6_doc1_type, $allowed)){
                            $s5_6_doc1_new = 'dpsnew_'.$user1['MBR_ID'].'_'.round(microtime(true)).'.'.$s5_6_doc1_ext;
                            if(move_uploaded_file($_FILES["dps_proof"]["tmp_name"], "upload/" . $s5_6_doc1_new)){
                                $s5_6_doc1_Path = 'upload/'. $s5_6_doc1_new;
                                $s5_6_doc1_key = basename($s5_6_doc1_Path);
                                
                                try {
                                    $result = $s3->putObject([
                                        'Bucket' => $bucketName,
                                        'Key'    => $folder.'/'.$s5_6_doc1_key,
                                        'Body'   => fopen($s5_6_doc1_Path, 'r'),
                                        'ACL'    => 'public-read', // make file 'public'
                                    ]);
                                    mysqli_query($db, '
                                        INSERT INTO tb_dpwd SET
                                        tb_dpwd.DPWD_MBR = '.$user1['MBR_ID'].',
                                        tb_dpwd.DPWD_TYPE = 1,
                                        tb_dpwd.DPWD_DEVICE = "Mobile",
                                        tb_dpwd.DPWD_BANKSRC = '.$DPWD_BANKSRC.',
                                        tb_dpwd.DPWD_BANK = '.$bank.',
                                        tb_dpwd.DPWD_RACC = (SELECT ID_ACC FROM tb_racc WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'" LIMIT 1),
                                        tb_dpwd.DPWD_AMOUNT = '.$amount.',
                                        tb_dpwd.DPWD_NOTE = "Deposit New Account",
                                        tb_dpwd.DPWD_PIC = "'.$s5_6_doc1_new.'",
                                        tb_dpwd.DPWD_DATETIME = "'.date('Y-m-d H:i:s').'",
                                        tb_dpwd.DPWD_TIMESTAMP = "'.date('Y-m-d H:i:s').'"
                                    ') or die (mysqli_error($db));

                                    mysqli_query($db, '
                                        UPDATE tb_racc SET
                                        tb_racc.ACC_WPCHECK = 2
                                        WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                                    ') or die (mysqli_error($db));

                                    // Message Telegram
                                    $mesg = 'Notif : Deposit Akun Baru '.
                                    PHP_EOL.'Date : '.date("Y-m-d").
                                    PHP_EOL.'Time : '.date("H:i:s");
                                    // PHP_EOL.'======== Informasi Deposit Akun Baru =========='.
                                    // PHP_EOL.'Nama : '.$user1['MBR_NAME'].
                                    // PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                                    // PHP_EOL.'Jumlah : '.$curr_ag.' '.$curr.
                                    // PHP_EOL.'Status : Pending';

                                    // Message Telegram
                                    $mesg_othr = 'Notif : Deposit Akun Baru '.
                                    PHP_EOL.'Date : '.date("Y-m-d").
                                    PHP_EOL.'Time : '.date("H:i:s").
                                    PHP_EOL.'=========================================='.
                                    PHP_EOL.'                     Informasi Deposit Akun Baru'.
                                    PHP_EOL.'=========================================='.
                                    PHP_EOL.'Nama : '.$user1['MBR_NAME'].
                                    PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                                    PHP_EOL.'Jumlah : '.$curr_ag.' '.$curr.
                                    PHP_EOL.'Status : Pending';

                                    $request_params = [
                                        'chat_id' => $chat_id,
                                        'text' => $mesg_othr
                                    ];
                                    http_request('https://api.telegram.org/bot'.$token1.'/sendMessage?'.http_build_query($request_params));
                                    
                                    $request_params_all = [
                                        'chat_id' => $chat_id_all,
                                        'text' => $mesg
                                    ];
                                    http_request('https://api.telegram.org/bot'.$token_all.'/sendMessage?'.http_build_query($request_params_all));
                                            
                                    $request_params_othr = [
                                        'chat_id' => $chat_id_othr,
                                        'text' => $mesg_othr
                                    ];
                                    http_request('https://api.telegram.org/bot'.$token_othr.'/sendMessage?'.http_build_query($request_params_othr));

                                    insert_log($user1['MBR_ID'], 'Deposit New Account');
                                    unlink($s5_6_doc1_Path);
                                    die ("<script>location.href = 'home.php?page=account'</script>");
                                } catch (Aws\S3\Exception\S3Exception $e) {
                                    die ("<script>location.href = 'home.php?page=racc/deposit&id=".$id_live."&notif=".base64_encode('There was an error uploading the file.')."'</script>");
                                };
                            } else {
                                logerr("Folder Tidak Ditemukan", "Deposit New Account", $user1["MBR_ID"]);
                                die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('File is not uploaded.')."'</script>"); 
                            };
                        } else {
                            logerr("Type File Tidak Sesuai", "Deposit New Account", $user1["MBR_ID"]);
                            die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Error: There was a problem uploading your file. Please try again.')."'</script>"); 
                        };
                    } else {
                        logerr("Extensi File Tidak Sesuai", "Deposit New Account", $user1["MBR_ID"]);
                        die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Only *.jpg, *.jpeg, *.png')."'</script>"); 
                    };
                } else {
                    logerr("File Tidak Dapta Di Baca", "Deposit New Account", $user1["MBR_ID"]);
                    die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('File Tidak Dapat Di Baca')."'</script>"); 
                };
            } else {
                logerr("Nilai Inputan Kurang Dari Nilai Minimal", "Deposit New Account", $user1["MBR_ID"]);
                die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Perhatikan nilai deposit')."'</script>"); 
            };
        } else {
            logerr("Parameter Ke-1 Tidak Lengkap", "Deposit New Account", $user1["MBR_ID"]);
            die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter Ke-1 Tidak Lengkap')."'</script>"); 
        };
    };

    $SQL_QUERY = mysqli_query($db,'
        SELECT
            tb_racc.ACC_F_APP_BK_1_NAMA,
            tb_racc.ACC_F_APP_BK_1_CBNG,
            tb_racc.ACC_F_APP_BK_1_ACC,
            tb_racc.ACC_F_APP_BK_1_TLP,
            tb_racc.ACC_F_APP_BK_1_JENIS,
            tb_racc.ACC_F_APP_BK_2_NAMA,
            tb_racc.ACC_CURR,
            tb_racc.ACC_F_APP_BK_2_CBNG,
            IF(tb_racc.ACC_F_APP_BK_2_ACC = "", "-", tb_racc.ACC_F_APP_BK_2_ACC) AS ACC_F_APP_BK_2_ACC,
            tb_racc.ACC_F_APP_BK_2_TLP,
            tb_racc.ACC_F_APP_BK_2_JENIS
        FROM tb_racc
        WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
        LIMIT 1
    ') or die(mysqli_error($db));
    if(mysqli_num_rows($SQL_QUERY) > 0){
        $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
        $ACC_CURR = $RESULT_QUERY['ACC_CURR'];
        if($ACC_CURR == 'IDR'){
            $ACC_CURR1 = 'Rp.';
            $ACC_CURR2 = 'rupiah';
        } else {
            $ACC_CURR1 = '$.';
            $ACC_CURR2 = 'dollar';
        }
        $ACC_F_APP_BK_1_NAMA = $RESULT_QUERY['ACC_F_APP_BK_1_NAMA'];
        $ACC_F_APP_BK_1_CBNG = $RESULT_QUERY['ACC_F_APP_BK_1_CBNG'];
        $ACC_F_APP_BK_1_ACC = $RESULT_QUERY['ACC_F_APP_BK_1_ACC'];
        $ACC_F_APP_BK_1_TLP = $RESULT_QUERY['ACC_F_APP_BK_1_TLP'];
        $ACC_F_APP_BK_1_JENIS = $RESULT_QUERY['ACC_F_APP_BK_1_JENIS'];
        $ACC_F_APP_BK_2_NAMA = $RESULT_QUERY['ACC_F_APP_BK_2_NAMA'];
        $ACC_F_APP_BK_2_CBNG = $RESULT_QUERY['ACC_F_APP_BK_2_CBNG'];
        $ACC_F_APP_BK_2_ACC = $RESULT_QUERY['ACC_F_APP_BK_2_ACC'];
        $ACC_F_APP_BK_2_TLP = $RESULT_QUERY['ACC_F_APP_BK_2_TLP'];
        $ACC_F_APP_BK_2_JENIS = $RESULT_QUERY['ACC_F_APP_BK_2_JENIS'];
    }else{
        $ACC_F_APP_BK_1_NAMA = '-';
        $ACC_F_APP_BK_1_CBNG = '-';
        $ACC_F_APP_BK_1_ACC = '-';
        $ACC_F_APP_BK_1_TLP = '-';
        $ACC_F_APP_BK_1_JENIS = '-';
        $ACC_F_APP_BK_2_NAMA = '-';
        $ACC_F_APP_BK_2_CBNG = '-';
        $ACC_F_APP_BK_2_ACC = '-';
        $ACC_F_APP_BK_2_TLP = '-';
        $ACC_F_APP_BK_2_JENIS = '-';
        $ACC_CURR = 'IDR';
        $ACC_CURR1 = 'Rp.';
        $ACC_CURR2 = 'rupiah';
    };
?>
<div class="page-title page-title-small">
    <h2>Deposit New Account</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>

<!-- <div class="alert me-3 ms-3 rounded-s bg-yellow-dark" role="alert">
    <h4 class="text-uppercase color-white">Pemberitahuan</h4>
    <strong class=""><br>Top up yang melebihi jam operasional (08.00 s/d 17.00) WIB, dan tidak bisa di konfirmasi oleh Wakil Pialang PT.IBF akan di proses di hari kerja berikutnya.</strong>
    <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
</div> -->

<form method="post" enctype="multipart/form-data">
    <div class="card card-style">
        <div class="content">
            <h4>Bank Pengirim</h4>
            <hr>
            <div class="input-wrapper">
                <label class="label" for="text4b">Bank Option</label>
                <select class="form-control" id="bank_option" name="bank_option" onchange="change_bank()" required>
                    <option value="Bank 1">Bank 1</option>
                    <?php if($ACC_F_APP_BK_2_ACC <> '-'){ ?>
                        <option value="Bank 2">Bank 2</option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-wrapper">
                <label class="label" for="text4b">Nama Bank</label>
                <input type="text" class="form-control" id="ACC_F_APP_BK_NAMA" value="<?php echo $ACC_F_APP_BK_1_NAMA ?>" readonly required>
            </div>
            <div class="input-wrapper mt-2">
                <label class="label" for="text4b">Nama Pemilik</label>
                <input type="text" class="form-control" value="<?php echo $user1['MBR_NAME'] ?>" readonly required>
            </div>
            <div class="row" style="margin-bottom: unset;">
                <div class="col-6">
                    <div class="input-wrapper mt-2">
                        <label class="label" for="text4b">Cabang Bank</label>
                        <input type="text" class="form-control" id="ACC_F_APP_BK_CBNG" value="<?php echo $ACC_F_APP_BK_1_CBNG ?>" readonly required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-wrapper mt-2">
                        <label class="label" for="text4b">Bank Rekening</label>
                        <input type="text" class="form-control" id="ACC_F_APP_BK_ACC" value="<?php echo $ACC_F_APP_BK_1_ACC ?>" readonly required>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: unset;">
                <div class="col-6">
                    <div class="input-wrapper mt-2">
                        <label class="label" for="text4b">Phone Number</label>
                        <input type="text" class="form-control" id="ACC_F_APP_BK_TLP" value="<?php echo $ACC_F_APP_BK_1_TLP ?>" readonly required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-wrapper mt-2">
                        <label class="label" for="text4b">Jenis Tabungan</label>
                        <input type="text" class="form-control" id="ACC_F_APP_BK_JENIS" value="<?php echo $ACC_F_APP_BK_1_JENIS ?>" readonly required>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    function change_bank(){
        if(document.getElementById('bank_option').value == 'Bank 1'){
            document.getElementById('ACC_F_APP_BK_NAMA').value = '<?php echo $ACC_F_APP_BK_1_NAMA; ?>';
            document.getElementById('ACC_F_APP_BK_CBNG').value = '<?php echo $ACC_F_APP_BK_1_CBNG; ?>';
            document.getElementById('ACC_F_APP_BK_ACC').value = '<?php echo $ACC_F_APP_BK_1_ACC; ?>';
            document.getElementById('ACC_F_APP_BK_TLP').value = '<?php echo $ACC_F_APP_BK_1_TLP; ?>';
            document.getElementById('ACC_F_APP_BK_JENIS').value = '<?php echo $ACC_F_APP_BK_1_JENIS; ?>';
            console.log('bank 1');
        } else if(document.getElementById('bank_option').value == 'Bank 2'){
            document.getElementById('ACC_F_APP_BK_NAMA').value = '<?php echo $ACC_F_APP_BK_2_NAMA; ?>';
            document.getElementById('ACC_F_APP_BK_CBNG').value = '<?php echo $ACC_F_APP_BK_2_CBNG; ?>';
            document.getElementById('ACC_F_APP_BK_ACC').value = '<?php echo $ACC_F_APP_BK_2_ACC; ?>';
            document.getElementById('ACC_F_APP_BK_TLP').value = '<?php echo $ACC_F_APP_BK_2_TLP; ?>';
            document.getElementById('ACC_F_APP_BK_JENIS').value = '<?php echo $ACC_F_APP_BK_2_JENIS; ?>';
            console.log('bank 2');
        }
    }
</script>
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <div class="card card-style">
        <div class="content">
            <h4>Bank Penerima</h4>
            <hr>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label class="label" for="text4b">Bank Holder</label>
                    <input type="text" class="form-control" value="PT. INTERNATIONAL BUSINESS FUTURES" readonly required>
                </div>
                <div class="input-wrapper mt-2">
                    <label class="label" for="text4b">Bank Destination</label>
                    <select class="form-control" name="bank" required>
                        <option disabled>Destination</option>
                        <?php
                            $SQL_QUERY = mysqli_query($db, "
                                SELECT 
                                    tb_bankadm.ID_BKADM,
                                    tb_bankadm.BKADM_CURR,
                                    tb_bankadm.BKADM_NAME,
                                    tb_bankadm.BKADM_HOLDER,
                                    tb_bankadm.BKADM_ACCOUNT
                                FROM tb_bankadm
                            ");
                            if(mysqli_num_rows($SQL_QUERY) > 0) {
                                while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)) {
                        ?>
                        <option value="<?php echo $RESULT_QUERY['ID_BKADM'] ?>"><?php echo $RESULT_QUERY['BKADM_NAME'].' / '.$RESULT_QUERY['BKADM_CURR'].' / '.$RESULT_QUERY['BKADM_ACCOUNT'] ?></option>
                        <?php };}; ?>
                    </select>
                </div>
                <div class="input-wrapper mt-2">
                    <label class="label" for="text4b">Enter Amount deposit</label>
                    <input type="text" class="form-control" name="amount" id="rupiah" required>
                </div>
                <div class="input-wrapper mt-2">
                    <label class="label" for="text4b">Image</label>
                    <input type="file" class="form-control" name="dps_proof" accept=".png, .jpg, .jpeg" required>
                    <ul>
                        <li>Dokumen akan menyertakan bukti pembayaran, dan hanya dapat diberikan dalam format jpg dan png..</li>
                        <li>Ukuran gambar yang disarankan adalah 600x500 piksel.</li>
                        <li>Maximal 5 MB.</li>
                    </ul>
                </div>
                <hr>
                <ul style="color:red">
                    <li>Nama penyetor harus sesuai dengan nama akun yang terdaftar.</li>
                    <li>Transfer selain dari bank konvensional dan Syariah seperti Bank Digital tidak akan di proses.</li>
                    <li>Setoran dana dari pihak ketiga tidak dapat di proses.</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <button type="submit" name="dp_submit" class="btn btn-lg btn-primary btn-block">Deposit Sekarang</button>
    </div>
</form>

<script>
    /* Fungsi formatRupiah */
    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value, '<?php echo $ACC_CURR1 ?> ');
    });
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '<?php echo $ACC_CURR1 ?> ' + rupiah : '');
    }
</script>
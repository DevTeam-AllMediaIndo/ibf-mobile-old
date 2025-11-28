


<?php

require 'vendor/autoload.php';
use Aws\S3\S3Client;
// AWS Info
$region = 'ap-southeast-1';
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
$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");

    if(isset($_POST['dp_submit'])){
        if(isset($_POST['bank_option'])){
            if(isset($_POST['login']) && isset($_POST['amount']) && isset($_POST['bank'])){
                $login = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['login']))));
                $amount = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['amount']))));
                $bank = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['bank']))));
                $bank_option = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['bank_option']))));
                $amount = str_replace(' ', '', $amount);
                $amount = str_replace('Rp.', '', $amount);
                $amount = str_replace('.', '', $amount);
                $SQL_FND = mysqli_query($db,'
                    SELECT
                        tb_racc.ACC_RATE
                    FROM tb_racc
                    WHERE ACC_LOGIN = "'.$login.'" 
                    AND ACC_MBR = '.$user1['MBR_ID'].' 
                    LIMIT 1
                ');
                if(mysqli_num_rows($SQL_FND) > 0){
                    $RSLT_FND = mysqli_fetch_assoc($SQL_FND);
                    if($RSLT_FND['ACC_RATE'] == 0){ $rate = 10000;} else {$rate = $RSLT_FND['ACC_RATE'];}
                }
                if($RSLT_FND['ACC_RATE'] == '0'){
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
                if($bank_option == 'Bank 1'){
                    $DPWD_BANKSRC = 1;
                } else {
                    $DPWD_BANKSRC = 2;
                }
                $SQL_CHECK = mysqli_query($db,'
                    SELECT 
                        COUNT(tb_dpwd.DPWD_STS) AS TOTAL,
                        (
                            SELECT 
                                tb_racc.ACC_F_APP_PRIBADI_NAMA
                            FROM tb_racc 
                            WHERE ACC_LOGIN = "'.$login.'" 
                            AND ACC_MBR = '.$user1["MBR_ID"].' 
                            LIMIT 1
                        ) AS NME
                    FROM tb_dpwd
                    WHERE tb_dpwd.DPWD_MBR = '.$user1["MBR_ID"].'
                    AND tb_dpwd.DPWD_LOGIN = (SELECT ID_ACC FROM tb_racc WHERE ACC_LOGIN = "'.$login.'" AND ACC_MBR = '.$user1['MBR_ID'].' LIMIT 1)
                    #AND tb_dpwd.DPWD_NOTE <> "Deposit New Account"
                    AND tb_dpwd.DPWD_TYPE = 1
                    AND tb_dpwd.DPWD_STS = 0
                ');
                $RESULT_ASC = mysqli_fetch_assoc($SQL_CHECK);
                if($RESULT_ASC["TOTAL"] > 0){
                    logerr("Masih Ada Pending Deposit", "Deposit", $user1["MBR_ID"]);
                    die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Request Deposit Anda Sebelumnya Masih Belum Di Setujui.')."'</script>");
                } else {
                    if($amount > 100){
                        if(isset($_FILES["dps_proof"]) && $_FILES["dps_proof"]["error"] == 0){
        
                            $newfilename1 = round(microtime(true));
        
                            $s5_6_doc1_name = $_FILES["dps_proof"]["name"];
                            $s5_6_doc1_type = $_FILES["dps_proof"]["type"];
                            
                            $s5_6_doc1_ext = pathinfo($s5_6_doc1_name, PATHINFO_EXTENSION);
                            if(array_key_exists($s5_6_doc1_ext, $allowed)){
                                if(in_array($s5_6_doc1_type, $allowed)){
                                    $s5_6_doc1_new = 'dps_'.$user1['MBR_ID'].'_'.round(microtime(true)).'.'.$s5_6_doc1_ext;
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
                                                tb_dpwd.DPWD_LOGIN = (SELECT ID_ACC FROM tb_racc WHERE ACC_LOGIN = "'.$login.'" AND ACC_MBR = '.$user1['MBR_ID'].' LIMIT 1),
                                                tb_dpwd.DPWD_AMOUNT = '.$amount.',
                                                tb_dpwd.DPWD_PIC = "'.$s5_6_doc1_new.'",
                                                tb_dpwd.DPWD_DATETIME = "'.date('Y-m-d H:i:s').'"
                                            ') or die (mysqli_error($db));

                                            // Message Telegram
                                            $mesg = 'Notif : Deposit'.
                                            PHP_EOL.'Date : '.date("Y-m-d").
                                            PHP_EOL.'Time : '.date("H:i:s");
                                            // PHP_EOL.'======== Informasi Deposit =========='.
                                            // PHP_EOL.'Nama : '.$user1['MBR_NAME'].
                                            // PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                                            // PHP_EOL.'Login : '.$login.
                                            // PHP_EOL.'Ammount : '.$curr_ag.' '.$curr.
                                            // PHP_EOL.'Status : Pending';

                                            // Message Telegram
                                            $mesg_othr = 'Notif : Deposit'.
                                            PHP_EOL.'Date : '.date("Y-m-d").
                                            PHP_EOL.'Time : '.date("H:i:s").
                                            PHP_EOL.'============================='.
                                            PHP_EOL.'               Informasi Deposit'.
                                            PHP_EOL.'============================='.
                                            PHP_EOL.'Nama : '.$RESULT_ASC["NME"].
                                            PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                                            PHP_EOL.'Login : '.$login.
                                            PHP_EOL.'Ammount : '.$curr_ag.' '.$curr.
                                            PHP_EOL.'Status : Pending';

                                            $request_params_wpb = [
                                                'chat_id' => $chat_id,
                                                'text' => $mesg_othr
                                            ];
                                            http_request('https://api.telegram.org/bot'.$token1.'/sendMessage?'.http_build_query($request_params_wpb));

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
                            
        
                                            insert_log($user1['MBR_ID'], 'Top Up Account '.$login);
                                            unlink($s5_6_doc1_Path);
                                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Success Upload Bukti Deposit.')."'</script>");
                                        } catch (Aws\S3\Exception\S3Exception $e) {
                                            die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('There was an error uploading the file.')."'</script>");
                                        };
                                    } else { 
                                        logerr("Folder Tidak Di Temukan", "Deposit", $user1["MBR_ID"]);
                                        die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('file tidak terupload, silahkan ulangi lagi')."'</script>"); 
                                    };
                                } else { 
                                    logerr("Type File Tidak Sesuai", "Deposit", $user1["MBR_ID"]);
                                    die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('file hanya jpg, png, jpeg')."'</script>"); 
                                };
                            } else { 
                                logerr("Extensi File Tidak Sesuai", "Deposit", $user1["MBR_ID"]);
                                die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('file hanya jpg, png, jpeg')."'</script>"); 
                            };
                        } else { 
                            logerr("File Tidak Bisa Dibaca", "Deposit", $user1["MBR_ID"]);
                            die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('sertakan bukti upload')."'</script>"); 
                        };
                    } else { 
                        logerr("Jumlah Inputan Kurang Dari Nilai Minimal", "Deposit", $user1["MBR_ID"]);
                        die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('minimal top up 10.000')."'</script>"); 
                    };
                };

                
            } else { 
                logerr("Parameter Ke-2 Tidak Lengkap", "Deposit", $user1["MBR_ID"]);
                die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Errno1')."'</script>"); 
            };
        } else { 
            logerr("Parameter Ke-1 Tidak Lengkap", "Deposit", $user1["MBR_ID"]);
            die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Errno2')."'</script>"); 
        };
    };
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        // if(isset($_POST['wd_submit'])){
            if(isset($_POST['login'])){
                if(isset($_POST['amountwd'])){
                    if(isset($_POST['bank_option'])){
                        $login = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['login']))));
                        $bank_option = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['bank_option']))));
                        $amountwd = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['amountwd']))));
                        $note = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['note']))));
                        $amountwd = str_replace(' ', '', $amountwd);
                        $amountwd = str_replace('Rp.', '', $amountwd);
                        $amountwd = str_replace('.', '', $amountwd);
                        $SQL_FND = mysqli_query($db,'
                            SELECT
                                tb_racc.ACC_RATE
                            FROM tb_racc
                            WHERE ACC_LOGIN = "'.$login.'" 
                            AND ACC_MBR = '.$user1['MBR_ID'].' 
                            LIMIT 1
                        ');
                        if(mysqli_num_rows($SQL_FND) > 0){
                            $RSLT_FND = mysqli_fetch_assoc($SQL_FND);
                            if($RSLT_FND['ACC_RATE'] == 0){ $rate = 10000;} else {$rate = $RSLT_FND['ACC_RATE'];}
                        }
                        if($RSLT_FND['ACC_RATE'] == '0'){
                            $curr_idr = 0;
                            $curr = number_format($amountwd, 2);
                            $curr_lg = 'USD';
                            $curr_ag = '$';
                        }else{
                            $curr_idr = number_format($amountwd, 0);
                            $curr = number_format($amountwd, 0);
                            $curr_lg = 'IDR';
                            $curr_ag = 'Rp.';
                        }

                        $SQL_CHECK = mysqli_query($db,'
                            SELECT COUNT(tb_dpwd.DPWD_STS) AS TOTAL
                            FROM tb_dpwd
                            WHERE tb_dpwd.DPWD_MBR = '.$user1["MBR_ID"].'
                            AND tb_dpwd.DPWD_LOGIN = (SELECT ID_ACC FROM tb_racc WHERE ACC_LOGIN = "'.$login.'" AND ACC_MBR = '.$user1['MBR_ID'].' LIMIT 1)
                            AND tb_dpwd.DPWD_TYPE = 2
                            AND tb_dpwd.DPWD_STS = 0
                        ');
                        $RESULT_ASC = mysqli_fetch_assoc($SQL_CHECK);
                        if($RESULT_ASC["TOTAL"] > 0){
                            die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Request Withdrawal Anda Sebelumnya Masih Belum Di Setujui.')."'</script>");
                        } else {
                            if($amountwd > 10000){

                                $SQL_QUERY = mysqli_query($db, '
                                    SELECT 
                                        tb_racc.ID_ACC,
                                        tb_racc.ACC_F_APP_BK_1_ACC,
                                        tb_racc.ACC_F_APP_BK_2_ACC,
                                        tb_racc.ACC_F_APP_PRIBADI_NAMA,
                                        tb_ib.IB_NAME,
                                        tb_ib.IB_CITY
                                    FROM tb_racc 
                                    JOIN tb_acccond
                                    JOIN tb_ib
                                    ON(tb_racc.ACC_LOGIN = tb_acccond.ACCCND_LOGIN
                                    AND tb_acccond.ACCCND_IB = tb_ib.IB_ID)
                                    WHERE ACC_LOGIN = "'.$login.'" AND ACC_MBR = '.$user1['MBR_ID'].' 
                                    LIMIT 1    
                                ');
                                if(mysqli_num_rows($SQL_QUERY) > 0) {
                                    $SQL_RSLT = mysqli_fetch_assoc($SQL_QUERY);
                                    if($bank_option == 'Bank 1'){
                                        $DPWD_BANKSRC = 1;
                                        $BK_ACC = $SQL_RSLT["ACC_F_APP_BK_1_ACC"];
                                    } else {
                                        $DPWD_BANKSRC = 2;
                                        $BK_ACC = $SQL_RSLT["ACC_F_APP_BK_2_ACC"];
                                    }
                                    mysqli_query($db, '
                                        INSERT INTO tb_dpwd SET
                                        tb_dpwd.DPWD_MBR = '.$user1['MBR_ID'].',
                                        tb_dpwd.DPWD_STSACC = -1,
                                        tb_dpwd.DPWD_TYPE = 2,
                                        tb_dpwd.DPWD_BANKSRC = '.$DPWD_BANKSRC.',
                                        tb_dpwd.DPWD_DEVICE = "Mobile",
                                        tb_dpwd.DPWD_LOGIN = (SELECT ID_ACC FROM tb_racc WHERE ACC_LOGIN = "'.$login.'" AND ACC_MBR = '.$user1['MBR_ID'].' LIMIT 1),
                                        tb_dpwd.DPWD_AMOUNT = '.$amountwd.',
                                        tb_dpwd.DPWD_NOTE = "'.$note.'",
                                        tb_dpwd.DPWD_DATETIME = "'.date('Y-m-d H:i:s').'"
                                    ') or die(mysqli_error($db));

                                    // Message Telegram
                                    $mesg = 'Notif : Withdarawal'.
                                    PHP_EOL.'Date : '.date("Y-m-d").
                                    PHP_EOL.'Time : '.date("H:i:s");
                                    // PHP_EOL.'======== Informasi Withdarawal =========='.
                                    // PHP_EOL.'Nama : '.$user1['MBR_NAME'].
                                    // PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                                    // PHP_EOL.'Login : '.$login.
                                    // PHP_EOL.'Ammount : '.$curr_ag.' '.$curr.
                                    // PHP_EOL.'Status : Pending';

                                    // Message Telegram
                                    $mesg_othr = 'Notif : Withdarawal'.
                                    PHP_EOL.'Date : '.date("Y-m-d").
                                    PHP_EOL.'Time : '.date("H:i:s").
                                    PHP_EOL.'=================================='.
                                    PHP_EOL.'                 Informasi Withdarawal'.
                                    PHP_EOL.'=================================='.
                                    PHP_EOL.'Nama : '.$SQL_RSLT["ACC_F_APP_PRIBADI_NAMA"].
                                    PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                                    PHP_EOL.'IB : '.$SQL_RSLT["IB_NAME"]. ' ('.$SQL_RSLT["IB_CITY"].')'.
                                    PHP_EOL.'Login : '.$login.
                                    PHP_EOL.'Ammount : '.$curr_ag.' '.$curr.
                                    PHP_EOL.'Bank Account : '.$BK_ACC.
                                    PHP_EOL.'Status : Pending';

                                    $request_params_stlmnt = [
                                        'chat_id' => $chat_id_stllmnt,
                                        'text' => $mesg
                                    ];
                                    http_request('https://api.telegram.org/bot'.$token_stllmnt.'/sendMessage?'.http_build_query($request_params_stlmnt));

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
                                    insert_log($user1['MBR_ID'], 'Withdrawal Account '.$login);
                                    die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Success Withdrawal.')."'</script>");
            
                                } else {
                                    logerr("Akun Tidak Ditemukan", "Withdrawal", $user1["MBR_ID"]);
                                    die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Please select account.')."'</script>"); 
                                }
                            } else {
                                logerr("Jumlah Inputan Kurang Dari Nilai Minimal", "Withdrawal", $user1["MBR_ID"]);
                                die("<script>location.href = 'home.php?page=account&notif=".base64_encode('Jumlah Inputan Kurang Dari Nilai Minimal.')."'</script>"); 
                            }
                        };
                    }else {
                        logerr("Parameter Ke-3 Tidak Lengkap", "Withdrawal", $user1["MBR_ID"]);
                        die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Please try again3.')."'</script>"); 
                    }
                } else {
                    logerr("Parameter Ke-2 Tidak Lengkap", "Withdrawal", $user1["MBR_ID"]);
                    die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Please try again2.')."'</script>"); 
                }
            } else {
                logerr("Parameter Ke-1 Tidak Lengkap", "Withdrawal", $user1["MBR_ID"]);
                die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Please try again.')."'</script>"); 
            }
        // };
    };
    $id_live = $_GET['login'];
    
    $SQL_QUERY = mysqli_query($db,'
        SELECT
            tb_racc.ACC_F_APP_BK_1_NAMA,
            tb_racc.ACC_F_APP_BK_1_CBNG,
            tb_racc.ACC_F_APP_BK_1_ACC,
            tb_racc.ACC_F_APP_BK_1_TLP,
            tb_racc.ACC_F_APP_BK_1_JENIS,
            tb_racc.ACC_F_APP_BK_2_NAMA,
            tb_racc.ACC_F_APP_BK_2_CBNG,
            IF(tb_racc.ACC_F_APP_BK_2_ACC = "", "-", tb_racc.ACC_F_APP_BK_2_ACC) AS ACC_F_APP_BK_2_ACC,
            tb_racc.ACC_F_APP_BK_2_TLP,
            tb_racc.ACC_F_APP_BK_2_JENIS
        FROM tb_racc
        WHERE ((tb_racc.ACC_LOGIN)) = "'.$id_live.'"
        LIMIT 1
    ') or die(mysqli_error($db));
    if(mysqli_num_rows($SQL_QUERY) > 0){
        $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
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
    };

    if(isset($_GET['x'])){
        $x = form_input($_GET["x"]);
    }
    if(isset($_GET['action'])){
        if(isset($_GET['login'])){
            $action = form_input($_GET["action"]);
            $login = form_input($_GET["login"]);
            
            if($action == 'deposit'){
?>
<form method="post" enctype="multipart/form-data" id="frm">
    <div class="page-title page-title-small">
        <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Top Up</h2>
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
    <div class="card card-style">
        <div class="content">
            <h4>Bank Pengirim</h4>
            <hr>
            <div class="input-wrapper">
                <label class="label" for="text4b">Bank Option</label>
                <select class="form-control" id="bank_option" name="bank_option" onchange="change_bank()" required>
                    <option>Bank 1</option>
                    <?php if($ACC_F_APP_BK_2_ACC <> '-'){ ?>
                        <option>Bank 2</option>
                    <?php } ?>
                </select>
            </div>
            <script>
                function change_bank(){
                    if(document.getElementById('bank_option').value == 'Bank 1'){
                        document.getElementById('ACC_F_APP_BK_NAMA').value = '<?php echo $ACC_F_APP_BK_1_NAMA; ?>';
                        document.getElementById('ACC_F_APP_BK_CBNG').value = '<?php echo $ACC_F_APP_BK_1_CBNG; ?>';
                        document.getElementById('ACC_F_APP_BK_ACC').value = '<?php echo $ACC_F_APP_BK_1_ACC; ?>';
                        document.getElementById('ACC_F_APP_BK_TLP').value = '<?php echo $ACC_F_APP_BK_1_TLP; ?>';
                        document.getElementById('ACC_F_APP_BK_JENIS').value = '<?php echo $ACC_F_APP_BK_1_JENIS; ?>';
                    } else if(document.getElementById('bank_option').value == 'Bank 2'){
                        document.getElementById('ACC_F_APP_BK_NAMA').value = '<?php echo $ACC_F_APP_BK_2_NAMA; ?>';
                        document.getElementById('ACC_F_APP_BK_CBNG').value = '<?php echo $ACC_F_APP_BK_2_CBNG; ?>';
                        document.getElementById('ACC_F_APP_BK_ACC').value = '<?php echo $ACC_F_APP_BK_2_ACC; ?>';
                        document.getElementById('ACC_F_APP_BK_TLP').value = '<?php echo $ACC_F_APP_BK_2_TLP; ?>';
                        document.getElementById('ACC_F_APP_BK_JENIS').value = '<?php echo $ACC_F_APP_BK_2_JENIS; ?>';
                    }
                }
            </script>
            <div class="input-wrapper">
                <label class="label" for="text4b">Nama Bank</label>
                <input type="text" class="form-control" id="ACC_F_APP_BK_NAMA" value="<?php echo $ACC_F_APP_BK_1_NAMA ?>" readonly required>
            </div>
            <div class="input-wrapper mt-2">
                <label class="label" for="text4b">Nama Pemilik</label>
                <input type="text" class="form-control" id="" value="<?php echo $user1['MBR_NAME'] ?>" readonly required>
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

    <div class="card card-style">
        <div class="content">
            <h4>Bank Penerima</h4>
            <input type="hidden" value="<?php echo $login ?>" name="login" required>
            <hr>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <label class="label" for="text4b">MetaTrader Account Number</label>
                    <input type="text" class="form-control" value="<?php echo $login ?>" readonly required>
                </div>
                <div class="input-wrapper mt-2">
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
                        <li>Maximal 100kb.</li>
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
        <input type="hidden" name="dp_submit" value="1">
        <input type="submit" class="btn btn-m rounded-sm btn-full shadow-l bg-success text-uppercase font-700 text-start text-center" value="Top Up Now" style="width:100%;" name="dp_submits">
    </div>
</form>

<script>
    /* Fungsi formatRupiah */
    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value, 'Rp. ');
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
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    
    document.getElementById('frm').addEventListener('submit', (e) => {
        e.submitter.disabled  = true;
        e.submitter.innerHTML = `
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        `;
    });
</script>
<?php } else if($action == 'withdrawal'){ ?>
    
<form method="post" id="wd_submit">
    <div class="page-title page-title-small">
        <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a><?php echo ucfirst($action) ?></h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="150">
        <div class="card-overlay bg-highlight opacity-95"></div>
        <div class="card-overlay dark-mode-tint"></div>
        <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
    </div>
    <div class="card card-style">
        <div class="content">
            <h4>Bank Penerima</h4>
            <hr>
            <div class="input-wrapper">
                <label class="label" for="text4b">Bank Option</label>
                <select class="form-control" id="bank_option" name="bank_option" onchange="change_bank()" required>
                    <option>Bank 1</option>
                    <?php if($ACC_F_APP_BK_2_ACC <> '-'){ ?>
                        <option>Bank 2</option>
                    <?php } ?>
                </select>
            </div>
            <script>
                function change_bank(){
                    if(document.getElementById('bank_option').value == 'Bank 1'){
                        document.getElementById('ACC_F_APP_BK_NAMA').value = '<?php echo $ACC_F_APP_BK_1_NAMA; ?>';
                        document.getElementById('ACC_F_APP_BK_CBNG').value = '<?php echo $ACC_F_APP_BK_1_CBNG; ?>';
                        document.getElementById('ACC_F_APP_BK_ACC').value = '<?php echo $ACC_F_APP_BK_1_ACC; ?>';
                        document.getElementById('ACC_F_APP_BK_TLP').value = '<?php echo $ACC_F_APP_BK_1_TLP; ?>';
                        document.getElementById('ACC_F_APP_BK_JENIS').value = '<?php echo $ACC_F_APP_BK_1_JENIS; ?>';
                    } else if(document.getElementById('bank_option').value == 'Bank 2'){
                        document.getElementById('ACC_F_APP_BK_NAMA').value = '<?php echo $ACC_F_APP_BK_2_NAMA; ?>';
                        document.getElementById('ACC_F_APP_BK_CBNG').value = '<?php echo $ACC_F_APP_BK_2_CBNG; ?>';
                        document.getElementById('ACC_F_APP_BK_ACC').value = '<?php echo $ACC_F_APP_BK_2_ACC; ?>';
                        document.getElementById('ACC_F_APP_BK_TLP').value = '<?php echo $ACC_F_APP_BK_2_TLP; ?>';
                        document.getElementById('ACC_F_APP_BK_JENIS').value = '<?php echo $ACC_F_APP_BK_2_JENIS; ?>';
                    }
                }
            </script>
            <div class="input-wrapper">
                <label class="label" for="text4b">Nama Bank</label>
                <input type="text" class="form-control" id="ACC_F_APP_BK_NAMA" value="<?php echo $ACC_F_APP_BK_1_NAMA ?>" readonly required>
            </div>
            <div class="input-wrapper mt-2">
                <label class="label" for="text4b">Nama Pemilik</label>
                <input type="text" class="form-control" id="" value="<?php echo $user1['MBR_NAME'] ?>" readonly required>
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

    <div class="card card-style">
        <div class="content">
            <h4>Withdrawal Account</h4>
            <hr>
            <input type="hidden" value="<?php echo $login ?>" name="login" required>
            <table>
                <tr>
                    <td>Your Login Account</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><strong><?php echo $login ?></strong></td>
                </tr>
                <!-- <tr>
                    <td>Bank Name</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><strong><?php echo $user1['MBR_BK_NAME'] ?></strong></td>
                </tr>
                <tr>
                    <td>Bank Holder</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><strong><?php echo $user1['MBR_NAME'] ?></strong></td>
                </tr>
                <tr>
                    <td>Bank Account</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><strong><?php echo $user1['MBR_BK_ACC'] ?></strong></td>
                </tr> -->
            </table>
            <div class="input-wrapper mt-2">
                <label class="label" for="text4b">Enter Amount Withdrawal</label>
                <input type="text" class="form-control" name="amountwd" id="rupiah" required>
            </div>
            
            <!-- <input type="text" class="form-control" name="note" value="-"> -->
            <input type="submit" class="btn btn-m rounded-sm btn-full shadow-l bg-danger text-uppercase font-700 text-start text-center mt-3" style="width:100%;" name="wd_submit">
        </div>
    </div>
</form>

<script>
    /* Fungsi formatRupiah */
    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value, 'Rp. ');
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
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    document.getElementById('wd_submit').addEventListener('submit', function(ev){ 
        ev.submitter.toggleAttribute("disabled");
        ev.submit();
    });
</script>
<?php } else if($action == 'document'){ ?>
<div class="page-title page-title-small">
    <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a><?php echo ucfirst($action) ?></h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style">
    <div class="content mb-2">
        <h4>Legal Document Account</h4>
        <div class="list-group list-boxes mt-3">
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/01-pilihan-produk.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Pilihan Produk</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/02-profil-perusahaaan-pialang-berjangka.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Profil Perusahaan Pialang Berjangka</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/03.pernyataan-telah-melakukan-simulasi.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Pernyataan Telah Melakukan Simulasi</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/04.pernyataan-pengalaman-transaksi.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Pernyataan Pengalaman Transaksi</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/05.aplikasi-pembukaan-rekening.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Aplikasi Pembukaan Rekening</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/06.dokumen-pemberitahuan-adanya-resiko.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Dokumen Pemberitahuan Adanya Resiko</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/07.perjanjian-pemberian-amanat.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Perjanjian Pemberian Amanat</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/08.trading-rules.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Trading rules</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/09.pernyataan-bertanggung-jawab-atas-kode-transaksi.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Pernyataan Bertanggung Jawab Atas Kode Transaksi</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/10.disclosure-statement.php?x=<?php echo $x; ?>" download class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Disclosure Statement</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <!--
            <a href="#" class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Upload Dokumen</span>
            </a>
            <a href="#" class="border border-green-dark rounded-s shadow-xs" style="margin-left: 50px;">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Foto Terbaru</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="#" class="border border-green-dark rounded-s shadow-xs" style="margin-left: 50px;">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Identitas</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="#" class="border border-green-dark rounded-s shadow-xs" style="margin-left: 50px;">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Dokumen Pendukung</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="#" class="border border-green-dark rounded-s shadow-xs" style="margin-left: 50px;">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                    <span>Dokumen Tambahan</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/12.account-condition.php?x=<?php echo $login; ?>" class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Account Condition</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/13.bukti-konfirmasi-penerimaan-nasabah.php?x=<?php echo $login; ?>"" class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Bukti Konfirmasi Penerimaan Nasabah</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            -->
            <!--
            <a href="#" class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Funding Deposit</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="#" class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Funding Withdrawal</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            <a href="#" class="border border-green-dark rounded-s shadow-xs">
                <i class="fa font-20 fa-mobile color-blue-dark"></i>
                <span>Dokumen Perubahan Data Nasabah</span>
                <u class="color-green-dark">Download</u>
                <i class="fa fa-download color-green-dark"></i>
            </a>
            -->
        </div>
    </div>
</div>
<?php
            };
        };
    };
?>
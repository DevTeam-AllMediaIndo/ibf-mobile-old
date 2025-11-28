
<?php
    include_once('setting.php');
    require 'vendor/autoload.php';
    
    $s3 = new Aws\S3\S3Client([
        'region'  => $region,
        'version' => 'latest',
        'credentials' => [
            'key'    => $IAM_KEY,
            'secret' => $IAM_SECRET,
        ]
    ]);	
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");

    $SQL_QUERY = mysqli_query($db, "
        SELECT 
            tb_bankadm.ID_BKADM,
            tb_bankadm.BKADM_CURR,
            tb_bankadm.BKADM_NAME,
            tb_bankadm.BKADM_HOLDER,
            tb_bankadm.BKADM_ACCOUNT
        FROM tb_bankadm
    ");
    $opt = '';
    if(mysqli_num_rows($SQL_QUERY) > 0) {
        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)) {
            $opt .= '<option value="'.$RESULT_QUERY['ID_BKADM'].'">'. $RESULT_QUERY['BKADM_NAME'].' / '.$RESULT_QUERY['BKADM_CURR'].' / '.$RESULT_QUERY['BKADM_ACCOUNT'].'</option>';
        }
    }
    function cek($d){
        if($d){
            return 'true';
        }else{ return 'false'; }
    }
    if(isset($_POST['dp_submit'])){
        if(isset($_POST['bank_option'])){
            if(isset($_POST['mr_ux']) && isset($_POST['pers_name']) && isset($_POST['ml'])){
                if(isset($_POST['login']) && isset($_POST['amount']) && isset($_POST['bank'])){
                    $login = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['login']))));
                    $amount = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['amount']))));
                    $bank = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['bank']))));
                    $bank_option = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['bank_option']))));
                    $amount = str_replace(' ', '', $amount);
                    $amount = str_replace('Rp.', '', $amount);
                    $amount = str_replace('.', '', $amount);
                    $user1 = [
                        "MBR_ID"    => form_input($_POST["mr_ux"]),
                        "MBR_NAME"  => form_input($_POST["pers_name"]),
                        "MBR_EMAIL" => base64_decode($_POST["ml"])
                    ];
                    $SQL_FND = mysqli_query($db,'
                        SELECT
                            tb_racc.ACC_RATE,
                            tb_racc.ACC_MBR
                        FROM tb_racc
                        WHERE ACC_LOGIN = "'.$login.'" 
                        AND MD5(MD5(ACC_MBR)) = "'.$user1['MBR_ID'].'"
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
                        SELECT COUNT(tb_dpwd.DPWD_STS) AS TOTAL
                        FROM tb_dpwd
                        WHERE tb_dpwd.DPWD_MBR = '.$RSLT_FND['ACC_MBR'].'
                        AND tb_dpwd.DPWD_LOGIN = (SELECT ID_ACC FROM tb_racc WHERE ACC_LOGIN = "'.$login.'" AND ACC_MBR = '.$RSLT_FND['ACC_MBR'].' LIMIT 1)
                        #AND tb_dpwd.DPWD_NOTE <> "Deposit New Account"
                        AND tb_dpwd.DPWD_TYPE = 1
                        AND tb_dpwd.DPWD_STS = 0
                    ');
                    $RESULT_ASC = mysqli_fetch_assoc($SQL_CHECK);
                    if($RESULT_ASC["TOTAL"] > 0){
                        die("<script>location.href = 'signin.php?notif=".base64_encode('Request Deposit Anda Sebelumnya Masih Belum Di Setujui.')."'</script>");
                    } else {
                        if($amount > 100){
                            if(isset($_FILES["dps_proof"]) && $_FILES["dps_proof"]["error"] == 0){
            
                                $newfilename1 = round(microtime(true));
            
                                $s5_6_doc1_name = $_FILES["dps_proof"]["name"];
                                $s5_6_doc1_type = $_FILES["dps_proof"]["type"];
                                
                                $s5_6_doc1_ext = pathinfo($s5_6_doc1_name, PATHINFO_EXTENSION);
                                if(array_key_exists($s5_6_doc1_ext, $allowed)){
                                    if(in_array($s5_6_doc1_type, $allowed)){
                                        $s5_6_doc1_new = 'dps_'.$RSLT_FND['ACC_MBR'].'_'.round(microtime(true)).'.'.$s5_6_doc1_ext;
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
                                                    tb_dpwd.DPWD_MBR = '.$RSLT_FND['ACC_MBR'].',
                                                    tb_dpwd.DPWD_TYPE = 1,
                                                    tb_dpwd.DPWD_DEVICE = "Mobile",
                                                    tb_dpwd.DPWD_BANKSRC = '.$DPWD_BANKSRC.',
                                                    tb_dpwd.DPWD_BANK = '.$bank.',
                                                    tb_dpwd.DPWD_LOGIN = (SELECT ID_ACC FROM tb_racc WHERE ACC_LOGIN = "'.$login.'" AND ACC_MBR = '.$RSLT_FND['ACC_MBR'].' LIMIT 1),
                                                    tb_dpwd.DPWD_AMOUNT = '.$amount.',
                                                    tb_dpwd.DPWD_PIC = "'.$s5_6_doc1_new.'",
                                                    tb_dpwd.DPWD_DATETIME = "'.date('Y-m-d H:i:s').'"
                                                ') or die ("<script>location.href = 'signin.php?notif=".base64_encode('Error DeBe')."'</script>");

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
                                                PHP_EOL.'Nama : '.$user1['MBR_NAME'].
                                                PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                                                PHP_EOL.'Login : '.$login.
                                                PHP_EOL.'Ammount : '.$curr_ag.' '.$curr.
                                                PHP_EOL.'Status : Pending';

                                                $request_params_wpb = [
                                                    'chat_id' => $chat_id,
                                                    'text' => $mesg
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
                                
            
                                                insert_log($RSLT_FND['ACC_MBR'], 'Top Up Account '.$login);
                                                unlink($s5_6_doc1_Path);
                                                die ("<script>location.href = 'signin.php?notif=".base64_encode('Success Upload Bukti Deposit.')."'</script>");
                                            } catch (Aws\S3\Exception\S3Exception $e) {
                                                logerr("Tidak Dapat Mengupload Ke AWS S3 Bucket", "Insta-Trans" , $RSLT_FND["ACC_MBR"]); 
                                                die ("<script>location.href = 'signin.php?notif=".base64_encode('There was an error uploading the file.')."'</script>");
                                            };
                                        } else {
						                    logerr("Folder Tidak Di Temukan", "Insta-Trans" , $RSLT_FND["ACC_MBR"]); 
                                            die("<script>location.href = 'signin.php?notif=".base64_encode('file tidak terupload, silahkan ulangi lagi')."'</script>"); 
                                        };
                                    } else {
						                logerr("Type File Tidak Sesuai", "Insta-Trans" , $sql_rsl1["ACC_MBR"]); 
                                        die("<script>location.href = 'signin.php?notif=".base64_encode('file hanya jpg, png, jpeg')."'</script>"); 
                                    };
                                } else {
						            logerr("Extensi File Tidak Sesuai", "Insta-Trans" , $sql_rsl1["ACC_MBR"]); 
                                    die("<script>location.href = 'signin.php?notif=".base64_encode('file hanya jpg, png, jpeg')."'</script>"); 
                                };
                            } else {
						        logerr("Terdapat Error Pada File", "Insta-Trans" , $sql_rsl1["ACC_MBR"]); 
                                die("<script>location.href = 'signin.php?notif=".base64_encode('sertakan bukti upload')."'</script>"); 
                            };
                        } else { 
						    logerr("Jumlah Inputan Kurang Dari Batas Minimal", "Insta-Trans" , $sql_rsl1["ACC_MBR"]);
                            die("<script>location.href = 'signin.php?notif=".base64_encode('minimal top up 10.000')."'</script>"); 
                        };
                    };

                    
                } else { 
                    logerr("Parameter Ke-3 Tidak Lengkap", "Insta-Trans" , $sql_rsl1["ACC_MBR"]);
                    die("<script>location.href = 'signin.php?notif=".base64_encode('Errno1')."'</script>"); 
                };
            } else { 
                logerr("Parameter Ke-2 Tidak Lengkap", "Insta-Trans" , $sql_rsl1["ACC_MBR"]);
                die("<script>location.href = 'signin.php?notif=".base64_encode('Errno2')."'</script>"); 
            };
        } else { 
            logerr("Parameter Ke-1 Tidak Lengkap", "Insta-Trans" , $sql_rsl1["ACC_MBR"]);
            die("<script>location.href = 'signin.php?notif=".base64_encode('Errno3')."'</script>"); 
        };
    };
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title><?php echo $web_name ?></title>
<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

    <body class="theme-light">

        <!-- <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div> -->

        <div id="page">
            <div class="page-content">

                <div class="page-title page-title-small">
                    <h2><a href="signin.php" data-back-button><i class="fa fa-arrow-left"></i></a>TOP UP</h2>
                    <!--
                    <a href="#" data-menu="menu-main" class="bg-fade-highlight-light shadow-xl preload-img" data-src="images/avatars/5s.png"></a>
                    -->
                </div>
                <div class="card header-card shape-rounded" data-card-height="150">
                    <div class="card-overlay bg-highlight opacity-95"></div>
                    <div class="card-overlay dark-mode-tint"></div>
                    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
                </div>

                <div class="card card-style">
                    <div class="content mb-3">
                        <h4>TOP UP</h4>
                        <p>
                            Silahkan masukan Account untuk melakukan TOP UP!
                        </p>
                        <div class="row mb-0">
                            <div class="col-12">
                                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa-solid fa-user text-warning"></i> Account</label>
                                <input type="number" class="form-control" value="" name="acc" id="acc"  required autocomplete="off">
                            </div>
                        </div>
                        <div class="row mb-0" id="divAcc"> 
                            <div class="col-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" enctype="multipart/form-data" id="dp_form">
                </form>
            </div>
        </div>



        <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
        <script type="text/javascript" src="scripts/custom.js"></script>
        <script>
            let acc            = document.getElementById("acc");
            let dp_form        = document.getElementById("dp_form");
            let divAcc         = document.getElementById("divAcc");
            let Url            = new URL(window.location.href);
            let search_params  = Url.searchParams;
            let tabD;
            let tabW;
            let ress;
            divAcc.style.display = 'none';

            document.getElementById('dp_form').addEventListener('submit', function(ev){ 
                ev.submitter.toggleAttribute("disabled");
                // ev.submit();
            });

            const elll = `
                <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa-solid fa-user"></i> Nama</label>
                <input type="text" class="form-control" id="perName" value="" name="pers_name" readonly required>
            `;

            function change_bank(){
                if(document.getElementById('bank_option').value == 'Bank 1'){
                    document.getElementById('ACC_F_APP_BK_NAMA').value  = ress[0].bk_name_1;
                    // document.getElementById('ACC_F_APP_BK_CBNG').value  = ress[0].bk_brnch_1;
                    document.getElementById('ACC_F_APP_BK_ACC').value   = cenNum(ress[0].bk_acc_1);
                    // document.getElementById('ACC_F_APP_BK_TLP').value   = ress[0].bk_tlp_1;
                    // document.getElementById('ACC_F_APP_BK_JENIS').value = ress[0].bk_type_1;
                } else if(document.getElementById('bank_option').value == 'Bank 2'){
                    document.getElementById('ACC_F_APP_BK_NAMA').value  = ress[0].bk_name_2;
                    // document.getElementById('ACC_F_APP_BK_CBNG').value  = ress[0].bk_brnch_2;
                    document.getElementById('ACC_F_APP_BK_ACC').value   = cenNum(ress[0]?.bk_acc_2);
                    // document.getElementById('ACC_F_APP_BK_TLP').value   = ress[0].bk_tlp_2;
                    // document.getElementById('ACC_F_APP_BK_JENIS').value = ress[0].bk_type_2;
                }
                
            }
            function cenNum(num){
                let half   = ((num.length*45) / 100);
                let numCen = num.substring(0, half) + star(half);
                function star(star){
                    let restar = '';
                    for(let i = 0; i<star; i++){
                        restar += '*';
                    }
                    return restar;
                }
                return numCen;
            }
            acc.addEventListener('keyup', function(e){
                let elProp = e.target;
                if(elProp.value.length >= 5){
                    if(dp_form.innerHTML == '<div class="col-12 text-center">Tidak ada data yang di temukan</div>' || dp_form.innerHTML == '<div class="col-12 text-center">Email ini tidak terdaftar/belum memiliki akun</div>'){ dp_form.innerHTML = " "; }
                    $.ajax({
                        url: 'ajax/get_acc.php',
                        type: "GET",
                        dataType: 'JSON',
                        data: {
                            lgn: elProp.value
                        },
                    }).done(function(resp) {
                        if(resp.length > 0){
                            console.log(resp);
                            let bkOpt;
                            $("#divAcc div").html(elll);
                            $("#divAcc").show();
                            let perName = document.getElementById("perName");
                            perName.value = resp[0].pers_name;
                            ress = resp;
                            if(resp[0].bk_acc_2?.length >= 3){
                                bkOpt = `
                                    <option value="Bank 1">Bank 1</option>
                                    <option value="Bank 2">Bank 2</option>
                                `;
                            }else{ bkOpt = `<option value="Bank 1">Bank 1</option>`; }
                            tabD = `
                                <div class="card card-style">
                                    <div class="content">
                                        <h4>Bank Pengirim</h4>
                                        <hr>
                                        <div class="input-wrapper">
                                            <label class="label" for="text4b">Bank Option</label>
                                            <select class="form-control" id="bank_option" name="bank_option" onchange="change_bank()" required>
                                                ${bkOpt}
                                            </select>
                                        </div>
                                        <div class="input-wrapper">
                                            <label class="label" for="text4b">Nama Bank</label>
                                            <input type="text" class="form-control" id="ACC_F_APP_BK_NAMA" value="${resp[0].bk_name_1}" readonly required>
                                        </div>
                                        <div class="input-wrapper mt-2">
                                            <label class="label" for="text4b">Bank Rekening</label>
                                            <input type="text" class="form-control" id="ACC_F_APP_BK_ACC" value="${cenNum(resp[0].bk_acc_1)}" readonly required>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-style">
                                    <div class="content">
                                        <h4>Bank Penerima</h4>
                                        <input type="hidden" value="${resp[0].login}" name="login" required>
                                        <input type="hidden" value="${resp[0].ml}" name="ml" required>
                                        <input type="hidden" value="${resp[0].mr_ux}" name="mr_ux" required>
                                        <input type="hidden" value="${resp[0].pers_name}" name="pers_name" required>
                                        <hr>
                                        <div class="form-group boxed">
                                            <div class="input-wrapper">
                                                <label class="label" for="text4b">MetaTrader Account Number</label>
                                                <input type="text" class="form-control" value="${resp[0].login}" readonly required>
                                            </div>
                                            <div class="input-wrapper mt-2">
                                                <label class="label" for="text4b">Bank Holder</label>
                                                <input type="text" class="form-control" value="${resp[0].bk_comp}" readonly required>
                                            </div>
                                            <div class="input-wrapper mt-2">
                                                <label class="label" for="text4b">Bank Destination</label>
                                                <select class="form-control" name="bank" required>
                                                    <option disabled>Destination</option>
                                                    <?php echo $opt; ?>
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
                                    <input type="hidden" name="dp_submit">
                                    <input type="submit" class="btn btn-m rounded-sm btn-full shadow-l bg-success text-uppercase font-700 text-start text-center" value="Top Up Now" style="width:100%;">
                                </div>
                            `;
                            if(search_params.get("tab") == 'd'){
                                dp_form.innerHTML = tabD;
                            }else{
                                dp_form.innerHTML = ' ';
                            }
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
                        }else{
                            divAcc.style.display = 'none';
                            dp_form.innerHTML = '<div class="col-12 text-center">Account ini tidak terdaftar</div>';
                        }
                    });
                }else{
                    divAcc.style.display = 'none';
                    dp_form.innerHTML = '<div class="col-12 text-center">Tidak ada data yang di temukan</div>';
                }
            });

        </script>
    </body>
</html>
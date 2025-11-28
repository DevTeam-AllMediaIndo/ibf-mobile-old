<?php
    require 'vendor/autoload.php';
    require 'setting.php';

    use Aws\S3\S3Client;
    
    $region = 'ap-southeast-1';
    $bucketName = 'allmediaindo-2';
    $folder = 'ibftrader';
    $IAM_KEY = 'AKIASPLPQWHJMMXY2KPR';
    $IAM_SECRET = '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';

    if(isset($_POST['submit'])){
        if(isset($_POST['w3review'])){
            $w3review = form_input($_POST['w3review']);
            if(isset($_POST['email'])){
                $email = form_input($_POST['email']);
                $SQL_CHECK_EMAIL = mysqli_query($db, '
                    SELECT
                        *
                    FROM tb_member
                    WHERE tb_member.MBR_EMAIL = "'.$email.'"
                    LIMIT 1
                ');
                if($SQL_CHECK_EMAIL && mysqli_num_rows($SQL_CHECK_EMAIL) > 0){
                    $user1 = mysqli_fetch_assoc($SQL_CHECK_EMAIL);
                }else{ die ("<script>location.href = 'ticket.php?notif=".base64_encode('Email not found!')."'</script>"); }
            }else{ die ("<script>location.href = 'ticket.php?notif=".base64_encode('Silahkan masukan email, untuk identifikasi!')."'</script>"); }
            $s3 = new Aws\S3\S3Client([
                'region'  => $region,
                'version' => 'latest',
                'credentials' => [
                    'key'    => $IAM_KEY,
                    'secret' => $IAM_SECRET,
                ]
            ]);	

            if(!isset($_FILES["file_doc"])){
                mysqli_query($db,'
                    INSERT INTO tb_ticket SET
                    tb_ticket.TCKT_MBR = '.$user1['MBR_ID'].',
                    tb_ticket.TCKT_KONTEN_MBR = "'.$w3review.'",
                    tb_ticket.TCKT_DATETIME_MBR = "'.date('Y-m-d H:i:s').'"
                ') or die (mysqli_error($db));

				// Message Telegram
				$mesg = 'Notif : Ticket'.
				PHP_EOL.'Date : '.date("Y-m-d").
				PHP_EOL.'Time : '.date("H:i:s");
				// PHP_EOL.'======== Informasi Ticket =========='.
				// PHP_EOL.'Nama : '.$user1['MBR_NAME'].
				// PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
				// PHP_EOL.'Login : '.$num_log.
				// PHP_EOL.'Permasalahan : '.$w3review.
				// PHP_EOL.'Status : Pending';

                // Message Telegram
				$mesg_othr = 'Notif : Ticket'.
				PHP_EOL.'Date : '.date("Y-m-d").
				PHP_EOL.'Time : '.date("H:i:s").
                PHP_EOL.'==================================================='.
                PHP_EOL.'                                        Informasi Ticket'.
                PHP_EOL.'==================================================='.
				PHP_EOL.'Nama : '.$user1['MBR_NAME'].
				PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
				PHP_EOL.'Login : '.$num_log.
				PHP_EOL.'Permasalahan : '.$w3review.
				PHP_EOL.'Status : Pending';

				$request_params_wpb = [
					'chat_id' => $chat_id,
					'text' => $mesg_othr
					// 'text' => $mesg
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
                die ("<script>location.href = 'ticket.php?notif=".base64_encode('berhasil membuat tiket, tunggu admin konfirmasi')."'</script>");
            }else{

                $newfilename1 = round(microtime(true));
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
                if(isset($_FILES["file_doc"]) && $_FILES["file_doc"]["error"] == 0){
                    
                    $file_doc_name = $_FILES["file_doc"]["name"];
                    $file_doc_type = $_FILES["file_doc"]["type"];
                    $file_doc_size = $_FILES["file_doc"]["size"];
                    
                    $file_doc_ext = pathinfo($file_doc_name, PATHINFO_EXTENSION);
                    
                    if($file_doc_size < 5000000) {
                        if(array_key_exists($file_doc_ext, $allowed)){
                            if(in_array($file_doc_type, $allowed)){
                                $file_doc_new = 'tic_'.$user1['MBR_ID'].'_'.round(microtime(true)).'.'.$file_doc_ext;
                                if(move_uploaded_file($_FILES["file_doc"]["tmp_name"], "upload/" . $file_doc_new)){
                                    
                                    $file_doc_Path = 'upload/'. $file_doc_new;
                                    $file_doc_key = basename($file_doc_Path);

                                    try {
                                        $result = $s3->putObject([
                                            'Bucket' => $bucketName,
                                            'Key'    => $folder.'/'.$file_doc_key,
                                            'Body'   => fopen($file_doc_Path, 'r'),
                                            'ACL'    => 'public-read', // make file 'public'
                                        ]);
                                    } catch (Aws\S3\Exception\S3Exception $e) {
                                        die ("<script>location.href = 'ticket.php?notif=".base64_encode('berhasil membuat tiket, tunggu admin konfirmasi')."'</script>");
                                    }
                                } else { 
                                    logerr("Folder Tidak Ditemukan", "Pusat Bantuan / Ticket", $user1["MBR_ID"]);
                                    die ("<script>location.href = 'ticket.php?notif=".base64_encode('Gagal upload file. Hubungi administrator')."'</script>"); 
                                };
                            } else { 
                                logerr("Type File Tidak Sesuai", "Pusat Bantuan / Ticket", $user1["MBR_ID"]);
                                die ("<script>location.href = 'ticket.php?notif=".base64_encode('Hanya file png, jpeg, jpeg, jpg')."'</script>"); 
                            };
                        } else { 
                            logerr("Extensi File Tidak Sesuai", "Pusat Bantuan / Ticket", $user1["MBR_ID"]);
                            die ("<script>location.href = 'ticket.php?notif=".base64_encode('Hanya file png, jpeg, jpeg, jpg')."'</script>"); 
                        };
                    } else { 
                        logerr("Kapasitas File Melebihi Jumlah Maksimal", "Pusat Bantuan / Ticket", $user1["MBR_ID"]);
                        die ("<script>location.href = 'ticket.php?notif=".base64_encode('File tidak dapat di upload. Ukuran file harus lebih kecil dari 200KB')."'</script>"); 
                    };
                } else { $file_doc_new = ''; };
                

                mysqli_query($db, '
                    INSERT INTO tb_ticket SET
                    tb_ticket.TCKT_MBR = '.$user1['MBR_ID'].',
                    tb_ticket.TCKT_KONTEN_MBR = "'.$w3review.'",
                    tb_ticket.TCKT_FILE = "'.$file_doc_new.'",
                    tb_ticket.TCKT_DATETIME_MBR = "'.date('Y-m-d H:i:s').'"
                ') or die (mysqli_error($db));
                unlink($file_doc_Path);
                push_notification('create');
                
				// Message Telegram
				$mesg = 'Notif : Ticket'.
				PHP_EOL.'Date : '.date("Y-m-d").
				PHP_EOL.'Time : '.date("H:i:s");
				// PHP_EOL.'======== Informasi Ticket =========='.
				// PHP_EOL.'Nama : '.$user1['MBR_NAME'].
				// PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
				// PHP_EOL.'Login : '.$num_log.
				// PHP_EOL.'Permasalahan : '.$w3review.
				// PHP_EOL.'Status : Pending';

                // Message Telegram
				$mesg_othr = 'Notif : Ticket'.
				PHP_EOL.'Date : '.date("Y-m-d").
				PHP_EOL.'Time : '.date("H:i:s").
                PHP_EOL.'==================================================='.
                PHP_EOL.'                                        Informasi Ticket'.
                PHP_EOL.'==================================================='.
				PHP_EOL.'Nama : '.$user1['MBR_NAME'].
				PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
				PHP_EOL.'Login : '.$num_log.
				PHP_EOL.'Permasalahan : '.$w3review.
				PHP_EOL.'Status : Pending';

				$request_params_wpb = [
					'chat_id' => $chat_id,
					'text' => $mesg_othr
					// 'text' => $mesg
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
                die ("<script>location.href = 'ticket.php?notif=".base64_encode('berhasil membuat tiket, tunggu admin konfirmasi')."'</script>");
            };
        }else { die ("<script>location.href = 'ticket.php?notif=".base64_encode('Err8')."'</script>"); };
    }
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
        <title><?php echo $web_name ?></title>
        <meta name="theme-color" content="#000000"/>
        <link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
        <link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
        <link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
    </head>

    <body class="theme-light">
        <div id="page">
            <div class="page-content">
                <div class="page-title page-title-small">
                    <h2><a href="./" data-back-button><i class="fa fa-arrow-left"></i></a>Ticket</h2>
                </div>
                <div class="card header-card shape-rounded" data-card-height="150">
                    <div class="card-overlay bg-highlight opacity-95"></div>
                    <div class="card-overlay dark-mode-tint"></div>
                    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
                </div>

                <?php
                    if(isset($_GET['notif'])){
                        $notif = base64_decode($_GET['notif']);
                ?>
                <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert">
                    <span class="alert-icon"><i class="fa fa-bell font-18"></i></span>
                    <strong class="alert-icon-text"><?php echo $notif; ?>.</strong>
                    <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                </div>
                <?php }; ?>

                <div class="card card-style">
                    <div class="content">
                        <div class="divider"></div>
                        <h4>
                            Message
                        </h4>
                        <div align="center">
                            <div class="form-control">
                                <form method="post" enctype="multipart/form-data" id="frm">
                                    
                                    <label for="form5" class="color-dark">Silahkan masukan alamat email anda yang sudah terdaftar</label>
                                    <div class="input-style has-borders no-icon mb-4">
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                    <br><p><u>Silahkan Isi Keluhan Anda Pada Form Di Bawah Ini!</u></p>
                                    <textarea id="w3review" class="form-control" name="w3review" rows="4" cols="28" required></textarea>
                                    <br><br>
                                    <input type="file" id="fileuploadInput1" accept=".png, .jpg, .jpeg" name="file_doc">
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" name="submit" value="1">
                                            <button type="submit" name="submits" class="simulate-android-badge btn btn-m btn-full rounded-s shadow-xl text-uppercase font-700 bg-highlight">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of page content-->
        </div>
        <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
        <script type="text/javascript" src="scripts/custom.js"></script>
    </body>
</html>
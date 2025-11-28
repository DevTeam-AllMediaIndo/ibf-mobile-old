<?php
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
if(isset($_POST['createacc'])){
    if(isset($_POST['type'])){
        $type = form_input($_POST["type"]);
        if($type == 'demo'){
            $SQL_QUERY = mysqli_query($db, '
                SELECT tb_racc.*
                FROM tb_racc
                WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                AND tb_racc.ACC_DERE = 2
                AND tb_racc.ACC_TYPE = 1
            ');
            if(mysqli_num_rows($SQL_QUERY) < 1) {
                
                $meta_pass = (substr(md5(microtime()),rand(0,21),8));
                $meta_investor = (substr(md5(microtime()),rand(0,22),8));
                $meta_phone = (substr(md5(microtime()),rand(0,23),8));
                $createaccount = mt4api_demo_post(41, "AccountCreate4", 'name='.str_replace(" ", "_", $user1['MBR_NAME']).'&group=demoIBF-Forex&password='.$meta_pass.'&investor='.$meta_investor.'&country='.$user1['MBR_COUNTRY'].'&state=&email='.$user1['MBR_EMAIL'].'&city='.$user1['MBR_CITY'].'&comment=metaapi&leverage=100&zip_code=0&phone='.$user1['MBR_PHONE'].'&address='.$user1['MBR_ADDRESS'].'&enable=true&enable_change_password=true&phone_password='.$meta_phone.'&login=0');
                $createaccount = json_decode($createaccount['message'], true);
                $result = mt4api_demo_post(41, 'Deposit', 'login='.($createaccount['login']).'&amount=10000&comment=mobile_deposit');
                if($createaccount['login']){
                    mysqli_query($db, '
                        INSERT INTO tb_racc SET
                        tb_racc.ACC_MBR = '.$user1['MBR_ID'].',
                        tb_racc.ACC_LOGIN = "'.($createaccount['login']).'",
                        tb_racc.ACC_PASS = "'.$meta_pass.'",
                        tb_racc.ACC_INVESTOR = "'.$meta_investor.'",
                        tb_racc.ACC_PASSPHONE = "'.$meta_phone.'",
                        tb_racc.ACC_INITIALMARGIN = 10000,
                        tb_racc.ACC_DERE = 2,
                        tb_racc.ACC_DEVICE = "Mobile",
                        tb_racc.ACC_TYPE = 1
                    ') or die(mysqli_error($db));
    
    
                    insert_log($user1['MBR_ID'], 'Create Demo Account '.($createaccount['login']));
                    $mail = new PHPMailer(true);
                    // try {
                    //     $mail->isSMTP();
                    //     $mail->Host       = $setting_email_host_api;
                    //     $mail->SMTPAuth   = true;
                    //     $mail->Username   = $setting_email_support_name;
                    //     $mail->Password   = $setting_email_support_password;
                    //     $mail->SMTPSecure = $setting_email_port_encrypt;
                    //     $mail->Port       = $setting_email_port_api;
    
                    //     //Recipients
                    //     $mail->setFrom($setting_email_support_name, $web_name);
                    //     $mail->addAddress($user1['MBR_EMAIL'], $user1['MBR_NAME']);
                        
                    //     //Content
                    //     $mail->isHTML(true);
                    //     $mail->Subject = 'Demo Account Information '.$web_name_full.' '.date('Y-m-d H:i:s');
                        
                    //     $mail->Body    = "
                    //     <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                    //     <html hola_ext_inject='disabled' xmlns='http://www.w3.org/1999/xhtml'>
                    //         <head>
                    //             <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    //             <title>".$web_name_full."</title>
                    //             <style type='text/css'>
                    //                 @media only screen and (min-device-width:600px) {
                    //                     .content {width:600px!important;}
                    //                 }
                    //                 @media only screen and (max-device-width:480px) {
                    //                     .text {font-size:12px!important;-webkit-text-size-adjust:100%!important;-moz-text-size-adjust:100%!important;-ms-text-size-adjust:100%!important;}
                    //                     .button {font-size:16px!important;-webkit-text-size-adjust:100%!important;-moz-text-size-adjust:100%!important;-ms-text-size-adjust:100%!important;}
                    //                 }
                    //             </style>
                    //         </head>
                    //         <body style='background-color:#cacaca'>
                    //             <div style='max-width: 1000px; margin: auto;padding: 20px'></div>
                    //             <div style='max-width: 600px; background-color:#ffffff;margin: auto;border: 1px solid #eaeaea;padding: 20px;border-radius: 5px;'>
                    //                 <center><img src='".$setting_email_logo_linksrc."' style='height:50px'></center>
    
                    //                 <div style='padding: 10px;text-align: justify;'>
                    //                     <strong>Informasi Data Demo Account</strong><br>
    
                    //                     Hi <strong>".$user1['MBR_NAME'].", </strong><br>
                                        
                    //                     <ul>
                    //                         <li>Login : ".($createaccount['login'])."</li>
                    //                         <li>Password Master : ".$meta_pass."</li>
                    //                         <li>Password Investor : ".$meta_investor."</li>
                    //                     </ul>
    
                    //                     Terima Kasih.
    
    
                    //                     <br><br>
                    //                     Dari Kami,<br>
                    //                     ".$web_name_full." Team Support
                    //                 </div>
                    //                 <hr>
                    //                 <p>
                    //                     <small>
                    //                         Anda menerima email ini karena Anda mendaftar di ".$setting_front_web_link." jika Anda memiliki<br>
                    //                         pertanyaan, silahkan hubungi kami melalui email di ".$setting_email_support_name.". Anda juga dapat menghubungi<br>
                    //                         nomor ".$setting_number_phone." 
                    //                     </small>
                    //                     <br>
                    //                     <small>
                    //                         <a href='".$setting_insta_link."'><img src='".$setting_insta_linksrc."'></a>
                    //                         <a href='".$setting_facebook_link."'><img src='".$setting_facebook_linksrc."'></a>
                    //                         <a href='".$setting_linkedin_link."'><img src='".$setting_linkedin_linksrc."'></a>
                    //                     </small>
                    //                 </p>
                    //                 <hr>
                    //                 <p>
                    //                     <small>
                    //                         <strong>Phone</strong> : <a href='tel:".$setting_office_number."'>".$setting_office_number."</a><br>
                    //                         <strong>Support</strong> : <a href='mailto:".$setting_email_support_name."'>".$setting_email_support_name."</a><br>
                    //                         <strong>Website</strong> : <a href='www.".$setting_front_web_link."'>".$setting_front_web_link."</a><br>
                    //                         <strong>Address</strong> : ".$setting_central_office_address."<br>
                    //                         <br>
                    //                         Resmi dan diatur oleh Badan Pengawas Perdagangan Berjangka Komoditi. Nomor registrasi BAPPEBTI : 912/BAPPEBTI/SI/8/2006.
                    //                     </small>
                    //                 </p>
                    //                 <hr>
                    //                 <p style='text-align: justify;'>
                    //                     <small>
                    //                         <strong>PEMBERITAHUAN RESIKO:</strong><br>
                    //                         Semua produk finansial yang ditransaksikan dalam sistem margin mempunyai resiko tinggi terhadap dana Anda. Produk finansial ini tidak diperuntukkan bagi semua investor dan Anda bisa saja kehilangan dana lebih dari deposit awal Anda. Pastikan bahwa Anda benar-benar mengerti resikonya, dan mintalah nasihat independen jika diperlukan. Lihat Pemberitahuan Resiko lengkap kami di Ketentuan Bisnis.
                    //                     </small>
                    //                 </p>
                    //             </div>
                    //             <div style='max-width: 1000px; margin: auto;padding: 20px'></div>
                    //         </body>
                    //     </html>
                    //     ";
                    //     $mail->send();
                    //     //echo 'Message has been sent';
                    //     //die("<script>location.href = 'home.php?page=accout&notif=account success created'</script>");
                    // } catch (Exception $e) {
                    //     //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    //     //die("<script>location.href = 'home.php?page=accout&notif=account success created'</script>");
                    // }
                }

?>

        <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert">
            <span class="alert-icon"><i class="fa fa-check font-18"></i></span>
            <h4 class="text-uppercase color-white">Success</h4>
            <strong class="alert-icon-text">Account demo has been created.</strong>
            <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>

        <div class="card card-style">
            <div class="content">
                <table class="table table-striped table-hover">
                    <tr>
                        <td>Login</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?php echo ($createaccount['login']); ?></td>
                    </tr>
                    <tr>
                        <td>Master</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?php echo ($meta_pass); ?></td>
                    </tr>
                    <tr>
                        <td>Investor</td>
                        <td>&nbsp;:&nbsp;</td>
                        <td><?php echo ($meta_investor); ?></td>
                    </tr>
                </table>

                <a href="home.php?page=account" class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m">Back to List Account</a>
            </div>
        </div>
<?php

            
            } else { die("<script>location.href = 'home.php?page=account'</script>"); }
        } else if($type == 'live'){
            $SQL_QUERY = mysqli_query($db, '
                SELECT tb_racc.*
                FROM tb_racc
                WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                AND tb_racc.ACC_WPCHECK = 0
                AND tb_racc.ACC_LOGIN = 0
                AND tb_racc.ACC_DERE = 1
                AND tb_racc.ACC_TYPE = 1
            ');
            if(mysqli_num_rows($SQL_QUERY) < 1) {
                mysqli_query($db, '
                    INSERT INTO tb_racc SET
                    tb_racc.ACC_MBR = '.$user1['MBR_ID'].',
                    tb_racc.ACC_DERE = 1,
                    tb_racc.ACC_TYPE = 1,
                    tb_racc.ACC_DEVICE = "Mobile"
                ') or die("<script>location.href = 'home.php?page=personal-information'</script>");
                
                $SQL_QUERY = mysqli_query($db, '
                    SELECT MD5(MD5(tb_racc.ID_ACC)) AS ID_ACC
                    FROM tb_racc
                    WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                    AND tb_racc.ACC_WPCHECK = 0
                    AND tb_racc.ACC_LOGIN = 0
                    AND tb_racc.ACC_DERE = 1
                    AND tb_racc.ACC_TYPE = 1
                    LIMIT 1
                ');
                if(mysqli_num_rows($SQL_QUERY) > 0) {
                    $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
?>
    <div class="page-title page-title-small">
        <h2>Create Account Live</h2>
    </div>
    <div class="card header-card shape-rounded" data-card-height="150">
        <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>
        <div class="card card-style">
            <div class="content">
                <img src="assets/img/live_001.png" alt="image" class="imaged img-fluid">
                <h2 class="mt-3 mb-2">Selamat bergabung bersama PT. International Business Futures!</h2>
                <p>
                    Eksekusi Cepat, data pasar real-time, dan saran serta pelatihan broker pribadi gratis untuk membantu Anda
                    manfaatkan investasi Anda sebaik-baiknya
                </p>
                <a href="home.php?page=racc/createaccountreal&id=<?php echo $RESULT_QUERY['ID_ACC']; ?>" class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m">Mulai Gunakan IBF Trader</a>
            </div>
        </div>
    </div>
<?php
                    die("<script>location.href = 'home.php?page=racc/createaccountreal&id=".$RESULT_QUERY['ID_ACC']."'</script>");
                } else {die("<script>alert('please try again');location.href = 'home.php?page=account'</script>"); }
            } else {die("<script>alert('your account still creating');location.href = 'home.php?page=account'</script>"); }
        } else { die("<script>location.href = 'home.php?page=account'</script>"); }
    }
}
    if(isset($_GET['action'])){
        $action = form_input($_GET["action"]);
        if($action == 'createacc'){
            if(isset($_GET['type'])){
                $type = form_input($_GET["type"]);
                
                if($type == 'demo'){
                    $SQL_QUERY = mysqli_query($db, '
                        SELECT tb_racc.*
                        FROM tb_racc
                        WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                        AND tb_racc.ACC_DERE = 2
                        AND tb_racc.ACC_TYPE = 1
                    ');
                    if(mysqli_num_rows($SQL_QUERY) < 1) {
                        
                        $meta_pass = (substr(md5(microtime()),rand(0,21),8));
                        $meta_investor = (substr(md5(microtime()),rand(0,22),8));
                        $createaccount = mt4api_demo_post(41, "AccountCreate4", 'name='.str_replace(" ", "_", $user1['MBR_NAME']).'&group=demoIBF-Forex&password='.$meta_pass.'&investor='.$meta_investor.'&country='.$user1['MBR_COUNTRY'].'&state=&email='.$user1['MBR_EMAIL'].'&city='.$user1['MBR_CITY'].'&comment=metaapi&leverage=100&zip_code=0&phone='.$user1['MBR_PHONE'].'&address='.$user1['MBR_ADDRESS'].'&enable=true&enable_change_password=true&phone_password='.$meta_phone.'&login=0');
                        $createaccount = json_decode($createaccount['message'], true);
                        $result = mt4api_demo_post(41, 'Deposit', 'login='.($createaccount['login']).'&amount=10000&comment=mobile_deposit');
                        if($createaccount['login']){
                            mysqli_query($db, '
                                INSERT INTO tb_racc SET
                                tb_racc.ACC_MBR = '.$user1['MBR_ID'].',
                                tb_racc.ACC_LOGIN = '.($createaccount['login']).',
                                tb_racc.ACC_PASS = "'.$meta_pass.'",
                                tb_racc.ACC_INVESTOR = "'.$meta_investor.'",
                                tb_racc.ACC_PASSPHONE = "'.$meta_phone.'",
                                tb_racc.ACC_INITIALMARGIN = 10000,
                                tb_racc.ACC_DERE = 2,
                                tb_racc.ACC_DEVICE = "Mobile",
                                tb_racc.ACC_TYPE = 1
                            ') or die("<script>location.href = 'home.php?page=account'</script>");

                            insert_log($user1['MBR_ID'], 'Create Demo Account '.($createaccount['login']));
                            $mail = new PHPMailer(true);
                            try {
                                $mail->isSMTP();
                                $mail->Host       = $setting_email_host_api;
                                $mail->SMTPAuth   = true;
                                $mail->Username   = $setting_email_support_name;
                                $mail->Password   = $setting_email_support_password;
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                $mail->Port       = $setting_email_port_api;
            
                                //Recipients
                                $mail->setFrom($setting_email_support_name, $web_name);
                                $mail->addAddress($user1['MBR_EMAIL'], $user1['MBR_NAME']);
                                
                                //Content
                                $mail->isHTML(true);
                                $mail->Subject = 'Demo Account Information '.$web_name_full.' '.date('Y-m-d H:i:s');
                                
                                $mail->Body    = "
                                <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                                <html hola_ext_inject='disabled' xmlns='http://www.w3.org/1999/xhtml'>
                                    <head>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                        <title>".$web_name_full."</title>
                                        <style type='text/css'>
                                            @media only screen and (min-device-width:600px) {
                                                .content {width:600px!important;}
                                            }
                                            @media only screen and (max-device-width:480px) {
                                                .text {font-size:12px!important;-webkit-text-size-adjust:100%!important;-moz-text-size-adjust:100%!important;-ms-text-size-adjust:100%!important;}
                                                .button {font-size:16px!important;-webkit-text-size-adjust:100%!important;-moz-text-size-adjust:100%!important;-ms-text-size-adjust:100%!important;}
                                            }
                                        </style>
                                    </head>
                                    <body style='background-color:#cacaca'>
                                        <div style='max-width: 1000px; margin: auto;padding: 20px'></div>
                                        <div style='max-width: 600px; background-color:#ffffff;margin: auto;border: 1px solid #eaeaea;padding: 20px;border-radius: 5px;'>
                                            <center><img src='".$setting_email_logo_linksrc."' style='height:50px'></center>
            
                                            <div style='padding: 10px;text-align: justify;'>
                                                <strong>Informasi Data Demo Account</strong><br>
            
                                                Hi <strong>".$user1['MBR_NAME'].", </strong><br>
                                                
                                                <ul>
                                                    <li>Login : ".($createaccount['login'])."</li>
                                                    <li>Password Master : ".$meta_pass."</li>
                                                    <li>Password Investor : ".$meta_investor."</li>
                                                </ul>
            
                                                Terima Kasih.
            
            
                                                <br><br>
                                                Dari Kami,<br>
                                                ".$web_name_full." Team Support
                                            </div>
                                            <hr>
                                            <p>
                                                <small>
                                                    Anda menerima email ini karena Anda mendaftar di ".$setting_front_web_link." jika Anda memiliki<br>
                                                    pertanyaan, silahkan hubungi kami melalui email di ".$setting_email_support_name.". Anda juga dapat menghubungi<br>
                                                    nomor ".$setting_number_phone." 
                                                </small>
                                                <br>
                                                <small>
                                                    <a href='".$setting_insta_link."'><img src='".$setting_insta_linksrc."'></a>
                                                    <a href='".$setting_facebook_link."'><img src='".$setting_facebook_linksrc."'></a>
                                                    <a href='".$setting_linkedin_link."'><img src='".$setting_linkedin_linksrc."'></a>
                                                </small>
                                            </p>
                                            <hr>
                                            <p>
                                                <small>
                                                    <strong>Phone</strong> : <a href='tel:".$setting_office_number."'>".$setting_office_number."</a><br>
                                                    <strong>Support</strong> : <a href='mailto:".$setting_email_support_name."'>".$setting_email_support_name."</a><br>
                                                    <strong>Website</strong> : <a href='www.".$setting_front_web_link."'>".$setting_front_web_link."</a><br>
                                                    <strong>Address</strong> : ".$setting_central_office_address."<br>
                                                    <br>
                                                    Resmi dan diatur oleh Badan Pengawas Perdagangan Berjangka Komoditi. Nomor registrasi BAPPEBTI : 912/BAPPEBTI/SI/8/2006.
                                                </small>
                                            </p><hr>
                                            <p style='text-align: justify;'>
                                                <small>
                                                    <strong>PEMBERITAHUAN RESIKO:</strong><br>
                                                    Semua produk finansial yang ditransaksikan dalam sistem margin mempunyai resiko tinggi terhadap dana Anda. Produk finansial ini tidak diperuntukkan bagi semua investor dan Anda bisa saja kehilangan dana lebih dari deposit awal Anda. Pastikan bahwa Anda benar-benar mengerti resikonya, dan mintalah nasihat independen jika diperlukan. Lihat Pemberitahuan Resiko lengkap kami di Ketentuan Bisnis.
                                                </small>
                                            </p>
                                        </div>
                                        <div style='max-width: 1000px; margin: auto;padding: 20px'></div>
                                    </body>
                                </html>
                                ";
                                $mail->send();
                                echo 'Message has been sent';
                                //die("<script>location.href = 'home.php?page=accout&notif=account success created'</script>");
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                //die("<script>location.href = 'home.php?page=accout&notif=account success created'</script>");
                            }
                        }else{ die("<script>loctaion.href='home.php?page=dashboard&notif=".base64_encode('Gagal membuat demo account silahkan coba lagi')."'</script>"); }


?>

    <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert">
        <span class="alert-icon"><i class="fa fa-check font-18"></i></span>
        <h4 class="text-uppercase color-white">Success</h4>
        <strong class="alert-icon-text">Account demo has been created.</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
    </div>

    <div class="card card-style">
        <div class="content">
            <table class="table table-striped table-hover">
                <tr>
                    <td>Login</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo ($createaccount['login']); ?></td>
                </tr>
                <tr>
                    <td>Master</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo ($meta_pass); ?></td>
                </tr>
                <tr>
                    <td>Investor</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td><?php echo ($meta_investor); ?></td>
                </tr>
            </table>
            
            <a href="home.php?page=account" class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m">Back to List Account</a>
        </div>
    </div>
<?php

                        
                    } else { die("<script>location.href = 'home.php?page=account&notif=account already exist'</script>"); }
                } else if($type == 'live'){
                    $SQL_QUERY = mysqli_query($db, '
                        SELECT tb_racc.*
                        FROM tb_racc
                        WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                        AND tb_racc.ACC_WPCHECK = 0
                        AND tb_racc.ACC_LOGIN = 0
                        AND tb_racc.ACC_DERE = 1
                        AND tb_racc.ACC_TYPE = 1
                    ');
                    if(mysqli_num_rows($SQL_QUERY) < 2) {
                        mysqli_query($db, '
                            INSERT INTO tb_racc SET
                            tb_racc.ACC_MBR = '.$user1['MBR_ID'].',
                            tb_racc.ACC_DERE = 1,
                            tb_racc.ACC_TYPE = 1,
                            tb_racc.ACC_DEVICE = "Mobile"
                        ') or die("<script>location.href = 'home.php?page=personal-information'</script>");
                        
                        $SQL_QUERY = mysqli_query($db, '
                            SELECT MD5(MD5(tb_racc.ID_ACC)) AS ID_ACC
                            FROM tb_racc
                            WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                            AND tb_racc.ACC_WPCHECK = 0
                            AND tb_racc.ACC_LOGIN = 0
                            AND tb_racc.ACC_DERE = 1
                            AND tb_racc.ACC_TYPE = 1
                            LIMIT 1
                        ');
                        if(mysqli_num_rows($SQL_QUERY) > 0) {
                            $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
?>
<div class="page-title page-title-small">
    <h2>Create Account Live</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style">
    <div class="content">
        <img src="assets/img/live_001.png" alt="image" class="imaged img-fluid">
        <h2 class="mt-3 mb-2">Selamat bergabung bersama PT. International Business Futures!</h2>
        <p>
            Eksekusi Cepat, data pasar real-time, dan saran serta pelatihan broker pribadi gratis untuk membantu Anda
            manfaatkan investasi Anda sebaik-baiknya
        </p>
        <a href="home.php?page=racc/createaccountreal&id=<?php echo $RESULT_QUERY['ID_ACC']; ?>" class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m">Mulai Gunakan IBF Trader</a>
    </div>
</div>
<?php
                            die("<script>location.href = 'home.php?page=racc/createaccountreal&id=".$RESULT_QUERY['ID_ACC']."'</script>");
                        } else {die("<script>alert('please try again');location.href = 'home.php?page=account'</script>"); }
                    } else {die("<script>alert('your account still creating');location.href = 'home.php?page=account'</script>"); }
                };
            }
        }
    }
?>
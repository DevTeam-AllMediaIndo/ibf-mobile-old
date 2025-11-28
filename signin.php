<?php
require_once 'vendor/autoload.php';
if(!isset($_SESSION)){
    session_start();
}
if(empty($_SESSION["wrpass_count"])){
    $_SESSION["wrpass_count"] = 0;
}
include_once('setting.php');
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Check if form was submitted:
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['submit'])) {
            if(isset($_POST['email'])) {
                if(isset($_POST['password'])) {
                    $mail = strtolower(form_input($_POST["email"]));
                    $pass = form_inputpass($_POST["password"]);
                    
                    $sql_ver = mysqli_query($db, 'SELECT  MBR_EMAIL, MBR_STS, MBR_ID FROM tb_member WHERE LOWER(MBR_EMAIL) = LOWER("'.$mail.'") LIMIT 1');
                    if(mysqli_num_rows($sql_ver) > 0){
                        $sql_rsltver = mysqli_fetch_assoc($sql_ver);
                        if($sql_rsltver["MBR_STS"] == 1){ die ("<script>location.href = 'signin.php?notif=".base64_encode('Your account has benn blocked!')."'</script>");  }
                        $sql_cari = mysqli_query($db, $cquer = 'SELECT  MBR_EMAIL, MBR_ID, MBR_STS FROM tb_member WHERE LOWER(MBR_EMAIL) = LOWER("'.$mail.'") AND MBR_PASS = "'.$pass.'" LIMIT 1');
                        if(mysqli_num_rows($sql_cari) > 0){
                            $sql_rsl = mysqli_fetch_assoc($sql_cari);
                            $sql_cari1= mysqli_query($db, "
                                SELECT 
                                    MBR_EMAIL, 
                                    MBR_PASS, 
                                    MBR_ID, 
                                    MBR_STS 
                                FROM tb_member 
                                WHERE MBR_PASS = '".$pass."'
                                AND MBR_EMAIL = '".$sql_rsl["MBR_EMAIL"]."'
                                AND MBR_ID = ".$sql_rsl["MBR_ID"]."
                                LIMIT 1
                            ");
                            $test = base64_encode($pass.' '.$sql_rsl["MBR_EMAIL"].' '.$sql_rsl["MBR_ID"]);
                            if(mysqli_num_rows($sql_cari1) > 0) {
                                $sql_rsl1 = mysqli_fetch_assoc($sql_cari1);

                                $EXEC_SQL = mysqli_query($db, "
                                    UPDATE tb_member SET
                                    tb_member.MBR_IP = '".$IP_ADDRESS."'
                                    WHERE tb_member.MBR_ID = ".$sql_rsl["MBR_ID"]."
                                ") or die ("<script>alert('Please try again, or contact support');location.href = 'Javascript:history.back(1)'</script>");

                                if($sql_rsl1['MBR_STS'] == -1){

                                    setcookie('id', md5(md5($sql_rsl1['MBR_ID'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                                    setcookie('x', md5(md5($sql_rsl1['MBR_EMAIL'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                                    die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Success login')."'</script>");
                                } else if($sql_rsl1['MBR_STS'] == 0){
                                    setcookie('id', md5(md5($sql_rsl1['MBR_ID'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                                    setcookie('x', md5(md5($sql_rsl1['MBR_EMAIL'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                                    die ("<script>location.href = 'otp.php'</script>");
                                } else { die ("<script>location.href = './'</script>"); }

                            } else { 
                                logerr("Password/Email Salah", "Signin", $sql_rsl["MBR_ID"]);
                                die ("<script>location.href = 'signin.php?notif=".base64_encode('check your email / password ')."&ant=$test'</script>"); 
                            }
                        } else { 
                            logerr("Password/Email Salah", "Signin", $sql_rsltver["MBR_ID"]);
                            if($_SESSION["wrpass_count"] == 5){

                                $SQL_EMAIL = mysqli_query($db, '
                                    SELECT
                                        tb_member.MBR_NAME
                                    FROM tb_member
                                    WHERE MBR_EMAIL = "'.$mail.'"
                                ');
                                if($SQL_EMAIL && mysqli_num_rows($SQL_EMAIL) > 0){
                                    $RSLT_EMAIL = mysqli_fetch_assoc($SQL_EMAIL);
                                    $MBR_EMAIL  = $mail;
                                    $MBR_NAME   = $RSLT_EMAIL["MBR_NAME"];
                                }else{
                                    $MBR_EMAIL  = $mail;
                                    $MBR_NAME   = 'Costumer';
                                }
                                $UPDT_BLOCK = mysqli_query($db, '
                                    UPDATE tb_member SET
                                        tb_member.MBR_STS = 1
                                    WHERE MBR_EMAIL = "'.$mail.'"
                                ');


                                
                                // Message Telegram
                                $mesg_othr = 'Notif : Email Diblokir'.
                                PHP_EOL.'Date : '.date("Y-m-d").
                                PHP_EOL.'Time : '.date("H:i:s").
                                PHP_EOL.'=================================='.
                                PHP_EOL.'                 Informasi User'.
                                PHP_EOL.'=================================='.
                                PHP_EOL.'Email : '.$mail;
                                $request_params_othr = [
                                    'chat_id' => $chat_id_othr,
                                    'text' => $mesg_othr
                                ];
                                http_request('https://api.telegram.org/bot'.$token_othr.'/sendMessage?'.http_build_query($request_params_othr));


                                $SendMail = new PHPMailer(true);
                                try {
                                    //Server settings
                                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                    $SendMail->isSMTP();
                                    $SendMail->Host       = $setting_email_host_api;
                                    $SendMail->SMTPAuth   = true;
                                    $SendMail->Username   = $setting_email_support_name;
                                    $SendMail->Password   = $setting_email_support_password;
                                    $SendMail->SMTPSecure = $setting_email_port_encrypt;
                                    $SendMail->Port       = $setting_email_port_api;
        
                                    //Recipients
                                    $SendMail->setFrom($setting_email_support_name, 'PT.International Business Futures');
                                    $SendMail->addAddress($MBR_EMAIL, $MBR_NAME);
                                    // $SendMail->addAddress('indooallmedia@gmail.com', $MBR_NAME);
                                    
                                    //Content
                                    $SendMail->isHTML(true);
                                    $SendMail->Subject = 'Account Blocked | '.date("Y-m-d H:i:s");
        
                                    $SendMail->Body    = "
                                        <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                                        <html hola_ext_inject='disabled' xmlns='http://www.w3.org/1999/xhtml'>
                                            <head>
                                                <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                                <title>Account Blocked</title>
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
                                            <body style='background-color:#f9f9f9'>
                                                <div style='max-width: 1000px; margin: auto;padding: 20px'>
                                                    <center><img src='https://ibftrader.allmediaindo.com/assets/img/logoibf.png' style='height:50px'></center>
                                                </div>
                                                <div style='max-width: 600px; background-color:#ffffff;margin: auto;border: 1px solid #eaeaea;padding: 20px;border-radius: 5px;'>
                                                    <div style='background-color:#f9f9f9;padding: 10px;border-radius: 5px;'>
                                                        <strong>Security Notice: Your Account Has Been Blocked</strong>
                                                    </div>
                                                    <div style='padding: 10px;'>
                                                    Dear ".$MBR_NAME.", <br>
                                                        <p>Your account has been blocked due to 5 incorrect password attempts. To unblock your account, please create a ticket by tapping the Ticket button at the bottom of the Sign In page in your IBF Trader application</p>
                                                        
                                                        Best regard,<br>
                                                        Team Support
                                                    </div>
                                                </div>
                                            </body>
                                        </html>
                                    ";
                                    $SendMail->send();
                                    $eml_sts = 'Sent';
                                    // echo 'Message has been sent';
                                } catch (Exception $e) {
                                    $eml_sts = 0;
                                    logerr(str_replace("'", "", $e->getMessage()), "Signin");
                                    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";die;
                                    // die ("<script>location.href = 'signin.php?notif=".base64_encode('check your email for OTP CODE..')."'</script>");
                                }
                                // die ("<script>location.href = 'signin.php?notif=".base64_encode('Your account has benn blocked! eml: '.$eml_sts)."'</script>"); 
                                die ("<script>location.href = 'signin.php?notif=".base64_encode('Your account has benn blocked!')."'</script>"); 
                            }
                            // $_SESSION["wrpass_count"] = ($_SESSION["wrpass_count"] + 1);
                            die ("<script>location.href = 'signin.php?notif=".base64_encode('Password/Email Salah')."'</script>"); 
                        }
                    } else { 
                        logerr("Email: $mail Tidak Terdaftar", "Signin");
                        die ("<script>location.href = 'signin.php?notif=".base64_encode('Invalid email / password')."'</script>"); 
                    }

                } else { 
                    logerr("Parameter Ke-3 Tidak Lengkap", "Signin");
                    die ("<script>location.href = 'signin.php?notif=".base64_encode('please try again')."'</script>"); 
                }
            } else { 
                logerr("Parameter Ke-2 Tidak Lengkap", "Signin");
                die ("<script>location.href = 'signin.php?notif=".base64_encode('please try again')."'</script>"); 
            }
        } else { 
            logerr("Parameter Ke-1 Tidak Lengkap", "Signin");
            die ("<script>location.href = 'signin.php?notif=".base64_encode('please try again')."'</script>"); 
        }
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
    <div id="menu-success-1" class="menu menu-box-modal rounded-m" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-menu-height="600" data-menu-width="310">
        <h1 class="text-center mt-3 pt-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 16 16">
                <path fill="#005baa" fill-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M9 5a1 1 0 1 1-2 0a1 1 0 0 1 2 0M7 7a.75.75 0 0 0 0 1.5h.25v2h-1a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-1V7z" clip-rule="evenodd"/>
            </svg>
        </h1>
        <h1 class="text-center mt-3 font-700">Informasi</h1>
        <p class="boxed-text-l">
            KEBIJAKAN PRIVASI<br>
            Selamat datang di website resmi PT International Business Futures (https://ibftrader.com/) yang dikembangkan dan dikelola oleh PT International Business Futures melalui (<?php echo $setting_dev_name ?>). Kami berkomitmen untuk melindungi privasi Anda dan menjaga informasi pribadi Anda tetap aman. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan saat mengakses atau menggunakan layanan kami. Dengan mengakses atau menggunakan layanan kami, Anda menyetujui praktik yang dijelaskan dalam kebijakan privasi ini.<br>
            Kami berkomitmen untuk menghargai dan melindungi data pengguna dan mematuhi segala peraturan perundang-undangan dan kebijakan pemerintah Republik Indonesia yang berlaku, termasuk yang mengatur tentang informasi dan transaksi elektronik, penyelenggaraan sistem elektronik, dan perlindungan data pribadi. Kebijakan privasi ini dirancang untuk membantu pengguna memahami bagaimana kami mengumpulkan, menggunakan, mengungkapkan dan/atau mengolah data pribadi pengguna. <br>
            Dengan menggunakan layanan, mendaftar, mengunjungi atau mengakses layanan kami, anda setuju untuk memberikan data yang benar dan akurat dan memberitahukan ketidakakuratan atau perubahan informasi yang ada, serta mengizinkan kami untuk mengumpulkan, menggunakan, mengungkapkan dan/atau mengolah data pribadi anda. Layanan berarti produk, layanan, konten, fitur, teknologi, atau fungsi, situs web yang kami tawarkan untuk pengguna.<br>
            <br><br><br>
            PENGUMPULAN DATA<br>
            Kami akan atau mungkin mengumpulkan data pribadi pengguna pada website yang mengharuskan pengguna memberikan data pribadi. Informasi yang kami minta akan disimpan oleh kami dan digunakan seperti yang dijelaskan dalam kebijakan privasi ini.<br>
            Perangkat pengguna mengirimkan informasi yang mungkin mencakup data mengenai pengguna yang dapat dicatat oleh server web apabila pengguna menggunakan layanan kami. Ini biasanya termasuk namun tidak terbatas pada, alamat Internet Protocol (IP), sistem operasi komputer/ perangkat mobile, dan jenis browser, jenis perangkat mobile, karakteristik perangkat mobile, unique device identifier (UDID) atau mobile equipment identifier (MEID) perangkat mobile, alamat dari situs yang merekomendasikan (apabila ada), halaman yang dikunjungi di situs web kami dan waktu kunjungan pengguna, dan kadang "cookie" (yang dapat dinonaktifkan dengan menggunakan preferensi) untuk membantu situs mengingat kunjungan pengguna yang terakhir. Jika pengguna log in (masuk), informasi ini dikaitkan dengan akun pribadi pengguna. Informasi tersebut juga disertakan dalam statistik anonim untuk memungkinkan kami memahami cara pengunjung menggunakan situs kami.<br>
            <br><br><br>
            PENYIMPANAN DATA<br>
            Kami menerapkan berbagai langkah pengamanan dan berusaha untuk memastikan keamanan data pribadi pengguna di sistem kami. Data pribadi pengguna berada di belakang jaringan yang aman yang sudah terdapat firewall dan hanya dapat diakses oleh sejumlah kecil pengelola yang memiliki hak akses khusus ke sistem tersebut. Namun demikian, tidak adanya jaminan atau keamanan absolut tidak dapat terhindarkan dan pemberian informasi oleh pengguna merupakan resiko yang ditanggung oleh pengguna sendiri, sehingga sangat kami sarankan juga untuk menjaga keamanan username dan password masing-masing pengguna. Data dan informasi pengguna akan disimpan selama masih diperlukan, digunakan untuk tujuan sebagaimana dimaksud pada kebijakan privasi ini.<br>
            <br><br><br>
            PENGGUNAAN DATA<br>
            Kami menggunakan data pribadi pengguna yang diperoleh atau dikumpulkan termasuk untuk hal berikut, namun tidak terbatas untuk memproses transaksi atau aktivitas pengguna layanan website, melakukan kegiatan internal seperti pengelolaan, pengoperasian, penyediaan layanan, menyelesaikan permasalahan software, bug, analisis data, pengujian, pemantauan, monitoring ataupun investigasi transaksi dan penggunaan data lainnya untuk kepentingan pengguna dan PT. International Business Futures.<br>
            <br><br><br>
            TAUTAN KE SITUS LAIN<br>
            Layanan ini mungkin berisi tautan ke situs lain. Jika Anda mengklik tautan pihak ketiga, Anda akan diarahkan ke situs itu. Perhatikan bahwa situs eksternal ini tidak dioperasikan oleh kami. Oleh karena itu, kami sangat menyarankan Anda untuk meninjau Kebijakan Privasi dari situs web ini. Kami tidak memiliki kendali atas dan tidak bertanggung jawab atas konten, kebijakan privasi, atau praktik dari situs atau layanan pihak ketiga.<br>
            <br><br><br>
            PERUBAHAN KEBIJAKAN PRIVASI<br>
            Kami sewaktu-waktu dapat melakukan perubahan atau pembaharuan Kebijakan Privasi ini demi keamanan dan kenyamanan transaksi pengguna layanan kami tanpa pemberitahuan sebelumnya. Dengan tetap menggunakan layanan kami, maka pengguna setuju bahwa bertanggungjawab untuk membaca secara seksama dan memeriksa kebijakan privasi dari waktu ke waktu untuk mengetahui pembaharuan atau perubahan apapun.<br>
            <br><br><br>

            KONTAK KAMI<br>
            <?php echo $web_name_full ?><br>
            <?php echo $setting_central_office_address ?><br>
            Telepon: <?php echo $setting_office_number ?><br>
            Email: <?php echo $setting_email_support_name2 ?>
            <br><br><br>
        </p>
        
        <div class="custom-control custom-checkbox mt-3 mb-1">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" chacked=true id="customCheckb1">
                <label class="form-check-label" for="customCheckb1">
                    Saya telah membaca dan menyetujui kebijakan privasi yang diterapkan oleh PT. international Business Futures
                </label>
            </div>
        </div>
        <button type="button" id="agg_btn" class="mb-3 close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green-light mt-3" disabled>OKE</button>
    </div>
    <div id="page">
        <div class="page-content">
            <div class="page-title page-title-small">
                <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Sign In.</h2>
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
                <div class="content mt-2 mb-0">
                    <br>
                    <div class="text-center">
                        <img src="https://mobileibftraders.techcrm.net/assets/img/logoibf.png" width="226" height="86" style="margin-left: -26px;">
                    </div>
                    <br>
                    <br>
                    <form method="post">
                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-user"></i>
                            <input type="email" class="form-control validate-name" id="form1a" placeholder="Email" name="email" required autocomplete="off">
                            <label for="form1a" class="color-blue-dark font-10 mt-1">Email</label>
                            <em>(required)</em>
                        </div>

                        <div class="input-style no-borders has-icon validate-field mb-4">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control validate-password" id="form3a" placeholder="Password" name="password" required>
                            <label for="form3a" class="color-blue-dark font-10 mt-1">Password</label>
                            <em>(required)</em>
                        </div>

                        <button type="submit" name="submit" class="btn btn-m mt-4 mb-4 btn-full bg-green-dark rounded-sm text-uppercase font-900" style="width: 100%;">Login</button>
                        <!-- <div class="text-center"><a href="home.php?page=dashboard">Signin as guest</a></div> -->

                        <div class="divider"></div>

                        <a href="google_signin.php" class="btn btn-icon btn-m rounded-sm btn-full shadow-l bg-twitter text-uppercase font-700 text-start"><i class="fab fa-google text-center"></i>Signin with Google</a>

                        <div class="divider mt-4 mb-3"></div>

                        <div class="d-flex">
                            <div class="w-50 font-11 pb-2 color-theme opacity-60 pb-3 text-start"><a href="signup1.php" class="color-theme">Create Account</a></div>
                            <div class="w-50 font-11 pb-2 color-theme opacity-60 pb-3 text-end"><a href="forget.php" class="color-theme">Lupa Password</a></div>
                        </div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4 text-center">
                                <a href="ticket.php" class="color-theme w-50 font-11 pb-2 color-theme opacity-60 pb-3">Ticket</a>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </form>
                </div>
                <a href="#" data-menu="menu-success-1"  style="visibility: collapse;" id="mdl_btn"></a>
            </div>
        </div>
        <!-- end of page content-->
    </div>
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/custom.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById('mdl_btn').click();
            document.getElementById('customCheckb1').addEventListener('change', function(ev){
                console.log(this.checked);
                if(this.checked){
                    document.getElementById('agg_btn').disabled = false;
                }else{ document.getElementById('agg_btn').disabled = true; }
            });
        });
    </script>
</body>
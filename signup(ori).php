<?php
if(!isset($_SESSION)){
    session_start();
}
include_once('setting.php');
    require 'phpmailer/Exception.php';
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';
    
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['submit'])) {
            if(isset($_POST['fullname']) || 
                isset($_POST['email']) || 
                isset($_POST['password']) || 
                isset($_POST['passwordconf']) || 
                isset($_POST['phonenumber']) || 
                isset($_POST['username'])
            ){
                $MBR_NAME = $_POST["fullname"];
                $MBR_NAME = strtoupper($MBR_NAME);
                $MBR_USER = form_input($_POST["username"]);
                $MBR_USER = strtolower($MBR_USER);
                $MBR_EMAIL = form_input($_POST["email"]);
                $MBR_EMAIL = strtolower($MBR_EMAIL);
                $MBR_PHONE = form_input($_POST["phonenumber"]);
                $MBR_PHONE = strtolower($MBR_PHONE);
                $MBR_PASS = form_inputpass($_POST["password"]);
                $MBR_PASS1 = form_inputpass($_POST["passwordconf"]);
                $MBR_KODE = form_input($_POST["form_inv"]);
                if($MBR_KODE == 'X' || $MBR_KODE == 'x'){ $MBR_KODE = 'admin'; };
                $MBR_PASS = form_inputpass($_POST["password"]);

                if($MBR_PASS <> $MBR_PASS1){
                    die ("<script>alert('Please check password confirm');location.href = './'</script>");
                };
                
                /*
                if($MBR_USERSPN == ''){ $MBR_USERSPN = 'admin'; } else {
                    $MBR_USERSPN = form_input($_POST["sponsor"]);
                };
                */
                $MBR_USERSPN = 'admin';
                
                $QUERY_EMAIL = mysqli_query($db, 'SELECT MBR_ID FROM tb_member WHERE LOWER(MBR_EMAIL) = "'.$MBR_EMAIL.'" LIMIT 1');
                if(mysqli_num_rows($QUERY_EMAIL) < 1) {
                
                    $QUERY_USERNAME = mysqli_query($db, 'SELECT MBR_ID FROM tb_member WHERE MBR_USER = "'.$MBR_USER.'" LIMIT 1');
                    if(mysqli_num_rows($QUERY_USERNAME) < 1) {
                        
                        $QUERY_SPN = mysqli_query($db, '
                            SELECT
                                UNIX_TIMESTAMP(NOW())+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1) AS MBR_ID,
                                MD5(CONCAT(UNIX_TIMESTAMP(NOW())+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1),"'.$MBR_PASS.'")) AS MBR_HASH,
                                100000+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1) AS USERNAME,
                                MBR_ID AS MBR_IDSPN,
                                MBR_USER
                            FROM tb_member
                            WHERE MBR_CODE = "'.$MBR_KODE.'"
                            LIMIT 1
                        ');
                        if(mysqli_num_rows($QUERY_SPN) > 0) {
                            $RESULT_MBRID = mysqli_fetch_assoc($QUERY_SPN);
                            $ggg_hhh = rand(1000, 9999);
                            $ggg_hhh1 = rand(100000, 999999);
                            
                            //echo $SQL_QUERY;
                            $EXEC_SQL = mysqli_query($db, "
                                INSERT INTO tb_member SET
                                tb_member.MBR_ID = ".$RESULT_MBRID['MBR_ID'].",
                                tb_member.MBR_IDSPN = ".$RESULT_MBRID['MBR_IDSPN'].",
                                tb_member.MBR_OTP = ".$ggg_hhh.",
                                tb_member.MBR_CODE = ".$ggg_hhh1.",
                                tb_member.MBR_NAME = '".$MBR_NAME."',
                                tb_member.MBR_USER = '".$MBR_USER."',
                                tb_member.MBR_PASS = '".$MBR_PASS."',
                                tb_member.MBR_EMAIL = '".$MBR_EMAIL."',
                                tb_member.MBR_PHONE = '0".$MBR_PHONE."',
                                tb_member.MBR_STS = 0,
                                tb_member.MBR_DATETIME = '".date("Y-m-d H:i:s")."',
                                tb_member.MBR_IP = '".$IP_ADDRESS."'
                            ") or die (mysqli_error($db));
                            

                            $mail = new PHPMailer(true);
                            try {
                                //Server settings
                                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                $mail->isSMTP();
                                $mail->Host       = $setting_email_host_api;
                                $mail->SMTPAuth   = true;
                                $mail->Username   = $setting_email_support_name;
                                $mail->Password   = $setting_email_support_password;
                                $mail->SMTPSecure = $setting_email_port_encrypt;
                                $mail->Port       = $setting_email_port_api;

                                //Recipients
                                $mail->setFrom($setting_email_support_name, 'PT.International Business Futures');
                                $mail->addAddress($MBR_EMAIL, $MBR_NAME);
                                
                                //Content
                                $mail->isHTML(true);
                                $mail->Subject = 'Registration Confirmation | '.date("Y-m-d H:i:s");

                                $mail->Body    = "
                                    <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
                                    <html hola_ext_inject='disabled' xmlns='http://www.w3.org/1999/xhtml'>
                                        <head>
                                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                                            <title>Registration Confirmation</title>
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
                                                    <strong>Registration Info</strong>
                                                </div>
                                                <div style='padding: 10px;'>
                                                Dear ".$MBR_NAME.", <br>
                                                    Thank you for joining us, the registration process is completed!<br>
                                                    Your account has been created, and here are your account credentials:<br>
                                                    <ul>
                                                        <li>Email: ".$MBR_EMAIL."</li>
                                                        <li>Username: ".$MBR_USER."</li>
                                                        <li>Password: ".$MBR_PASS."</li>
                                                        <!--<li>Invitation Code: ".$ggg_hhh1."</li>-->
                                                    </ul><br>
                                                    
                                                    PIN Code : <strong style='background-color: black;color: white;'>&nbsp;".$ggg_hhh."&nbsp;</strong>
                                                    
                                                    <br><br>
                                                    Please, change your password in your account area & never share it with anyone!<br><br>
                                                    Best regard,<br>
                                                    Team Support
                                                </div>
                                            </div>
                                        </body>
                                    </html>
                                ";
                                $mail->send();
                                echo 'Message has been sent';
                                die ("<script>location.href = 'signin.php?notif=".base64_encode('check your email for OTP CODE.')."'</script>");
                            } catch (Exception $e) {
                                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                die ("<script>location.href = 'signin.php?notif=".base64_encode('check your email for OTP CODE..')."'</script>");
                            }
                        } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('Kode Referal Yang Anda Masukan Tidak Seusai. Silahkan Coba Lagi')."'</script>"); }
                    } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('Username Already Registered')."'</script>"); }
                } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('Email Already Registered')."'</script>"); }
            } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('Please try register again2')."'</script>"); }
        } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('Please try register again1')."'</script>"); }
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
</head>

<body class="theme-light">


<div id="page">

    <div class="page-content">

        <div class="page-title page-title-small">
            <h2><a href="signin.php" data-back-button><i class="fa fa-arrow-left"></i></a>Sign Up</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>

        <div class="card card-style">
            <div class="content mb-0 mt-1">
                <form method="post">
                    <div class="col-12">
                        <label for="fullname1" class="color-blue-dark font-10 mt-1"><i class="fa fa-user"></i> Full Name</label>
                        <input type="text" class="form-control validate-name" id="fullname1" placeholder="Your full name" name="fullname" required autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="username1" class="color-blue-dark font-10 mt-1"><i class="far fa-user"></i> Username</label>
                        <input type="text" class="form-control validate-name" id="username1" placeholder="Your user name" name="username" required autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="username1" class="color-blue-dark font-10 mt-1"><i class="fas fa-phone"></i> Phone Number</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" style="font-size: 12px;">+62</span>
                            <input type="number" class="form-control validate-phone" min="100000000" max="999999999999999" id="phonenumber2" placeholder="Make sure your phone number has whatsapp" name="phonenumber" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="email1" class="color-blue-dark font-10 mt-1"><i class="fa fa-at"></i> E-mail</label>
                        <input type="email" class="form-control validate-email" id="email1" placeholder="Your email" name="email" required autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="password1" class="color-blue-dark font-10 mt-1"><i class="fa fa-lock"></i> Password</label>
                        <input type="password" class="form-control validate-password" id="password1" placeholder="Your password" name="password" required>
                    </div>
                    <div class="col-12">
                        <label for="password2" class="color-blue-dark font-10 mt-1"><i class="fa fa-lock"></i> Password Again</label>
                        <input type="password" class="form-control validate-password" id="password2" placeholder="Type password again" name="passwordconf" required>
                    </div>
                    <div class="col-12">
                        <label for="invitation1" class="color-blue-dark font-10 mt-1"><i class="fa fa-ticket" aria-hidden="true"></i> Invitation Code</label>
                        <input type="text" class="form-control validate-invitation" id="invitation1" placeholder="(Jika tidak mempunyai refferal code isi dengan 'x')" name="form_inv" required autocomplete="off">
                    </div>
                    <div class="custom-control custom-checkbox mt-2 mb-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" chacked=true id="customCheckb1" required>
                            <label class="form-check-label" for="customCheckb1">
                                I agree <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and
                                    conditions</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" name="submit" class="btn btn-m btn-full rounded-sm shadow-l bg-green-dark text-uppercase font-700 mt-4" style="width:100%">Create account</button>

                    <div class="divider"></div>

                    <a href="google_signup.php" class="btn btn-icon btn-m rounded-sm btn-full shadow-l bg-twitter text-uppercase font-700 text-start"><i class="fab fa-google text-center"></i>Register with Google</a>

                    <div class="divider mt-4"></div>

                    <div class="d-flex">
                        <div class="w-50 font-11 pb-2 color-theme opacity-60 pb-3 text-start"><a href="signin.php" class="color-theme">Already registered?</a></div>
                        <div class="w-50 font-11 pb-2 color-theme opacity-60 pb-3 text-end"><a href="forget.php" class="color-theme">Forgot Credentials</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of page content-->
</div>

<!-- Terms Modal -->
<div class="modal fade modalbox" id="termsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions</h5>
                <a href="#" data-bs-dismiss="modal">Close</a>
            </div>
            <div class="modal-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fermentum, urna eget finibus
                    fermentum, velit metus maximus erat, nec sodales elit justo vitae sapien. Sed fermentum
                    varius erat, et dictum lorem. Cras pulvinar vestibulum purus sed hendrerit. Praesent et
                    auctor dolor. Ut sed ultrices justo. Fusce tortor erat, scelerisque sit amet diam rhoncus,
                    cursus dictum lorem. Ut vitae arcu egestas, congue nulla at, gravida purus.
                </p>
                <p>
                    Donec in justo urna. Fusce pretium quam sed viverra blandit. Vivamus a facilisis lectus.
                    Nunc non aliquet nulla. Aenean arcu metus, dictum tincidunt lacinia quis, efficitur vitae
                    dui. Integer id nisi sit amet leo rutrum placerat in ac tortor. Duis sed fermentum mi, ut
                    vulputate ligula.
                </p>
                <p>
                    Vivamus eget sodales elit, cursus scelerisque leo. Suspendisse lorem leo, sollicitudin
                    egestas interdum sit amet, sollicitudin tristique ex. Class aptent taciti sociosqu ad litora
                    torquent per conubia nostra, per inceptos himenaeos. Phasellus id ultricies eros. Praesent
                    vulputate interdum dapibus. Duis varius faucibus metus, eget sagittis purus consectetur in.
                    Praesent fringilla tristique sapien, et maximus tellus dapibus a. Quisque nec magna dapibus
                    sapien iaculis consectetur. Fusce in vehicula arcu. Aliquam erat volutpat. Class aptent
                    taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                </p>
            </div>
        </div>
    </div>
</div>
<!-- * Terms Modal -->

<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>
</html>
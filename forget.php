<?php
include_once "setting.php";
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
if(!isset($_SESSION)){
session_start();
}
// Check if form was submitted:
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['submit'])) {
            if(isset($_POST['email'])) {
                
                $email = strtolower(form_input($_POST["email"]));
                $pass = generatePassword(8);

				$sql_ver = mysqli_query($db, 'SELECT MBR_NAME, MBR_EMAIL, MBR_ID FROM tb_member WHERE LOWER(MBR_EMAIL) = "'.$email.'" AND MBR_STS = -1 LIMIT 1');
				if(mysqli_num_rows($sql_ver) > 0){
					$sql_rsl1 = mysqli_fetch_assoc($sql_ver);
					$EXEC_SQL = mysqli_query($db, "
						UPDATE tb_member SET
						tb_member.MBR_PASS = '".$pass."',
						tb_member.MBR_IP = '".$IP_ADDRESS."'
						WHERE tb_member.MBR_ID = ".$sql_rsl1["MBR_ID"]."
					") or die ("<script>alert('Please try again, or contact support');location.href = 'Javascript:history.back(1)'</script>");

					//===========================================================================

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
						$mail->setFrom($setting_email_support_name, $setting_title);
						$mail->addAddress($sql_rsl1['MBR_EMAIL'], $sql_rsl1['MBR_NAME']);

						//Content
						$mail->isHTML(true);
						$mail->Subject = 'Forget Password '.$setting_name.' '.date("Y-m-d H:i:s");
						$mail->Body    = "
							
						<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
							<html hola_ext_inject='disabled' xmlns='http://www.w3.org/1999/xhtml'>
								<head>
									<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
									<title>'.$setting_name.'</title>
									<style type='text/css'>
										@media only screen and (min-device-width:600px) {
											.content {
												width: 600px !important;
											}
										}

										@media only screen and (max-device-width:480px) {
											.text {
												font-size: 12px !important;
												-webkit-text-size-adjust: 100% !important;
												-moz-text-size-adjust: 100% !important;
												-ms-text-size-adjust: 100% !important;
											}

											.button {
												font-size: 16px !important;
												-webkit-text-size-adjust: 100% !important;
												-moz-text-size-adjust: 100% !important;
												-ms-text-size-adjust: 100% !important;
											}
										}
									</style>
								</head>
								<body style='background-color:#f9f9f9'>
									<div style='max-width: 1000px; margin: auto;padding: 20px'>
										<center>
											<img src='https://ibftrader.allmediaindo.com/assets/img/logoibf.png' style='height:50px'>
										</center>
									</div>
									<div style='max-width: 600px; background-color:#ffffff;margin: auto;border: 1px solid #eaeaea;padding: 20px;border-radius: 5px;'>
										<div style='background-color:#f9f9f9;padding: 10px;border-radius: 5px;'>
											<strong>Password Reset</strong>
										</div>
										<div style='padding: 10px;'> Dear ".$sql_rsl1['MBR_NAME'].", <br> Your account has been reset, and here are your account credentials: <br>
											<ul>
												<li>Email: ".$email."</li>
												<li>Password: ".$pass."</li>
											</ul>
											<br> Please, change your password in your account area & never share it with anyone! <br>
											<br> ".$setting_name." Team Support
										</div>
									</div>
									<br>
									<center style='text-decoration:none;padding-bottom:20px;'> ".$setting_name." - Team Support </center>
								</body>
							</html> ";

						$mail->send();
						echo 'Message has been sent';
						die ("<script>alert('check your email');location.href = './'</script>");
					} catch (Exception $e) {
						echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
						logerr("Tidak Dapat Mengirim email ke: $email", "Forget" , $sql_rsl1["MBR_ID"]);
						die ("<script>alert('Message could not be sent');location.href = './'</script>");
					}
					//===========================================================================
                                    
            	} else { 
					logerr("Email : $email tidak terdaftar", "Forget");
					die ("<script>location.href = 'signin.php?notif=".base64_encode('email '.$email.' not found.')."'</script>"); 
				}
            } else { 
				logerr("Parameter Kedua Hilang", "Forget");
				die ("<script>location.href = 'signin.php?notif=".base64_encode('please try again')."'</script>"); 
			}
        } else { 
			logerr("Parameter Pertama Hilang","Forget");
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
		<title>IBF Trader</title>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
		<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
		<link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
	</head>
	<body class="theme-light">
		<div id="page">
			<!-- header and footer bar go here-->
			<div class="header header-fixed header-auto-show header-logo-app">
				<a href="#" data-back-button class="header-title header-subtitle">Back to Pages</a>
				<a href="#" data-back-button class="header-icon header-icon-1">
					<i class="fas fa-arrow-left"></i>
				</a>
				<a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-dark">
					<i class="fas fa-sun"></i>
				</a>
				<a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-light">
					<i class="fas fa-moon"></i>
				</a>
				<a href="#" data-menu="menu-highlights" class="header-icon header-icon-3">
					<i class="fas fa-brush"></i>
				</a>
				<a href="#" data-menu="menu-main" class="header-icon header-icon-4">
					<i class="fas fa-bars"></i>
				</a>
			</div>
			<div class="page-content">
				<div class="page-title page-title-small">
					<h2>
						<a href="#" data-back-button>
							<i class="fa fa-arrow-left"></i>
						</a>Forgot
					</h2>
				</div>
				<div class="card header-card shape-rounded" data-card-height="150">
					<div class="card-overlay bg-highlight opacity-95"></div>
					<div class="card-overlay dark-mode-tint"></div>
					<div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
				</div>
				<div class="card card-style">
					<div class="content mb-0">
						<h4>Recover your Account</h4>
						<p> Simply enter your email name which you registered your account under and we'll send you the password reset instructions. </p>
						<form method="post">
							<div class="input-style no-borders has-icon validate-field mb-4">
								<i class="fa fa-at"></i>
								<input type="email" name="email" class="form-control validate-email" id="form1a" placeholder="name@domain.com" required autocomplete="off">
								<label for="form1a" class="color-blue-dark font-10 mt-1">Email</label>
								<i class="fa fa-times disabled invalid color-red-dark"></i>
								<i class="fa fa-check disabled valid color-green-dark"></i>
								<em>(required)</em>
							</div>
							<button type="submit" name="submit" class="btn btn-m mt-4 mb-3 btn-full rounded-sm bg-highlight text-uppercase font-700">Send Reset Instructions</button>
						</form>
						<div class="divider mt-4 mb-3"></div>
						<!-- <div class="d-flex"><div class="w-50 font-11 pb-2 color-theme opacity-60 pb-3 text-start"><a href="system-signin-1.html" class="color-theme">Access Account</a></div><div class="w-50 font-11 pb-2 color-theme opacity-60 pb-3 text-end"><a href="system-signup-1.html" class="color-theme">Create Account</a></div></div> -->
					</div>
				</div>
				<!-- footer and footer card-->
			</div>
			<!-- end of page content-->
			<div id="menu-share" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-load="menu-share.html" data-menu-height="420" data-menu-effect="menu-over"></div>
			<div id="menu-highlights" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-load="menu-colors.html" data-menu-height="510" data-menu-effect="menu-over"></div>
			<div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" data-menu-width="260" data-menu-load="menu-main.html" data-menu-active="nav-pages" data-menu-effect="menu-over"></div>
		</div>
		<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/custom.js"></script>
	</body>
</html>
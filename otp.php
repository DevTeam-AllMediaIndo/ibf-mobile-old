<?php
    date_default_timezone_set("Asia/Jakarta");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

if(!isset($_SESSION)){
    session_start();
}
    include_once('setting.php');


    
    if(isset($_COOKIE['id'])) {
        if(isset($_COOKIE['x'])) {

            $id = form_input($_COOKIE["id"]);
            $x = form_input($_COOKIE["x"]);
                                
            $SQL_QUERY = mysqli_query($db,'
                SELECT
                    tb_member.MBR_ID,
                    tb_member.MBR_OTP
                FROM tb_member
                WHERE MD5(MD5(tb_member.MBR_ID)) = "' . $id . '"
                AND MD5(MD5(tb_member.MBR_EMAIL)) = "' . $x . '" 
                LIMIT 1
            ');
                                
            if(mysqli_num_rows($SQL_QUERY) > 0) {
                $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);

                if(isset($_POST['submit'])){
                    if(isset($_POST['otp1'])){
                        if(isset($_POST['otp2'])){
                            if(isset($_POST['otp3'])){
                                if(isset($_POST['otp4'])){
                                    $otp1 = form_input($_POST["otp1"]);
                                    $otp2 = form_input($_POST["otp2"]);
                                    $otp3 = form_input($_POST["otp3"]);
                                    $otp4 = form_input($_POST["otp4"]);
                                    $otpcode = $otp1.''.$otp2.''.$otp3.''.$otp4;
            
                                    if($RESULT_QUERY["MBR_OTP"] == $otpcode){
                                        $EXEC_SQL = mysqli_query($db,'
                                            UPDATE tb_member SET
                                            tb_member.MBR_STS = -1
                                            WHERE tb_member.MBR_ID = "'.$RESULT_QUERY['MBR_ID'].'"
                                        ') or die (mysqli_error($db));
                                        die ("<script>location.href = 'home.php?page=dashboard'</script>");
                                    }else{ 
                                        logerr("OTP yang anda masukan salah", "OTP", $RESULT_QUERY["MBR_ID"]);
                                        die ("<script>location.href = 'signin.php?notif=".base64_encode('OTP yang anda masukan salah')."'</script>");
                                    }
                                }else { 
                                    logerr("Parameter Ke-4 Tidak Lengkap", "OTP", $RESULT_QUERY["MBR_ID"]);
                                    die ("<script>alert('Please try register again4');location.href = 'signin.php?notif=".base64_encode('Please try register again')."'</script>"); 
                                }
                            }else { 
                                logerr("Parameter Ke-3 Tidak Lengkap", "OTP", $RESULT_QUERY["MBR_ID"]);
                                die ("<script>alert('Please try register again4');location.href = 'signin.php?notif=".base64_encode('Please try register again')."'</script>"); 
                            }
                        }else { 
                            logerr("Parameter Ke-2 Tidak Lengkap", "OTP", $RESULT_QUERY["MBR_ID"]);
                            die ("<script>alert('Please try register again4');location.href = 'signin.php?notif=".base64_encode('Please try register again')."'</script>"); 
                        }
                    }else { 
                        logerr("Parameter Ke-1 Tidak Lengkap", "OTP", $RESULT_QUERY["MBR_ID"]);
                        die ("<script>alert('Please try register again4');location.href = 'signin.php?notif=".base64_encode('Please try register again')."'</script>"); 
                    }
                }
            } else {
                logerr("Cookie Tidak Sesuai", "OTP");
                die ("<script>location.href = 'signin.php?notif=".base64_encode('Cookie Tidak Sesuai')."'</script>");
            }
        }else{
            logerr("Tidak Ada Parameter Cookie Ke-2", "OTP");
            die ("<script>location.href = 'signin.php?notif=".base64_encode('Tidak Ada Parameter Cookie Ke-2')."'</script>");
        }
    }else{
        logerr("Tidak Ada Parameter Cookie Ke-1", "OTP");
        die ("<script>location.href = 'signin.php?notif=".base64_encode('Tidak Ada Parameter Cookie Ke-1')."'</script>");
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
<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
</head>

<body class="theme-light">

<!-- <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div> -->

<div id="page">

    <div class="page-content">

        <div class="page-title page-title-small">
            <h2><a href="signin.php" data-back-button><i class="fa fa-arrow-left"></i></a>OTP</h2>
            <!--
            <a href="#" data-menu="menu-main" class="bg-fade-highlight-light shadow-xl preload-img" data-src="images/avatars/5s.png"></a>
            -->
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>

        <div class="card card-style text-center">
            <div class="content py-5">
				<h1><i class="fa fa-lock color-highlight fa-4x"></i></h1>
				<h1 class="pt-5 font-28">Verification Code</h1>
				<p class="boxed-text-l">
					Silahkana Masukan Kode OTP Yang Anda Terima Dari Email.
				</p>
                <form method="post">
                    <div class="text-center mb-3 pt-3 pb-2">
                        <input class="otp mx-1 rounded-sm text-center font-20 font-900" type="number" min="0" max="9" name="otp1" required value="&#10059">
                        <input class="otp mx-1 rounded-sm text-center font-20 font-900" type="number" min="0" max="9" name="otp2" required value="&#10059;">
                        <input class="otp mx-1 rounded-sm text-center font-20 font-900" type="number" min="0" max="9" name="otp3" required value="&#10059;">
                        <input class="otp mx-1 rounded-sm text-center font-20 font-900" type="number" min="0" max="9" name="otp4" required value="&#10059;">
                    </div>
                    <!-- <a href="#" class="text-center d-block mb-4 font-11">Didn't Receive OTP? Send code again</a> -->

                    <button type="submit" name="submit" class="back-button btn btn-m btn-center-l bg-highlight rounded-sm font-700 text-uppercase">Verify</button>
                </form>

            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>
</html>
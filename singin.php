<?php
require_once 'vendor/autoload.php';
if(!isset($_SESSION)){
    session_start();
}
$_SESSION["wrpass_count"] = 0;
include_once('setting.php');

// Check if form was submitted:
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['submit'])) {
            if(isset($_POST['email'])) {
                if(isset($_POST['password'])) {
                    $mail = strtolower(form_input($_POST["email"]));
                    $pass = form_inputpass($_POST["password"]);
                    
                    $sql_ver = mysqli_query($db, 'SELECT  MBR_EMAIL,  MBR_STS, MBR_ID FROM tb_member WHERE LOWER(MBR_EMAIL) = LOWER("'.$mail.'") LIMIT 1');
                    if(mysqli_num_rows($sql_ver) > 0){
                        $rslt_ver = mysqli_fetch_assoc($sql_ver);
                        if($rslt_ver["MBR_STS"] == 1){ die ("<script>location.href = 'signin.php?notif=".base64_encode('Your account has benn blocked!')."'</script>");  }
                        $sql_cari = mysqli_query($db, $cquer = 'SELECT  MBR_EMAIL, MBR_ID, MBR_STS FROM tb_member WHERE LOWER(MBR_EMAIL) = LOWER("'.$mail.'") AND MBR_PASS = '$pass' LIMIT 1');
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
                            $test = base64_encode(var_dump($pass, $sql_rsl["MBR_EMAIL"], $sql_rsl["MBR_ID"]));
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
                                    die ("<script>location.href = 'home.php?page=dashboard'</script>");
                                } else if($sql_rsl1['MBR_STS'] == 0){
                                    setcookie('id', md5(md5($sql_rsl1['MBR_ID'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                                    setcookie('x', md5(md5($sql_rsl1['MBR_EMAIL'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                                    die ("<script>location.href = 'otp.php'</script>");
                                } else { die ("<script>location.href = './'</script>"); }

                            } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('check your email / password '.$test)."'</script>"); }
                        } else { 
                            if($_SESSION["wrpass_count"] == 5){
                                $UPDT_BLOCK = mysqli_query($db, '
                                    UPDATE tb_member SET
                                        tb_member.MBR_STS = 1
                                    WHERE MBR_EMAIL = '$mail'
                                ');
                                die ("<script>location.href = 'signin.php?notif=".base64_encode('Your account has benn blocked!')."'</script>"); 
                            }
                            $_SESSION["wrpass_count"] = $_SESSION["wrpass_count"]++;
                            die ("<script>location.href = 'signin.php?notif=".base64_encode('Please confirmation your email first')."'</script>"); 
                        }
                    } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('Invalid email / password')."'</script>"); }
                } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('please try again')."'</script>"); }
            } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('please try again')."'</script>"); }
        } else { die ("<script>location.href = 'signin.php?notif=".base64_encode('please try again')."'</script>"); }
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
                    </form>
                </div>

            </div>
        </div>
        <!-- end of page content-->
    </div>
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/custom.js"></script>
</body>
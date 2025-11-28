<?php
include_once('setting.php');
if(isset($_GET["page"])){
    $login_page = htmlentities(str_replace('%', '', str_replace(' ', '_', stripslashes(($_GET['page'])))),ENT_QUOTES,'WINDOWS-1252');
    $page_title = ucwords(strtolower(str_replace('-', ' ', $login_page)));
} else { die ("<script>location.href ='../'</script>"); };
if (isset($_COOKIE['id'])) {
    if (isset($_COOKIE['x'])) {
        $id = form_input($_COOKIE["id"]);
        $x = form_input($_COOKIE["x"]);

        $sql_user = mysqli_query($db, '
            SELECT 
                tb_member.*,
                DATE_FORMAT(DATE(DATE_ADD(tb_member.MBR_TIMESTAMP, INTERVAL 7 HOUR)), "%d %b %Y") AS MBR_TIMESTAMP_DATE,
                TIME(DATE_ADD(tb_member.MBR_TIMESTAMP, INTERVAL 7 HOUR)) AS MBR_TIMESTAMP_TIME
            FROM tb_member 
            WHERE MD5(MD5(tb_member.MBR_ID)) = "' . $id . '"
            AND MD5(MD5(tb_member.MBR_EMAIL)) = "' . $x . '" 
            LIMIT 1
        ');
        if ($sql_user) {
            if (mysqli_num_rows($sql_user) > 0) {
                $user1 = mysqli_fetch_assoc($sql_user);
                $user_name = $user1['MBR_NAME'];

                setcookie('id', md5(md5($user1['MBR_ID'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                setcookie('x', md5(md5($user1['MBR_EMAIL'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                if($user1['MBR_STS'] <> -1){
                    die("<script>location.href ='otp.php'</script>");
                }
            } else { die ("<script>location.href ='signin.php?notif=".base64_encode('Please try register again')."'</script>"); }
        } else { die ("<script>location.href ='signin.php?notif=".base64_encode('Please try register again')."'</script>"); }
    } else { $user_name = 'Guest' ; }
} else {  $user_name = 'Guest' ;  }

$mbr_avatar = convertToBase64('assets/img/avatar-64.png');
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
<style>

    .radio_css {
        width: 20px;
        height: 20px;
        border: 3px solid #6c757d;
        border-color: #6c757d !important;
        padding: 5px;
    }
</style>
</head>
    
<body class="theme-light">
    
<div id="page">
    
    <!-- header and footer bar go here-->
    <div class="header header-fixed header-auto-show header-logo-app">
        <a href="#" data-back-button class="header-title header-subtitle">Back to Pages</a>
        <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-dark"><i class="fas fa-sun"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-light"><i class="fas fa-moon"></i></a>
        <a href="#" data-menu="menu-highlights" class="header-icon header-icon-3"><i class="fas fa-brush"></i></a>
    </div>
    <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert">
        <span class="alert-icon"><i class="fa fa-bell font-18"></i></span>
        <strong class="alert-icon-text"><?php echo "asdfkjlaksjdflk"; ?>.</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
    </div>
    <div id="footer-bar" class="footer-bar-5">
        <?php
            if($login_page == 'market'){
        ?>
        <script>
            setinterval_price = 1;
        </script>
        <?php
            } else {
        ?>
        <script>
            setinterval_price = 0;
        </script>
        <?php
            }
        ?>
        <a href="home.php?page=market" <?php if($login_page == 'market'){ echo 'class="active-nav"'; } ?>><i data-feather="bar-chart-2" data-feather-line="1" data-feather-size="21" data-feather-color="red-dark" data-feather-bg="red-fade-light"></i><span>Market</span></a>
        <a href="home.php?page=account" 
            <?php 
                if($login_page == 'account' || 
                $login_page == 'dpwddc'|| 
                $login_page == 'jadwal-temu'||
                $login_page == 'jadwal-temu1'||
                $login_page == 'racc/createaccountreal'||
                $login_page == 'racc/formapplication'||
                $login_page == 'racc/profileperusahaanpialang'||
                $login_page == 'racc/simulasiperdagangan'||
                $login_page == 'racc/pengalamantransaksi'||
                $login_page == 'racc/pernyataanpengungkapan'||
                $login_page == 'racc/aplikasipembukaanrekening01'||
                $login_page == 'racc/aplikasipembukaanrekening02'||
                $login_page == 'racc/aplikasipembukaanrekening03'||
                $login_page == 'racc/aplikasipembukaanrekening04'||
                $login_page == 'racc/aplikasipembukaanrekening05'||
                $login_page == 'racc/aplikasipembukaanrekening06'||
                $login_page == 'racc/aplikasipembukaanrekening07'||
                $login_page == 'racc/aplikasipembukaanrekening08'||
                $login_page == 'racc/aplikasipembukaanrekening09'||
                $login_page == 'racc/aplikasipembukaanrekening10'||
                $login_page == 'racc/aplikasipembukaanrekening11'||
                $login_page == 'racc/adanyaresiko'||
                $login_page == 'racc/dokumentadanyaresiko'||
                $login_page == 'racc/perjanjianamanat'||
                $login_page == 'racc/tradingrules'||
                $login_page == 'racc/kodeakses'||
                $login_page == 'racc/disclosure'||
                $login_page == 'racc/selesai'||
                $login_page == 'racc/deposit'||
                $login_page == 'list_account'){ echo 'class="active-nav"'; } 
            ?>
        >
            <i data-feather="server" data-feather-line="1" data-feather-size="21" data-feather-color="green-dark" data-feather-bg="green-fade-light"></i><span>account</span>
        </a>
        <a href="home.php?page=dashboard" <?php if($login_page == 'dashboard'||$login_page == 'blog-detail'){ echo 'class="active-nav"'; } ?>><i data-feather="home" data-feather-line="1" data-feather-size="21" data-feather-color="blue-dark" data-feather-bg="blue-fade-light"></i><span>Home</span></a>
        <a href="home.php?page=order" <?php if($login_page == 'order'){ echo 'class="active-nav"'; } ?>><i data-feather="file" data-feather-line="1" data-feather-size="21" data-feather-color="brown-dark" data-feather-bg="brown-fade-light"></i><span>Order</span></a>
        <a href="home.php?page=settings" 
            <?php 
                if($login_page == 'settings' ||
                $login_page == 'ajak_teman' ||
                $login_page == 'pusat_bantuan' ||
                $login_page == 'disclaimer' ||
                $login_page == 'syarat_ketentuan' ||
                $login_page == 'faq' ||
                $login_page == 'profile'){ echo 'class="active-nav"'; };
            ?>
        >
            <i data-feather="settings" data-feather-line="1" data-feather-size="21" data-feather-color="dark-dark" data-feather-bg="gray-fade-light"></i><span>Settings</span>
        </a>
    </div>
    
    <div class="page-content">
        <?php if($login_page == 'dashboard'){ ?>
            <div class="page-title page-title-large">
                <h2 data-username="<?php echo $user_name ?>" class="greeting-text"></h2>
                <a href="#" data-menu="menu-highlights" class="bg-fade-highlight-light shadow-xl preload-img" data-src="<?php echo $mbr_avatar; ?>"></a>
            </div>
            <div class="card header-card shape-rounded" data-card-height="270">
                <div class="card-overlay bg-highlight opacity-95"></div>
                <div class="card-overlay dark-mode-tint"></div>
                <div class="card-bg preload-img" data-src="<?php echo convertToBase64('images/pictures/20s.jpg'); ?>"></div>
            </div>
        <?php }; ?>
               
        <?php
            if(file_exists("doc/".$login_page.".php")){
                include "doc/".$login_page.".php";
            } else { include "doc/"."404.php"; };
        ?>
    </div>    
    <!-- end of page content-->
    
    <div id="menu-highlights" 
         class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-load="menu-colors.html"
         data-menu-height="510" 
         data-menu-effect="menu-over">        
    </div>
</div>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>

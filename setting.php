<?php
date_default_timezone_set("Asia/Jakarta");
putenv('AWS_SUPPRESS_PHP_DEPRECATION_WARNING=true');

$host_name = "45.76.176.106:1224";
$user_name = "root";
$password = "Masuk@1224";
$database = "db_ibftrader";
$db = mysqli_connect($host_name, $user_name, $password, $database);

$web_name_full = 'PT. International Business Futures';
$web_name = 'IBF Trader';

$setting_desc = 'The Ultimate Gateway to Trading Success.';
$setting_name = 'International Business Futures';
$setting_title = 'PT.International Business Futures';

$setting_front_web_link         = 'ibftrader.com';
$setting_central_office_address = 'PASKAL HYPER SQUARE BLOK D NO.45-46 JL. H.O.S COKROAMINOTO NO.25-27 BANDUNG, JAWA BARAT – 40181';
$setting_playstore_link         = 'https://play.google.com/store/apps/details?id=com.allmediaindo.ibftrader&hl=en';
$setting_office_number          = '(022) 86061128';
$setting_email_support_name     = 'notification@ibftrader.co.id';
$setting_email_support_password = 'ynacgsetzlpyicjm';
$setting_email_support_name2    = 'support@ibftrader.com';
$setting_email_logo_linksrc     = 'https://ibftrader.allmediaindo.com/assets/img/logoibf.png';
$setting_email_host_api         = 'smtp.gmail.com';
$setting_email_port_api         = '587';
$setting_email_port_encrypt     = 'tls';
$setting_number_phone           = '(022) 86061128';
$setting_fax_number             = '(022) 86061128';
$setting_insta_link             = 'https://www.instagram.com/ibf.trader/?hl=id';
$setting_facebook_link          = 'https://www.facebook.com/profile.php?id=100064234740634&mibextid=ZbWKwL';
$setting_linkedin_link          = 'https://www.linkedin.com/company/pt-international-business-futures/';
$setting_facebook_linksrc       = 'https://mobileibftraders.techcrm.net/assets/img/sosmed/fb.png';
$setting_insta_linksrc          = 'https://mobileibftraders.techcrm.net/assets/img/sosmed/ig.png';
$setting_linkedin_linksrc       = 'https://mobileibftraders.techcrm.net/assets/img/sosmed/linkedin.png';

$setting_dev_name = 'PT. All Media Indo';


// AWS Info
$region = 'ap-southeast-1';
$bucketName = 'allmediaindo-2';
$folder = 'ibftrader';
$IAM_KEY = 'AKIASPLPQWHJGPL7K3MB';
$IAM_SECRET = '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';

include_once 'module/MobileDetect.class.php'; 

$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
if(filter_var($client, FILTER_VALIDATE_IP)){ $IP_ADDRESS = $client;
} else if(filter_var($forward, FILTER_VALIDATE_IP)){ $IP_ADDRESS = $forward;
} else { $IP_ADDRESS = $remote; };

$mdetect = new MobileDetect(); 
$device_detect = '';
$os_detect = '';
if($mdetect->isMobile()){ 
    if($mdetect->isTablet()){ 
        $device_detect = 'Tablet'; 
    } else { 
        $device_detect = 'Mobile'; 
    } 

    if($mdetect->isiOS()){ 
        $os_detect = 'IOS'; 
    } else if($mdetect->isAndroidOS()){ 
        $os_detect = 'ANDROID';
    };
} else { 
    $device_detect = 'Desktop'; 
};
$device_and_os = $device_detect.' '.$os_detect;

$useragent=$_SERVER['HTTP_USER_AGENT'];

//==============TGM WPB====================
$chat_id = -1001987395922;
$token1 = '6085888588:AAFLm1TUrevDg8SO8tgMv_8yo6ZyobjoFSg';
//=========================================

//==============TGM Accounting====================
$chat_id_accounnting = -1001940540034;
$token_accounnting = '6161938463:AAE8j7k1X19O9pI99hxPkG_QQD14Z8lsNUo';
//================================================

//==============TGM Settlement====================
$chat_id_stllmnt = -1001892503389;
$token_stllmnt = '6221174683:AAFn6IwbtOfG6XW4tXI5FhOFVH2IZ0NnK6U';
//================================================

//==============TGM Dealer====================
$chat_id_dlr = -1001866565531;
$token_dlr = '6070107202:AAGaZj2T-oQkTCZTSQS4LdMyLPTNCTWJF-A';
//============================================

//==============TGM All=======================
$chat_id_all = -1001901689504;
$token_all = '6050317096:AAH4KA67JqakFtZxt29hiHlZK_Gic6B7C8Y';
//============================================

//==============TGM Other====================
$chat_id_othr = -1001879202892;
$token_othr = '6626297298:AAFoAup0Oo6tbXdHS2s4zdufW1v741zYtaA';
//===========================================

//==============TGM Ticket====================
$chat_id_tckt = -1003173460203;
$token_tckt = '8062724551:AAFzFJI7AVGe2eqfYXzJCCsJuRiknlxJLaY';
//===========================================




function masking_count_star($total){
    $tulis = '';
    $i = 1;
    while ($i <= $total){
        $tulis = $tulis.'*';
        $i++;
    }
    return $tulis;
}
function msqrade($name){
    $half = ((strlen($name)*60) / 100);
    return substr($name, 0, -$half).masking_count_star($half);
}
function checkmobile_device(){
    global $useragent;
    $mobile_agents = '!(tablet|pad|mobile|phone|symbian|android|ipod|ios|blackberry|webos)!i';
    if (preg_match($mobile_agents, $_SERVER['HTTP_USER_AGENT'])) {
        $a1 = substr($useragent, strpos(strtolower($useragent), 'android'), strlen($useragent));
        $a2 = strpos(strtolower($a1), 'build');
        $a3 = substr($a1, 0, $a2).';';
        $a4 = explode(';', $a3);
        $out['mobile'] = 'yes';
        $out['type'] = $a4[0];
        $out['name'] = $a4[1];
    } else {
        $out['mobile'] = 'no';
        $out['type'] = 'unknown';
        $out['name'] = 'unknown';
    }
    return $out;
}

$agent_var_type = checkmobile_device()['type'];
$agent_var_name = checkmobile_device()['name'];

function insert_log($id_log, $message_log){
    global $db;
    global $IP_ADDRESS;
    global $agent_var_type;
    global $agent_var_name;
    mysqli_query($db, "
        INSERT INTO tb_log SET
        tb_log.LOG_MBR = ".$id_log.",
        tb_log.LOG_MESSAGE = '".$message_log."',
        tb_log.LOG_IP = '".$IP_ADDRESS."',
        tb_log.LOG_DEVICE = '".$agent_var_type."',
        tb_log.LOG_DEVICENAME = '".$agent_var_name."',
        tb_log.LOG_DATETIME = '".date("Y-m-d H:i:s")."'
    ") or die (mysqli_error($db));
}
function logerr($messg_log, $pge, $id_usr = 'NULL'){
    global $db;
    global $IP_ADDRESS;
    global $agent_var_type;
    global $agent_var_name;
    mysqli_query($db, "
        INSERT INTO tb_log_err SET
        tb_log_err.LOGERR_MBR = ".$id_usr.",
        tb_log_err.LOGERR_MESSAGE = '".$messg_log."',
        tb_log_err.LOGERR_IP = '".$IP_ADDRESS."',
        tb_log_err.LOGERR_DEVICE = '".$agent_var_type."',
        tb_log_err.LOGERR_DEVICENAME = '".$agent_var_name."',
        tb_log_err.LOGERR_PAGE = '".$pge."',
        tb_log_err.LOGERR_DATETIME = '".date("Y-m-d H:i:s")."'
    ") or die(mysqli_error($db));

}
function curl_get_contents($url){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
    
    function imageToBase64($image){
        $imageData = base64_encode(curl_get_contents($image));
        $mime_types = array(
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'odt' => 'application/vnd.oasis.opendocument.text ',
            'docx'	=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'gif' => 'image/gif',
            'jpg' => 'image/jpg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'bmp' => 'image/bmp',
            'svg' => 'image/svg'
        );
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        
        if (array_key_exists($ext, $mime_types)) {
            $a = $mime_types[$ext];
        }
        return 'data: '.$a.';base64,'.$imageData;
    }
    
    function convertToBase64($image){
        $imageData = base64_encode(file_get_contents($image));
        $mime_types = array(
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'odt' => 'application/vnd.oasis.opendocument.text ',
            'docx'	=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'gif' => 'image/gif',
            'jpg' => 'image/jpg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'bmp' => 'image/bmp',
            'svg' => 'image/svg'
        );
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        
        if (array_key_exists($ext, $mime_types)) {
            $a = $mime_types[$ext];
        }
        return 'data: '.$a.';base64,'.$imageData;
    }
    
    function remoteFileExists($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        $ret = false;
        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
            if ($statusCode == 200) {
                $ret = true;   
            }
        }
        curl_close($curl);
        return $ret;
    }
    
    function svgToBase64 ($filepath){  
        if (file_exists($filepath)){
            $filetype = pathinfo($filepath, PATHINFO_EXTENSION);
            if ($filetype==='svg'){
                $filetype .= '+xml';
            }
            $get_img = file_get_contents($filepath);
            return 'data:image/' . $filetype . ';base64,' . base64_encode($get_img );
        }
    }
    
    function Redirect($url, $permanent = false){
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }
        
    function form_input($input_form){
        global $db;
        return htmlspecialchars(trim(addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($input_form))))));
    }
    
    function form_inputpass($input_form){
        global $db;
        return htmlspecialchars((addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($input_form))))));
    }
    
    function mt4api_connect_post($path, $data){
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-mt4.techcrm.net/um9iemwl/'.$path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            //CURLOPT_POSTFIELDS => 'name=alfi&group=demoindex-MMI&password=Python1234&investor=Python1234&country=Indonesia&state=Jawa%20Timur&email=allmediaindo%40gmail.com&city=Surabaya&comment=Example%20comment&leverage=100&zip_code=43199&phone=0812233&address=Example%20Address&enable=1&enable_change_password=1&phone_password=PhonePassword&login=10066377',
            CURLOPT_HTTPHEADER => array(
                'key: be70d400b871d5bdac806e3adb00de26',
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
    
        $response = curl_exec($curl);
        return json_decode($response, true);
        curl_close($curl);
    };
    
    function mt4api_connect_get($path){
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-mt4.techcrm.net/um9iemwl/'.$path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'key: be70d400b871d5bdac806e3adb00de26'
            ),
        ));
    
        $response = curl_exec($curl);
        return json_decode($response, true);
        curl_close($curl);
    };

    
    function mt4api_demo_post($mt_v, $cmd, $syntax){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-mt5.techcrm.net/v3/'.$mt_v.'/'.$cmd.'?'.$syntax,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'key: 73b8d8fe0ced9cd3fde08852f9221b83'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
        // return $response;
        
    }
    function MetaCreateDemo($syntax){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'http://139.180.212.62:7004/AccountCreate?id=d9759288-5e38-4f9b-9ce3-36669586e63d-ibfmmf_demo&'.$syntax,
            CURLOPT_URL => 'http://139.180.219.85:7004/AccountCreate?id=d9759288-5e38-4f9b-9ce3-36669586e63d-ibfmmf_demo&'.$syntax,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
        // return $response;
        
    }
    function MetaDepositDemo($syntax){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'http://139.180.212.62:7004/Deposit?id=d9759288-5e38-4f9b-9ce3-36669586e63d-ibfmmf_demo&'.$syntax,
            CURLOPT_URL => 'http://139.180.219.85:7004/Deposit?id=d9759288-5e38-4f9b-9ce3-36669586e63d-ibfmmf_demo&'.$syntax,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
        // return $response;
        
    }
    
    function push_notification($action){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://firebase.techcrm.net/ibftrader/'.$action,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'key: 1d73adee8d0d3d502e88cc1b847b09cf'
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    };

    function http_request($url){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);
        return $output;
    }
    function generatePassword($len)
    {
        $lower = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $upper = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $specials = array('!','#','$','%','(',')','*','+',',','-','.',':',';','=','?','@','^','_','{','|','}','~');
        $digits = array('0','1','2','3','4','5','6','7','8','9');
        $all = array($lower, $upper, $specials, $digits);

        $pwd = $lower[array_rand($lower, 1)];
        $pwd = $pwd . $upper[array_rand($upper, 1)];
        $pwd = $pwd . $specials[array_rand($specials, 1)];
        $pwd = $pwd . $digits[array_rand($digits, 1)];

        for($i = strlen($pwd); $i < max(8, $len); $i++)
        {
            $temp = $all[array_rand($all, 1)];
            $pwd = $pwd . $temp[array_rand($temp, 1)];
        }
        return str_shuffle($pwd);
    }

?>
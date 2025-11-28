<?php 
// Include configuration file 

include_once('setting.php');
require_once('vendor/autoload.php');
  
// init configuration
//mobileibf
//$clientID = '332607465480-s9fi2gq14k54sngv4pqejamu7k43m7is.apps.googleusercontent.com';
//$clientSecret = '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';
//$redirectUri = 'https://mobileibf.techcrm.net/google_signin.php';

//mobileibftrader
$clientID = '332607465480-sjv5usi867tjohjln9pgq7n2t1q7q6lq.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://mobileibftraders.techcrm.net/google_signin.php';

$google_client = new Google_Client();
$google_client->setApplicationName('Login to IBF Trader');
$google_client->setClientId($clientID);
$google_client->setClientSecret($clientSecret);
$google_client->setRedirectUri($redirectUri);
$google_client->addScope('email');
$google_client->addScope('profile');

if(isset($_GET["code"])){
    //echo 'code ada<br>';
    //It will Attempt to exchange a code for an valid authentication token.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    //print_r($token);

    //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
    if(!isset($token['error'])){
        //echo 'error ada';
        //Set the access token used for requests
        $google_client->setAccessToken($token['access_token']);

        //Store "access_token" value in $_SESSION variable for future use.
        $_SESSION['access_token'] = $token['access_token'];

        //Create Object of Google Service OAuth 2 class
        $google_service = new Google_Service_Oauth2($google_client);

        //Get user profile data from google
        $data = $google_service->userinfo->get();

        //Below you can find Get profile data and store into $_SESSION variable
        if(!empty($data['given_name'])){
            $given_name = $data['given_name'];
        } else { $given_name = ''; };

        if(!empty($data['family_name'])){
            $family_name = $data['family_name'];
        } else { $family_name = ''; };

        if(!empty($data['email'])){
            $email = $data['email'];
        } else { $email = ''; };

        if(!empty($data['locale'])){
            $locale = $data['locale'];
        } else { $locale = ''; };

        if(!empty($data['gender'])){
            $gender = $data['gender'];
        } else { $gender = ''; };

        if(!empty($data['id'])){
            $id = $data['id'];
        } else { $id = ''; };

        if(!empty($data['picture'])){
            $picture = $data['picture'];
        } else { $picture = ''; };
        
        $SQL_QUERY1 = mysqli_query($db, 'SELECT MBR_ID, MBR_EMAIL FROM tb_member WHERE LOWER(MBR_EMAIL) = LOWER("'.$email.'") LIMIT 1');
        if($SQL_QUERY1 && mysqli_num_rows($SQL_QUERY1) > 0){
            //$SQL_QUERY = mysqli_query($db, 'SELECT MBR_ID, MBR_EMAIL FROM tb_member WHERE MBR_EMAIL = LOWER("'.$email.'") AND MBR_OAUTH_ID = "'.$id.'" LIMIT 1');
            $SQL_QUERY = mysqli_query($db, 'SELECT MBR_ID, MBR_EMAIL FROM tb_member WHERE LOWER(MBR_EMAIL) = LOWER("'.$email.'") LIMIT 1');
            if($SQL_QUERY && mysqli_num_rows($SQL_QUERY) > 0){
                $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
                insert_log($RESULT_QUERY['MBR_ID'], 'previous successful authorization - google');
                
                setcookie('id', md5(md5($RESULT_QUERY['MBR_ID'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                setcookie('x', md5(md5($RESULT_QUERY['MBR_EMAIL'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                
                die ("<script>location.href = 'home.php?page=dashboard'</script>");
            } else {
                $MBR_PASS = $id;
                $MBR_KODE = 'admin';
                $QUERY_SPN = mysqli_query($db, '
                    SELECT
                        UNIX_TIMESTAMP(NOW())+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1) AS MBR_ID,
                        MD5(CONCAT(UNIX_TIMESTAMP(NOW())+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1),"'.$MBR_PASS.'")) AS MBR_HASH,
                        100000+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1) AS USERNAME,
                        MBR_ID AS MBR_IDSPN,
                        MBR_USER
                    FROM tb_member
                    WHERE MBR_CODE = "'.$MBR_KODE.'" LIMIT 1');
                if(mysqli_num_rows($QUERY_SPN) > 0) {
                    $RESULT_MBRID = mysqli_fetch_assoc($QUERY_SPN);
                    $ggg_hhh = rand(1000, 9999);
                    $ggg_hhh1 = rand(100000, 999999);
                    
                    //echo $SQL_QUERY;
                    $EXEC_SQL = mysqli_query($db, "
                        INSERT INTO tb_member SET
                        tb_member.MBR_ID = ".$RESULT_MBRID['MBR_ID'].",
                        tb_member.MBR_IDSPN = ".$RESULT_MBRID['MBR_IDSPN'].",
                        tb_member.MBR_OAUTH = 'google',
                        tb_member.MBR_OAUTH_ID = '".$MBR_PASS."',
                        tb_member.MBR_CODE = ".$ggg_hhh1.",
                        tb_member.MBR_NAME = '".$given_name." ".$family_name."',
                        tb_member.MBR_USER = '".str_replace(' ', '', strtolower($given_name))."',
                        tb_member.MBR_PASS = '".$MBR_PASS."',
                        tb_member.MBR_EMAIL = '".$email."',
                        tb_member.MBR_OAUTH_PIC = '".$picture."',
                        tb_member.MBR_STS = -1,
                        tb_member.MBR_DATETIME = '".date("Y-m-d H:i:s")."',
                        tb_member.MBR_IP = '".$IP_ADDRESS."'
                    ") or die (mysqli_error($db));
                    insert_log($RESULT_MBRID['MBR_ID'], 'register new email - google');
                    
                    setcookie('id', md5(md5($RESULT_MBRID['MBR_ID'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                    setcookie('x', md5(md5($email)), time() + (86400) + (86400), '/'); // 86400 = 1 day

                    die ("<script>alert('success register');location.href = './'</script>");
                };
            };
        } else {
            
            $MBR_PASS = $id;
            $MBR_KODE = 'admin';
            $QUERY_SPN = mysqli_query($db, '
                SELECT
                    UNIX_TIMESTAMP(NOW())+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1) AS MBR_ID,
                    MD5(CONCAT(UNIX_TIMESTAMP(NOW())+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1),"'.$MBR_PASS.'")) AS MBR_HASH,
                    100000+(SELECT IFNULL(MAX(tb1.ID_MBR),0) FROM tb_member tb1) AS USERNAME,
                    MBR_ID AS MBR_IDSPN,
                    MBR_USER
                FROM tb_member
                WHERE MBR_CODE = "'.$MBR_KODE.'" LIMIT 1');
            if(mysqli_num_rows($QUERY_SPN) > 0) {
                $RESULT_MBRID = mysqli_fetch_assoc($QUERY_SPN);
                $ggg_hhh = rand(1000, 9999);
                $ggg_hhh1 = rand(100000, 999999);
                
                //echo $SQL_QUERY;
                $EXEC_SQL = mysqli_query($db, "
                    INSERT INTO tb_member SET
                    tb_member.MBR_ID = ".$RESULT_MBRID['MBR_ID'].",
                    tb_member.MBR_IDSPN = ".$RESULT_MBRID['MBR_IDSPN'].",
                    tb_member.MBR_OAUTH = 'google',
                    tb_member.MBR_OAUTH_ID = '".$MBR_PASS."',
                    tb_member.MBR_CODE = ".$ggg_hhh1.",
                    tb_member.MBR_NAME = '".$given_name." ".$family_name."',
                    tb_member.MBR_USER = '".str_replace(' ', '', strtolower($given_name))."',
                    tb_member.MBR_PASS = '".$MBR_PASS."',
                    tb_member.MBR_EMAIL = '".$email."',
                    tb_member.MBR_OAUTH_PIC = '".$picture."',
                    tb_member.MBR_STS = -1,
                    tb_member.MBR_DATETIME = '".date("Y-m-d H:i:s")."',
                    tb_member.MBR_IP = '".$IP_ADDRESS."'
                ") or die (mysqli_error($db));
                insert_log($RESULT_MBRID['MBR_ID'], 'register new email - google');
                
                setcookie('id', md5(md5($RESULT_MBRID['MBR_ID'])), time() + (86400) + (86400), '/'); // 86400 = 1 day
                setcookie('x', md5(md5($email)), time() + (86400) + (86400), '/'); // 86400 = 1 day

                die ("<script>alert('success register');location.href = './'</script>");
            };
        };
    };
};

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_GET['code'])){
    die ("<script>location.href = '".$google_client->createAuthUrl()."'</script>");
}

?>
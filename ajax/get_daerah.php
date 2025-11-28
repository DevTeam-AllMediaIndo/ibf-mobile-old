<?php
date_default_timezone_set("Asia/Jakarta");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host_name = "localhost";
$user_name = "broker";
$password = "Masuk@1224";
$database = "db_broker01";
$db = mysqli_connect($host_name, $user_name, $password, $database);

    switch ($_GET['jenis']) {
    //ambil data kota / kabupaten
    case 'kota':
    $id_provinces = $_GET['id_provinces'];
    if($id_provinces == ''){
        exit;
    } else {
        $getcity = mysqli_query($db,"SELECT  * FROM wilayah_kabupaten WHERE provinsi_id ='$id_provinces' ORDER BY nama ASC") or die (mysqli_error($db));
        while($data = mysqli_fetch_array($getcity)){
                echo '<option value="'.$data['id'].'">'.$data['nama'].'</option>';
        }
        exit;    
    }
    break;
    }
?>
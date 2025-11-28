<?php
    require 'vendor/autoload.php';

    use Aws\S3\S3Client;
    
    $region = 'ap-southeast-1';
    $bucketName = 'allmediaindo-2';
    $folder = 'ibftrader';
    $IAM_KEY = 'AKIASPLPQWHJMMXY2KPR';
    $IAM_SECRET = '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';

    if(isset($_POST['submit'])){
        if(isset($_POST['w3review'])){
            $w3review = form_input($_POST['w3review']);
            $file_doc = $_POST['file_doc'];
            if(isset($_POST['num_log'])){
                $num_log = form_input($_POST['num_log']);
            }else{
                $num_log = NULL;
            }
            $s3 = new Aws\S3\S3Client([
                'region'  => $region,
                'version' => 'latest',
                'credentials' => [
                    'key'    => $IAM_KEY,
                    'secret' => $IAM_SECRET,
                ]
            ]);	

            if(!isset($_FILES["file_doc"])){
                mysqli_query($db,'
                    INSERT INTO tb_ticket SET
                    tb_ticket.TCKT_MBR = '.$user1['MBR_ID'].',
                    tb_ticket.TCKT_KONTEN_MBR = "'.$w3review.'",
                    tb_ticket.TCKT_LOGIN = "'.$num_log.'",
                    tb_ticket.TCKT_DATETIME_MBR = "'.date('Y-m-d H:i:s').'"
                ') or die (mysqli_error($db));
                die ("<script>location.href = 'home.php?page=dashboard&notif".base64_encode('berhasil membuat tiket, tunggu admin konfirmasi')."'</script>");
            }else{

                $newfilename1 = round(microtime(true));
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
                if(isset($_FILES["file_doc"]) && $_FILES["file_doc"]["error"] == 0){
                    
                    $file_doc_name = $_FILES["file_doc"]["name"];
                    $file_doc_type = $_FILES["file_doc"]["type"];
                    $file_doc_size = $_FILES["file_doc"]["size"];
                    
                    $file_doc_ext = pathinfo($file_doc_name, PATHINFO_EXTENSION);
                    
                    if($file_doc_size < 5000000) {
                        if(array_key_exists($file_doc_ext, $allowed)){
                            if(in_array($file_doc_type, $allowed)){
                                $file_doc_new = 'tic_'.$user1['MBR_ID'].'_'.round(microtime(true)).'.'.$file_doc_ext;
                                if(move_uploaded_file($_FILES["file_doc"]["tmp_name"], "upload/" . $file_doc_new)){
                                    
                                    $file_doc_Path = 'upload/'. $file_doc_new;
                                    $file_doc_key = basename($file_doc_Path);

                                    try {
                                        $result = $s3->putObject([
                                            'Bucket' => $bucketName,
                                            'Key'    => $folder.'/'.$file_doc_key,
                                            'Body'   => fopen($file_doc_Path, 'r'),
                                            'ACL'    => 'public-read', // make file 'public'
                                        ]);
                                    } catch (Aws\S3\Exception\S3Exception $e) {
                                        die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('berhasil membuat tiket, tunggu admin konfirmasi')."'</script>");
                                    }
                                } else { die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Gagal upload file. Hubungi administrator')."'</script>"); };
                            } else { die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('File terbaca')."'</script>"); };
                        } else { die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Hany file png, jpeg, jpeg, jpg')."'</script>"); };
                    } else { die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('File tidak dapat di upload. Ukuran file harus lebih kecil dari 200KB')."'</script>"); };
                } else { $file_doc_new = ''; };
                

                mysqli_query($db, '
                    INSERT INTO tb_ticket SET
                    tb_ticket.TCKT_MBR = '.$user1['MBR_ID'].',
                    tb_ticket.TCKT_KONTEN_MBR = "'.$w3review.'",
                    tb_ticket.TCKT_LOGIN = "'.$num_log.'",
                    tb_ticket.TCKT_FILE = "'.$file_doc_new.'",
                    tb_ticket.TCKT_DATETIME_MBR = "'.date('Y-m-d H:i:s').'"
                ') or die (mysqli_error($db));
                unlink($file_doc_Path);
                push_notification('create');
            };
        }else { die ("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Err8')."'</script>"); };
    }
?>
<div class="page-title page-title-small">
    <h2>Pusat Bantuan</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style">
    <div class="content">
        <p>
            Halo, apa yang bisa kami bantu?
        </p>
        <div class="divider"></div>
        <h4>Message</h4>
        <div align="center">
            <div class="form-control">
                <form method="post" enctype="multipart/form-data">
                    <?php
                        $SQL_SCRH = mysqli_query($db,'
                            SELECT
                                MD5(MD5(tb_racc.ID_ACC)) AS ID_ACC,
                                tb_racc.ACC_LOGIN
                            FROM tb_racc
                            WHERE tb_racc.ACC_MBR = "'.$user1['MBR_ID'].'"
                            AND tb_racc.ACC_DERE = 1
                            AND tb_racc.ACC_WPCHECK = 6
                            AND tb_racc.ACC_LOGIN > "0"
                        ');
                        if(mysqli_num_rows($SQL_SCRH) > 0){
                    ?>
                        <label for="form5" class="color-dark">Silahkan pilih nomer login yang akan di perbaiki</label>
                        <div class="input-style has-borders no-icon mb-4">
                            <select name="num_log" class="text-center mt-2">
                                <?php
                                    while($RES_SRCH = mysqli_fetch_assoc($SQL_SCRH)){
                                ?>
                                    <option value="">Pilih Nomer Login</option>
                                    <option value="<?php echo $RES_SRCH["ACC_LOGIN"]; ?>"><?php echo $RES_SRCH["ACC_LOGIN"]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <em></em>
                        </div>
                    <?php
                        }
                    ?>
                    <br><p class="mt-3"><u>Silahkan Isi Keluhan Anda Pada Form Di Bawah Ini!</u></p>
                    <textarea id="w3review" name="w3review" rows="4" cols="28" required></textarea>
                    <br><br>
                    <input type="file" id="fileuploadInput1" accept=".png, .jpg, .jpeg" name="file_doc" value="">
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="submit" class="simulate-android-badge btn btn-m btn-full rounded-s shadow-xl text-uppercase font-700 bg-highlight">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card card-style">
    <div class="content">
        <?php
            $SQL_QUERY = mysqli_query($db, '
                SELECT 
                    tb_ticket.ID_TCKT,
                    tb_ticket.TCKT_DATETIME_MBR,
                    tb_ticket.TCKT_DATETIME_ADM,
                    tb_ticket.TCKT_KONTEN_MBR,
                    tb_ticket.TCKT_KONTEN_ADM
                FROM tb_ticket
                WHERE tb_ticket.TCKT_MBR = '.$user1['MBR_ID'].'
            ');
        if(mysqli_num_rows($SQL_QUERY) > 0){
            while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
        ?>
            <?php if($RESULT_QUERY['TCKT_KONTEN_ADM'] > "0"){?>
                <div class="mt-3" align="left">
                    <div class="form-control">
                        <label>Question <?php echo $RESULT_QUERY['TCKT_DATETIME_MBR'] ?></label>
                        <p><?php echo $RESULT_QUERY['TCKT_KONTEN_MBR'] ?></p>
                    </div>
                </div>
                <div align="right">
                    <div class="form-control">
                        <label>Answer <?php echo $RESULT_QUERY['TCKT_DATETIME_ADM'] ?></label>
                        <p><?php echo $RESULT_QUERY['TCKT_KONTEN_ADM'] ?></p>
                    </div>
                </div>
            <?php }else{?>
                <div class="mt-3" align="left">
                    <div class="form-control">
                        <label>Question <?php echo $RESULT_QUERY['TCKT_DATETIME_MBR'] ?></label>
                        <p><?php echo $RESULT_QUERY['TCKT_KONTEN_MBR'] ?></p>
                    </div>
                </div>
            <?php };?>
        <?php
            };
        } 
        ?>
    </div>   
</div>   
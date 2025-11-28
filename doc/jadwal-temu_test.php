<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['submit'])){
            if(isset($_POST['sesi']) &&
            isset($_POST['alamat']) &&
            isset($_POST['idnt_type']) &&
            isset($_POST['idnt_number']) &&
            isset($_POST['tanggal']) &&
            isset($_POST['birth_date']) &&
            isset($_POST['kode_pos']) &&
            isset($_POST['tmpt_lhr']) &&
            isset($_POST['nomer_tlp']) &&
            //isset($_POST['pekerjaan']) &&
            //isset($_POST['jenis_klemain']) &&
            //isset($_POST['sts_kawin']) &&
            //isset($_POST['profil_resk']) &&
            //isset($_POST['mwpp']) &&
            isset($_POST['demoacc'])){
                $sesi = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['sesi']))));
                $alamat = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['alamat']))));
                $idnt_type = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['idnt_type']))));
                $idnt_number = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['idnt_number']))));
                $tanggal = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['tanggal']))));
                $birth_date = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['birth_date']))));
                $kode_pos = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['kode_pos']))));
                $tmpt_lhr = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['tmpt_lhr']))));
                //$pekerjaan = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['pekerjaan']))));
                //$jenis_klemain = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['jenis_klemain']))));
                //$sts_kawin = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['sts_kawin']))));
                //$profil_resk = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['profil_resk']))));
                //$mwpp = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['mwpp']))));
                $demoacc = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['demoacc']))));
                $nomer_tlp = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_POST['nomer_tlp']))));

                mysqli_query($db, '
                    UPDATE tb_member SET
                        tb_member.MBR_ADDRESS = "'.$alamat.'",
                        tb_member.MBR_TYPE_IDT = "'.$idnt_type.'",
                        tb_member.MBR_NO_IDT = "'.$idnt_number.'",
                        tb_member.MBR_ZIP = "'.$kode_pos.'",
                        tb_member.MBR_TMPTLAHIR = "'.$tmpt_lhr.'",
                        tb_member.MBR_PHONE = "'.$nomer_tlp.'",
                        #tb_member.MBR_PEKERJAAN 
                        #tb_member.MBR_JENIS_KELAMIN 
                        #tb_member.MBR_STS_PRKWN
                        #tb_member.MBR_PRFL_RESK
                        #tb_member.MBR_NAMA_MWPP
                        tb_member.MBR_TGLLAHIR = "'.$birth_date.'"
                    WHERE tb_member.MBR_ID = '.$user1['MBR_ID'].'
                ') or die("<script>alert('please try again or contact support1');location.href = 'home.php?page=" . $login_page . "'</script>");

                mysqli_query($db, '
                    DELETE FROM tb_schedule
                    WHERE tb_schedule.SCHD_ID = '.$user1['MBR_ID'].'
                ') or die("<script>alert('please try again or contact support2');location.href = 'home.php?page=" . $login_page . "'</script>");

                mysqli_query($db, '
                    INSERT INTO tb_schedule SET
                    tb_schedule.SCHD_ID = '.$user1['MBR_ID'].',
                    tb_schedule.SCHD_DEVICE = "Mobile",
                    tb_schedule.SCHD_JAM = "'.$sesi.'",
                    tb_schedule.SCHD_DEMO = "'.$demoacc.'",
                    tb_schedule.SCHD_TANGGAL = "'.$tanggal.'",
                    tb_schedule.SCHD_DATETIME = "'.date("Y-m-d H:i:s").'"
                ') or die("<script>alert('please try again or contact support3');location.href = 'home.php?page=" . $login_page . "'</script>");
                insert_log($user1['MBR_ID'], 'Request Jadwal temu');

                // Message Telegram
                $mesg = 'Notif : Jadwal Temu '.
                PHP_EOL.'Date : '.date("Y-m-d").
                PHP_EOL.'Time : '.date("H:i:s").
                PHP_EOL.'======== Informasi Jadwal Temu =========='.
                PHP_EOL.'Nama : '.$user1['MBR_NAME'].
                PHP_EOL.'Email : '.$user1['MBR_EMAIL'].
                PHP_EOL.'Tanggal temu : '.$tanggal.
                PHP_EOL.'Jam temu : '.$sesi.
                PHP_EOL.'Status : Pending';

                $request_params = [
                    'chat_id' => $chat_id,
                    'text' => $mesg
                ];
                http_request('https://api.telegram.org/bot'.$token1.'/sendMessage?'.http_build_query($request_params));
                
				$request_params_all = [
					'chat_id' => $chat_id_all,
					'text' => $mesg
				];
				http_request('https://api.telegram.org/bot'.$token_all.'/sendMessage?'.http_build_query($request_params_all));
                die("<script>location.href = 'home.php?page=account'</script>");
                
            };
        }; 
    };
?>
<div class="page-title page-title-small">
    <h2>Jadwal Temu</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<form method="post">
    <div class="card card-style mt-4">
        <div class="card-body">
            <div class="section mt-2 mb-2">
                <div class="section-title">Ajukan Jadwal Penjelasan</div>
                    <p>Dear wakil Pialang Pemasaran <br> Saya yang bertanda tangan dibawah ini :</p>
                    <form method="POST">
                        <div class="form-group boxed">
                            <div class="input-wrapper">
                                <label class="label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="<?php echo $user1['MBR_NAME'] ?>" readonly required>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label">Nomor Telephone</label>
                                <input type="number" class="form-control" name="nomer_tlp" value="<?php echo $user1['MBR_PHONE'] ?>" placeholder="Pastikan nomor anda memiliki nomor whatsapp" required>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label" for="select4b">Choose Demo Acc</label>
                                <select class="form-control custom-select" id="select4b" name="demoacc" required>
                                    <?php
                                        $SQL_QUERY = mysqli_query($db, "
                                            SELECT tb_racc.ACC_LOGIN
                                            FROM tb_racc
                                            WHERE tb_racc.ACC_LOGIN <> '0'
                                            AND tb_racc.ACC_MBR = ".$user1['MBR_ID']."
                                            AND tb_racc.ACC_DERE = 2
                                            AND tb_racc.ACC_TYPE = 1
                                        ");
                                        if(mysqli_num_rows($SQL_QUERY) > 0) {
                                            while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)) {
                                    ?>
                                    <option value="<?php echo $RESULT_QUERY['ACC_LOGIN'] ?>"><?php echo $RESULT_QUERY['ACC_LOGIN'] ?></option>
                                    <?php };}; ?>
                                </select>
                                <a href="home.php?page=list_account&action=createacc&type=demo">klik disini untuk membuat akun demo</a>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label">Alamat Rumah</label>
                                <input type="text" class="form-control" value="<?php echo $user1['MBR_ADDRESS'] ?>" placeholder="Isi alamat sesuai dengan KTP" name="alamat" required>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label">Kode POS</label>
                                <input type="number" min="10000" max="99999" step="1" class="form-control" value="<?php echo $user1['MBR_ZIP'] ?>" placeholder="Isi sesuai dengan KTP" name="kode_pos" required>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label">Alamat Email</label>
                                <input type="text" class="form-control" value="<?php echo $user1['MBR_EMAIL'] ?>" placeholder="Masukkan email anda" name="alamat_email" required>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label" for="select4b">Jenis Identitas</label>
                                <select class="form-control custom-select" id="idt_type" onchange="GetSelectedTextValue2(this)" required name="idnt_type">
                                    <option value="">Jenis Identitas</option>
                                    <option <?php if($user1['MBR_TYPE_IDT'] == 'KTP'){ echo 'selected'; } ?> value="KTP">KTP</option>
                                    <option <?php if($user1['MBR_TYPE_IDT'] == 'Passport'){ echo 'selected'; } ?> value="Passport">Passport</option>
                                </select>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label" for="select4b">No. Identitas</label>
                                <input type="text" class="form-control" id="no_idt" maxlength="16" minlength="8" value="<?php echo $user1['MBR_NO_IDT'] ?>" placeholder="Masukkan nomor identitas" required name="idnt_number" autocomplete="off">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label">Tempat lahir</label>
                                <input type="text" class="form-control" value="<?php echo $user1['MBR_TMPTLAHIR'] ?>" placeholder="Isi sesuai dengan KTP" name="tmpt_lhr" required autocomplete="off">
                            </div>
                            <div class="input-wrapper mt-3">
                                <label class="label" for="select4b">Tanggal lahir</label>
                                <input type="date" max="<?php echo date('Y-m-d', strtotime('-21 years')) ?>" class="form-control" value="<?php echo date_format(date_create($user1['MBR_TGLLAHIR']), 'Y-m-d') ?>" required name="birth_date" autocomplete="off">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <div class="col mt-3">
                                <p class="mb-3 text-start text-left ">Adalah calon nasabah yang berkenan mendapatkan penjelasan mengenai resiko <br> 
                                dan perjanjian amanat dalam transaksi perdagangan berjangka komoditi dari <br> wakil pialang berjangka pemasaran PT. INTERNATIONAL BUSINESS FUTURES.</p><br>
                                <input type='checkbox' class="form-check-input" name='bahasa1' value='' required> Saya sudah membaca, memahami, dan menyetujui</p>
                            </div>
                            <div class="col">
                                <h2 class="mb-3 text-start text-center ">Jadwal Penjelasan WPB</h2>
                                <p class="text-start text-center"><u>Notes</u> : Hanya jam kerja (Working Day), untuk weekend tidak melayani</p>
                                <div class="form-group boxed">
                                    <div class="input-wrapper">
                                        <label class="label" for="select4">Sesi</label>
                                        <select class="form-control custom-select" id="select4" name="sesi" required>
                                            <option disabled selected value>Atur jam konfirmasi dengan wakil pialang</option>
                                            <option value="08:00 WIB - 10:00 WIB">08:00 WIB - 10:00 WIB</option>
                                            <option value="10:00 WIB - 12:00 WIB">10:00 WIB - 12:00 WIB</option>
                                            <option value="12:00 WIB - 14:00 WIB">12:00 WIB - 14:00 WIB</option>
                                            <option value="14:00 WIB - 16:00 WIB">14:00 WIB - 16:00 WIB</option>
                                            <option value="18:00 WIB - 20:00 WIB">18:00 WIB - 20:00 WIB</option>
                                            <option value="20:00 WIB - 20:30 WIB">20:00 WIB - 20:30 WIB</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="form-group boxed">
                                    <label class="label">Tanggal</label>
                                    <?php
                                        $DATE_CURRENT = date("Y-m-d");
                                        $day_add = 9;
                                        if(date("N", strtotime($DATE_CURRENT)) == 1){
                                            $date_min = $DATE_CURRENT;
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 4 days'));
                                        } else if(date("N", strtotime($DATE_CURRENT)) == 2){
                                            $date_min = $DATE_CURRENT;
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 3 days'));
                                        } else if(date("N", strtotime($DATE_CURRENT)) == 3){
                                            $date_min = $DATE_CURRENT;
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 2 days'));
                                        } else if(date("N", strtotime($DATE_CURRENT)) == 4){
                                            $date_min = $DATE_CURRENT;
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 1 days'));
                                        } else if(date("N", strtotime($DATE_CURRENT)) == 5){
                                            $date_min = $DATE_CURRENT;
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 0 days'));
                                        } else if(date("N", strtotime($DATE_CURRENT)) == 6){
                                            $date_min = date('Y-m-d', strtotime($DATE_CURRENT.' + 2 days'));
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 1 days'));
                                        } else if(date("N", strtotime($DATE_CURRENT)) == 7){
                                            $date_min = date('Y-m-d', strtotime($DATE_CURRENT.' + 1 days'));
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 0 days'));
                                        } else {
                                            $date_min = $DATE_CURRENT;
                                            $date_max = date('Y-m-d', strtotime($DATE_CURRENT.' + 5 days'));
                                        };
                                    ?>
                                    <input type="date" min="<?php echo $date_min; ?>" max="<?php echo $date_max ?>" placeholder="yyyy-MM-dd" class="form-control text-center" name="tanggal" autocomplete="off" required>
                                    <!-- <input type="text" placeholder="yyyy-MM-dd" class="form-control text-center" id="datepicke" name="tanggal" autocomplete="off" required> -->
                                    <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div><br>
                                <button class="btn btn-primary rounded-pill btn-login w-100 mb-2" type="submit" name="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
</form>
<script>
    GetSelectedTextValue2(idt_type);
    function GetSelectedTextValue2(idt_type) {
        var selVal = idt_type.value;
        var no_idt = document.getElementById("no_idt");
        if(selVal == 'Passport'){
            document.getElementById('no_idt').type='text';
            document.getElementById("no_idt").maxlength = "16";
            document.getElementById("no_idt").minlength = "8";
        } else {
            document.getElementById('no_idt').type='number';
            document.getElementById("no_idt").max = "9999999999999999";
            document.getElementById("no_idt").min = "1000000000000000";
        }
    };

    let no_idt = document.getElementById('no_idt');
    no_idt.addEventListener('invalid', function(evt){
        if(evt){
            console.log(evt.target.value.length)
            if(evt.target.value.length > 16 ){
                console.log(evt);
                evt.target.setCustomValidity('Input Maksimal 16 digit');
            }else if(evt.target.value.length < 16){
                console.log(evt);
                evt.target.setCustomValidity('Input Minimal 16 digit');
            }
        }
    });

</script>
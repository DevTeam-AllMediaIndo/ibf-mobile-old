<?php

$id_live = $_GET['id'];
if(isset($_POST['submit_26'])){
    if(isset($_POST['aggree'])){
        if(isset($_GET['id'])){
            $aggree = $_POST['aggree'];
            if($aggree == 'Yes'){
                mysqli_query($db, '
                    UPDATE tb_racc SET
                    tb_racc.ACC_F_DISC = 1,
                    tb_racc.ACC_F_DISC_PERYT = "'.$aggree.'",
                    tb_racc.ACC_F_DISC_IP = "'.$IP_ADDRESS.'",
                    tb_racc.ACC_F_DISC_DATE = "'.date('Y-m-d H:i:s').'"
                    WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                ') or die (mysqli_error($db));

                // Message Telegram
                $mesg = 'Notif : Regol Baru'.
                PHP_EOL.'Date : '.date("Y-m-d").
                PHP_EOL.'Time : '.date("H:i:s");
                // PHP_EOL.'======== Informasi Regol =========='.
                // PHP_EOL.'Nama : '.$user1["MBR_NAME"].
                // PHP_EOL.'Email : '.$user1["MBR_EMAIL"].
                // PHP_EOL.'Status : Pending';

                // Message Telegram
                $mesg_othr = 'Notif : Regol Baru'.
                PHP_EOL.'Date : '.date("Y-m-d").
                PHP_EOL.'Time : '.date("H:i:s").
                PHP_EOL.'==================================='.
                PHP_EOL.'                         Informasi Regol'.
                PHP_EOL.'==================================='.
                PHP_EOL.'Nama : '.$user1["MBR_NAME"].
                PHP_EOL.'Email : '.$user1["MBR_EMAIL"].
                PHP_EOL.'Status : Pending';

                $request_params = [
                    'chat_id' => $chat_id,
                    'text' => $mesg_othr
                ];
                http_request('https://api.telegram.org/bot'.$token1.'/sendMessage?'.http_build_query($request_params));
                
				$request_params_all = [
					'chat_id' => $chat_id_all,
					'text' => $mesg
				];
				http_request('https://api.telegram.org/bot'.$token_all.'/sendMessage?'.http_build_query($request_params_all));
                                            
                $request_params_othr = [
                    'chat_id' => $chat_id_othr,
                    'text' => $mesg_othr
                ];
                http_request('https://api.telegram.org/bot'.$token_othr.'/sendMessage?'.http_build_query($request_params_othr));
                die ("<script>location.href = 'home.php?page=racc/selesai&id=".$id_live."'</script>");
            }else{die("<script>location.href = 'home.php?page=racc/disclosure&id=".$id_live."'</script>");};
        } else {
            logerr("Parameter Ke-2 Tidak Lengkap", "Disclosure 1", $user1["MBR_ID"]);
            die ("<script>alert('please try again');location.href = 'home.php?page=racc/disclosure&id=".$id_live."'</script>"); 
        };
    } else {
        logerr("Parameter Ke-1 Tidak Lengkap", "Disclosure 1", $user1["MBR_ID"]);
        die ("<script>alert('please try again');location.href = 'home.php?page=racc/disclosure&id=".$id_live."'</script>"); 
    };
};
?>
<div class="page-title page-title-small">
    <h2>Pernyataan Pengungkapan</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
    <form method="post">
        <div class="card card-style">
            <div class="card-body">
                <div class="mt-3 text-center" style="vertical-align: middle;padding: 20px 0 10px 0;">
                <h4>PERNYATAAN PENGUNGKAPAN<br><i>(DISCLOSURE STATEMENT)</i></h4>
            </div>
            <div class="mt-3">
                <ol>
                    <li>Perdagangan Berjangka BERISIKO SANGAT TINGGI tidak cocok untuk semua orang. Pastikan bahwa anda SEPENUHNYA MEMAHAMI RISIKO ini sebelum melakukan perdagangan.</li>
                    <li>Perdagangan Berjangka merupakan produk keuangan dengan leverage dan dapat menyebabkan KERUGIAN ANDA MELEBIHI setoran awal Anda. Anda harus siap apabila SELURUH DANA ANDA HABIS.</li>
                    <li>TIDAK ADA PENDAPATAN TETAP (FIXED INCOME) dalam Perdagangan Berjangka.</li>
                    <li>Apabila anda PEMULA kami sarankan untuk mempelajari mekanisme transaksinya, PERDAGANGAN BERJANGKA membutuhkan pengetahuan dan pemahaman khusus.</li>
                    <li>ANDA HARUS MELAKUKAN TRANSAKSI SENDIRI, segala risiko yang akan timbul akibat transaksi sepenuhnya akan menjadi tanggung jawab Saudara.</li>
                    <li>User id dan password BERSIFAT PRIBADI DAN RAHASIA, anda bertanggung jawab atas penggunaannya, JANGAN SERAHKAN ke pihak lain terutama Wakil Pialang Berjangka dan pegawai Pialang Berjangka.</li>
                    <li>ANDA berhak menerima LAPORAN ATAS TRANSAKSI yang anda lakukan. Waktu anda 2 X 24 JAM UNTUK MEMBERIKAN SANGGAHAN. Untuk transaksi yang TELAH SELESAI (DONE/SETTLE) DAPAT ANDA CEK melalui system informasi transaksi nasabah yang berfungsi untuk memastikan transaksi anda telah terdaftar di Lembaga Kliring Berjangka.</li>
                </ol>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="text-center">
                    SECARA DETAIL BACA DOKUMEN PEMBERITAHUAN ADANYA RESIKO DAN DOKUMEN PERJANJIAN PEMBERIAN AMANAT
                    </div>
                </div>
            </div><br>
            <!-- <p class="mt-3">Dengan mengisi kolom "YA" di bawah ini, saya menyatakan bahwa saya telah memiliki pengalaman yang mencukupi dalam melaksanakan transaksi Perdagangan Berjangka karena pernah bertransaksi pada Perusahaan Pialang Berjangka PT. International Business Futures), dan telah memahami tentang tata cara bertransaksi Perdagangan Berjangka.</p> -->
            <p>Demikian Pernyataan ini dibuat dengan sebenarnya dalam keadaan sadar, sehat jasmani dan rohani serta tanpa paksaan apapun dari pihak manapun.</p>
            <div class="row mt-3 mb-3">
                <div class="col-6">
                    Pernyataan diterima / tidak<br>
                    <input type="radio" class="form-check-input radio_css" name="aggree" value="Yes" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                    <input type="radio" class="form-check-input radio_css" name="aggree" value="No" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak</label>
                </div>
                <div class="col-6">
                    <label>Pernyataan pada Tanggal</label>
                    <input type="text" readonly required value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control text-center">
                </div>
            </div>
        </div>
        <div class="card card-style">
            <input type="hidden" name="check" value="1">
            <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
            <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_26">Next</button>
        </div>
    </form>
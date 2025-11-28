<?php
    if(isset($_POST["submit_019"])){
        if(isset($_POST["namleng"])){
            if(isset($_POST["account"])){
                if(isset($_POST["reknas"])){
                    if(isset($_POST["noidt"])){
                        if(isset($_POST["almtemail"])){
                            if(isset($_POST["notelp"])){
                                if(isset($_POST["eqtahkr"])){
                                    if(isset($_POST["reason"])){
                                        if(isset($_POST["tempat"])){
                                            $namleng    = form_input($_POST["namleng"]);
                                            $account    = form_input($_POST["account"]);
                                            $reknas     = form_input($_POST["reknas"]);
                                            $noidt      = form_input($_POST["noidt"]);
                                            $almtemail  = form_input($_POST["almtemail"]);
                                            $notelp     = form_input($_POST["notelp"]);
                                            $eqtahkr    = form_input($_POST["eqtahkr"]);
                                            $reason     = form_input($_POST["reason"]);
                                            $tempat     = form_input($_POST["tempat"]);

                                            $INS_SQL = mysqli_query($db, '
                                                INSERT INTO tb_dlt_account SET
                                                tb_dlt_account.DLTACC_MBR           = '.$user1["MBR_ID"].',
                                                tb_dlt_account.DLTACC_NAMLENG       = "'.$namleng.'",
                                                tb_dlt_account.DLTACC_ACCOUNT       = "'.$account.'",
                                                tb_dlt_account.DLTACC_NOREK_NSBH    = "'.$reknas.'",
                                                tb_dlt_account.DLTACC_NOIDT         = "'.$noidt.'",
                                                tb_dlt_account.DLTACC_EMAIL         = "'.$almtemail.'",
                                                tb_dlt_account.DLTACC_NOTELP        = "'.$notelp.'",
                                                tb_dlt_account.DLTACC_LST_EQT       = "'.$eqtahkr.'",
                                                tb_dlt_account.DLTACC_REASON        = "'.$reason.'",
                                                tb_dlt_account.DLTACC_TMPT          = "'.$tempat.'",
                                                tb_dlt_account.DLTACC_STS           = 0,
                                                tb_dlt_account.DLTACC_DATETIME      = "'.date("Y-m-d H:i:s").'",
                                                tb_dlt_account.DLTACC_TIMESTAMP     = "'.date("Y-m-d H:i:s").'"
                                            ');
                                            insert_log($user1['MBR_ID'], 'Mengajukan penghapusan akun.');
                                            die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Berhasil Membuat Pengajuan Penghapusan Account.')."'</script>");
                                        }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
                                    }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
                                }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
                            }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
                        }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
                    }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
                }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
            }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
        }else{ die("<script>location.href = 'home.php?page=dashboard&notif=".base64_encode('Parameter tidak tidak sesuai. Silahkan coba lagi!. L: '.__LINE__)."'</script>"); }
    }
?>
<style>
    .table1 {
        --bs-table-bg: transparent;
        --bs-table-accent-bg: transparent;
        --bs-table-striped-color: #212529;
        --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
        --bs-table-active-color: #212529;
        --bs-table-active-bg: rgba(0, 0, 0, 0.1);
        --bs-table-hover-color: #212529;
        --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
        width: 100%;
        margin-bottom: 1rem;
        vertical-align: top;
        border-spacing: 10px;
        border-collapse: separate;
    }
</style>
<div class="page-title page-title-small">
    <h2>HAPUS AKUN</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<form method="post">
    <div class="card card-style">
        <div class="card-body">
            <h6 class="text-center">FORMULIR PENGAJUAN PENGHAPUSAN AKUN NASABAH</h5>
            <hr>
            <h4>DATA NASABAH</h4>
            <table class="table1">
                <tr>
                    <td>Nama Lengkap</td>
                    <td> : </td>
                    <td><input type="text" name="namleng" class="form-control text-center" value="<?php echo $user1['MBR_NAME'] ?>" required></td>
                </tr>
                <tr>
                    <td>Account</td>
                    <td> : </td>
                    <td><input type="text" name="account" class="form-control text-center" value="" required></td>
                </tr>
                <tr>
                    <td>Nomor Rekening Nasabah</td>
                    <td> : </td>
                    <td><input type="text" name="reknas" class="form-control text-center" value="" required></td>
                </tr>
                <tr>
                    <td>Nomor Identitas (KTP)</td>
                    <td> : </td>
                    <td><input type="text" name="noidt" class="form-control text-center" value="<?php echo $user1['MBR_NO_IDT'] ?>" required></td>
                </tr>
                <tr>
                    <td>Alamat Email</td>
                    <td> : </td>
                    <td><input type="email" name="almtemail" class="form-control text-center" value="<?php echo $user1['MBR_EMAIL'] ?>" required></td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td> : </td>
                    <td><input type="text" name="notelp" class="form-control text-center" value="<?php echo $user1['MBR_PHONE'] ?>" required></td>
                </tr>
                <tr>
                    <td>Equity Akhir</td>
                    <td> : </td>
                    <td><input type="text" name="eqtahkr" class="form-control text-center" value="" required></td>
                </tr>
            </table>
            <hr>
            <div class="row mt-3 mb-3">
                <div class="col-12 mb-3">
                    <h3>ALASAN PENGHAPUSAN AKUN</h3>
                    (Silakan centang salah satu atau menuliskan alasan lain penghapusan akun)<br>
                    <input type="radio" class="form-check-input radio_css" name="reason" value="Tidak aktif bertransaksi" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak aktif bertransaksi</label><br>
                    <input type="radio" class="form-check-input radio_css" name="reason" value="Sudah tidak tertarik pada perdagangan berjangka" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Sudah tidak tertarik pada perdagangan berjangka</label><br>
                    <input type="radio" class="form-check-input radio_css" name="reason" value="Pindah ke perusahaan pialang lain" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Pindah ke perusahaan pialang lain</label><br>
                    <input type="radio" class="form-check-input radio_css" name="reason" value="Tidak melakukan kegiatan usaha lagi atau ditutup" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak melakukan kegiatan usaha lagi atau ditutup</label><br>
                    <input type="radio" class="form-check-input radio_css" name="reason" value style="margin-top: 10px;" required id="prsnlr">
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Alasan pribadi: <input type="text" id="prsnlinpt" class="form-control" placeholder="Masukan Alasan Pribadi Anda"></label><br>
                </div>
                <hr>
                <h4>PERNYATAAN PENGAJUAN</h4>
                <p>
                    Saya yang bertanda tangan di bawah ini, dengan ini mengajukan permohonan <b>penghapusan akun/rekening transaksi</b> saya <?php echo $web_name_full ?> :
                </p>
                <div>
                    <ul>
                        <li>
                            Saya menyatakan bahwa <b>seluruh kewajiban telah diselesaikan</b>, tidak ada dana tertahan, dan tidak terdapat posisi terbuka dalam akun saya.
                        </li>
                        <li>
                            Saya memahami bahwa setelah akun dihapus, saya <b>tidak dapat lagi melakukan transaksi atau mengakses sistem</b>.
                        </li>
                        <li>
                            Saya menyatakan tidak akan melakukan tuntutan hukum apapun dikemudian hari terkait segala transaksi dan semua aktivitas account milik saya.
                        </li>
                        <li>
                            Saya menyatakan keputusan ini dibuat secara sukarela tanpa paksaan maupun pengaruh dari pihak mana pun.
                        </li>
                    </ul>
                </div>
                <div class="col-12">
                    <h4>Pemohon</h4>
                    <table class="table1">
                        <tr>
                            <td>Tempat, Tanggal</td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" name="tempat" class="form-control text-center" placeholder="Tempat" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="date" class="form-control text-center" value="<?= date("Y-m-d") ?>" readonly>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Terang</td>
                            <td>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" class="form-control text-center" placeholder="Nama" value="<?php echo $user1['MBR_NAME'] ?>" required>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_019">Submit</button>
    </div>
</form>
<script>
    document.getElementById('prsnlinpt').addEventListener('keyup', function(e){
        document.getElementById('prsnlr').value = this.value;
    });
</script>
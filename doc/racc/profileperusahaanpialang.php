
<?php
$id_live = $_GET['id'];
    if(isset($_POST['submit_018'])){
        if(isset($_POST['check'])){
            if(isset($_POST['id_live'])){
                if(isset($_POST['aggree'])){
                    $aggree = ($_POST["aggree"]);
                    if($aggree == 'Yes'){
                        mysqli_query($db, '
                            UPDATE tb_racc SET
                            tb_racc.ACC_F_PROFILE = 1,
                            tb_racc.ACC_F_PROFILE_IP = "'.$IP_ADDRESS.'",
                            tb_racc.ACC_F_PROFILE_PERYT = "'.$aggree.'",
                            tb_racc.ACC_F_PROFILE_DATE = "'.date('Y-m-d H:i:s').'"
                            WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                        ') or die (mysqli_error($db));
                        die ("<script>location.href = 'home.php?page=racc/simulasiperdagangan&id=".$id_live."'</script>");
                    } else {
                        die ("<script>location.href = 'home.php?page=racc/profileperusahaanpialang&id=".$id_live."'</script>"); 
                    }
                } else {
                    logerr("Parameter Ke-1 Tidak Lengkap", "Pernyataan Pengunkapan", $user1["MBR_ID"]);
                    die ("<script>location.href = 'home.php?page=racc/profileperusahaanpialang&id=".$id_live."'</script>"); 
                }
            };
        };
    };
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
    <h2>Profile Perusahaan Pialang</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<form method="post">
    <div class="card card-style">
        <div class="card-body">
            <div class="row">
                <!-- <div class="col-6 text-left">
                    <strong><small><b>Formulir Nomor 107.PBK.01</b></small></strong>
                </div> -->
                <!-- <div class="col-12 text-right">
                    <small>
                        Lampiran Peraturan Kepala Badan Pengawas<br>
                        Perdagangan Berjangka Komoditi<br>
                        Nomor : 107/BAPPEBTI/PER/11/2013
                    </small>
                </div> -->
                <?php include 'header_form.php'; ?>
            </div>
            <h6 class="text-center">PROFIL PERUSAHAAN PIALANG BERJANGKA</h5>
            <hr>
            <table class="table1" >
                <tr>
                    <td>Nama perusahaan</td>
                    <td> : </td>
                    <td><?php echo $web_name_full ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : </td>
                    <td>Paskal Hyper Square Blok D no.45-46 Jalan H.O.S. Cokroaminoto no.25-27 Bandung</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td> : </td>
                    <td>(022) 86061128</td>
                </tr>
                <tr>
                    <td>No Fax</td>
                    <td> : </td>
                    <td>(022) 86061126</td>
                </tr>
                <tr>
                    <td>E-Mail</td>
                    <td> : </td>
                    <td>Support@ibftrader.com</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td> : </td>
                    <td>www.ibftrader.com</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><h3>Susunan Pengurus Perusahaan</h3></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Dewan Direksi</strong></td>
                </tr>
                <tr>
                    <td>1. President Direktur</td>
                    <td> : </td>
                    <td>Ernawan Sukardi</td>
                </tr>
                <tr>
                    <td>2. Direktur Kepatuhan</td>
                    <td> : </td>
                    <td>Ilham Sukmana, SH</td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Dewan Komisaris</strong></td>
                </tr>
                <tr>
                    <td>1. Komisaris Utama</td>
                    <td> : </td>
                    <td>Budiman Wijaya</td>
                </tr>
                <tr>
                    <td>2. Komisaris</td>
                    <td> : </td>
                    <td>A. Mufti Mardian</td>
                </tr>
                <tr>
                    <td>Susunan Pemegang Saham Perusahaan</td>
                    <td> : </td>
                    <td>
                        1. Budiman Wijaya<br>
                        2. A. Mufti Mardian
                    </td>
                </tr>
                <tr>
                    <td>Nomor dan Tanggal Izin Usaha Dari Bappebti</td>
                    <td> : </td>
                    <td>
                        No.	912/BAPPEBTI/SI/8/2006<br>
                        Tanggal : 25 Agustus 2006
                    </td>
                </tr>
                <tr>
                    <td>Nomor dan Tanggal Keanggotaan Bursa Berjangka</td>
                    <td> : </td>
                    <td>
                        No.	SPAB - 142/BBJ/08/05<br>
                        Tanggal : 31 Agustus 2005
                    </td>
                </tr>
                <tr>
                    <td>Nomor dan Tanggal Keanggotaan Lembaga Kliring Berjangka</td>
                    <td> : </td>
                    <td>
                        No. 120/AK-KBI/X/2024<br>
                        Tanggal : 28 Januari 2011
                    </td>
                </tr>
                <tr>
                    <td>Nomor dan Tanggal Persetujuan Sebagai Peserta Sistem Perdagangan Alternatif</td>
                    <td> : </td>
                    <td>
                        No.	22/BAPPEBTI/SP/04/2011<br>
                        Tanggal : 21 April 2011
                    </td>
                </tr>
                <tr>
                    <td>Nomer izin Otoritas Jasa Keuangan</td>
                    <td> : </td>
                    <td>No.S-316/PM.02/2025</td>
                </tr>
                <tr>
                    <td>Nomer Izin Bank Indonesia</td>
                    <td> : </td>
                    <td>No.27/363/DPPK/Srt/B</td>
                </tr>
                <tr>
                    <td>Nama Penyelenggara Sistem Perdagangan Alternatif</td>
                    <td> : </td>
                    <td>PT. Realtime Forex Indonesia (RTFI)</td>
                </tr>
                <tr>
                    <td>Kontrak Berjangka Yang Diperdagangkan *)</td>
                    <td> : </td>
                    <td>1. Kontrak Gulir Index Emas (KIE) <br>
                        2. Kontrak Berjangka Emas Gold 100 <br>
                        3. Kontrak Berjangka Emas Gold 250 <br>
                        4. Kontrak Berjangka Emas Gold
                    </td>
                </tr>
                <tr>
                    <td>Kontrak Derivatif Syariah Yang Diperdagangkan *)</td>
                    <td> : </td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Kontrak Derivatif dalam Sistem Perdagangan Alternatif *)</td>
                    <td> : </td>
                    <td>1. CFD Mata Uang Asing ( EUR/USD, GBP/USD, AUD/USD, USD/JPY, USD/CHF ) <br>
                        2. CFD Indeks Saham ( Hangseng, Nikkei, Kospi) <br>
                        3. CFD Komoditi Emas ( XAU/USD )
                    </td>
                </tr>
                <tr>
                    <td>Kontrak Derivatif dalam Sistem Perdagangan Alternatif dengan volume minimum 0,1 (nol koma satu) lot Yang Ddiperdagangkan *)</td>
                    <td> : </td>
                    <td>1. CFD Mata Uang Asing ( EUR/USD, GBP/USD, AUD/USD, USD/JPY, USD/CHF ) <br>
                        2. CFD Indeks Saham ( Hangseng, Nikkei, Kospi) <br>
                        3. CFD Komoditi Emas ( XAU/USD )

                    </td>
                </tr>
                <tr>
                    <td>Biaya Secara Rinci yang Di Bebankan Pada Nasabah</td>
                    <td> : </td>
                    <td>
                        Trading Rules (Spesifikasi Kontrak)
                    </td>
                </tr>
                <tr>
                    <td>Nomor atau alamat email jika terjadi keluhan :</td>
                    <td> : </td>
                    <td> (022) 86061125 / Support@ibftrader.com</td>
                </tr>
                <tr>
                    <td colspan="3">
                    Sarana Penyelesaian perselisihan yang dipergunakan apabila terjadi perselisihan :<br>
                    Penyelesaian Perselisihan Mempergunakan Sarana Melalui Prosedur Sebagai Berikut.
                        <ol>
                            <li>Nasabah menyampaikan pengaduannya dengan mengisi ringkasan kasusnya pada Form Pengaduan Nasabah dan diserahkan kepada Divisi Compliance</li>
                            <li>Divisi Compliance berkoordinasi dengan departmen lainnya yang terkait akan melakukan verifikasi kasus atas dokumen-dokumen dan bukti-bukti pendukung lainnya dengan mengacu pada ketentuan yang berlaku di Perusahaan serta peraturan yang telah di tetapkan oleh instansi yang berwenang di bidang Perdagangan Berjangka Komoditi.</li>
                            <li>Setelah diperoleh hasil verifikasi atas dokumen-dokumen dan bukti-bukti pendukung tersebut , Divisi Compliance akan menghubungi Nasabah serta pihak-pihak yang terkait pada kasus tersebut untuk melakukan musyawarah dengan tujuan mencapai mufakat.</li>
                            <li>Apabila perselisihan ternyata belum terselesaikan dalam musyawarah tersebut, maka selanjutnya penyelesainya akan memanfaatkan sarana penyelesaian yang tersedia di Bursa Berjangka,</li>
                            <li>Apabila Perselisihan ternyata belum terselesaikan di BBJ maka selanjutnya perselisihan akan di selesaikan melalui Badan Arbitrase Perdagangan Berjangka Komoditi (BAKTI) atau Pengadilan Negeri yang berwenang.</li>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Nama-nama Wakil Pialang Berjangka yang Bekerja di Perusahaan Pialang Berjangka:
                        <div class="row" style="margin:0px 5px;">
                            <div class="col">
                                <?php $nmr = 0; ?>
                                <?= ++$nmr; ?>. Agus Slamet Medya <br>
                                <?= ++$nmr; ?>. Dinan Harjadinata <br>
                                <?= ++$nmr; ?>. Alvin Hilmansyah <br>
                                <?= ++$nmr; ?>. M. Meidy Fazria SH <br>
                                <?= ++$nmr; ?>. Muhamad Ramdan Diniarsah <br>
                                <?= ++$nmr; ?>. Muhammat Aris <br>
                                <?= ++$nmr; ?>. Novi Asnuriani <br>
                                <?= ++$nmr; ?>. Dona Fadhillah <br>
                                <?= ++$nmr; ?>. Rudi Pandapotan S <br>
                                <?= ++$nmr; ?>. Tetti Erlinda Gultom <br>
                                <?= ++$nmr; ?>. Helen Astri Kantinasari <br>
                                <?= ++$nmr; ?>. Adi Nugroho <br>
                                <?= ++$nmr; ?>. Maikona <br>
                                <?= ++$nmr; ?>. Resti Ayu Wardhani<br>
                                <?= ++$nmr; ?>. Febiyanti <br>
                                <?= ++$nmr; ?>. Evriliya Cyti Nurnaini <br>
                                <?= ++$nmr; ?>. Fitri Kurnia Sari <br>
                            </div>
                            <div class="col">
                                <?= ++$nmr; ?>. Andreas Konanjaya <br>
                                <?= ++$nmr; ?>. Faisal Rahman <br>
                                <?= ++$nmr; ?>. Moch Ali Imron <br>
                                <?= ++$nmr; ?>. Endang Yunanda <br>
                                <?= ++$nmr; ?>. Erwin Ariyanto <br>
                                <?= ++$nmr; ?>. Vita Sari Patiska <br>
                                <?= ++$nmr; ?>. Susanti Hamzah <br>
                                <?= ++$nmr; ?>. Yoel Leonard<br>
                                <?= ++$nmr; ?>. Laraswati<br>
                                <?= ++$nmr; ?>. Pratika Devianti<br>
                                <?= ++$nmr; ?>. Nia Chusniatin<br>
                                <?= ++$nmr; ?>. Rai Anggawa<br>
                                <?= ++$nmr; ?>. Yuda Junendri R<br>
                                <?= ++$nmr; ?>. Soalae Rumapea<br>
                                <?= ++$nmr; ?>. Istin Selvia Ningsih<br>
                                <?= ++$nmr; ?>. Ricky Yefi Nurrahman<br>
                                <?= ++$nmr; ?>. Syahrul Hanafia<br>
                                <?= ++$nmr; ?>. Yericho Reinaldi Raya<br>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>Nama – Nama Wakil Pialang Berjangka yang secara khusus ditunjuk oleh Pialang Berjangka untuk melakukanVerifikasi dalam rangka penerimaan Nasabah elektronik on- Line : </p>
                        <div class="row" style="margin:0px 5px;">
                            <div class="col">
                                1. M Ramdan Diniarsah
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="text-center"><h3>Nomor Rekening Terpisah<br>(Segregated Account)<br>Perusahaan Pialang Berjangka:</h3></div>
                        <div class="section mt-3 mb-3">

                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="assets/img/bca.png" width="100%" alt="" />
                                            <div>
                                                - BCA KCU ASIA AFRIKA <br>
                                                - <?php echo $web_name_full ?> <br>
                                                - 0083073966 (IDR) <br>
                                                - 0084214210 (USD)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card"> 
                                        <div class="card-body">
                                            <img src="assets/img/madniri-fix.png" width="100%"  alt="" />
                                            <div>
                                                - BANK MANDIRI CAB. BANDUNG ASIA AFRIKA <br>
                                                - <?php echo $web_name_full ?> <br>
                                                - 1300088881779 (IDR) <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="text-center">
                        <strong>PERNYATAAN TELAH MEMBACA PROFIL PERUSAHAAN PIALANG BERJANGKA
                        <p style="display: inline;">Dengan mengisi kolom “YA” di bawah ini, saya menyatakan bahwa saya telah membaca dan menerima informasi<br>PROFIL PERUSAHAAN PIALANG BERJANGKA, mengerti dan memahami isinya.</p></strong>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="text-right">Pernyataan pada Tanggal</div>
                    <input type="text" readonly required value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control text-center mb-3">
                </div>
                <div class="col-md-6">
                    Pernyataan diterima / tidak<br>
                    <input type="radio" name="aggree" value="Yes" class="form-check-input radio_css" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                    <input type="radio" name="aggree" value="No" class="form-check-input radio_css" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak</label>
                </div>
            </div>
        </div>
        <div class="">
            <div class="col-12">
                <!-- <a href="home.php?page=live_018&id=<?php echo $id_live ?>&check=1" class="btn btn-lg btn-primary btn-block">submit</a> -->
                <input type="hidden" name="check" value="1">
                <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
            </div><br>
        </div>
    </div>
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_018">Next</button>
    </div>
</form>
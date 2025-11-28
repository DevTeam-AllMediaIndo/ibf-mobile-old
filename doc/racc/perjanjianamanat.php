<?php
    $id_live = $_GET['id'];

    $SQL_QUERYACC = mysqli_query($db, "
        SELECT tb_racc.*
        FROM tb_racc
        WHERE tb_racc.ACC_LOGIN = '0'
        AND tb_racc.ACC_MBR = ".$user1['MBR_ID']."
        AND tb_racc.ACC_DERE = 1
        AND MD5(MD5(tb_racc.ID_ACC)) = '".$id_live."'
        LIMIT 1
    ");
    if(mysqli_num_rows($SQL_QUERYACC) > 0) {
        $RESULT_QUERYACC = mysqli_fetch_assoc($SQL_QUERYACC);
    };

    if($RESULT_QUERYACC['ACC_TYPE'] == 1){
        $title = 'Derivatif dalam Sistem Perdagangan Alternatif';
    } else if($RESULT_QUERYACC['ACC_TYPE'] == 2){
        $title = 'berjangka';
    }

    if((date('H:i:s') >= '06:00:00') && (date('H:i:s') <= '14:59:59')){
        $shift = 'M Ramdan Diniarsah';
    } else{ $shift = 'M Ramdan Diniarsah'; }
    
    if(isset($_POST['submit_08'])){
        if(isset($_POST['step07_kotapenyelesaian'])){
            if(isset($_POST['step07_kantorpenyelesaian'])){
                if(isset($_GET['id'])){
                    $aggree = form_input($_POST['aggree']);
                    if($aggree == 'Yes'){
                        $step07_kotapenyelesaian = form_input($_POST["step07_kotapenyelesaian"]);
                        $step07_kantorpenyelesaian = form_input($_POST["step07_kantorpenyelesaian"]);
                    
                        mysqli_query($db, '
                            UPDATE tb_racc SET
                                tb_racc.ACC_F_PERJ = 1,
                                tb_racc.ACC_F_PERJ_IP = "'.$IP_ADDRESS.'",
                                tb_racc.ACC_F_PERJ_DATE = "'.date('Y-m-d H:i:s').'",
                                tb_racc.ACC_F_PERJ_WPB = "'.$shift.'",
                                tb_racc.ACC_F_PERJ_KANTOR = "'.$step07_kotapenyelesaian.'",
                                tb_racc.ACC_F_PERJ_PERSLISIHAN = "'.$step07_kantorpenyelesaian.'",
                                tb_racc.ACC_F_PERJ_PERYT = "'.$aggree.'",
                                tb_racc.ACC_F_PERJ_DATE = "'.date('Y-m-d H:i:s').'"
                            WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                        ') or die (mysqli_error($db));
                        die ("<script>location.href = 'home.php?page=racc/tradingrules&id=".$id_live."'</script>");
                    }else {die("<script>location.href = 'home.php?page=racc/perjanjianamanat&id=".$id_live."'</script>");};
                } else {
                    logerr("Parameter Ke-3 Tidak Lengkap", "Perjanjian Amanat", $user1["MBR_ID"]);
                    die ("<script>alert('please try again2');location.href = 'home.php?page=racc/perjanjianamanat&id=".$id_live."'</>"); 
                }
            } else {
                logerr("Parameter Ke-2 Tidak Lengkap", "Perjanjian Amanat", $user1["MBR_ID"]);
                die ("<script>alert('please try again1');location.href = 'home.php?page=racc/perjanjianamanat&id=".$id_live."'</script>"); 
            }
        } else {
            logerr("Parameter Ke-1 Tidak Lengkap", "Perjanjian Amanat", $user1["MBR_ID"]);
            die ("<script>alert('please try again1');location.href = 'home.php?page=racc/perjanjianamanat&id=".$id_live."'</script>"); 
        }
    };
        
        if(strtolower(date('l')) == strtolower('Monday')){ $date_day = 'Senin';
        } else if(strtolower(date('l')) == strtolower('Tuesday')){ $date_day = 'Selasa';
        } else if(strtolower(date('l')) == strtolower('wednesday')){ $date_day = 'Rabu';
        } else if(strtolower(date('l')) == strtolower('thursday')){ $date_day = 'Kamis';
        } else if(strtolower(date('l')) == strtolower('Friday')){ $date_day = 'Jumat';
        } else if(strtolower(date('l')) == strtolower('Saturday')){ $date_day = 'Sabtu';
        } else if(strtolower(date('l')) == strtolower('Sunday')){ $date_day = 'Minggu';
        };

        if(strtolower(date('F')) == strtolower('January')){ $date_month = 'Januari';
        } else if(strtolower(date('F')) == strtolower('February')){ $date_month = 'Februari';
        } else if(strtolower(date('F')) == strtolower('March')){ $date_month = 'Maret';
        } else if(strtolower(date('F')) == strtolower('April')){ $date_month = 'April';
        } else if(strtolower(date('F')) == strtolower('May')){ $date_month = 'Mai';
        } else if(strtolower(date('F')) == strtolower('June')){ $date_month = 'Juni';
        } else if(strtolower(date('F')) == strtolower('July')){ $date_month = 'Juli';
        } else if(strtolower(date('F')) == strtolower('August')){ $date_month = 'Agustus';
        } else if(strtolower(date('F')) == strtolower('September')){ $date_month = 'September';
        } else if(strtolower(date('F')) == strtolower('October')){ $date_month = 'Oktober';
        } else if(strtolower(date('F')) == strtolower('November')){ $date_month = 'November';
        } else if(strtolower(date('F')) == strtolower('December')){ $date_month = 'Desember';
        };
?>
<?php
    if($RESULT_QUERYACC['ACC_TYPE'] == 1){
        $ACC_TYPE1 = 2;
        $title = 'derivatif dalam sistem perdagangan alternatif';
        $typecont = 'Formulir Nomor 107.PBK.04.2 ';
    } else if($RESULT_QUERYACC['ACC_TYPE'] == 2){
        $ACC_TYPE1 = 1;
        $title = 'berjangka';
        $typecont = 'Formulir Nomor 107.PBK.04.1 ';
    }
?>
<div class="page-title page-title-small">
    <h2>Formulir</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<form method="post">
    <div class="card card-style">
        <div class="card-body">
            <div class="form-group boxed">
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="col-6 text-left">
                            <strong><small><b><?php //echo $typecont ?></b></small></strong>
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
                    <div class="text-center" style="vertical-align: middle;padding: 20px 0 10px 0;">
                        <?php if($ACC_TYPE1 == 1){ ?>
                            <h6 class="text-center"><u>PERJANJIAN PEMBERIAN AMANAT SECARA ELEKTRONIK ON-LINE<br>
                            UNTUK TRANSAKSI KONTRAK BERJANGKA</u></h6>
                        <?php } else if($ACC_TYPE1 == 2){ ?>
                            <h6 class="text-center"><u>PERJANJIAN PEMBERIAN AMANAT SECARA ELEKTRONIK ON-LINE<br>
                            UNTUK TRANSAKSI KONTRAK DERIVATIF<br>
                            DALAM SISTEM PERDAGANGAN ALTERNATIF</u></h6>
                        <?php } ?>
                    </div>
                    <hr>
                    <div class="mt-3 text-center" style="border:3px solid black;vertical-align: middle;padding: 2px;">
                        <div class="text-center" style="border:1px solid black;vertical-align: middle;padding: 10px 0;">
                            <strong>PERHATIAN !</strong><br>
                            PERJANJIAN INI MERUPAKAN KONTRAK HUKUM. HARAP DIBACA DENGAN SEKSAMA
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-justify">Pada hari ini <?php echo $date_day ?>, tanggal <?php echo date('d') ?>, bulan <?php echo $date_month ?>, tahun <?php echo date('Y') ?>, kami
                        yang mengisi perjanjian di bawah ini:</p>
                        <table width="100%">
                            <tr>
                                <td rowspan="3" width="1%" style="padding:0px 5px;white-space:nowrap;vertical-align: top;"> 1. </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;" > Nama </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;"> : </td>
                                <td> <?php echo $user1['MBR_NAME'] ?></td>
                            </tr>
                            <tr>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;" > Pekerjaan / Jabatan </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;"> : </td>
                                <td> <?php echo $RESULT_QUERYACC['ACC_F_APP_KRJ_NAMA'].' / '.$RESULT_QUERYACC['ACC_F_APP_KRJ_JBTN'] ?></td>
                            </tr>
                            <tr>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;" > Alamat </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;"> : </td>
                                <td> <?php echo $user1['MBR_ADDRESS'] ?></td>
                            </tr>
                        </table><br>
                        <p class="text-justify">dalam hal ini bertindak untuk dan atas nama sendiri, yang selanjutnya di sebut Nasabah,</p>
                        <table width="100%">
                            <tr>
                                <td rowspan="3" width="1%" style="padding:0px 5px;white-space:nowrap;vertical-align: top;"> 2. </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;" > Nama </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;"> : </td>
                                <td><?php echo $shift?></td>
                            </tr>
                            <tr>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;" > Pekerjaan / Jabatan </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;"> : </td>
                                <td> (Petugas Wakil Pialang yang Ditunjuk Memverifikasi)</td>
                            </tr>
                            <tr>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;" > Alamat </td>
                                <td width="1%" style="padding:0px 5px;white-space:nowrap;"> : </td>
                                <td> Paskal Hyper Square Blok D no.45-46 Jalan H.O.S. Cokroaminoto no.25-27 Bandung</td>
                            </tr>
                        </table>
                        <p class="text-justify">dalam hal ini bertindak untuk dan atas nama <strong>PT. International Business Futures</strong> yang selanjutnya
                        disebut <strong>Pialang Berjangka</strong>,</p>
                        <p class="text-justify">Nasabah dan Pialang Berjangka secara bersama – sama selanjutnya disebut <strong>Para Pihak</strong>.</p>
                        <p class="text-justify">Para pihak sepakat untuk mengadakan Perjanjian Pemberian Amanat untuk melakukan
                        transaksi penjualan maupun pembelian Kontrak <?php echo ucwords($title); ?> dengan ketentuan sebagai berikut:</p>
                        <ol>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '1'; } else { echo '1'; } ?>.">
                                <strong>Margin dan Pembayaran Lainnya</strong>
                                <ol>
                                    <li seq=" (1)"><strong>Nasabah menempatkan sejumlah dana</strong> (Margin) ke Rekening Terpisah (Segregated Account) Pialang Berjangka sebagai Margin Awal dan wajib mempertahankannya sebagaimana ditetapkan.</li>
                                    <li seq=" (2)">membayar biaya-biaya yang diperlukan untuk transaksi, yaitu biaya transaksi, pajak, komisi, dan biaya pelayanan, biaya bunga sesuai tingkat yang berlaku, dan biaya lainnya yang dapat dipertanggungjawabkan berkaitan dengan transaksi sesuai amanat Nasabah, maupun biaya rekening Nasabah.</li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_01" onclick="run();" value="YA" required/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '2'; } else { echo '2'; } ?>.">
                                <strong>Pelaksanaan <?php if($ACC_TYPE1 == 1){ echo 'Amanat'; } else { echo 'Transaksi'; } ?></strong>
                                <?php if($ACC_TYPE1 == 1){ ?>
                                    <ol>
                                        <li seq=" (1)">Setiap amanat yang disampaikan oleh Nasabah atau kuasanya yang ditunjuk
                                        secara tertulis oleh Nasabah, dianggap sah apabila diterima oleh Pialang Berjangka
                                        sesuai dengan ketentuan yang berlaku, dapat berupa amanat tertulis yang
                                        ditandatangani oleh Nasabah atau kuasanya, amanat telepon yang direkam,
                                        dan/atau amanat transaksi elektronik lainnya. </li>
                                        <li seq=" (2)">Setiap amanat Nasabah yang diterima dapat langsung dilaksanakan sepanjang
                                        nilai Margin yang tersedia pada rekeningnya mencukupi dan eksekusinya
                                        tergantung pada kondisi dan sistem transaksi yang berlaku yang mungkin dapat
                                        menimbulkan perbedaan waktu terhadap proses pelaksanaan amanat tersebut.
                                        Nasabah harus mengetahui posisi Margin dan posisi terbuka sebelum memberikan
                                        amanat untuk transaksi berikutnya. </li>
                                        <li seq=" (3)">Amanat Nasabah hanya dapat dibatalkan dan/atau diperbaiki apabila transaksi
                                        atas amanat tersebut belum terjadi. Pialang Berjangka tidak bertanggung jawab
                                        atas kerugian yang timbul akibat tidak terlaksananya pembatalan dan/atau
                                        perbaikan sepanjang bukan karena kelalaian Pialang Berjangka. </li>
                                        <li seq=" (4)">Pialang Berjangka berhak menolak amanat Nasabah apabila harga yang
                                        ditawarkan atau diminta tidak wajar. </li>
                                        <li seq=" (5)">Nasabah bertanggung jawab atas keamanan dan penggunaan 
                                            username dan password dalam transaksi Perdagangan Berjangka,
                                            oleh karenanya Nasabah dilarang memberitahukan, menyerahkan atau meminjamkan username dan password kepada pihak lain,
                                            termasuk kepada pegawai Pialang Berjangka.
                                        </li>
                                    </ol>
                                <?php } else{ ?>
                                    <ol>
                                        <li seq=" (1)">Setiap transaksi Nasabah dilaksanakan secara elektronik on-line oleh Nasabah
                                        yang bersangkutan;</li>
                                        <li seq=" (2)">Setiap amanat Nasabah yang diterima dapat langsung dilaksanakan sepanjang
                                        nilai Margin yang tersedia pada rekeningnya mencukupi dan eksekusinya dapat
                                        menimbulkan perbedaan waktu terhadap proses pelaksanaan transaksi
                                        tersebut. Nasabah harus mengetahui posisi Margin dan posisi terbuka sebelum
                                        memberikan amanat untuk transaksi berikutnya.</li>
                                        <li seq=" (3)">Setiap transaksi Nasabah secara bilateral dilawankan dengan Penyelenggara Sistem Perdagangan 
                                        Alternatif PT. Real Time Forex Indonesia yang bekerjasama dengan Pialang Berjangka.
                                        </li>
                                        <li seq=" (4)">Nasabah bertanggung jawab atas keamanan dan peggunaan username dan password 
                                        dalam transaksi Perdagangan Berjangka, Nasabah dilarang memberitahukan, mnyerahkan atau 
                                        meminjamkan username dan password kepada pihak lain, termasuk kepada pegawai Pialang Berjangka.</li>
                                    </ol>
                                <?php }; ?>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_02" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <?php if($ACC_TYPE1 == 1){ ?>
                                <li seq="3.">
                                    <strong>Antisipasi penyerahan barang</strong>
                                    <ol>
                                        <li seq=" (1)">Untuk kontrak-kontrak tertentu penyelesaian transaksi dapat dilakukan dengan
                                        penyerahan atau penerimaan barang (delivery) apabila kontrak jatuh tempo.
                                        Nasabah menyadari bahwa penyerahan atau penerimaan barang mengandung
                                        risiko yang lebih besar daripada melikuidasi posisi dengan offset. Penyerahan fisik
                                        barang memiliki konsekuensi kebutuhan dana yang lebih besar serta tambahan
                                        biaya pengelolaan barang.</li>
                                        <li seq=" (2)">Pialang Berjangka tidak bertanggung jawab atas klasifikasi mutu (grade), kualitas
                                        atau tingkat toleransi atas komoditi yang diserahkan atau akan diserahkan.</li>
                                        <li seq=" (3)">Pelaksanaan penyerahan atau penerimaan barang tersebut akan diatur dan
                                        dijamin oleh Lembaga Kliring Berjangka.</li>
                                    </ol>
                                </li>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_03" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            <?php }; ?>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '4'; } else { echo '3'; } ?>.">
                                <strong>Kewajiban Memelihara Margin</strong>
                                <ol>
                                    <li seq=" (1)">Nasabah wajib memelihara/memenuhi tingkat Margin yang harus tersedia di rekening pada Pialang Berjangka sesuai dengan jumlah yang telah ditetapkan baik diminta ataupun tidak oleh Pialang Berjangka.</li>
                                    <li seq=" (2)">Apabila jumlah Margin memerlukan penambahan maka Pialang Berjangka wajib memberitahukan dan memintakan kepada Nasabah untuk menambah Margin segera.</li>
                                    <li seq=" (3)">Apabila jumlah Margin memerlukan tambahan (Call Margin) maka Nasabah wajib melakukan penyerahan Call Margin selambat-lambatnya sebelum dimulai hari perdagangan berikutnya. Kewajiban Nasabah sehubungan dengan penyerahan Call Margin tidak terbatas pada jumlah Margin awal.</li>
                                    <li seq=" (4)">Pialang Berjangka tidak berkewajiban melaksanakan amanat untuk melakukan transaksi yang baru dari Nasabah sebelum Call Margin dipenuhi.</li>
                                    <li seq=" (5)">Untuk memenuhi kewajiban Call Margin dan keuangan lainnya dari Nasabah, Pialang Berjangka dapat mencairkan dana Nasabah yang ada di Pialang Berjangka.</li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_04" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '5'; } else { echo '4'; } ?>.">
                                <strong>Hak Pialang Berjangka Melikuidasi Posisi Nasabah</strong>
                                <p style="padding-left:5px;">Nasabah bertanggung jawab memantau/mengetahui posisi terbukanya secara terus- menerus dan memenuhi kewajibannya. Apabila dalam jangka waktu tertentu dana pada rekening Nasabah kurang dari yang dipersyaratkan, Pialang Berjangka dapat menutup posisi terbuka Nasabah secara keseluruhan atau sebagian, membatasi transaksi, atau tindakan lain untuk melindungi diri dalam pemenuhan Margin tersebut dengan terlebih dahulu memberitahu atau tanpa memberitahu Nasabah dan Pialang Berjangka tidak bertanggung jawab atas kerugian yang timbul akibat tindakan tersebut.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_05" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <?php if($ACC_TYPE1 == 1){ ?>
                                <li seq="6.">
                                    <strong>Penggantian Kerugian Tidak Menyerahkan Barang</strong>
                                    <p style="padding-left:5px;">Apabila Nasabah tidak mampu menyerahkan komoditi atas Kontrak Berjangka yang
                                    jatuh tempo, Nasabah memberikan kuasa kepada Pialang Berjangka untuk meminjam
                                    atau membeli komoditi untuk penyerahan tersebut. Nasabah wajib membayar
                                    secepatnya semua biaya, kerugian dan premi yang telah dibayarkan oleh Pialang
                                    Berjangka atas tindakan tersebut. Apabila Pialang Berjangka harus menerima
                                    penyerahan komoditi atau surat berharga maka Nasabah bertanggung jawab atas
                                    penurunan nilai dari komoditi atas surat berharga tersebut.<br>
                                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_06_01" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                                </li>
                            <?php }; ?>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '7'; } else { echo '5'; } ?>.">
                                <strong>Penggantian Kerugian Tidak Adanya Penutupan Posisi</strong>
                                <p style="padding-left:5px;">Apabila Nasabah tidak mampu melakukan penutupan atas transaksi yang jatuh tempo, Pialang Berjangka dapat melakukan penutupan atas transaksi <?php if($ACC_TYPE1 == 1){ echo 'di Bursa'; } else { echo 'Nasabah yang terjadi'; } ?>. Nasabah wajib membayar biaya-biaya, termasuk biaya kerugian dan premi yang telah dibayarkan oleh Pialang Berjangka, dan apabila Nasabah lalai untuk membayar biaya-biaya tersebut, Pialang Berjangka berhak untuk mengambil pembayaran dari dana Nasabah.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_06" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '8'; } else { echo '6'; } ?>.">
                                <strong>Pialang Berjangka Dapat Membatasi Posisi</strong>
                                <p style="padding-left:5px;">Nasabah mengakui hak Pialang Berjangka untuk membatasi posisi terbuka Kontrak <?php if($ACC_TYPE1 == 1){ echo 'berjangka nasabah'; }; ?> Nasabah tidak melakukan transaksi melebihi batas yang telah ditetapkan tersebut.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_07" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '9'; } else { echo '7'; } ?>.">
                                <strong>Tidak Ada Jaminan atas Informasi atau Rekomendasi</strong>
                                <p style="padding-left:5px;">Nasabah mengakui bahwa :</p>
                                <ol>
                                    <li seq=" (1)">Informasi dan rekomendasi yang diberikan oleh Pialang Berjangka kepada Nasabah tidak selalu lengkap dan perlu diverifikasi.</li>
                                    <li seq=" (2)">Pialang Berjangka tidak menjamin bahwa informasi dan rekomendasi yang diberikan merupakan informasi yang akurat dan lengkap.</li>
                                    <li seq=" (3)">Informasi dan rekomendasi yang diberikan oleh Wakil Pialang Berjangka yang satu dengan yang lain mungkin berbeda karena perbedaan analisis fundamental atau teknikal. Nasabah menyadari bahwa ada kemungkinan Pialang Berjangka dan pihak terafiliasinya memiliki posisi di pasar dan memberikan rekomendasi tidak konsisten kepada Nasabah.</li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_08" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '10'; } else { echo '8'; } ?>.">
                                <strong>Pembatasan Tanggung Jawab Pialang Berjangka.</strong>
                                <ol>
                                    <li seq=" (1)">Pialang Berjangka tidak bertanggung jawab untuk memberikan penilaian kepada Nasabah mengenai iklim, pasar, keadaan politik dan ekonomi nasional dan internasional, nilai Kontrak <?php if($ACC_TYPE1 == 1){ echo 'berjangka'; } else { echo 'Derivatif'; } ?>, kolateral, atau memberikan nasihat mengenai keadaan pasar. Pialang Berjangka hanya memberikan pelayanan untuk melakukan transaksi secara jujur serta memberikan laporan atas transaksi tersebut.</li>
                                    <li seq=" (2)">Perdagangan sewaktu-waktu dapat dihentikan oleh pihak yang memiliki otoritas (Bappebti/Bursa Berjangka) tanpa pemberitahuan terlebih dahulu kepada Nasabah. Atas posisi terbuka yang masih dimiliki oleh Nasabah pada saat perdagangan tersebut dihentikan, maka akan diselesaikan (likuidasi) berdasarkan pada peraturan/ketentuan yang dikeluarkan dan ditetapkan oleh pihak otoritas tersebut, dan semua kerugian serta biaya yang timbul sebagai akibat dihentikannya transaksi oleh pihak otoritas perdagangan tersebut, menjadi beban dan tanggung jawab Nasabah sepenuhnya.</li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_09" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '11'; } else { echo '9'; } ?>.">
                                <strong>Transaksi Harus Mematuhi Peraturan Yang Berlaku</strong>
                                <p style="padding-left:5px;">
                                    <?php if($ACC_TYPE1 == 1){ ?>
                                        Semua transaksi baik yang dilakukan sendiri oleh Nasabah maupun melalui Pialang
                                        Berjangka wajib mematuhi peraturan perundang-undangan di bidang Perdagangan
                                        Berjangka, kebiasaan dan interpretasi resmi yang ditetapkan oleh Bappebti atau
                                        Bursa Berjangka.
                                    <?php } else if($ACC_TYPE1 == 2){ ?>
                                        Semua transaksi dilakukan sendiri oleh Nasabah dan wajib mematuhi peraturan
                                        perundang-undangan di bidang Perdagangan Berjangka, kebiasaan dan
                                        interpretasi resmi yang ditetapkan oleh Bappebti atau Bursa Berjangka. 
                                    <?php }; ?><br>
                                </p>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_10" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '12'; } else { echo '10'; } ?>.">
                                <strong>Pialang Berjangka tidak Bertanggung jawab atas Kegagalan Komunikasi</strong>
                                <p style="padding-left:5px;">Pialang Berjangka tidak bertanggung jawab atas keterlambatan atau tidak tepat waktunya pengiriman amanat atau informasi lainnya yang disebabkan oleh kerusakan fasilitas komunikasi atau sebab lain diluar kontrol Pialang Berjangka.<br>
                                </p>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_11" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '13'; } else { echo '11'; } ?>.">
                                <strong>Konfirmasi</strong>
                                <ol>
                                    <li seq=" (1)">Konfirmasi dari Nasabah dapat berupa surat, telex, media lain, <?php if($ACC_TYPE1 == 1){ echo ''; } else { echo 'surat elektronik,'; } ?> secara tertulis ataupun rekaman suara.</li>
                                    <li seq=" (2)">Pialang Berjangka berkewajiban menyampaikan konfirmasi transaksi, laporan rekening, permintaan Call Margin, dan pemberitahuan lainnya kepada Nasabah secara akurat, benar dan secepatnya pada alamat (email) Nasabah sesuai dengan yang tertera dalam rekening Nasabah. Apabila dalam jangka waktu 2 x 24 jam setelah amanat jual atau beli disampaikan, tetapi Nasabah belum menerima konfirmasi melalui alamat email Nasabah dan/atau sistem transaksi, Nasabah segera memberitahukan hal tersebut kepada Pialang Berjangka melalui telepon dan disusul dengan pemberitahuan tertulis.</li>
                                    <li seq=" (3)">Jika dalam waktu 2 x 24 jam sejak tanggal penerimaan konfirmasi tersebut tidak ada sanggahan dari Nasabah maka konfirmasi Pialang Berjangka dianggap benar dan sah.</li>
                                    <li seq=" (4)">Kekeliruan atas konfirmasi yang diterbitkan Pialang Berjangka akan diperbaiki oleh Pialang Berjangka sesuai keadaan yang sebenarnya dan demi hukum konfirmasi yang lama batal.</li>
                                    <li seq=" (5)">Nasabah tidak bertanggung jawab atas transaksi yang dilaksanakan atas rekeningnya apabila konfirmasi tersebut tidak disampaikan secara benar dan akurat.</li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_12" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '14'; } else { echo '12'; } ?>.">
                                <strong>Kebenaran Informasi Nasabah</strong>
                                <p style="padding-left:5px;">Nasabah memberikan informasi yang benar dan akurat mengenai data Nasabah yang diminta oleh Pialang Berjangka dan akan memberitahukan paling lambat dalam waktu 3 (tiga) hari kerja setelah terjadi perubahan, termasuk perubahan kemampuan keuangannya untuk terus melaksanakan transaksi.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_13" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '15'; } else { echo '13'; } ?>.">
                                <strong>Komisi Transaksi</strong>
                                <p style="padding-left:5px;">Nasabah mengetahui dan menyetujui bahwa Pialang Berjangka berhak untuk memungut komisi atas transaksi yang telah dilaksanakan, dalam jumlah sebagaimana akan ditetapkan dari waktu ke waktu oleh Pialang Berjangka. Perubahan beban (fees) dan biaya lainnya harus disetujui secara tertulis oleh Para Pihak.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_14" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '16'; } else { echo '14'; } ?>.">
                                <strong>Pemberian Kuasa</strong>
                                <p style="padding-left:5px;">Nasabah memberikan kuasa kepada Pialang Berjangka untuk menghubungi bank, lembaga keuangan, Pialang Berjangka lain, atau institusi lain yang terkait untuk memperoleh keterangan atau verifikasi mengenai informasi yang diterima dari Nasabah. Nasabah mengerti bahwa penelitian mengenai data hutang pribadi dan bisnis dapat dilakukan oleh Pialang Berjangka apabila diperlukan. Nasabah diberikan kesempatan untuk memberitahukan secara tertulis dalam jangka waktu yang telah disepakati untuk melengkapi persyaratan yang diperlukan.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_15" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '17'; } else { echo '15'; } ?>.">
                                <strong>Pemindahan Dana</strong>
                                <p style="padding-left:5px;">Pialang Berjangka dapat setiap saat mengalihkan dana dari satu rekening ke rekening lainnya berkaitan dengan kegiatan transaksi yang dilakukan Nasabah seperti pembayaran komisi, pembayaran biaya transaksi, kliring dan keterlambatan dalam memenuhi kewajibannya, tanpa terlebih dahulu memberitahukan kepada Nasabah. Transfer yang telah dilakukan akan segera diberitahukan secara tertulis kepada Nasabah<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_16" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '18'; } else { echo '16'; } ?>.">
                                <strong>Pemberitahuan</strong>
                                <ol>
                                    <li seq=" (<?php if($ACC_TYPE1 == 1){ echo '1'; } else { echo '4'; } ?>)">Semua komunikasi, uang, surat berharga, dan kekayaan lainnya harus dikirimkan langsung ke alamat Nasabah seperti tertera dalam rekeningnya atau alamat lain yang ditetapkan/diberitahukan secara tertulis oleh Nasabah.</li>
                                    <li seq=" (<?php if($ACC_TYPE1 == 1){ echo '2'; } else { echo '5'; } ?>)">
                                        Semua uang, harus disetor atau ditransfer langsung oleh Nasabah ke Rekening Terpisah (Segregated Account) Pialang Berjangka:
                                        <table width="100%" style="margin-left:5px;">
                                            <tr>
                                                <td width="36%">Nama</td>
                                                <td width="2%">&nbsp;:&nbsp;</td>
                                                <td>PT. International Business Futures</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">Alamat</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td>
                                                Paskal Hyper Square Blok D no.45-46 Jalan H.O.S. Cokroaminoto no.25-27 Bandung
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bank</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>BCA (Bank Central Asia Tbk)</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">No. Rekening Terpisah</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td>
                                                    008-3073966 (IDR)<br>
                                                    008-4214210 (USD)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bank</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>Bank Mandiri</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">No. Rekening Terpisah</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td>
                                                    130-0088881779 (IDR)
                                                </td>
                                            </tr>
                                        </table>
                                        dan dianggap sudah diterima oleh Pialang Berjangka apabila sudah ada tanda terima bukti setor atau transfer dari pegawai Pialang Berjangka.<br>
                                    </li>
                                    <li seq=" (<?php if($ACC_TYPE1 == 1){ echo '3'; } else { echo '6'; } ?>)">
                                        Semua surat berharga, kekayaan lainnya, atau komunikasi harus dikirim kepada Pialang Berjangka:
                                        <table width="100%" style="margin-left:5px;">
                                            <tr>
                                                <td width="36%">Nama</td>
                                                <td width="2%">&nbsp;:&nbsp;</td>
                                                <td>PT. International Business Futures</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">Alamat</td>
                                                <td valign="top">&nbsp;:&nbsp;</td>
                                                <td>
                                                Paskal Hyper Square Blok D no.45-46 Jalan H.O.S. Cokroaminoto no.25-27 Bandung
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Telepon</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>(022) 86061128</td>
                                            </tr>
                                            <tr>
                                                <td>Facsimile</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>(022) 86061126</td>
                                            </tr>
                                            <tr>
                                                <td>E-mail</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>Support@ibftrader.com</td>
                                            </tr>
                                        </table>
                                        dan dianggap sudah diterima oleh Pialang Berjangka apabila sudah ada tanda bukti penerimaan dari pegawai Pialang Berjangka.<br>
                                    </li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_17" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '19'; } else { echo '17'; } ?>.">
                                <strong>Dokumen Pemberitahuan Adanya Risiko</strong>
                                <p style="padding-left:5px;">Nasabah mengakui menerima dan mengerti Dokumen Pemberitahuan Adanya Risiko.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_18" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '20'; } else { echo '18'; } ?>.">
                                <strong>Jangka Waktu Perjanjian dan Pengakhiran</strong>
                                <ol>
                                    <li seq=" (1)">Perjanjian ini mulai berlaku terhitung sejak tanggal dilakukannya konfirmasi oleh Pialang Berjangka dengan diterimanya Bukti Konfirmasi Penerimaan Nasabah dari Pialang Berjangka oleh Nasabah.</li>
                                    <li seq=" (2)">Nasabah dapat mengakhiri Perjanjian ini hanya jika Nasabah sudah tidak lagi memiliki posisi terbuka dan tidak ada kewajiban Nasabah yang diemban oleh atau terhutang kepada Pialang Berjangka.</li>
                                    <li seq=" (3)">Pengakhiran tidak membebaskan salah satu Pihak dari tanggung jawab atau kewajiban yang terjadi sebelum pemberitahuan tersebut.</li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_19" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '21'; } else { echo '19'; } ?>.">
                                <strong>Berakhirnya Perjanjian</strong>
                                <p style="padding-left:5px;">Perjanjian dapat berakhir dalam hal Nasabah:</p>
                                <ol>
                                    <li seq=" (1)">dinyatakan pailit, memiliki hutang yang sangat besar, dalam proses peradilan, menjadi hilang ingatan, mengundurkan diri atau meninggal;</li>
                                    <li seq=" (2)">tidak dapat memenuhi atau mematuhi perjanjian ini dan/atau melakukan pelanggaran terhadapnya;</li>
                                    <li seq=" (3)">
                                        berkaitan dengan butir (1) dan (2) tersebut diatas, Pialang Berjangka dapat :                                                            
                                        <ol>
                                            <li seq=" i)">meneruskan atau menutup posisi Nasabah tersebut setelah mempertimbangkannya secara cermat dan jujur ; dan</li>
                                            <li seq=" ii)">menolak transaksi dari Nasabah.</li>
                                        </ol>
                                    </li>
                                    <li seq=" (4)">Pengakhiran Perjanjian sebagaimana dimaksud dengan angka (1) dan (2) tersebut di atas tidak melepaskan kewajiban dari Para Pihak yang berhubungan dengan penerimaan atau kewajiban pembayaran atau pertanggungjawaban kewajiban lainnya yang timbul dari Perjanjian.</li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_20" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '22'; } else { echo '20'; } ?>.">
                                <strong><i>Force Majeur</i></strong>
                                <p style="padding-left:5px;">
                                    Tidak ada satupun pihak di dalam Perjanjian dapat diminta pertanggungjawabannya untuk suatu keterlambatan atau terhalangnya memenuhi kewajiban berdasarkan Perjanjian yang diakibatkan oleh suatu sebab yang berada di luar kemampuannya atau kekuasaannya (<i>force majeur</i>), sepanjang pemberitahuan tertulis mengenai sebab itu disampaikannya kepada pihak lain dalam Perjanjian dalam waktu tidak lebih dari 24 (dua puluh empat) jam sejak timbulnya sebab itu.<br>
                                    Yang dimaksud dengan <i>Force Majeur</i> dalam Perjanjian adalah peristiwa kebakaran, bencana alam (seperti gempa bumi, banjir, angin topan, petir), pemogokan umum, huru hara, peperangan, perubahan terhadap peraturan perundang-undangan yang berlaku dan kondisi di bidang ekonomi, keuangan dan Perdagangan Berjangka, pembatasan yang dilakukan oleh otoritas Perdagangan Berjangka dan Bursa Berjangka serta terganggunya sistem perdagangan, kliring dan penyelesaian transaksi Kontrak Berjangka di mana transaksi dilaksanakan yang secara langsung mempengaruhi pelaksanaan pekerjaan berdasarkan Perjanjian.<br>
                                </p>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_21" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '23'; } else { echo '21'; } ?>.">
                                <strong>Perubahan atas Isian dalam Perjanjian Pemberian Amanat</strong>
                                <p style="padding-left:5px;">Perubahan atas isian dalam Perjanjian ini hanya dapat dilakukan atas persetujuan Para Pihak, atau Pialang Berjangka telah memberitahukan secara tertulis perubahan yang diinginkan, dan Nasabah tetap memberikan perintah untuk transaksi dengan tanpa memberikan tanggapan secara tertulis atas usul perubahan tersebut. Tindakan Nasabah tersebut dianggap setuju atas usul perubahan tersebut.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_22" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <?php if($ACC_TYPE1 == 2){?>
                                <li seq="<?php if($ACC_TYPE1 == 2){ echo '22'; } else { echo '22'; } ?>.">
                                    <strong>Tanggung Jawab Kepada Nasabah</strong>
                                    <ol type="a">
                                        <li>
                                            Penyelenggara Sistem Perdagangan Alternatif yang merupakan pihak yang menguasai dan/atau memiliki sistem perdagangan elektronik bertanggung jawab atas pelanggaran 
                                            penyalahgunaan sistem perdagangan elektronik sesuai dengan ketentuan yang diatur dalam Perjanjian Kerjasama (PKS) dan peraturan perdagangan (trading rules) 
                                            antara Penyelenggara Sistem Perdagangan Alternatif dan Peserta Sistem Perdagangan Alternatif yang mengakibatkan kerugian Nasabah.
                                        </li>
                                        <li>
                                            Peserta Sistem Perdagangan Alternatif yang merupakan pihak yang menggunakan sistem perdagangan 
                                            elektronik bertanggung jawab atas pelanggaran penyalahgunaan sistem perdagangan elektronik 
                                            sebagaimana dimaksud pada angka 22 huruf (a) yang mengakibatkan kerugian Nasabah.
                                        </li>
                                        <li>
                                            Dalam pemanfaatan sistem perdagangan elektronik, 
                                            Penyelenggara Sistem Perdagangan Alternatif dan/atau Peserta Sistem Perdagangan 
                                            Alternatif tidak bertanggung jawab atas kerugian Nasabah diluar hal-hal yang telah diatur pada 
                                            angka 22 huruf (a) dan (b), antara lain: kerugian yang diakibatkan oleh risiko-risiko yang 
                                            disebutkan di dalam Dokumen Pemberitahuan Adanya Risiko yang telah dimengerti dan disetujui 
                                            oleh Nasabah.
                                        </li>
                                    </ol>
                                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_23" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                                </li>
                            <?php };?>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '24'; } else { echo '23'; } ?>.">
                                <strong>Penyelesaian Perselisihan</strong>
                                <ol>
                                    <li seq=" (<?php if($ACC_TYPE1 == 1){ echo '1'; } else { echo '5'; } ?>)">Semua perselisihan dan perbedaan pendapat yang timbul dalam pelaksanaan Perjanjian ini wajib diselesaikan terlebih dahulu secara musyawarah untuk mencapai mufakat antara Para Pihak.</li>
                                    <li seq=" (<?php if($ACC_TYPE1 == 1){ echo '2'; } else { echo '6'; } ?>)">Apabila perselisihan dan perbedaan pendapat yang timbul tidak dapat diselesaikan secara musyawarah untuk mencapai mufakat, Para Pihak wajib memanfaatkan sarana penyelesaian perselisihan yang tersedia di Bursa Berjangka.</li>
                                    <li seq=" (<?php if($ACC_TYPE1 == 1){ echo '3'; } else { echo '7'; } ?>)">
                                        Apabila perselisihan dan perbedaan pendapat yang timbul tidak dapat diselesaikan melalui cara sebagaimana dimaksud pada angka (1) dan angka (2), maka Para Pihak sepakat untuk menyelesaikan perselisihan melalui *):
                                        <table width="50%" style="margin-left:5px;">
                                            <tr>
                                                <td width="2%" style="vertical-align:top"><input class="form-check-input radio_css" type="radio"  name="step07_kotapenyelesaian" value="BAKTI" required /></td>
                                                <td width="2%" style="vertical-align:top">&nbsp;&nbsp;a.&nbsp;&nbsp;</td>
                                                <td>Badan Arbitrase Perdagangan Berjangka Komoditi (BAKTI) 
                                                berdasarkan Peraturan dan Prosedur Badan Arbitrase 
                                                Perdagangan Berjangka Komoditi (BAKTI); atau</td>
                                            </tr>
                                            <tr>
                                                <td width="2%" style="vertical-align:top"><input class="form-check-input radio_css" type="radio" name="step07_kotapenyelesaian" value="Pengadilan Negeri Bandung" required /></td>
                                                <td width="2%" style="vertical-align:top">&nbsp;&nbsp;b.&nbsp;&nbsp;</td>
                                                <td>Pengadilan Negeri Bandung</td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li seq=" (<?php if($ACC_TYPE1 == 1){ echo '4'; } else { echo '8'; } ?>)">Kantor atau kantor cabang Pialang Berjangka terdekat dengan domisili Nasabah tempat penyelesaian dalam hal terjadi perselisihan.
                                        <ul>
                                            <li>
                                                Kantor yang dipilih (salah satu)<br/>
                                                Daftar Kantor: 
                                                <ol type="a">
                                                    <li>
                                                        <input type="radio" class="form-check-input radio_css" name="step07_kantorpenyelesaian" value="BANDUNG" required >
                                                        BANDUNG
                                                    </li>
                                                    <li>
                                                        <input type="radio" class="form-check-input radio_css" name="step07_kantorpenyelesaian" value="PURWOKERTO" required >
                                                        PURWOKERTO
                                                    </li>
                                                </ol>
                                            </li>
                                        </ul>    
                                        <!-- <table width="50%" style="margin-left:0px;">
                                            <tr>
                                                <td width="2%" style="white-space: nowrap;" colspan="2">Kantor yang dipilih (salah satu)&nbsp;&nbsp;</td>
                                                <td>Daftar Kantor</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top"><input type="radio" class="form-check-input radio_css" name="step07_kantorpenyelesaian" value="BANDUNG" required ></td>
                                                <td width="2%" class="text-right" style="white-space: nowrap;vertical-align:top">&nbsp;&nbsp;a.&nbsp;&nbsp;</td>
                                                <td>Paskal Hyper Square Blok D no.45-46 Jalan H.O.S. Cokroaminoto no.25-27 Bandung</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top"><input type="radio" class="form-check-input radio_css" name="step07_kantorpenyelesaian" value="PURWOKERTO" required ></td>
                                                <td width="2%" class="text-right" style="white-space: nowrap;vertical-align:top">&nbsp;&nbsp;b.&nbsp;&nbsp;</td>
                                                <td>PURWOKERTO</td>
                                            </tr>
                                            
                                        </table> -->
                                    </li>
                                </ol>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_24" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li seq="<?php if($ACC_TYPE1 == 1){ echo '25'; } else { echo '24'; } ?>.">
                                <strong>Bahasa</strong>
                                <p style="padding-left:5px;">Perjanjian ini dibuat dalam Bahasa Indonesia.<br>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_25" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                        </ol>
                        <!-- <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_26" onclick="run1();" value="YA" required/> Saya telah membaca dan menyetujui dari semua isi perjanjian ini</label></div> -->
                    </div>
                </div>
                <p>
                    Demikian Perjanjian Pemberian Amanat ini dibuat oelh Para Pihak dalam keadaan sadar, sehat jasmani rohani dan tanpa unsur paksaan dari pihak manapun.
                </p>
                <p class="text-center">
                    "Saya telah membaca, mengerti dan setuju terhadap semua ketentuan yang<br>tercantum dalam perjanjian ini"
                </p>
                <p class="text-center">
                    Dengan mengisi kolom "YA" di bawah ini, saya menyatakan bahwa saya telah menerima<br>
                    "PERJANJIAN PEMBERIAN AMANAT TRANSAKSI KONTRAK <?php echo strtoupper($title) ?>"<br>
                    mengerti dan menyetujui isinya.
                </p>
                <div class="row mt-3 mb-3">
                    <div class="col-6">
                        Pernyataan menerima / tidak<br>
                        <input type="radio" class="form-check-input radio_css" name="aggree" value="Yes" style="margin-top: 10px;" required>
                        <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                        <input type="radio" class="form-check-input radio_css" name="aggree" value="No" style="margin-top: 10px;" required>
                        <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak</label>
                    </div>
                    <div class="col-6">
                        <label>Menerima pada Tanggal</label>
                        <input type="text" readonly required value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <input type="hidden" name="check" value="1">
        <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_08">Next</button>
    </div>
</form>
<script>
    function run(){
        if(document.getElementById("cb_01").checked == true){ 
            document.getElementById("cb_02").disabled = false; 
            document.getElementById("cb_01").scrollIntoView({behavior: "smooth", inline: "end"}); 
        } else { 
            document.getElementById("cb_02").disabled = true; 
        }
        <?php if($ACC_TYPE1 == 1){?>
            if(document.getElementById("cb_02").checked == true){ 
                document.getElementById("cb_03").disabled = false; 
                document.getElementById("cb_02").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_03").disabled = true; 
            }
        
        <?php }else{?>
            if(document.getElementById("cb_02").checked == true){ 
                document.getElementById("cb_04").disabled = false; 
                document.getElementById("cb_02").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_03").disabled = true; 
            }
        <?php };?>
        <?php if($ACC_TYPE1 == 1){?>
            if(document.getElementById("cb_03").checked == true){ 
                document.getElementById("cb_04").disabled = false; 
                document.getElementById("cb_03").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_04").disabled = true; 
            }
        <?php }?>
        
        if(document.getElementById("cb_04").checked == true){ 
            document.getElementById("cb_05").disabled = false; 
            document.getElementById("cb_04").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_05").disabled = true; 
        }
        if(document.getElementById("cb_05").checked == true){ 
            document.getElementById("cb_06").disabled = false; 
            document.getElementById("cb_05").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_06").disabled = true; 
        }
        <?php if($ACC_TYPE1 == 1){?>
            if(document.getElementById("cb_05").checked == true){ 
                document.getElementById("cb_06_01").disabled = false; 
                document.getElementById("cb_05").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_06_01").disabled = true; 
            }
        <?php }else{?>
            if(document.getElementById("cb_05").checked == true){ 
                document.getElementById("cb_06").disabled = false; 
                document.getElementById("cb_05").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_06").disabled = true; 
            }
        <?php }?>
        <?php if($ACC_TYPE1 == 1){?>
            if(document.getElementById("cb_06_01").checked == true){ 
                document.getElementById("cb_06").disabled = false; 
                document.getElementById("cb_06_01").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_06").disabled = true; 
            }
        <?php }?>
        if(document.getElementById("cb_06").checked == true){ 
            document.getElementById("cb_07").disabled = false; 
            document.getElementById("cb_06").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_07").disabled = true; 
        }
        if(document.getElementById("cb_07").checked == true){ 
            document.getElementById("cb_08").disabled = false; 
            document.getElementById("cb_07").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_08").disabled = true; 
        }
        if(document.getElementById("cb_08").checked == true){ 
            document.getElementById("cb_09").disabled = false; 
            document.getElementById("cb_08").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_09").disabled = true; 
        }
        if(document.getElementById("cb_09").checked == true){ 
            document.getElementById("cb_10").disabled = false; 
            document.getElementById("cb_09").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_10").disabled = true; 
        }
        if(document.getElementById("cb_10").checked == true){ 
            document.getElementById("cb_11").disabled = false; 
            document.getElementById("cb_10").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_11").disabled = true; 
        }
        if(document.getElementById("cb_11").checked == true){ 
            document.getElementById("cb_12").disabled = false; 
            document.getElementById("cb_11").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_12").disabled = true; 
        }
        if(document.getElementById("cb_12").checked == true){ 
            document.getElementById("cb_13").disabled = false; 
            document.getElementById("cb_12").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_13").disabled = true; 
        }
        if(document.getElementById("cb_13").checked == true){ 
            document.getElementById("cb_14").disabled = false; 
            document.getElementById("cb_13").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_14").disabled = true; 
        }
        if(document.getElementById("cb_14").checked == true){ 
            document.getElementById("cb_15").disabled = false; 
            document.getElementById("cb_14").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_15").disabled = true; 
        }
        if(document.getElementById("cb_15").checked == true){ 
            document.getElementById("cb_16").disabled = false; 
            document.getElementById("cb_15").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_16").disabled = true; 
        }
        if(document.getElementById("cb_16").checked == true){ 
            document.getElementById("cb_17").disabled = false; 
            document.getElementById("cb_16").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_17").disabled = true; 
        }
        if(document.getElementById("cb_17").checked == true){ 
            document.getElementById("cb_18").disabled = false; 
            document.getElementById("cb_17").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_18").disabled = true; 
        }
        if(document.getElementById("cb_18").checked == true){ 
            document.getElementById("cb_19").disabled = false; 
            document.getElementById("cb_18").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_19").disabled = true; 
        }
        if(document.getElementById("cb_19").checked == true){ 
            document.getElementById("cb_20").disabled = false; 
            document.getElementById("cb_19").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_20").disabled = true; 
        }
        if(document.getElementById("cb_20").checked == true){ 
            document.getElementById("cb_21").disabled = false; 
            document.getElementById("cb_20").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_21").disabled = true; 
        }
        if(document.getElementById("cb_21").checked == true){ 
            document.getElementById("cb_22").disabled = false; 
            document.getElementById("cb_21").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_22").disabled = true; 
        }
        <?php if($ACC_TYPE1 == 2){ ?>
            if(document.getElementById("cb_22").checked == true){ 
                document.getElementById("cb_23").disabled = false; 
                document.getElementById("cb_22").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_23").disabled = true; 
            }
        <?php }else{ ?>
            if(document.getElementById("cb_22").checked == true){ 
                document.getElementById("cb_24").disabled = false; 
                document.getElementById("cb_22").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_24").disabled = true; 
            }
        <?php };?>
        <?php if($ACC_TYPE1 == 2){ ?>
            if(document.getElementById("cb_23").checked == true){ 
                document.getElementById("cb_24").disabled = false; 
                document.getElementById("cb_23").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_24").disabled = true; 
            }
        <?php } ?>
        if(document.getElementById("cb_24").checked == true){ 
            document.getElementById("cb_25").disabled = false; 
            document.getElementById("cb_24").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_25").disabled = true; 
        }
        
        
    }
    function run1(){
        if(document.getElementById("cb_26").checked == true){ 
            document.getElementById("cb_01").checked = true
            document.getElementById("cb_02").checked = true
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_03").checked = true
            <?php }?>
            document.getElementById("cb_04").checked = true
            document.getElementById("cb_05").checked = true
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_06_01").checked = true
            <?php }?>
            document.getElementById("cb_06").checked = true
            document.getElementById("cb_07").checked = true
            document.getElementById("cb_08").checked = true
            document.getElementById("cb_09").checked = true
            document.getElementById("cb_10").checked = true
            document.getElementById("cb_11").checked = true
            document.getElementById("cb_12").checked = true
            document.getElementById("cb_13").checked = true
            document.getElementById("cb_14").checked = true
            document.getElementById("cb_15").checked = true
            document.getElementById("cb_16").checked = true
            document.getElementById("cb_17").checked = true
            document.getElementById("cb_18").checked = true
            document.getElementById("cb_19").checked = true
            document.getElementById("cb_20").checked = true
            document.getElementById("cb_21").checked = true
            document.getElementById("cb_22").checked = true
            document.getElementById("cb_23").checked = true
            document.getElementById("cb_24").checked = true
            document.getElementById("cb_25").checked = true
            
            document.getElementById("cb_02").disabled = true;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_03").disabled = true;
            <?php }?>
            document.getElementById("cb_04").disabled = true;
            document.getElementById("cb_05").disabled = true;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_06_01").disabled = true;
            <?php }?>
            document.getElementById("cb_06").disabled = true;
            document.getElementById("cb_07").disabled = true;
            document.getElementById("cb_08").disabled = true;
            document.getElementById("cb_09").disabled = true;
            document.getElementById("cb_10").disabled = true;
            document.getElementById("cb_11").disabled = true;
            document.getElementById("cb_12").disabled = true;
            document.getElementById("cb_13").disabled = true;
            document.getElementById("cb_14").disabled = true;
            document.getElementById("cb_15").disabled = true;
            document.getElementById("cb_16").disabled = true;
            document.getElementById("cb_17").disabled = true;
            document.getElementById("cb_18").disabled = true;
            document.getElementById("cb_19").disabled = true;
            document.getElementById("cb_20").disabled = true;
            document.getElementById("cb_21").disabled = true;
            document.getElementById("cb_22").disabled = true;
            document.getElementById("cb_23").disabled = true;
            document.getElementById("cb_24").disabled = true;
            document.getElementById("cb_25").disabled = true;
        } else {
            
            document.getElementById("cb_01").checked = false;
            document.getElementById("cb_02").checked = false;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_03").checked = false;
            <?php }?>
            document.getElementById("cb_04").checked = false;
            document.getElementById("cb_05").checked = false;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_06_01").checked = false;
            <?php }?>
            document.getElementById("cb_06").checked = false;
            document.getElementById("cb_07").checked = false;
            document.getElementById("cb_08").checked = false;
            document.getElementById("cb_09").checked = false;
            document.getElementById("cb_10").checked = false;
            document.getElementById("cb_11").checked = false;
            document.getElementById("cb_12").checked = false;
            document.getElementById("cb_13").checked = false;
            document.getElementById("cb_14").checked = false;
            document.getElementById("cb_15").checked = false;
            document.getElementById("cb_16").checked = false;
            document.getElementById("cb_17").checked = false;
            document.getElementById("cb_18").checked = false;
            document.getElementById("cb_19").checked = false;
            document.getElementById("cb_20").checked = false;
            document.getElementById("cb_21").checked = false;
            document.getElementById("cb_22").checked = false;
            document.getElementById("cb_23").checked = false;
            document.getElementById("cb_24").checked = false;
            document.getElementById("cb_25").checked = false;

            document.getElementById("cb_02").disabled = false;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_03").disabled = false;
            <?php }?>
            document.getElementById("cb_04").disabled = false;
            document.getElementById("cb_05").disabled = false;
            document.getElementById("cb_06").disabled = false;
            document.getElementById("cb_07").disabled = false;
            document.getElementById("cb_08").disabled = false;
            document.getElementById("cb_09").disabled = false;
            document.getElementById("cb_10").disabled = false;
            document.getElementById("cb_11").disabled = false;
            document.getElementById("cb_12").disabled = false;
            document.getElementById("cb_13").disabled = false;
            document.getElementById("cb_14").disabled = false;
            document.getElementById("cb_15").disabled = false;
            document.getElementById("cb_16").disabled = false;
            document.getElementById("cb_17").disabled = false;
            document.getElementById("cb_18").disabled = false;
            document.getElementById("cb_19").disabled = false;
            document.getElementById("cb_20").disabled = false;
            document.getElementById("cb_21").disabled = false;
            document.getElementById("cb_22").disabled = false;
            document.getElementById("cb_23").disabled = false;
            document.getElementById("cb_24").disabled = false;
            document.getElementById("cb_25").disabled = false;
        }
    }
</script>
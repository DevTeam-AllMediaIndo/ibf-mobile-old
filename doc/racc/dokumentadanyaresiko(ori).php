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
        $title = 'derivatif dalam sistem perdagangan alternatif';
        $typecont = 'Formulir Nomor 107.PBK.04.2 ';
    } else if($RESULT_QUERYACC['ACC_TYPE'] == 2){
        $title = 'berjangka ';
        $typecont = 'Formulir Nomor 107.PBK.04.1 ';
    }
    
    if(isset($_POST['check'])){
        if(isset($_POST['aggree'])){
            if(isset($_GET['id'])){
                $aggree = $_POST['aggree'];
                if($aggree == 'Yes'){
                    mysqli_query($db, '
                        UPDATE tb_racc SET
                        tb_racc.ACC_F_RESK = 1,
                        tb_racc.ACC_F_RESK_PERYT = "'.$aggree.'",
                        tb_racc.ACC_F_RESK_IP = "'.$IP_ADDRESS.'",
                        tb_racc.ACC_F_RESK_DATE = "'.date('Y-m-d H:i:s').'"
                        WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                    ') or die (mysqli_error($db));
                    die ("<script>location.href = 'home.php?page=racc/perjanjianamanat&id=".$id_live."'</script>");
                }else{ die("<script>location.href = 'home.php?page=racc/dokumentadanyaresiko&id=".$id_live."'</script>");};
            } else { die ("<script>alert('please try again');location.href = 'home.php?page=racc/dokumentadanyaresiko&id=".$id_live."'</>"); };
        } else { die ("<script>alert('please try again');location.href = 'home.php?page=racc/dokumentadanyaresiko&id=".$id_live."'</script>"); };
    };
?>
<div class="page-title page-title-small">
    <h2>Formulir</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<?php
    if($RESULT_QUERYACC['ACC_TYPE'] == 1){
        $ACC_TYPE1 = 2;
    } else if($RESULT_QUERYACC['ACC_TYPE'] == 2){
        $ACC_TYPE1 = 1;
    }
?>
<form method="post">
    <div class="card card-style">
        <div class="card-body">
            <div class="form-group boxed">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-left">
                            <strong><small><b><?php echo $typecont ?></b></small></strong>
                        </div>
                        <div class="col-6 text-right">
                            <small>
                                Lampiran Peraturan Kepala Badan Pengawas<br>
                                Perdagangan Berjangka Komoditi<br>
                                Nomor : 107/BAPPEBTI/PER/11/2013
                            </small>
                        </div>
                    </div>
                    <h6 class="text-left">Formulir Dokumen Resiko untuk Transaksi <?php echo ucwords($title); ?></h6>
                    <hr>
                    <div class="text-center">DOKUMEN PEMBERITAHUAN ADANYA RISIKO<br>YANG HARUS DISAMPAIKAN OLEH PIALANG BERJANGKA<br>
                    UNTUK TRANSAKSI KONTRAK <?php echo strtoupper($title); ?></div>
                    <div class="mt-3">
                        <p class="text-justify">Dokumen Pemberitahuan Adanya Risiko ini disampaikan kepada Anda sesuai
                        dengan Pasal 50 ayat (2) Undang-Undang Nomor 32 Tahun 1997 tentang
                        Perdagangan Berjangka Komoditi sebagaimana telah diubah dengan Undang-Undang
                        Nomor 10 Tahun 2011 tentang Perubahan Atas Undang-Undang Nomor 32 Tahun 1997
                        Tentang Perdagangan Berjangka Komoditi.</p>

                        <p class="text-justify">Maksud dokumen ini adalah memberitahukan bahwa kemungkinan kerugian atau
                        keuntungan dalam perdagangan Kontrak <?php echo ucwords($title); ?> bisa mencapai jumlah yang sangat
                        besar. Oleh karena itu, Anda harus berhati-hati dalam memutuskan untuk melakukan
                        transaksi, apakah kondisi keuangan Anda mencukupi.</p>
                        <ol>
                            <li class="text-justify">
                                <span><u>Perdagangan Kontrak <?php echo ucwords($title); ?> belum tentu layak bagi semua investor.</u></span><br>
                                <p>Anda dapat menderita kerugian dalam jumlah besar dan dalam jangka waktu
                                singkat. Jumlah kerugian uang dimungkinkan dapat melebihi jumlah uang yang
                                pertama kali Anda setor (Margin awal) ke Pialang Berjangka Anda.</p>
                                <p>Anda mungkin menderita kerugian seluruh Margin dan Margin tambahan yang
                                ditempatkan pada Pialang Berjangka untuk mempertahankan posisi Kontrak
                                <?php echo ucwords($title); ?> Anda.</p>
                                <p>Hal ini disebabkan Perdagangan Berjangka sangat dipengaruhi oleh mekanisme
                                leverage, dimana dengan jumlah investasi dalam bentuk yang relatif kecil dapat
                                digunakan untuk membuka posisi dengan aset yang bernilai jauh lebih tinggi.
                                Apabila Anda tidak siap dengan risiko seperti ini, sebaiknya Anda tidak melakukan
                                perdagangan Kontrak <?php echo ucwords($title); ?>.</p>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_01" onclick="run();" value="YA" required/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify">
                                <strong>Perdagangan Kontrak <?php echo ucwords($title); ?> mempunyai risiko dan mempunyai
                                kemungkinan kerugian yang tidak terbatas yang jauh lebih besar dari jumlah
                                uang yang disetor (Margin) ke Pialang Berjangka.</strong> Kontrak <?php echo ucwords($title); ?> sama
                                dengan produk keuangan lainnya yang mempunyai risiko tinggi, Anda sebaiknya
                                tidak menaruh risiko terhadap dana yang Anda tidak siap untuk menderita rugi,
                                seperti tabungan pensiun, dana kesehatan atau dana untuk keadaan darurat,
                                dana yang disediakan untuk pendidikan atau kepemilikan rumah, dana yang
                                diperoleh dari pinjaman pendidikan atau gadai, atau dana yang digunakan untuk
                                memenuhi kebutuhan sehari-hari.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_02" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Berhati-hatilah terhadap pernyataan bahwa Anda pasti mendapatkan
                                keuntungan besar dari perdagangan Kontrak <?php echo ucwords($title); ?>.</strong> Meskipun perdagangan
                                Kontrak <?php echo ucwords($title); ?> dapat memberikan keuntungan yang besar dan cepat, namun
                                hal tersebut tidak pasti, bahkan dapat menimbulkan kerugian yang besar dan
                                cepat juga. Seperti produk keuangan lainnya, tidak ada yang dinamakan "pasti
                                untung".
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_03" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Disebabkan adanya mekanisme leverage dan sifat dari transaksi Kontrak
                                <?php echo ucwords($title); ?>, Anda dapat merasakan dampak bahwa Anda menderita kerugian
                                dalam waktu cepat.</strong> Keuntungan maupun kerugian dalam transaksi Kontrak
                                <?php echo ucwords($title); ?> akan langsung dikredit atau didebet ke rekening Anda, paling lambat
                                secara harian. Apabila pergerakan di pasar terhadap Kontrak <?php echo ucwords($title); ?>
                                menurunkan nilai posisi Anda dalam Kontrak <?php echo ucwords($title); ?>, dengan kata lain berlawanan dengan posisi yang Anda ambil,
                                Anda diwajibkan untuk menambah dana untuk pemenuhan kewajiban Margin ke Pialang Berjangka.
                                Apabila rekening Anda berada dibawah minimum Margin yang telah ditetapkan
                                Lembaga Kliring Berjangka atau Pialang Berjangka, maka posisi Anda dapat
                                dilikuidasi pada saat rugi, dan Anda wajib menyelesaikan defisit (jika ada) dalam
                                rekening Anda.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_04" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Pada saat pasar dalam keadaan tertentu, Anda mungkin akan sulit atau tidak
                                mungkin melikuidasi posisi.</strong> Pada umumnya Anda harus melakukan transaksi mengambil posisi yang berlawanan dengan maksud melikuidasi posisi (offset) jika ingin melikuidasi posisi dalam Kontrak
                                <?php echo ucwords($title); ?>. Apabila Anda tidak
                                dapat melikuidasi posisi Kontrak <?php echo ucwords($title); ?>, Anda tidak dapat merealisasikan
                                keuntungan pada nilai posisi tersebut atau mencegah kerugian yang lebih tinggi.
                                Kemungkinan tidak dapat melikuidasi dapat terjadi, antara lain: jika perdagangan
                                berhenti dikarenakan aktivitas perdagangan yang tidak lazim pada Kontrak
                                <?php echo ucwords($title); ?> atau subjek Kontrak <?php echo ucwords($title); ?>, terjadi kerusakan sistem pada Pialang Berjangka Peserta Sistem Perdagangan Alternatif Berjangka Penyelenggara Sistem Perdagangan Alternatif. Bahkan apabila Anda dapat melikuidasi posisi tersebut, Anda
                                mungkin terpaksa melakukannya pada harga yang menimbulkan kerugian besar.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_05" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Pada saat pasar dalam keadaan tertentu, Anda mungkin akan sulit atau tidak
                                mungkin mengelola risiko atas posisi terbuka Kontrak <?php echo ucwords($title); ?> dengan cara
                                membuka posisi dengan nilai yang sama namun dengan posisi yang
                                berlawanan dalam kontrak bulan yang berbeda, dalam pasar yang berbeda atau
                                dalam “subjek Kontrak <?php echo ucwords($title); ?>” yang berbeda.</strong> Kemungkinan untuk tidak
                                dapat mengambil posisi dalam rangka membatasi risiko yang timbul, contohnya:
                                jika perdagangan dihentikan pada pasar yang berbeda disebabkan aktivitas
                                perdagangan yang tidak lazim pada Kontrak <?php echo ucwords($title); ?> atau “subjek Kontrak
                                <?php echo ucwords($title); ?>”.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_06" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <?php if($ACC_TYPE1 == 1){ ?>
                            <li class="text-justify mt-2">
                                <strong>Anda dapat diwajibkan untuk menyelesaikan Kontrak <?php echo ucwords($title); ?> dengan
                                penyerahan fisik dari “subjek Kontrak <?php echo ucwords($title); ?>”.</strong> Jika Anda mempertahankan
                                posisi penyelesaian fisik dalam Kontrak <?php echo ucwords($title); ?> sampai hari terakhir
                                perdagangan berdasarkan tanggal jatuh tempo Kontrak <?php echo ucwords($title); ?>, Anda akan
                                diwajibkan menyerahkan atau menerima penyerahan “subjek Kontrak <?php echo ucwords($title); ?>
                                yang dapat mengakibatkan adanya penambahan biaya. Pengertian penyelesaian
                                dapat berbeda untuk suatu Kontrak <?php echo ucwords($title); ?> dengan Kontrak <?php echo ucwords($title); ?> lainnya
                                atau suatu Bursa Berjangka dengan Bursa Berjangka lainnya. Anda harus melihat
                                secara teliti mengenai penyelesaian dan kondisi penyerahan sebelum membeli atau
                                menjual Kontrak <?php echo ucwords($title); ?>.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_07" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <?php } ?>
                            <li class="text-justify mt-2">
                                <strong>Anda dapat menderita kerugian yang disebabkan kegagalan sistem informasi.</strong> 
                                Sebagaimana yang terjadi pada setiap transaksi keuangan, Anda dapat menderita
                                kerugian jika amanat untuk melaksanakan transaksi Kontrak <?php echo ucwords($title); ?> tidak
                                dapat dilakukan karena kegagalan sistem informasi di Bursa Berjangka,
                                Pedagang Berjangka 
                                Penyelenggara Sistem Perdagangan Alternatif,maupun sistem di Pialang Berjangka 
                                Peserta Sistem Perdagangan Alternatif yang mengelola posisi Anda. Kerugian Anda akan semakin besar jika Pialang Berjangka yang
                                mengelola posisi Anda tidak memiliki sistem informasi cadangan atau prosedur
                                yang layak.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_08" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Semua Kontrak <?php echo ucwords($title); ?> mempunyai risiko, dan tidak ada strategi
                                berdagang yang dapat menjamin untuk menghilangkan risiko tersebut.</strong> Strategi
                                dengan menggunakan kombinasi posisi seperti spread, dapat sama berisiko seperti
                                posisi long atau short. Melakukan Perdagangan Berjangka memerlukan
                                pengetahuan mengenai Kontrak <?php echo ucwords($title); ?> dan pasar berjangka.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_09" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Strategi perdagangan harian dalam Kontrak <?php echo ucwords($title); ?> dan produk lainnya
                                memiliki risiko khusus.</strong> Seperti pada produk keuangan lainnya, pihak yang ingin
                                membeli atau menjual Kontrak <?php echo ucwords($title); ?> yang sama dalam satu hari untuk
                                mendapat keuntungan dari perubahan harga pada hari tersebut (“day traders”)
                                akan memiliki beberapa risiko tertentu antara lain jumlah komisi yang besar,
                                risiko terkena efek pengungkit (“exposure to leverage”), dan persaingan dengan
                                pedagang profesional. Anda harus mengerti risiko tersebut dan memiliki
                                pengalaman yang memadai sebelum melakukan perdagangan harian (“day
                                trading”).
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_10" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Menetapkan amanat bersyarat, seperti Kontrak <?php echo ucwords($title); ?> dilikuidasi pada
                                keadaan tertentu untuk membatasi rugi (stop loss), mungkin tidak akan dapat
                                membatasi kerugian Anda sampai jumlah tertentu saja.</strong> Amanat bersyarat
                                tersebut mungkin tidak dapat dilaksanakan karena terjadi kondisi pasar yang
                                tidak memungkinkan melikuidasi Kontrak <?php echo ucwords($title); ?>.
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_11" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Anda harus membaca dengan seksama dan memahami Perjanjian Pemberian
                                Amanat dengan Pialang Berjangka Anda sebelum melakukan transaksi
                                Kontrak <?php echo ucwords($title); ?>.</strong>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_12" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Pernyataan singkat ini tidak dapat memuat secara rinci seluruh risiko atau
                                aspek penting lainnya tentang Perdagangan Berjangka. Oleh karena itu Anda
                                harus mempelajari kegiatan Perdagangan Berjangka secara cermat sebelum
                                memutuskan melakukan transaksi.</strong>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_13" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                            <li class="text-justify mt-2">
                                <strong>Dokumen Pemberitahuan Adanya Risiko (Risk Disclosure) ini dibuat dalam
                                Bahasa Indonesia.</strong>
                                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_14" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                            </li>
                        </ol>
                        <!-- <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_15" onclick="run1();" value="YA" required/> Saya telah membaca dan menyetujui dari semua isi perjanjian ini</label></div> -->
                    </div>
                    <!--
                    <div class="form-group">
                        <span>Perusahaan Pialang Berjangka</span>
                        <input type="text" class="form-control"  placeholder="Perusahaan pialang berjangka" placeholder="off" name="s5_pilbe" autocomplete="off">
                    </div>
                    -->
                </div>
                <p class="mt-3 text-center">PERNYATAAN MENERIMA PEMBERITAHUAN ADANYA RESIKO</p>
                <p class="text-center">Dengan mengisi kolom "YA" di bawah ini, saya menyatakan bahwa saya telah menerima</p>
                <p class="text-center">"DOKUMEN PEMBERITAHUAN ADANYA RESIKO"<br>mengerti dan menyetujui isinya.</p>
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
        </div>
    </div>
    <div class="card card-style">
        <input type="hidden" name="check" value="1">
        <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_20">Next</button>
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
        if(document.getElementById("cb_02").checked == true){ 
            document.getElementById("cb_03").disabled = false; 
            document.getElementById("cb_02").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_03").disabled = true; 
        }
        if(document.getElementById("cb_03").checked == true){ 
            document.getElementById("cb_04").disabled = false; 
            document.getElementById("cb_03").scrollIntoView({behavior: "smooth"}); 
        } else { 
            document.getElementById("cb_04").disabled = true; 
        }
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
            if(document.getElementById("cb_06").checked == true){ 
                document.getElementById("cb_07").disabled = false; 
                document.getElementById("cb_06").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_07").disabled = true; 
            }
        <?php }else{?>
            if(document.getElementById("cb_06").checked == true){ 
                document.getElementById("cb_08").disabled = false; 
                document.getElementById("cb_06").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_08").disabled = true; 
            }
        <?php }?>
        <?php if($ACC_TYPE1 == 1){?>
            if(document.getElementById("cb_07").checked == true){ 
                document.getElementById("cb_08").disabled = false; 
                document.getElementById("cb_07").scrollIntoView({behavior: "smooth"}); 
            } else { 
                document.getElementById("cb_08").disabled = true; 
            }
        <?php };?>
        
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

        
    }

    function run1(){
        if(document.getElementById("cb_15").checked == true){ 
            document.getElementById("cb_01").checked = true
            document.getElementById("cb_02").checked = true
            document.getElementById("cb_03").checked = true
            document.getElementById("cb_04").checked = true
            document.getElementById("cb_05").checked = true
            document.getElementById("cb_06").checked = true
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_07").checked = true
            <?php }?>
            document.getElementById("cb_08").checked = true
            document.getElementById("cb_09").checked = true
            document.getElementById("cb_10").checked = true
            document.getElementById("cb_11").checked = true
            document.getElementById("cb_12").checked = true
            document.getElementById("cb_13").checked = true
            document.getElementById("cb_14").checked = true
            
            document.getElementById("cb_02").disabled = true;
            document.getElementById("cb_03").disabled = true;
            document.getElementById("cb_04").disabled = true;
            document.getElementById("cb_05").disabled = true;
            document.getElementById("cb_06").disabled = true;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_07").disabled = true;
            <?php }?>
            document.getElementById("cb_08").disabled = true;
            document.getElementById("cb_09").disabled = true;
            document.getElementById("cb_10").disabled = true;
            document.getElementById("cb_11").disabled = true;
            document.getElementById("cb_12").disabled = true;
            document.getElementById("cb_13").disabled = true;
            document.getElementById("cb_14").disabled = true;
        } else {
            
            document.getElementById("cb_01").checked = false;
            document.getElementById("cb_02").checked = false;
            document.getElementById("cb_03").checked = false;
            document.getElementById("cb_04").checked = false;
            document.getElementById("cb_05").checked = false;
            document.getElementById("cb_06").checked = false;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_07").checked = false;
            <?php }?>
            document.getElementById("cb_08").checked = false;
            document.getElementById("cb_09").checked = false;
            document.getElementById("cb_10").checked = false;
            document.getElementById("cb_11").checked = false;
            document.getElementById("cb_12").checked = false;
            document.getElementById("cb_13").checked = false;
            document.getElementById("cb_14").checked = false;

            document.getElementById("cb_02").disabled = false;
            document.getElementById("cb_03").disabled = false;
            document.getElementById("cb_04").disabled = false;
            document.getElementById("cb_05").disabled = false;
            document.getElementById("cb_06").disabled = false;
            <?php if($ACC_TYPE1 == 1){?>
            document.getElementById("cb_07").disabled = false;
            <?php }?>
            document.getElementById("cb_08").disabled = false;
            document.getElementById("cb_09").disabled = false;
            document.getElementById("cb_10").disabled = false;
            document.getElementById("cb_11").disabled = false;
            document.getElementById("cb_12").disabled = false;
            document.getElementById("cb_13").disabled = false;
            document.getElementById("cb_14").disabled = false;
        }
        
    }
</script>
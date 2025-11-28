
<?php

$id_live = $_GET['id'];
if(isset($_POST['submit_29'])){
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
                die ("<script>location.href = 'home.php?page=racc/dokumentadanyaresiko&id=".$id_live."'</script>");
            }else{die("<script>location.href = 'home.php?page=racc/adanyaresiko&id=".$id_live."'</script>");};

        } else { 
            logerr("Parameter Ke-2 Tidak Lengkap", "Adanya Resiko (REGOL)", $user1["MBR_ID"]);
            die ("<script>alert('please try again');location.href = 'home.php?page=racc/adanyaresiko&id=".$id_live."'</script>"); 
        };
    } else { 
        logerr("Parameter Ke-3 Tidak Lengkap", "Adanya Resiko (REGOL)", $user1["MBR_ID"]);
        die ("<script>alert('please try again');location.href = 'home.php?page=racc/adanyaresiko&id=".$id_live."'</script>"); 
    };
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

<form method="post">
    <div class="card card-style">
        <div class="card-body">
            <div class="row">
                <!-- <div class="col-6 text-left">
                    <strong><small><b>Formulir Nomor 107.PBK.04</b></small></strong>
                </div>
                <div class="col-6 text-right">
                    <small>
                        Lampiran Peraturan Kepala Badan Pengawas<br>
                        Perdagangan Berjangka Komoditi<br>
                        Nomor : 107/BAPPEBTI/PER/11/2013
                    </small>
                </div> -->
                <?php include 'header_form.php'; ?>
            </div>
            <div class="text-center"><strong style="font-size: larger;">Formulir Pemberitahuan Adanya Risiko dalam Sistem Aplikasi Penerimaan Nasabah Secara Elektronik Online</strong></div>
            <hr>
            <strong></strong>
            <br>
            Ketentuan penyajian dokumen Pemberitahuan Adanya Risiko dalam Sistem Aplikasi Penerimaan Nasabah Secara Elektronik Online:
            <ol>
                <li>
                    Pialang Berjangka wajib menyajikan dalam Sistem Penerimaan Nasabah secara elektronik Online Dokumen Pemberitahuan Adanya Risiko;
                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_01" onclick="run();" value="YA" required/> Saya sudah membaca dan memahami</label></div> 
                </li>
                <li>
                    Dalam menyajikan informasi Dokumen Pemberitahuan Adanya Risiko untuk transaksi Kontrak Berjangka, Pialang Berjangka wajib berpedoman pada formulir dokumen risiko untuk transaksi Kontrak. Berjangka; 
                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_02" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                </li>
                <li>
                    Dalam menyajikan informasi Dokumen Pemberitahuan Adanya Risiko untuk transaksi Kontrak Derivatif dalam Sistem Perdagangan Alternatif, Pialang Berjangka wajib berpedoman pada formulir dokumen risiko untuk transaksi Kontrak Derivatif dalam Sistem Perdagangan Alternatif;
                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_03" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                </li>
                <li>
                    Setiap paragraf, nomor, dan/atau huruf dalam ketentuan Dokumen Pemberitahuan Adanya Risiko ini wajib diberi tanda (tick mark) dan kata. "saya sudah membaca dan memahami", yang membuktikan bahwa Nasabah telah membaca dan memahami setiap paragraf. Apabila Nasabah tidak memberikan tanda (tick mark), maka Sistem Aplikasi tidak dapat melanjutkan ke proses selanjutnya;
                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_04" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                </li>
                <li>
                    Sistem Aplikasi Penerimaan Nasabah Secara Elektronik Online menolak melanjutkan ke proses selanjutnya apabila terdapat kolom tanda (tick mark) yang diwajibkan tidak diisi;
                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_05" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                </li>
                <li>
                    Pada akhir Dokumen Pemberitahuan Adanya Risiko, wajib terdapat kalimat "Dengan mengisi kolom "YA" di bawah, saya menyatakan bahwa saya telah menerima "DOKUMEN PEMBERITAHUAN ADANYA RISIKO" mengerti dan menyetujui isinya". Hal ini membuktikan bahwa Nasabah telah membaca dan menerima seluruh resiko yang ada dalam transaksi Perdagangan Berjangka.
                    <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_06" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                </li>
            </ol>
            <!-- <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_11" onclick="run1();" value="YA" required/> Saya telah membaca dan menyetujui dari semua isi perjanjian ini</label></div> -->
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
    <div class="card card-style">
        <input type="hidden" name="check" value="1">
        <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_29">Next</button>
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
    }
    function run1(){
        if(document.getElementById("cb_11").checked == true){ 
            document.getElementById("cb_01").checked = true
            document.getElementById("cb_02").checked = true
            document.getElementById("cb_03").checked = true
            document.getElementById("cb_04").checked = true
            document.getElementById("cb_05").checked = true
            document.getElementById("cb_06").checked = true
            document.getElementById("cb_07").checked = true
            document.getElementById("cb_08").checked = true
            document.getElementById("cb_09").checked = true
            document.getElementById("cb_10").checked = true
            
            document.getElementById("cb_02").disabled = true;
            document.getElementById("cb_03").disabled = true;
            document.getElementById("cb_04").disabled = true;
            document.getElementById("cb_05").disabled = true;
            document.getElementById("cb_06").disabled = true;
            document.getElementById("cb_07").disabled = true;
            document.getElementById("cb_08").disabled = true;
            document.getElementById("cb_09").disabled = true;
            document.getElementById("cb_10").disabled = true;
        } else {
            
            document.getElementById("cb_01").checked = false;
            document.getElementById("cb_02").checked = false;
            document.getElementById("cb_03").checked = false;
            document.getElementById("cb_04").checked = false;
            document.getElementById("cb_05").checked = false;
            document.getElementById("cb_06").checked = false;
            document.getElementById("cb_07").checked = false;
            document.getElementById("cb_08").checked = false;
            document.getElementById("cb_09").checked = false;
            document.getElementById("cb_10").checked = false;

            document.getElementById("cb_02").disabled = false;
            document.getElementById("cb_03").disabled = false;
            document.getElementById("cb_04").disabled = false;
            document.getElementById("cb_05").disabled = false;
            document.getElementById("cb_06").disabled = false;
            document.getElementById("cb_07").disabled = false;
            document.getElementById("cb_08").disabled = false;
            document.getElementById("cb_09").disabled = false;
            document.getElementById("cb_10").disabled = false;
        }
    }
</script>
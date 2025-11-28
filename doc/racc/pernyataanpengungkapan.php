<?php

$id_live = $_GET['id'];
if(isset($_POST['submit_28'])){

    if(isset($_GET['id'])){
        if(isset($_POST['aggree'])){
            $aggree = ($_POST["aggree"]);
            if($aggree == 'Yes'){
                mysqli_query($db, '
                    UPDATE tb_racc SET
                    tb_racc.ACC_F_APPPEMBUKAAN = 1,
                    tb_racc.ACC_F_APPPEMBUKAAN_PERYT = "'.$aggree.'",
                    tb_racc.ACC_F_APPPEMBUKAAN_IP = "'.$IP_ADDRESS.'",
                    tb_racc.ACC_F_APPPEMBUKAAN_DATE = "'.date('Y-m-d H:i:s').'"
                    WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                ') or die (mysqli_error($db));
                die ("<script>location.href = 'home.php?page=racc/disclosure3&id=".$id_live."'</script>");
            }else{die("<script>location.href = 'home.php?page=racc/pernyataanpengungkapan&id=".$id_live."'</script>");};
        } else {
            die ("<script>location.href = 'home.php?page=racc/pernyataanpengungkapan&id=".$id_live."'</>"); 
        };
    } else {
            logerr("Parameter Ke-1 Tidak Lengkap", "Pernyataan Pengunkapan", $user1["MBR_ID"]);
        die ("<script>location.href = 'home.php?page=racc/pernyataanpengungkapan&id=".$id_live."'</script>"); 
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
            <h6>Formulir Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online</h6>
            <p>Ketentuan Penyajian Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online:</p>
            <ol>
                <li>Seluruh data isian dalam Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online Dalam Sistem Perdagangan Alternatif wajib di isi sendiri oleh Nasabah, dan Nasabah bertanggung jawab atas kebenaran informasi yang diberikan dalam mengisi dokumen ini;</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_01" onclick="run();" value="YA" required/> Saya sudah membaca dan memahami</label></div> 
                <li>Pialang Berjangka wajib berpedoman pada Lampiran Peraturan Badan ini dalam menyajikan Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online;</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_02" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Nasabah wajib untuk mengisi data atau informasi yang tertera sebagaimana terlampir dalam Formulir Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online;</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_03" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Sistem Aplikasi Penerimaan Nasabah Secara Elektronik Online menolak melanjutkan ke proses selanjutnya apabila terdapat kolom data atau informasi yang diwajibkan tidak diisi atau tidak diisi secara benar;</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_04" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Wakil Pialang Berjangka yang ditunjuk oleh Pialang Berjangka untuk melakukan verifikasi melakukan penilaian terhadap latar belakang calon Nasabah yang mencakup pengetahuan, pengalaman transaksi di bidang Perdagangan Berjangka dan kemampuan keuangan sehingga diperoleh keyakinan bahwa calon Nasabah yang akan diterima. merupakan calon Nasabah yang layak, dengan menggunakan data atau informasi yang telah diisi dan dilampirkan oleh Nasabah.</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_05" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Dalam hal diperlukan Wakil Pialang Berjangka sebagaimana dimaksud pada angka 5 dapat menghubungi secara langsung melalui media elektronik dan/atau telepon untuk mendapatkan konfirmasi, kepastian, dan/atau penambahan dokumen atau informasi lain untuk memastikan bahwa Nasabah adalah Nasabah yang layak;</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_06" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Bahwa untuk seluruh penyetoran dan penarikan margin hanya dapat dilakukan ke rekening bank yang tercantum dalam Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online ini;</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_07" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Nasabah wajib melampirkan dokumen pendukung yang telah dipindai (scan) sebagaimana tersebut dalam Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online ini;</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_08" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Data isian yang tercantum dalam formulir ini merupakan data isian. yang paling sedikit ada dalam aplikasi pembukaan rekening Nasabah secara elektronik online. Pialang Berjangka dapat menambahkan kolom isian data informasi lain sesuai dengan kebutuhan tanpa mengurangi data isian yang terdapat dalam formulir ini.</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_09" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
                <li>Pada akhir Aplikasi Pembukaan Rekening Transaksi Secara Elektronik Online ini, wajib terdapat kalimat "Dengan mengisi kolom "YA" di bawah ini, saya menyatakan bahwa semua informasi dan semua dokumen yang saya lampirkan dalam APLIKASI PEMBUKAAN REKENING TRANSAKSI SECARA ELEKTRONIK ONLINE ini adalah benar dan tepat, Saya akan bertanggung jawab penuh apabila dikemudian hari terjadi sesuatu hal sehubungan dengan ketidakbenaran data yang saya berikan".</li>
                <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_10" onclick="run();" value="YA" required disabled="true"/> Saya sudah membaca dan memahami</label></div> 
            </ol>
            <!-- <div class="text-left"><label style="cursor:pointer;"><input type="checkbox" class="form-check-input" style="border: 1.5px solid black !important;" id="cb_11" onclick="run1();" value="YA" required/> Saya telah membaca dan menyetujui dari semua isi perjanjian ini</label></div>  -->
            <div class="row mt-3 mb-3">
                <div class="col-12">
                    <label>Menerima pada Tanggal</label>
                    <input type="text" readonly required value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control text-center mb-3">
                </div>
                <div class="col-12">
                    Pernyataan menerima / tidak<br>
                    <input type="radio" class="form-check-input radio_css" name="aggree" value="Yes" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                    <input type="radio" class="form-check-input radio_css" name="aggree" value="No" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <input type="hidden" name="check" value="1">
        <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_28">Next</button>
    </div>
</form>
<script>
    function run(){
        if(document.getElementById("cb_01").checked == true){ 
            document.getElementById("cb_02").disabled = false; 
            document.getElementById("cb_01").scrollIntoView({behavior: "smooth"}); 
            console.log('cb1');
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
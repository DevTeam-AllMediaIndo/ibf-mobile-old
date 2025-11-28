<?php
    $id_live = $_GET['id'];
    $SQL_QUERYasd = mysqli_query($db, "
        SELECT tb_racc.*
        FROM tb_racc
        WHERE tb_racc.ACC_LOGIN = '0'
        AND tb_racc.ACC_MBR = ".$user1['MBR_ID']."
        AND tb_racc.ACC_DERE = 1
        AND MD5(MD5(tb_racc.ID_ACC)) = '".$id_live."'
        LIMIT 1
    ");
    if(mysqli_num_rows($SQL_QUERYasd) > 0) {
        $RESULT_QUERYasd = mysqli_fetch_assoc($SQL_QUERYasd);
    };
    
    if(isset($_POST['submit_22'])){
        if(isset($_POST['check'])){
            if(isset($_POST['aggree'])){
                $aggree = ($_POST["aggree"]);
                if($aggree == 'Yes'){
                    if(isset($_GET['id'])){
                        if(isset($_POST["aggreep"])){
                            $s5_pilbe = form_input($_POST["s5_pilbe"]);
                        
                            mysqli_query($db, '
                                UPDATE tb_racc SET
                                    tb_racc.ACC_F_PENGLAMAN = 1,
                                    tb_racc.ACC_F_PENGLAMAN_IP = "'.$IP_ADDRESS.'",
                                    tb_racc.ACC_F_PENGLAMAN_PERYT = "'.$aggree.'",
                                    tb_racc.ACC_F_PENGLAMAN_PERSH = "'.$s5_pilbe.'",
                                    tb_racc.ACC_F_PENGLAMAN_DATE = "'.date('Y-m-d H:i:s').'"
                                WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                            ') or die (mysqli_error($db));
                            die ("<script>location.href = 'home.php?page=racc/disclosure3&id=".$id_live."'</script>");
                        }else{
                            logerr("Parameter Ke-4 Tidak Lengkap", "Pengalaman Transaksi", $user1["MBR_ID"]);
                            die("<script>location.href = 'home.php?page=racc/pengalamantransaksi&id=".$id_live."'</script>");
                        };
                    } else { 
                        logerr("Parameter Ke-3 Tidak Lengkap", "Pengalaman Transaksi", $user1["MBR_ID"]);
                        die ("<script>location.href = 'home.php?page=racc/pengalamantransaksi&id=".$id_live."'</script>");
                    }
                }else{die("<script>location.href = 'home.php?page=racc/pengalamantransaksi&id=".$id_live."'</script>");};

            } else {
                logerr("Parameter Ke-2 Tidak Lengkap", "Pengalaman Transaksi", $user1["MBR_ID"]);
                die ("<script>location.href = 'home.php?page=racc/pengalamantransaksi&id=".$id_live."'</script>"); 
            }
        } else {
            logerr("Parameter Ke-1 Tidak Lengkap", "Pengalaman Transaksi", $user1["MBR_ID"]);
            die ("<script>location.href = 'home.php?page=racc/pengalamantransaksi&id=".$id_live."'</script>"); 
        }
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
    <h2>Pengalaman Transaksi</h2>
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
                    <strong><small><b>Formulir Nomor 107.PBK.02.2</b></small></strong>
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
            <h6 class="text-center">PERNYATAAN TELAH BERPENGALAMAN MELAKSANAKAN TRANSAKSI PERDAGANGAN BERJANGKA KOMODITI</h5>
            <hr>
            <table class="table1">
                <tr>
                    <td>Nama Lengkap</td>
                    <td> : </td>
                    <td><?php echo $user1['MBR_NAME'] ?></td>
                </tr>
                <tr>
                    <td>Tempat Lahir</td>
                    <td> : </td>
                    <td><?php echo $user1['MBR_TMPTLAHIR'] ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td> : </td>
                    <td><?php echo $user1['MBR_TGLLAHIR'] ?></td>
                </tr>
                <tr>
                    <td>Alamat Rumah</td>
                    <td> : </td>
                    <td><?php echo $user1['MBR_ADDRESS'] ?></td>
                </tr>
                <tr>
                    <td>Kode Pos</td>
                    <td> : </td>
                    <td><?php echo $user1['MBR_ZIP'] ?></td>
                </tr>
                <tr>
                    <td>Tipe Identitas</td>
                    <td> : </td>
                    <td><?php echo $user1['MBR_TYPE_IDT'] ?></td>
                </tr>
                <tr>
                    <td>No. Identitas</td>
                    <td> : </td>
                    <td><?php echo $user1['MBR_NO_IDT'] ?></td>
                </tr><tr>
                    <td>No. Demo Acc</td>
                    <td> : </td>
                    <td><?php echo $RESULT_QUERYasd['ACC_DEMO'] ?></td>
                </tr>
            </table>
            <div class="row">
                <div class="col">
                    <input type="radio" class="form-check-input radio_css" <?php if($RESULT_QUERYasd['ACC_F_PENGLAMAN_PERSH'] > "0"){echo 'checked';}?> name="aggreep" id="aggreeYes" value="Yes" onclick="run()" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col">
                    <input type="radio" class="form-check-input radio_css" 
                        <?php if($RESULT_QUERYasd['ACC_F_PENGLAMAN'] == 1 && $RESULT_QUERYasd['ACC_F_PENGLAMAN_PERSH'] == ""){echo 'checked';}?>
                        name="aggreep" id="aggreeNo" value="No" onclick="run()" style="margin-top: 10px;" required
                    >
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Mengerti</label>
                </div>
            </div>
            <div class="row">
                <input 
                    type="<?php if($RESULT_QUERYasd['ACC_F_PENGLAMAN'] == 1 && $RESULT_QUERYasd['ACC_F_PENGLAMAN_PERSH'] == ""){echo 'hidden';}else{echo 'text';}?>" 
                    class="form-control"  placeholder="Perusahaan pialang berjangka" placeholder="off" id="s5_pilbe" name="s5_pilbe" autocomplete="off"
                    value="<?php if($RESULT_QUERYasd['ACC_F_PENGLAMAN_PERSH'] > "0"){echo $RESULT_QUERYasd['ACC_F_PENGLAMAN_PERSH'];}?>"
                    <?php if($RESULT_QUERYasd['ACC_F_PENGLAMAN_PERSH'] > "0"){echo 'required';}?>
                > 
            </div>
            <p class="mt-3">
                Dengan mengisi kolom "YA" di bawah ini, saya menyatakan bahwa saya telah memiliki pengalaman yang mencukupi dalam melaksanakan 
                transaksi Perdagangan Berjangka karena pernah bertransaksi pada Perusahaan Pialang Berjangka 
                dan telah memahami tentang tata cara bertransaksi Perdagangan Berjangka.
            </p>
            <p>Demikian Pernyataan ini dibuat dengan sebenarnya dalam keadaan sadar, sehat jasmani dan rohani serta tanpa paksaan apapun dari pihak manapun.</p>
            <div class="row mt-3 mb-3">
                <div class="col-6">
                    Pernyataan menerima / tidak<br>
                    <input type="radio" class="form-check-input radio_css" name="aggree" id="aggreeYes" value="Yes" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Ya</label>
                    <input type="radio" class="form-check-input radio_css" name="aggree" id="aggreeNo" value="No" style="margin-top: 10px;" required>
                    <label style="top: 0.5rem;position: relative;margin-bottom: 0;vertical-align: top;margin-right:1.5rem;">Tidak</label>
                </div>
                <div class="col-6">
                    <label>Menerima pada Tanggal</label>
                    <input type="text" readonly required value="<?php echo date('Y-m-d H:i:s') ?>" class="form-control text-center">
                </div>
            </div>
        </div>
    </div>
    <div class="card card-style">
        <input type="hidden" name="check" value="1">
        <input type="hidden" name="id_live" value="<?php echo $id_live ?>">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_22">Next</button>
    </div>
</form>
<script>
    function run(){
        if(document.getElementById('aggreeYes').checked == true){
            document.getElementById("s5_pilbe").required = true;
            document.getElementById("s5_pilbe").type = "text";
        }else{
            document.getElementById("s5_pilbe").required = false;
            document.getElementById("s5_pilbe").type = "hidden";
        };
    };
</script>
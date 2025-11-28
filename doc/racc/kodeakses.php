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

    if(isset($_POST['submit_10'])){
        if(isset($_POST['aggree'])){
            if(isset($_GET['id'])){   
                $aggree = $_POST['aggree'];     
                if($aggree == 'Yes'){
                    mysqli_query($db, '
                        UPDATE tb_racc SET
                            tb_racc.ACC_F_KODE = 1,
                            tb_racc.ACC_F_KODE_PERYT = "'.$aggree.'",
                            tb_racc.ACC_F_KODE_IP = "'.$IP_ADDRESS.'",
                            tb_racc.ACC_F_KODE_DATE = "'.date('Y-m-d H:i:s').'"
                        WHERE LOWER(MD5(MD5(tb_racc.ID_ACC))) = "'.$id_live.'"
                    ') or die (mysqli_error($db));
                    die ("<script>location.href = 'home.php?page=racc/disclosure1&id=".$id_live."'</script>");
                }else{die("<script>location.href = 'home.php?page=racc/kodeakses&id=".$id_live."'</script>");};
            } else { die ("<script>alert('please try again2');location.href = 'home.php?page=racc/kodeakses&id=".$id_live."'</script>"); }
        } else { die ("<script>alert('please try again2');location.href = 'home.php?page=racc/kodeakses&id=".$id_live."'</script>"); }
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
            <div class="card">
                <div class="row">
                    <!-- <div class="col-6 text-left" >
                        <strong><small>Formulir Nomor : 107.PBK.07</small></strong>
                    </div> -->
                    <!-- <div class="col-12 text-right" >
                        <small>
                            Lampiran Peraturan Kepala Badan Pengawas<br>
                            Perdagangan Berjangka Komoditi<br>
                            Nomor : 107/BAPPEBTI/PER/11/2013
                        </small>
                    </div> -->
                    <?php include 'header_form.php'; ?>
                </div>
                <h6 class="text-center">PERNYATAAN BERTANGGUNG JAWAB ATAS KODE AKSES TRANSAKSI NASABAH (Personal Access Password)</h5>
                <hr>
                <div class="card-body">
                    <table class="table table-borderless" >
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
                            <td>No. Identitas</td>
                            <td> : </td>
                            <td><?php echo $user1['MBR_NO_IDT'] ?></td>
                        </tr>
                        <tr>
                            <td>Tipe Identitas</td>
                            <td> : </td>
                            <td><?php echo $user1['MBR_TYPE_IDT'] ?></td>
                        </tr>
                        <tr>
                            <td>No. Acc</td>
                            <td> : </td>
                            <td>Waiting Account</td>
                        </tr>
                    </table>
                    <p class="mt-3" >Dengan mengisi kolom “YA” di bawah ini, saya menyatakan bahwa saya bertanggungjawab sepenuhnya terhadap kode akses transaksi Nasabah (Personal Access Password) dan tidak menyerahkan kode akses transaksi Nasabah (Personal Access Password) ke pihak lain, terutama kepada pegawai Pialang Berjangka atau pihak yang memiliki kepentingan dengan Pialang Berjangka.</p>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <div style="border:2px solid black;">
                                <strong >
                                    <span style="color:red">PERINGATAN !!!</span><br>
                                    Pialang Berjangka, Wakil Pialang Berjangka, pegawai Pialang Berjangka, atau Pihak
                                    yang memiliki kepentingan dengan dengan Pialang Berjangka dilarang menerima kode
                                    akses transaksi Nasabah (Personal Access Password).
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
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
        </div>
    </div>
    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="submit_10">Next</button>
    </div>
</form>
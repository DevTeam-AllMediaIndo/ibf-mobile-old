
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
        $R_RATE = $RESULT_QUERYACC['ACC_RATE'];
        $R_PRODUCT = $RESULT_QUERYACC['ACC_PRODUCT'];
        $R_TYPEACC = $RESULT_QUERYACC['ACC_TYPEACC'];
    } else {
        $R_RATE = '';
        $R_PRODUCT = '';
        $R_TYPEACC = '';
    }
    if(isset($_POST['input_lv3'])){
        if(isset($_POST['rate'])){
            if(isset($_POST['acc_select'])){
                if(isset($_POST['product'])){
                    if(isset($_POST['demoacc'])){
                        $rate = form_input($_POST['rate']);
                        $acc_select = form_input($_POST['acc_select']);
                        $product = form_input($_POST['product']);
                        $demoacc = form_input($_POST['demoacc']);
                        $EXEC_SQL = mysqli_query($db, '
                            UPDATE tb_racc SET
                            tb_racc.ACC_DEMO = "'.$demoacc.'",
                            tb_racc.ACC_TYPEACC = "'.$acc_select.'",
                            tb_racc.ACC_PRODUCT = "'.$product.'",
                            tb_racc.ACC_RATE = "'.$rate.'"
                            WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_live.'"
                        ') or die (mysqli_error($db));
                        die ("<script>location.href = 'home.php?page=racc/profileperusahaanpialang&id=".$id_live."'</script>");
                    }
                }
            }
        }
    }
?>
<div class="page-title page-title-small">
    <h2>Form Application</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<form method="post">
    <div class="card card-style">
        <div class="content">
            <div class="section mt-2 mb-2">
                <!-- <div class="section-title">Perkiraan Deposit Awal Kamu</div> -->
                <div class="form-group boxed">
                    <div class="input-wrapper mt-3">
                        <label class="label" for="select4b">Choose Demo Acc</label>
                        <select class="form-control custom-select" id="select4b" name="demoacc" required>
                            <?php

                                if($ACC_TYPE == 2){
                                    $ACC_TYPE = 1;
                                } else {
                                    $ACC_TYPE = 2;
                                }
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
                        <label class="label" for="select4b">Choose Rate</label>
                        <select class="form-control custom-select" id="select4b" name="rate" required>
                            <option value="">Choose Rate</option>
                            <option <?php if($R_RATE == '10000'){ echo 'selected'; } ?> value="10000">Rp.10.000</option>
                            <option <?php if($R_RATE == '12000'){ echo 'selected'; } ?> value="12000">Rp.12.000</option>
                            <option <?php if($R_RATE == '14000'){ echo 'selected'; } ?> value="14000">Rp.14.000</option>
                            <option <?php if($R_RATE == '0'){ echo 'selected'; } ?> value="0">Floating</option>
                        </select>
                    </div>
                    <div class="input-wrapper mt-3">
                        <label class="label" for="select5b">Poduct</label>
                        <select class="form-control custom-select" id="select5b" name="product" required>
                            <option value="">Choose Product</option>
                            <option <?php if($R_PRODUCT == 'Forex dan Gold'){ echo 'selected'; } ?> value="Forex dan Gold">Forex dan Gold</option>
                            <option <?php if($R_PRODUCT == 'Index Asia (Gulir)'){ echo 'selected'; } ?> value="Index Asia (Gulir)">Index Asia (Gulir)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content mb-2">
        <h5 class="float-start font-16 font-500">Pilih Tipe akun Live Anda</h5>
        <div class="clearfix"></div>
    </div>

    <div class="card card-style">
        <div class="card-body">
            <div class="form-check form-check-inline">
                <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault1" <?php if($R_TYPEACC == 'Mini'){ echo 'checked'; } ?> name="acc_select" value="Mini" required>
                <label class="form-check-label" for="radioInlineDefault1"></label>
            </div>
            <strong>Mini</strong>
            <ul>
                <li>Minimum Deposit USD 2,000</li>
                <li>Leverage 1 : 100</li>
                <li>Komisi : Maksimal</li>
            </ul> 
        </div>
    </div>

    <div class="card card-style">
        <div class="card-body">
            <div class="form-check form-check-inline">
                <input class="form-check-input radio_css" type="radio"  id="radioInlineDefault2" <?php if($R_TYPEACC == 'Regular'){ echo 'checked'; } ?> name="acc_select" value="Regular" required>
                <label class="form-check-label" for="radioInlineDefault2"></label>
            </div>
            <strong class="font-800">Regular</strong>
            <ul>
                <li>Minimum Deposit USD 5,000</li>
                <li>Leverage 1 : 100</li>
                <li>Komisi : Maksimal</li>
            </ul>
        </div>
    </div>

    <div class="card card-style">
        <button class="btn btn-full btn-primary rounded-sm shadow-xl font-800 btn-m" type="submit" name="input_lv3">Next</button>
    </div>
</form>
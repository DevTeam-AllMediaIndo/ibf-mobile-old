<?php 
if(!isset($user1['MBR_ID'])){
//ob_start();
//header("HTTP/1.1 301 Moved Permanently");
//header("Location: ../signin1.php");
die("<script>window.location.href = '../signin2.php'</script>");
}; 
?>
<div class="page-title page-title-small">
    <h2>Account</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>

<div id="card_create" class="card card-style bg-28" data-card-height="160">
    <div class="card-center">
        
        <?php
            if($user1['MBR_DATETIME'] >= '2023-02-06'){
                $SQL_QUERY = mysqli_query($db, '
                    SELECT COUNT(tb_racc.ID_ACC) AS ID_ACC
                    FROM tb_racc
                    WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                    AND tb_racc.ACC_DERE = 2
                    AND tb_racc.ACC_TYPE = 1
                ');
                if(mysqli_num_rows($SQL_QUERY) > 0) {
                    $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
                    if($RESULT_QUERY['ID_ACC'] == 0){
                        $DEMO_ACC_STS = 1;
        ?>
            <form method="post" action='home.php?page=list_account_test'>
                <input type="hidden" name="type" value="demo">
                <h3 class="color-black font-700 text-center mb-0">Create Demo Account</h3>
                <p class="color-black text-center opacity-40 mt-n1 mb-0">for the first time you must have demo account.</p>

                <button type="submit" name="createacc" class="btn btn-m font-900 text-uppercase rounded-sm bg-highlight btn-center-xl mt-3">Create Demo Account Now</button>
            </form>
        <?php 
                    };
                    $DEMO_ACC_STS = -1;
                };
            } else { 
                $DEMO_ACC_STS = -1;
            };
        ?>
        
        <?php
            $SQL_QUERY = mysqli_query($db, '
                SELECT
                    SUM(IF(tb_racc.ACC_DERE = 2, 1, 0)) AS TOTAL_DEMO,
                    SUM(IF(tb_racc.ACC_DERE = 1, 1, 0)) AS TOTAL_REAL,
                    IFNULL((
                        SELECT tb_schedule.SCHD_STS
                        FROM tb_schedule
                        WHERE tb_schedule.SCHD_ID = tb_racc.ACC_MBR

                        UNION ALL

                        SELECT tb_schedule1.SCHD_STS
                        FROM tb_schedule1
                        WHERE tb_schedule1.SCHD_ID = tb_racc.ACC_MBR
                        AND tb_schedule1.SCHD_STS = -1
                    ), -2) AS TOTAL_SCHEDULE,
                    IFNULL((
                        SELECT tb_schedule.SCHD_REASON
                        FROM tb_schedule
                        WHERE tb_schedule.SCHD_ID = tb_racc.ACC_MBR
                        AND tb_schedule.SCHD_STS = -1

                        UNION ALL

                        SELECT tb_schedule1.SCHD_REASON
                        FROM tb_schedule1
                        WHERE tb_schedule1.SCHD_ID = tb_racc.ACC_MBR
                        AND tb_schedule1.SCHD_STS = -1
                    ), "-") AS SCHD_REASON,
                    DATE(tb_racc.ACC_DATETIME) AS ACC_DATETIME_DATE
                FROM tb_racc
                WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
            ');
            if(mysqli_num_rows($SQL_QUERY) > 0) {
                $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
                // echo '<span style="color:white;">'.$RESULT_QUERY['ACC_DATETIME_DATE'].'</span><br>';
                // if($RESULT_QUERY['ACC_DATETIME_DATE'] >= '2023-02-06'){
                    if($RESULT_QUERY['TOTAL_DEMO'] > 0 && $RESULT_QUERY['TOTAL_REAL'] < 1 && $RESULT_QUERY['TOTAL_SCHEDULE'] == -2){
                        $SCHEDULE_STS = 1;
        ?>
            <h3 class="color-black font-700 text-center mb-0">Jadwal Temu</h3>
            <p class="color-black text-center opacity-40 mt-n1 mb-0">Atur jadwal Anda untuk melakukan video call dengan Wakil Pialang Berjangka.</p>

            <a href="home.php?page=jadwal-temu" class="btn btn-m font-900 text-uppercase rounded-sm bg-highlight btn-center-xl mt-3">Jadwalkan sekarang</a>
        <?php } else if($RESULT_QUERY['TOTAL_DEMO'] > 0 && $RESULT_QUERY['TOTAL_REAL'] < 1 && $RESULT_QUERY['TOTAL_SCHEDULE'] == 1){ $SCHEDULE_STS = 1; ?>
            <h3 class="color-black font-700 text-center mb-0">Jadwal Temu</h3>
            <p class="color-black text-center opacity-40 mt-n1 mb-0">Jadwal anda di tolak karena <?php echo $RESULT_QUERY['SCHD_REASON'] ?>,<br>atur kembali jadwal temu anda dengan Wakil Pialang Berjangka.</p>

            <a href="home.php?page=jadwal-temu" class="btn btn-m font-900 text-uppercase rounded-sm bg-highlight btn-center-xl mt-3">Jadwalkan sekarang</a>
        <?php } else if($RESULT_QUERY['TOTAL_DEMO'] > 0 && $RESULT_QUERY['TOTAL_REAL'] < 1 && $RESULT_QUERY['TOTAL_SCHEDULE'] == 0){ $SCHEDULE_STS = 1; ?>
            <h3 class="color-black font-700 text-center mb-0">Tunggu Confirmasi Dari Wakil Pialang Berjangka</h3>
            <p class="color-black text-center opacity-40 mt-n1 mb-0">Anda akan segera di hubungi oleh Wakil Pialang Berjangka.</p>

            <a href="#" class="btn btn-m font-900 text-uppercase rounded-sm bg-highlight btn-center-xl mt-3">Menunggu Konfirmasi</a>
        <?php
                    } else if($RESULT_QUERY['TOTAL_DEMO'] > 0 && $RESULT_QUERY['TOTAL_SCHEDULE'] == -1){
                        $SCHEDULE_STS = -3;
                    } else { 
                        if($RESULT_QUERY['ACC_DATETIME_DATE'] >= '2023-02-06'){
                            $SCHEDULE_STS = -3;
                        } else {
                            if($RESULT_QUERY['TOTAL_REAL'] > 0){
                                $SCHEDULE_STS = -3;
                            } else {
                                $SCHEDULE_STS = 1;
                            }
                        }
                    }
                // } else { 
                //     $SCHEDULE_STS = -3;
                // }
            } else { $SCHEDULE_STS = 1; }
        ?>

        <?php
            if($DEMO_ACC_STS == -1 && $SCHEDULE_STS == -3){
                $SQL_QUERY = mysqli_query($db, '
                    SELECT COUNT(tb_racc.ID_ACC) AS ID_ACC
                    FROM tb_racc
                    WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                    AND tb_racc.ACC_DERE = 1
                    AND tb_racc.ACC_LOGIN = "0"
                ');
                if(mysqli_num_rows($SQL_QUERY) > 0) {
                    $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
                    if($RESULT_QUERY['ID_ACC'] == 0){
        ?>
            <form method="post" action='home.php?page=list_account_test'>
                <input type="hidden" name="type" value="live">
                <h3 class="color-black font-700 text-center mb-0">Buat Real Account</h3>
                <p class="color-black text-center opacity-40 mt-n1 mb-0">isi dengan benar pada formulir pembuatan akun real.</p>

                <button type="submit" name="createacc" class="btn btn-m font-900 text-uppercase rounded-sm bg-highlight btn-center-xl mt-3">Buat Real Account Sekarang</button>
            </form>
        <?php
                    } else if($RESULT_QUERY['ID_ACC'] > 0){
        ?>
                <h3 class="color-black font-700 text-center mb-0">Buat Real Account</h3>
                <p class="color-black text-center opacity-40 mt-n1 mb-0">isi dengan benar pada formulir pembuatan akun real.</p>

                <a href="#" class="btn btn-m font-900 text-uppercase rounded-sm bg-highlight btn-center-xl mt-3">Menunggu Akun Anda selesai</a>
        <?php
                    };
                };
            };
        ?>
    </div>
    <div class="card-overlay bg-white opacity-90"></div>
</div>
<?php
        
    $SQL_QUERY_LIVE = mysqli_query($db, '
        SELECT
            tb_racc.ID_ACC,
            tb_racc.ACC_LOGIN,
            tb_racc.ACC_WPCHECK,
            IFNULL(tb_racc.ACC_F_DISC_PERYT, "No") AS ACC_F_DISC_PERYT,
            MD5(MD5(tb_racc.ID_ACC)) AS ACC_LOGIN_HASH
        FROM tb_racc
        WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
        AND tb_racc.ACC_TYPE = 1
        AND tb_racc.ACC_DERE = 1
        ORDER BY tb_racc.ID_ACC DESC
    ');
    if(mysqli_num_rows($SQL_QUERY_LIVE) > 0) {
        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY_LIVE)){
            if($RESULT_QUERY['ACC_LOGIN'] == '0' && $RESULT_QUERY['ACC_WPCHECK'] == 0 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'No'){
?>
                <div class="card card-style mt-4">
                    <div class="content">
                        <a href="home.php?page=racc/createaccountreal&id=<?php echo $RESULT_QUERY['ACC_LOGIN_HASH'] ?>"><h4>Pengisian pembuatan akun belum selesai</h4> (Klik disini untuk melanjutkan)</a>
                    </div>
                </div>
<?php } else if($RESULT_QUERY['ACC_LOGIN'] == '0' && $RESULT_QUERY['ACC_WPCHECK'] == 0 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'Yes'){ ?>
                <div class="card card-style mt-4">
                    <div class="content">
                        <h4>Menunggu Konfirmasi dari Wakil Pialang Berjangka</h4>Pembuatan akun telah selesai. Tunggu konfirmasi dari Wakil Pialang Berjangka yang akan menghubungi anda.
                    </div>
                </div>
<?php } else if($RESULT_QUERY['ACC_LOGIN'] == '0' && $RESULT_QUERY['ACC_WPCHECK'] == 1 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'Yes'){ ?>
                <div class="card card-style mt-4">
                    <div class="content">
                        <a href="home.php?page=racc/deposit&id=<?php echo $RESULT_QUERY['ACC_LOGIN_HASH'] ?>"><h4>Buat Deposit Akun Baru</h4> (Klik disini untuk melanjutkan)</a>
                    </div>
                </div>
<?php } else if($RESULT_QUERY['ACC_LOGIN'] == '0' && $RESULT_QUERY['ACC_WPCHECK'] == 2 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'Yes'){ ?>
                <div class="card card-style mt-4">
                    <div class="content">
                        <h4>Menunggu Konfirmasi Deposit Akun Baru</h4>Pembuatan akun telah selesai. Tunggu konfirmasi dari Wakil Pialang Berjangka yang akan menghubungi anda.
                    </div>
                </div>
<?php } else if($RESULT_QUERY['ACC_LOGIN'] == '0' && $RESULT_QUERY['ACC_WPCHECK'] == 3 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'Yes'){ ?>
                <div class="card card-style mt-4">
                    <div class="content">
                        <h4>Menunggu Konfirmasi dari Wakil Pialang Berjangka</h4>Pembuatan akun telah selesai. Tunggu konfirmasi dari Wakil Pialang Berjangka yang akan menghubungi anda.
                    </div>
                </div>
<?php } else if($RESULT_QUERY['ACC_LOGIN'] == '0' && $RESULT_QUERY['ACC_WPCHECK'] == 4 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'Yes'){ ?>
                <div class="card card-style mt-4">
                    <div class="content">
                        <h4>Menunggu Konfirmasi dari Wakil Pialang Berjangka</h4>Pembuatan akun telah selesai. Tunggu konfirmasi dari Wakil Pialang Berjangka yang akan menghubungi anda.
                    </div>
                </div>
<?php } else if($RESULT_QUERY['ACC_LOGIN'] == '0' && $RESULT_QUERY['ACC_WPCHECK'] == 5 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'Yes'){ ?>
                <div class="card card-style mt-4">
                    <div class="content">
                        <h4>Menunggu Konfirmasi dari Wakil Pialang Berjangka</h4>Pembuatan akun telah selesai. Tunggu konfirmasi dari Wakil Pialang Berjangka yang akan menghubungi anda.
                    </div>
                </div>
<?php
        } else if($RESULT_QUERY['ACC_LOGIN'] <> '0' && $RESULT_QUERY['ACC_WPCHECK'] == 6 && $RESULT_QUERY['ACC_F_DISC_PERYT'] == 'Yes'){
            $SQL_QUERY = mysqli_query($db, '
                SELECT
                    MD5(MD5(tb_racc.ID_ACC)) AS ID_ACC,
                    tb_racc.ACC_LOGIN,
                    MT4_USERS.LEVERAGE,
                    MT4_USERS.BALANCE,
                    MT4_USERS.MARGIN_FREE,
                    SUM(IF(MT4_TRADES.CMD = 6 AND MT4_TRADES.PROFIT > 0, MT4_TRADES.PROFIT, 0)) AS DEPOSIT,
                    SUM(IF(MT4_TRADES.CMD = 6 AND MT4_TRADES.PROFIT < 0, ABS(MT4_TRADES.PROFIT), 0)) AS WITHDRAWAL,
                    SUM(IF(MT4_TRADES.CMD = 0 OR MT4_TRADES.CMD = 1, MT4_TRADES.PROFIT+MT4_TRADES.COMMISSION+MT4_TRADES.SWAPS, 0)) AS PNL
                FROM tb_racc
                JOIN MT4_USERS
                JOIN MT4_TRADES
                ON(tb_racc.ACC_LOGIN = MT4_USERS.LOGIN
                AND tb_racc.ACC_LOGIN = MT4_TRADES.LOGIN)
                WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$RESULT_QUERY['ACC_LOGIN_HASH'].'"
                AND tb_racc.ACC_TYPE = 1
                AND tb_racc.ACC_DERE = 1
                GROUP BY tb_racc.ACC_LOGIN
            ');
            if(mysqli_num_rows($SQL_QUERY) > 0) {
                $RESULT_ACTIVE = mysqli_fetch_assoc($SQL_QUERY);

                
                if($RESULT_ACTIVE['MARGIN_FREE'] == $RESULT_ACTIVE['BALANCE']){
                    $MARGIN_FREE1 = 100;
                } else {
                    $MARGIN_FREE1 =  round($RESULT_ACTIVE['MARGIN_FREE']/$RESULT_ACTIVE['BALANCE']*100, 2);
                }
?>
<div class="card card-style mt-4">
    <div class="content">
        <h4 class="mb-3">Real - Login : <?php echo $RESULT_ACTIVE['ACC_LOGIN'].' (1:'.$RESULT_ACTIVE['LEVERAGE'].')'; ?></h4>
        <div class="progress rounded-sm shadow-xl border border-fade-primary-dark" style="height:28px">
            <div class="progress-bar bg-primary-dark text-start ps-3 color-white" 
                    role="progressbar" style="width: <?php echo $MARGIN_FREE1; ?>%" 
                    aria-valuenow="<?php echo round($MARGIN_FREE1, 0) ?>" aria-valuemin="0" 
                    aria-valuemax="<?php echo round($RESULT_ACTIVE['BALANCE'], 0) ?>">
                    <?php echo $MARGIN_FREE1 ?>% Margin Free
            </div>
        </div>
        
        <?php
    
            echo $MARGIN_FREE1
        ?>% Margin Free
        <div class="divider mt-4 mb-2"></div>
        <div class="d-flex">
            <div class="pe-4 align-self-center">
                <p class="font-600 color-highlight mb-0">P/L</p>
                <h1 class="mb-2">$<?php echo round($RESULT_ACTIVE['PNL'], 2) ?></h1>
            </div>
            <div class="w-100 align-self-center ps-3">
                <h6 class="font-14 font-500">Deposit<span class="float-end color-green-dark">+$<?php echo number_format($RESULT_ACTIVE['DEPOSIT'], 2) ?></span></h6>
                <div class="divider mb-2 mt-1"></div>
                <h6 class="font-14 font-500">Withdrawal<span class="float-end color-red-dark">-$<?php echo number_format($RESULT_ACTIVE['WITHDRAWAL'], 2) ?></span></h6>
            </div>
        </div>     
        <div class="divider"></div>
        <div class="row mb-0">
            <div class="col-6">
                <a href="home.php?page=dpwddc&action=deposit&login=<?php echo $RESULT_ACTIVE['ACC_LOGIN'] ?>" class="btn btn-full btn-success rounded-sm shadow-xl font-800 text-uppercase btn-m">Top Up</a>
            </div>
            <div class="col-6">
                <a href="home.php?page=dpwddc&action=withdrawal&login=<?php echo $RESULT_ACTIVE['ACC_LOGIN'] ?>" class="btn btn-full btn-danger rounded-sm shadow-xl font-800 text-uppercase btn-m">Withdrawal</a>
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-12">
                <a href="home.php?page=dpwddc&action=document&x=<?php echo $RESULT_ACTIVE['ID_ACC'] ?>&login=<?php echo $RESULT_ACTIVE['ACC_LOGIN'] ?>" class="mt-2 btn btn-full btn-info rounded-sm shadow-xl font-800 text-uppercase btn-m">Document</a>
            </div>
        </div>
    </div>
</div>
<?php 
                };
            };
        };
    };
?>
<?php
    $SQL_QUERY = mysqli_query($db, '
        SELECT
            tb_racc.ACC_LOGIN,
            MT4_USERS_DEMO.LEVERAGE,
            MT4_USERS_DEMO.BALANCE,
            MT4_USERS_DEMO.MARGIN_FREE,
            SUM(IF(MT4_TRADES_DEMO.CMD = 6 AND MT4_TRADES_DEMO.PROFIT > 0, MT4_TRADES_DEMO.PROFIT, 0)) AS DEPOSIT,
            SUM(IF(MT4_TRADES_DEMO.CMD = 6 AND MT4_TRADES_DEMO.PROFIT < 0, ABS(MT4_TRADES_DEMO.PROFIT), 0)) AS WITHDRAWAL,
            SUM(IF(MT4_TRADES_DEMO.CMD = 0 OR MT4_TRADES_DEMO.CMD = 1, MT4_TRADES_DEMO.PROFIT+MT4_TRADES_DEMO.COMMISSION, 0)) AS PNL
        FROM tb_racc
        JOIN MT4_USERS_DEMO
        JOIN MT4_TRADES_DEMO
        ON(tb_racc.ACC_LOGIN = MT4_USERS_DEMO.LOGIN
        AND tb_racc.ACC_LOGIN = MT4_TRADES_DEMO.LOGIN)
        WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
        AND tb_racc.ACC_LOGIN <> 0
        AND tb_racc.ACC_TYPE = 1
        AND tb_racc.ACC_DERE = 2
        GROUP BY tb_racc.ACC_LOGIN
    ');
    if(mysqli_num_rows($SQL_QUERY) > 0) {
        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
?>
<div class="card card-style mt-4">
    <div class="content">
        <h4 class="mb-3">Demo - Login : <?php echo $RESULT_QUERY['ACC_LOGIN'].' (1:'.$RESULT_QUERY['LEVERAGE'].')'; ?></h4>
        <div class="progress rounded-sm shadow-xl border border-fade-primary-dark" style="height:28px">
            <div class="progress-bar bg-primary-dark text-start ps-3 color-white" 
                role="progressbar" style="width: <?php if(round($RESULT_QUERY['MARGIN_FREE']/$RESULT_QUERY['BALANCE']*100, 2) <= 0){ echo 0; } else { echo round($RESULT_QUERY['MARGIN_FREE']/$RESULT_QUERY['BALANCE']*100, 2); }; ?>%" 
                aria-valuenow="<?php echo round($RESULT_QUERY['MARGIN_FREE'], 0) ?>" aria-valuemin="0" 
                aria-valuemax="<?php echo round($RESULT_QUERY['BALANCE'], 0) ?>">
                <?php echo round($RESULT_QUERY['MARGIN_FREE']/$RESULT_QUERY['BALANCE']*100, 2) ?>% Margin Free
            </div>
        </div>
        <?php
            if($RESULT_QUERY['MARGIN_FREE'] == $RESULT_QUERY['BALANCE']){
                echo 100;
            } else {
                echo round($RESULT_QUERY['MARGIN_FREE']/$RESULT_QUERY['BALANCE']*100, 2);
            }
        ?>% Margin Free
        <div class="divider mt-4 mb-2"></div>
        <div class="d-flex">
            <div class="pe-4 align-self-center">
                <p class="font-600 color-highlight mb-0">P/L</p>
                <h1 class="mb-2">$<?php echo round($RESULT_QUERY['PNL'], 2) ?></h1>
            </div>
            <div class="w-100 align-self-center ps-3">
                <h6 class="font-14 font-500">Deposit<span class="float-end color-green-dark">+$<?php echo number_format($RESULT_QUERY['DEPOSIT'], 2) ?></span></h6>
                <div class="divider mb-2 mt-1"></div>
                <h6 class="font-14 font-500">Withdrawal<span class="float-end color-red-dark">-$<?php echo number_format($RESULT_QUERY['WITHDRAWAL'], 2) ?></span></h6>
            </div>
        </div>
    </div>
</div>
<?php };}; ?>
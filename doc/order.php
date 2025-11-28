
<?php if(!isset($user1['MBR_ID'])){ Redirect('signin.php', false); }; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="page-title page-title-small">
    <h2>Order</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style mt-4">
    <div class="card-body">
        <div class="accordion" id="accordionExample2">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion001">
                        <img src="<?php echo convertToBase64('assets/img/icon/acc_live.png') ?>" width="24">
                        &nbsp;&nbsp;List Account 
                        <?php
                            if(isset($_GET['id'])){
                                $id_live = $_GET['id'];
                                $SQL_QUERY = mysqli_query($db, "
                                    SELECT 
                                        MT4_USERS.*,
                                        MD5(MD5(tb_racc.ID_ACC)) AS HASH_ID
                                    FROM tb_racc
                                    JOIN MT4_USERS
                                    ON(tb_racc.ACC_LOGIN = MT4_USERS.LOGIN)
                                    WHERE tb_racc.ACC_MBR = ".$user1['MBR_ID']."
                                    AND MD5(MD5(tb_racc.ID_ACC)) = '".$id_live."'
                                    LIMIT 1
                                ");
                                if(mysqli_num_rows($SQL_QUERY) > 0) {
                                    $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
                                    echo ' ('.$RESULT_QUERY['LOGIN'].')';
                                    $LOGIN = $RESULT_QUERY['LOGIN'];
                                    $BALANCE = $RESULT_QUERY['BALANCE'];
                                    $EQUITY = $RESULT_QUERY['EQUITY'];
                                    $I_HASH = $RESULT_QUERY['HASH_ID'];
                                } else {
                                    $LOGIN = 0;
                                    $BALANCE = 0;
                                    $EQUITY = 0;
                                    $I_HASH = "";
                                };
                            } else {
                                $LOGIN = 0;
                                $BALANCE = 0;
                                $EQUITY = 0;
                                $id_live = 0;
                            };
                        ?>
                    </button>
                </h2>
                <div id="accordion001" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                    <div class="accordion-body">
                        <ul>
                            <?php
                                $SQL_QUERY = mysqli_query($db, '
                                    SELECT
                                        tb_racc.ACC_LOGIN,
                                        MD5(MD5(tb_racc.ID_ACC)) AS ACC_LOGIN_HASH
                                    FROM tb_racc
                                    WHERE tb_racc.ACC_MBR = '.$user1['MBR_ID'].'
                                    AND tb_racc.ACC_LOGIN <> 0
                                    AND tb_racc.ACC_TYPE = 1
                                    AND tb_racc.ACC_DERE = 1
                                ');
                                if(mysqli_num_rows($SQL_QUERY) > 0) {
                                    while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
                            ?>
                                <li><a href="home.php?page=<?php echo $login_page ?>&id=<?php echo $RESULT_QUERY['ACC_LOGIN_HASH'] ?>"><?php if($RESULT_QUERY['ACC_LOGIN'] == 0){ echo 'waiting account submited'; } else { echo $RESULT_QUERY['ACC_LOGIN']; } ?></a></li>
                            <?php };} else { ?>
                                <li>No Account</li>
                            <?php }; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if($LOGIN > 0){
        $SQL_QUERY = mysqli_query($db, '
            SELECT
                SUM(IF(MT4_TRADES.CMD = 6 AND MT4_TRADES.PROFIT > 0, MT4_TRADES.PROFIT, 0)) AS DEPOSIT,
                SUM(IF(MT4_TRADES.CMD = 6 AND MT4_TRADES.PROFIT < 0, ABS(MT4_TRADES.PROFIT), 0)) AS WIDHDRAWAL,
                SUM(IF((MT4_TRADES.CMD = 0 OR MT4_TRADES.CMD = 1 ) AND MT4_TRADES.PROFIT > 0, ABS(MT4_TRADES.PROFIT)-MT4_TRADES.SWAPS-MT4_TRADES.COMMISSION, 0)) AS PROFIT,
                SUM(IF((MT4_TRADES.CMD = 0 OR MT4_TRADES.CMD = 1 ) AND MT4_TRADES.PROFIT < 0, ABS(MT4_TRADES.PROFIT)-MT4_TRADES.SWAPS-MT4_TRADES.COMMISSION, 0)) AS LOSS,
                SUM(MT4_TRADES.VOLUME / 100) AS LOT
            FROM MT4_TRADES
            WHERE MT4_TRADES.LOGIN = '.$LOGIN.'
            AND (MT4_TRADES.CMD = 0 OR MT4_TRADES.CMD = 1)
        ');
        if(mysqli_num_rows($SQL_QUERY) > 0) {
            $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
            $DEPOSIT = $RESULT_QUERY['DEPOSIT'];
            $WIDHDRAWAL = $RESULT_QUERY['WIDHDRAWAL'];
            $PROFIT = $RESULT_QUERY['PROFIT'];
            $LOSS = $RESULT_QUERY['LOSS'];
            $LOT = $RESULT_QUERY['LOT'];
        } else {
            $DEPOSIT = 0;
            $WIDHDRAWAL = 0;
            $PROFIT = 0;
            $LOSS = 0;
            $LOT = 0;
        }
?>
    <div class="card card-style mt-n3">
        <div class="content mt-3">
            <div class="d-flex">
                <div class="pe-4 align-self-center">
                    <p class="font-600 color-highlight mb-0">Balance</p>
                    <h1 class="mb-2">$<?php echo number_format($BALANCE, 2) ?></h1>
                </div>
                <div class="w-100 align-self-center ps-3">
                    <h6 class="font-14 font-500">Deposit<span class="float-end color-green-dark">+$<?php echo number_format($DEPOSIT, 2) ?></span></h6>
                    <div class="divider mb-2 mt-1"></div>
                    <h6 class="font-14 font-500">Withdrawal<span class="float-end color-red-dark">-$<?php echo number_format($WIDHDRAWAL, 2) ?></span></h6>
                </div>
            </div>
            <div class="divider mt-2 mb-3"></div>
            <div class="row mb-0">
                <div class="col-6 pe-1">
                    <div class="mx-0 mb-3">
                        <h6 class="font-13 font-400 mb-0">Profit</h6>
                        <h3 class="color-green-dark font-15 mb-0">+$<?php echo number_format($PROFIT, 2) ?></h3>
                    </div>
                </div>
                <div class="col-6 ps-1">
                    <div class="mx-0 mb-3">
                        <h6 class="font-13 font-400 mb-0">Loss</h6>
                        <h3 class="color-red-dark font-15 mb-0">-$<?php echo number_format($LOSS, 2) ?></h3>
                    </div>
                </div>
                <div class="col-6 pe-1">
                    <div class="mx-0 mb-3">
                        <h6 class="font-13 font-400 mb-0">Volume</h6>
                        <h3 class="color-brown-dark font-15 mb-0"><?php echo number_format($LOT, 2) ?></h3>
                    </div>
                </div>
                <div class="col-6 ps-1">
                    <div class="mx-0 mb-3">
                        <h6 class="font-13 font-400 mb-0">P/L</h6>
                        <h3 class="color-blue-dark font-15 mb-0">$<?php echo number_format($PROFIT-$LOSS, 2) ?></h3>
                    </div>
                </div>              
            </div>
        </div>            
    </div>
    <div class="card card-style bg-theme pb-0">
        <div class="content" id="tab-group-1">
            <div class="tab-controls tabs-small tabs-rounded" data-highlight="bg-highlight">
                <a href="#" data-active data-bs-toggle="collapse" data-bs-target="#open-order">Open</a>
                <a href="#" data-bs-toggle="collapse" data-bs-target="#pending-order">Pending</a>
                <a href="#" data-bs-toggle="collapse" data-bs-target="#history-order">History</a>
                <a href="#" data-bs-toggle="collapse" data-bs-target="#inout">In/Out</a>
                <!-- <a href="#" data-bs-toggle="collapse" data-bs-target="#doc">Doc.</a> -->
            </div>
            <div class="clearfix mb-3"></div>
            <div data-bs-parent="#tab-group-1" class="collapse show" id="open-order">
                <?php
                    $SQL_QUERY = mysqli_query($db, "
                        SELECT 
                            MT4_TRADES.TICKET,
                            MT4_TRADES.CMD,
                            MT4_TRADES.SYMBOL,
                            MT4_TRADES.PROFIT,
                            MT4_TRADES.OPEN_TIME,
                            MT4_TRADES.SL,
                            MT4_TRADES.TP,
                            MT4_TRADES.VOLUME,
                            MT4_TRADES.OPEN_PRICE,
                            MT4_TRADES.CLOSE_PRICE,
                            MT4_TRADES.COMMISSION,
                            MT4_TRADES.SWAPS,
                            MT4_PRICES.DIGITS
                        FROM tb_racc
                        JOIN MT4_TRADES
                        JOIN MT4_PRICES
                        ON(tb_racc.ACC_LOGIN = MT4_TRADES.LOGIN
                        AND MT4_TRADES.SYMBOL = MT4_PRICES.SYMBOL)
                        WHERE tb_racc.ACC_MBR = ".$user1['MBR_ID']."
                        AND MT4_TRADES.LOGIN = '".$LOGIN."'
                        AND DATE(MT4_TRADES.CLOSE_TIME) = DATE('1970-01-01')
                        AND (MT4_TRADES.CMD = 0 OR MT4_TRADES.CMD = 1)
                    ");
                    if ($SQL_QUERY && mysqli_num_rows($SQL_QUERY) > 0) {
                        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
                            if($RESULT_QUERY['CMD'] == 0){
                                $CMD = 'Buy';
                            } else { $CMD = 'Sell'; }
                            if($RESULT_QUERY['PROFIT'] > 0){
                                $PROFIT = '<span style="color:green;">'.number_format($RESULT_QUERY['PROFIT'], 2).'</span>';
                            } else { $PROFIT = '<span style="color:red;">'.number_format($RESULT_QUERY['PROFIT'], 2).'</span>'; }
                ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion<?php echo $RESULT_QUERY['TICKET'] ?>">
                                <table>
                                    <tr><td><?php echo $CMD.' - '.$RESULT_QUERY['TICKET'].' ('.$RESULT_QUERY['OPEN_TIME'].')' ?></td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td><?php echo '<strong>'.$RESULT_QUERY['SYMBOL'].'</strong> | '.$PROFIT; ?></td></tr>
                                </table>
                            </button>
                        </h2>
                        <div id="accordion<?php echo $RESULT_QUERY['TICKET'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <table width="100%">
                                    <tr>
                                        <td>P/L</td>
                                        <td><?php echo $PROFIT ?></td>
                                    </tr>
                                    <tr>
                                        <td>SL/TP</td>
                                        <td><?php echo number_format($RESULT_QUERY['SL'], $RESULT_QUERY['DIGITS']).'/'.number_format($RESULT_QUERY['TP'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lot</td>
                                        <td><?php echo number_format($RESULT_QUERY['VOLUME']/100, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Swap</td>
                                        <td><?php echo number_format($RESULT_QUERY['SWAPS'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order Price</td>
                                        <td><?php echo number_format($RESULT_QUERY['OPEN_PRICE'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Current Price</td>
                                        <td><?php echo number_format($RESULT_QUERY['CLOSE_PRICE'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Commision</td>
                                        <td><?php echo number_format($RESULT_QUERY['COMMISSION'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order No</td>
                                        <td><?php echo ($RESULT_QUERY['TICKET']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php };}; ?>
            </div>
            <div data-bs-parent="#tab-group-1" class="collapse" id="pending-order">
                <?php
                    $SQL_QUERY = mysqli_query($db, "
                        SELECT 
                            MT4_TRADES.TICKET,
                            MT4_TRADES.CMD,
                            MT4_TRADES.SYMBOL,
                            MT4_TRADES.PROFIT,
                            MT4_TRADES.OPEN_TIME,
                            MT4_TRADES.SL,
                            MT4_TRADES.TP,
                            MT4_TRADES.VOLUME,
                            MT4_TRADES.OPEN_PRICE,
                            MT4_TRADES.CLOSE_PRICE,
                            MT4_TRADES.COMMISSION,
                            MT4_TRADES.SWAPS,
                            MT4_PRICES.DIGITS
                        FROM tb_racc
                        JOIN MT4_TRADES
                        JOIN MT4_PRICES
                        ON(tb_racc.ACC_LOGIN = MT4_TRADES.LOGIN
                        AND MT4_TRADES.SYMBOL = MT4_PRICES.SYMBOL)
                        WHERE tb_racc.ACC_MBR = ".$user1['MBR_ID']."
                        AND MT4_TRADES.LOGIN = '".$LOGIN."'
                        AND (MT4_TRADES.CMD = 2 OR MT4_TRADES.CMD = 3
                        OR MT4_TRADES.CMD = 4 OR MT4_TRADES.CMD = 5)
                    ");
                    if ($SQL_QUERY && mysqli_num_rows($SQL_QUERY) > 0) {
                        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
                            if($RESULT_QUERY['CMD'] == 2){
                                $CMD = 'BUY LIMIT';
                            } else if($RESULT_QUERY['CMD'] == 3){
                                $CMD = 'SELL LIMIT'; 
                            } else if($RESULT_QUERY['CMD'] == 4){
                                $CMD = 'BUY STOP'; 
                            } else if($RESULT_QUERY['CMD'] == 5){
                                $CMD = 'SELL STOP'; 
                            }
                            if($RESULT_QUERY['PROFIT'] > 0){
                                $PROFIT = '<span style="color:green;">'.number_format($RESULT_QUERY['PROFIT'], 2).'</span>';
                            } else { $PROFIT = '<span style="color:red;">'.number_format($RESULT_QUERY['PROFIT'], 2).'</span>'; }
                ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion<?php echo $RESULT_QUERY['TICKET'] ?>">
                                <table>
                                    <tr><td><?php echo $CMD.' - '.$RESULT_QUERY['TICKET'].' ('.$RESULT_QUERY['OPEN_TIME'].')' ?></td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td><?php echo '<strong>'.$RESULT_QUERY['SYMBOL'].'</strong> | '.$PROFIT; ?></td></tr>
                                </table>
                            </button>
                        </h2>
                        <div id="accordion<?php echo $RESULT_QUERY['TICKET'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <table width="100%">
                                    <tr>
                                        <td>P/L</td>
                                        <td><?php echo $PROFIT ?></td>
                                    </tr>
                                    <tr>
                                        <td>SL/TP</td>
                                        <td><?php echo number_format($RESULT_QUERY['SL'], $RESULT_QUERY['DIGITS']).'/'.number_format($RESULT_QUERY['TP'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lot</td>
                                        <td><?php echo number_format($RESULT_QUERY['VOLUME']/100, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Swap</td>
                                        <td><?php echo number_format($RESULT_QUERY['SWAPS'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order Price</td>
                                        <td><?php echo number_format($RESULT_QUERY['OPEN_PRICE'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Current Price</td>
                                        <td><?php echo number_format($RESULT_QUERY['CLOSE_PRICE'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Commision</td>
                                        <td><?php echo number_format($RESULT_QUERY['COMMISSION'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order No</td>
                                        <td><?php echo ($RESULT_QUERY['TICKET']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php };}; ?>
            </div>
            <div data-bs-parent="#tab-group-1" class="collapse" id="history-order">
                <?php
                    $SQL_QUERY = mysqli_query($db, "
                        SELECT 
                            MT4_TRADES.TICKET,
                            MT4_TRADES.CMD,
                            MT4_TRADES.SYMBOL,
                            MT4_TRADES.PROFIT,
                            MT4_TRADES.OPEN_TIME,
                            MT4_TRADES.SL,
                            MT4_TRADES.TP,
                            MT4_TRADES.VOLUME,
                            MT4_TRADES.OPEN_PRICE,
                            MT4_TRADES.CLOSE_PRICE,
                            MT4_TRADES.COMMISSION,
                            MT4_TRADES.SWAPS,
                            MT4_PRICES.DIGITS
                        FROM tb_racc
                        JOIN MT4_TRADES
                        JOIN MT4_PRICES
                        ON(tb_racc.ACC_LOGIN = MT4_TRADES.LOGIN
                        AND MT4_TRADES.SYMBOL = MT4_PRICES.SYMBOL)
                        WHERE tb_racc.ACC_MBR = ".$user1['MBR_ID']."
                        AND MT4_TRADES.LOGIN = '".$LOGIN."'
                        AND DATE(MT4_TRADES.CLOSE_TIME) <> DATE('1970-01-01')
                        AND (MT4_TRADES.CMD = 0 OR MT4_TRADES.CMD = 1)
                        LIMIT 20
                    ");
                    if ($SQL_QUERY && mysqli_num_rows($SQL_QUERY) > 0) {
                        while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
                            if($RESULT_QUERY['CMD'] == 0){
                                $CMD = 'Buy';
                            } else { $CMD = 'Sell'; }
                            if($RESULT_QUERY['PROFIT'] > 0){
                                $PROFIT = '<span style="color:green;">'.number_format($RESULT_QUERY['PROFIT'], 2).'</span>';
                            } else { $PROFIT = '<span style="color:red;">'.number_format($RESULT_QUERY['PROFIT'], 2).'</span>'; }
                ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion<?php echo $RESULT_QUERY['TICKET'] ?>">
                                <table>
                                    <tr><td><?php echo $CMD.' - '.$RESULT_QUERY['TICKET'].' ('.$RESULT_QUERY['OPEN_TIME'].')' ?></td></tr>
                                    <tr><td>&nbsp;</td></tr>
                                    <tr><td><?php echo '<strong>'.$RESULT_QUERY['SYMBOL'].'</strong> | '.$PROFIT; ?></td></tr>
                                </table>
                            </button>
                        </h2>
                        <div id="accordion<?php echo $RESULT_QUERY['TICKET'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <table width="100%">
                                    <tr>
                                        <td>P/L</td>
                                        <td><?php echo $PROFIT ?></td>
                                    </tr>
                                    <tr>
                                        <td>SL/TP</td>
                                        <td><?php echo number_format($RESULT_QUERY['SL'], $RESULT_QUERY['DIGITS']).'/'.number_format($RESULT_QUERY['TP'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lot</td>
                                        <td><?php echo number_format($RESULT_QUERY['VOLUME']/100, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Swap</td>
                                        <td><?php echo number_format($RESULT_QUERY['SWAPS'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order Price</td>
                                        <td><?php echo number_format($RESULT_QUERY['OPEN_PRICE'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Current Price</td>
                                        <td><?php echo number_format($RESULT_QUERY['CLOSE_PRICE'], $RESULT_QUERY['DIGITS']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Commision</td>
                                        <td><?php echo number_format($RESULT_QUERY['COMMISSION'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Order No</td>
                                        <td><?php echo ($RESULT_QUERY['TICKET']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php };}; ?>
            </div>
            <div data-bs-parent="#tab-group-1" class="collapse" id="inout">
                <h4 class="text-center">History</h4>
                <?php
                    $SQL_HIST = mysqli_query($db,'
                        SELECT
                            IF(tb_dpwd.DPWD_TYPE = 1, "Deposit",
                                IF(tb_dpwd.DPWD_TYPE = 2, "Withdrawal", 0)
                            ) AS DPWD_TYPE,
                            tb_dpwd.DPWD_DATETIME,
                            tb_dpwd.DPWD_NOTE1,
                            tb_dpwd.DPWD_AMOUNT,
                            IF(tb_dpwd.DPWD_STS = 0, "Pending",
                                IF(tb_dpwd.DPWD_STS = -1, "Accept", "Reject")
                            ) AS DPWD_STS
                        FROM tb_dpwd
                        WHERE tb_dpwd.DPWD_MBR = '.$user1["MBR_ID"].'
                        AND tb_dpwd.DPWD_LOGIN = (SELECT ID_ACC FROM tb_racc WHERE ACC_LOGIN = "'.$LOGIN.'" LIMIT 1)
                        ORDER BY tb_dpwd.ID_DPWD DESC
                    ') or die(mysqli_error($db));
                    if(mysqli_num_rows($SQL_HIST) > 0){
                        while($HIST_RES = mysqli_fetch_assoc($SQL_HIST)){    
                            if($HIST_RES['DPWD_TYPE'] != "Withdrawal" || ($HIST_RES['DPWD_TYPE'] == "Withdrawal" && $HIST_RES['DPWD_STS'] == "Accept"))    {         
                ?>
                    <!-- <p>
                        Payments that have failed to process. Please contact support for more information
                    </p> -->
                    <div class="d-flex">
                        <div class="align-self-center me-2">
                            <h4 class="color-white font-12 font-400 p-1 px-2 mt-0 mb-3">
                                <?php if($HIST_RES["DPWD_TYPE"] == 'Deposit'){ ?>
                                    <i class="fa fa-3x fa-arrow-up color-green-dark" aria-hidden="true"></i>
                                <?php } else { ?>
                                    <i class="fa fa-3x fa-arrow-down color-red-dark" aria-hidden="true"></i>
                                <?php }; ?>
                            </h4>
                        </div>
                        <div style="align-self: center;">
                            <h6 class="align-self-center mb-n2 mt-0"><?php echo $HIST_RES["DPWD_TYPE"]?></h6>
                            <span class="color-theme opacity-30 d-block mb-0 font-11"><?php echo $HIST_RES["DPWD_DATETIME"]?></span>
                            <span class="color-theme opacity-30 d-block mb-0 font-11"><?php echo $HIST_RES["DPWD_NOTE1"]?></span>
                        </div>
                        <div class="align-self-center ms-auto">
                            <h6 class="text-end mb-n1 mt-n2">Rp <?php echo number_format($HIST_RES["DPWD_AMOUNT"], 0)?></h6>
                            <span class="slider-next badge bg-<?php if($HIST_RES["DPWD_STS"] == 'Pending'){ echo 'yellow';}elseif($HIST_RES["DPWD_STS"] == 'Accept'){ echo 'green';}else{echo 'red';}?>-dark mt-2 p-2 font-8" style="float: right;"><?php echo $HIST_RES["DPWD_STS"]?></span>
                        </div>
                    </div>
                    <hr style="margin-top: unset !important;"> 
                <?php }; }; } else { ?>
                    <span>Tidak Ada Transaksi</span>
                <?php }; ?>
            </div>
            <div data-bs-parent="#tab-group-1" class="collapse" id="doc">
                <!-- <div class="card card-style"> -->
                    <h4>Legal Document Account</h4>
                    <div class="list-group list-boxes mt-3">
                        <!-- <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/01-pilihan-produk.php?x=<?php echo $LOGIN; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Pilihan Produk</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a> -->
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/02-profil-perusahaaan-pialang-berjangka.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Profil Perusahaan Pialang Berjangka</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/03.pernyataan-telah-melakukan-simulasi.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Pernyataan Telah Melakukan Simulasi</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/04.pernyataan-pengalaman-transaksi.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Pernyataan Pengalaman Transaksi</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/05.aplikasi-pembukaan-rekening.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Aplikasi Pembukaan Rekening</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/06.dokumen-pemberitahuan-adanya-resiko.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Dokumen Pemberitahuan Adanya Resiko</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/07.perjanjian-pemberian-amanat.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Perjanjian Pemberian Amanat</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/08.trading-rules.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Trading rules</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/09.pernyataan-bertanggung-jawab-atas-kode-transaksi.php?x=<?php echo $I_HASH; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Pernyataan Bertanggung Jawab Atas Kode Transaksi</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a>
                        <!-- <a href="https://mobileibftraders.techcrm.net/doc/pdf/root/10.disclosure-statement.php?x=<?php echo $LOGIN; ?>" download class="border border-green-dark rounded-s shadow-xs">
                            <i class="fa font-20 fa-mobile color-blue-dark"></i>
                            <span>Disclosure Statement</span>
                            <u class="color-green-dark">Download</u>
                            <i class="fa fa-download color-green-dark"></i>
                        </a> -->
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
<?php }; ?>


    <?php
        include_once('../setting.php');
        $MBR_ID = $_GET['mbr_id'];
        $id_live = $_GET['id_live'];
        $day = $_GET['day'];
        if($day == 'today'){
            $filter = "AND DATE(MT4_TRADES.CLOSE_TIME) = DATE(NOW())";
        } else if($day == 'week'){
            $filter = "AND DATE(MT4_TRADES.CLOSE_TIME) <= DATE(DATE_ADD(NOW(),INTERVAL 1 WEEK))";
        } else if($day == 'month'){
            $filter = "AND DATE(MT4_TRADES.CLOSE_TIME) <= DATE(DATE_ADD(NOW(),INTERVAL 1 MONTH))";
        }
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
            FROM tb_lacc
            JOIN MT4_TRADES
            JOIN MT4_PRICES
            ON(tb_lacc.ACC_LOGIN = MT4_TRADES.LOGIN
            AND MT4_TRADES.SYMBOL = MT4_PRICES.SYMBOL)
            WHERE tb_lacc.ACC_MBR = ".$MBR_ID."
            AND MD5(MD5(tb_lacc.ID_ACC)) = '".$id_live."'
            ".$filter."
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
        <div class="accordion-body" style="color:white;">
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
    <?php
            }
        }
    ?>
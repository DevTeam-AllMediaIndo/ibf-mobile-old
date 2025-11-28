
    <?php
        include_once('../setting.php');
        $SQL_QUERY = mysqli_query($db, '
            SELECT
                tb_pricecat.PRCCAT_NAME,
                tb_price.PRC_PIC1,
                tb_price.PRC_PIC2,
                tb_price.PRC_ALIAS,
                tb_price.PRC_ALIASNAME,
                MT4_PRICES.DIRECTION,
                MT4_PRICES.BID,
                MT4_PRICES.ASK,
                MT4_PRICES.LOW,
                MT4_PRICES.HIGH,
                MT4_PRICES.DIGITS
            FROM tb_price
            JOIN tb_pricecat
            JOIN MT4_PRICES
            ON(tb_price.PRC_CAT = tb_pricecat.ID_PRCCAT
            AND tb_price.PRC_SYMBOL = MT4_PRICES.SYMBOL)
          
            #WHERE tb_pricecat.ID_PRCCAT = 4
        ');
        if ($SQL_QUERY && mysqli_num_rows($SQL_QUERY) > 0) {
            while($RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY)){
    ?>
        <tr>
            <td style="vertical-align:middle">
                <strong class="text-primary"><?php echo $RESULT_QUERY['PRC_ALIAS'] ?></strong>
            </td>
            <td style="vertical-align:middle;text-align:right;" class="<?php if($RESULT_QUERY['DIRECTION'] == 1){ echo 'text-danger'; } else { echo 'text-success'; } ?>">
                <div style="font-size: large;"><?php echo round($RESULT_QUERY['BID'], $RESULT_QUERY['DIGITS']) ?></div>
                <div style="white-space: nowrap;">H : <?php echo round($RESULT_QUERY['HIGH'], $RESULT_QUERY['DIGITS']) ?></div>
            </td>
            <td style="vertical-align:middle;text-align:right;" class="<?php if($RESULT_QUERY['DIRECTION'] == 1){ echo 'text-danger'; } else { echo 'text-success'; } ?>">
                <div style="font-size: large;"><?php echo round($RESULT_QUERY['ASK'], $RESULT_QUERY['DIGITS']) ?></div>
                <div style="white-space: nowrap;">L : <?php echo round($RESULT_QUERY['LOW'], $RESULT_QUERY['DIGITS']) ?></div>
            </td>
        </tr>
    <?php
            }
        }
    ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="page-title page-title-small">
    <h2>Market</h2>
</div>
<div class="card header-card shape-rounded" data-card-height="150">
    <div class="card-overlay bg-highlight opacity-95"></div>
    <div class="card-overlay dark-mode-tint"></div>
    <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
</div>
<div class="card card-style bg-theme pb-0">
    <div class="content" id="tab-group-1">
        <div class="tab-controls tabs-small tabs-rounded" data-highlight="bg-highlight">
            <a href="#" data-active data-bs-toggle="collapse" data-bs-target="#semua">Semua</a>
            <a href="#" data-bs-toggle="collapse" data-bs-target="#us_index">Forex</a>
            <a href="#" data-bs-toggle="collapse" data-bs-target="#index_asia">Indices</a>
            <a href="#" data-bs-toggle="collapse" data-bs-target="#foreign_exchange">Metals</a>
            <a href="#" data-bs-toggle="collapse" data-bs-target="#metals">Others</a>
        </div>
        <div class="clearfix mb-3"></div>
        <div data-bs-parent="#tab-group-1" class="collapse show" id="semua">
            <div class="table-responsive" width="100%">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Market</th>
                            <th class="text-center">Bid</th>
                            <th class="text-center">Ask</th>
                        </tr>
                    </thead>
                    <tbody id="market_home_01">
                        <?php
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
                            
                                WHERE tb_price.PRC_STS = -1
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
                        <?php };}; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div data-bs-parent="#tab-group-1" class="collapse" id="us_index">
            <div class="table-responsive" width="100%">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Market</th>
                            <th class="text-center">Bid</th>
                            <th class="text-center">Ask</th>
                        </tr>
                    </thead>
                    <tbody id="market_home_02">
                        <?php
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
                            
                                WHERE tb_pricecat.ID_PRCCAT = 4
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
                        <?php };}; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div data-bs-parent="#tab-group-1" class="collapse" id="index_asia">
            <div class="table-responsive" width="100%">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Market</th>
                            <th class="text-center">Bid</th>
                            <th class="text-center">Ask</th>
                        </tr>
                    </thead>
                    <tbody id="market_home_03">
                        <?php
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
                            
                                WHERE tb_pricecat.ID_PRCCAT = 2
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
                        <?php };}; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div data-bs-parent="#tab-group-1" class="collapse" id="foreign_exchange">
            <div class="table-responsive" width="100%">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Market</th>
                            <th class="text-center">Bid</th>
                            <th class="text-center">Ask</th>
                        </tr>
                    </thead>
                    <tbody id="market_home_04">
                        <?php
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
                            
                                WHERE tb_pricecat.ID_PRCCAT = 3
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
                                    <div style="font-size: large;"><?php echo number_format($RESULT_QUERY['ASK'], $RESULT_QUERY['DIGITS']) ?></div>
                                    <div style="white-space: nowrap;">L : <?php echo number_format($RESULT_QUERY['LOW'], $RESULT_QUERY['DIGITS']) ?></div>
                                </td>
                            </tr>
                        <?php };}; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div data-bs-parent="#tab-group-1" class="collapse" id="metals">
            <div class="table-responsive" width="100%">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Market</th>
                            <th class="text-center">Bid</th>
                            <th class="text-center">Ask</th>
                        </tr>
                    </thead>
                    <tbody id="market_home_05">
                        <?php
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
                            
                                WHERE tb_pricecat.ID_PRCCAT = 1
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
                        <?php };}; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>   
<script>
    function load_data_01(){
        $.ajax({
            method:"get",
            success:function(data){
                $("#market_home_01").html(data);
            },
            url:"ajax/home_market1.php"
        });
    }

    function load_data_02(){
        $.ajax({
            method:"get",
            success:function(data){
                $("#market_home_02").html(data);
            },
            url:"ajax/home_market2.php"
        });
    }

    function load_data_03(){
        $.ajax({
            method:"get",
            success:function(data){
                $("#market_home_03").html(data);
            },
            url:"ajax/home_market3.php"
        });
    }

    function load_data_04(){
        $.ajax({
            method:"get",
            success:function(data){
                $("#market_home_04").html(data);
            },
            url:"ajax/home_market4.php"
        });
    }

    function load_data_05(){
        $.ajax({
            url:"ajax/home_market5.php",
            method:"get",
            success:function(data){
                $("#market_home_05").html(data);
            }
        });
    }
    var var_load_data_01 = setInterval(load_data_01, 5000);
    var var_load_data_02 = setInterval(load_data_02, 6000);
    var var_load_data_03 = setInterval(load_data_03, 7000);
    var var_load_data_04 = setInterval(load_data_04, 8000);
    var var_load_data_05 = setInterval(load_data_05, 9000);
</script>
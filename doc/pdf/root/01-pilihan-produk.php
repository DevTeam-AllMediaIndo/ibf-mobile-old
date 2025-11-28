
<?php
    date_default_timezone_set("Asia/Jakarta");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../../../setting.php';
    require_once 'vendor/autoload.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $id_acc = form_input($_GET["x"]);
    
    $SQL_QUERY = mysqli_query($db, '
        SELECT
            tb_lacc.ACC_04_0_PRODUCT
        FROM tb_lacc
        JOIN tb_member
        ON(tb_member.MBR_ID = tb_lacc.ACC_MBR)
        WHERE tb_lacc.ACC_LOGIN = LOWER("'.$id_acc.'")
        LIMIT 1
    ');
    if(mysqli_num_rows($SQL_QUERY) > 0){
        $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
        $ACC_04_0_PRODUCT = $RESULT_QUERY['ACC_04_0_PRODUCT'];
    } else { $ACC_04_0_PRODUCT = ''; };
    
    $content = '
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, minimum-scale=1,0, maximum-scale=1.0">
            </head>
            <body>
                <table style="width:100%">
                    <tr>
                        <td width="50%" style="vertical-align: top; "><img src="data:image/png;base64,'.base64_encode(file_get_contents("https://allmediaindo-2.s3.ap-southeast-1.amazonaws.com/ibftrader/logoibf.png")).'" width="75%"></td>
                        <td width="50%" style="text-align:center; ">
                            <h3>PT.International Business Futures</h3>
                            <p>
                                PASKAL HYPER SQUARE BLOK D NO.45-46 JL. H.O.S COKROAMINOTO NO.25-27 BANDUNG, JAWA BARAT – 40181
                            </p>
                        </td>
                    </tr>
                </table>
                <hr>
                Produk Type : '.$ACC_04_0_PRODUCT.'
                <table>
                    <tr>
                        <td><img src="data:image/png;base64,'.base64_encode(file_get_contents("https://mobilebrokeribftrader.allmediaindo.com/assets/doc/forex.png")).'" width="100%"></td>
                        <td>&nbsp;</td>
                        <td><img src="data:image/png;base64,'.base64_encode(file_get_contents("https://mobilebrokeribftrader.allmediaindo.com/assets/doc/index.png")).'" width="100%"></td>
                    </tr>
                </table>
            </body>
        </html>
    ';

    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("PT.International Business Futures - Pilihan  Produk",array("Attachment"=>false));
    exit(0);
    
?>
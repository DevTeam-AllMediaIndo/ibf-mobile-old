
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
            tb_racc.ACC_F_PROFILE_DATE,
            tb_racc.ACC_F_PROFILE_IP
        FROM tb_racc
        JOIN tb_member
        ON(tb_member.MBR_ID = tb_racc.ACC_MBR)
        WHERE MD5(MD5(tb_racc.ID_ACC)) = "'.$id_acc.'"
        LIMIT 1
    ');
    if(mysqli_num_rows($SQL_QUERY) > 0){
        $RESULT_QUERY = mysqli_fetch_assoc($SQL_QUERY);
        $ACC_01_AGGDATE = $RESULT_QUERY['ACC_F_PROFILE_DATE'];
        $ACC_F_PROFILE_IP = $RESULT_QUERY['ACC_F_PROFILE_IP'];
    } else {
        $ACC_01_AGGDATE = '';
        $ACC_F_PROFILE_IP = '';
    };


    
    $content = '
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, minimum-scale=1,0, maximum-scale=1.0">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
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
                <!-- <table style="width:100%">
                    <tr>
                        <td width="50%" style="vertical-align: top; "><strong><small>Formulir Nomor : 107.PBK.01</small></strong></td>
                        <td width="50%" style="text-align:right; ">
                            <small>
                                Lampiran Peraturan Kepala Badan Pengawas<br>
                                Perdagangan Berjangka Komoditi<br>
                                Nomor : 107/BAPPEBTI/PER/11/2013
                            </small>
                        </td>
                    </tr>
                </table> -->
                <div style="text-align:center;vertical-align: middle;padding: 10px 0 10px 0;">
                    <h3>PROFIL PERUSAHAAN PIALANG BERJANGKA</h3>
                </div>
                <div style="border:1px solid black;padding:5px;">
                    <table style="width:100%">
                        <tr>
                            <td width="45%" style="vertical-align: top;">Nama perusahaan</td>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">PT.International Business Futures</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Alamat</td>
                            <td style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">PASKAL HYPER SQUARE BLOK D NO.45-46 JL. H.O.S COKROAMINOTO NO.25-27 BANDUNG, JAWA BARAT – 40181</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Nomor Telepon</td>
                            <td style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">02286061128</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">No Fax</td>
                            <td style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">02286061126</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">E-Mail</td>
                            <td style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">support@ibftrader.com</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Home-Page</td>
                            <td style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;"> https://ibftrader.com</td>
                        </tr>
                    </table>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Susunan Pengurus Perusahaan :</strong>
                    </div>
                    <table style="width:100%">
                        <tr>
                            <td colspan="4" style="vertical-align: top;"><div style="margin:0px 3px;"><strong>Dewan Direksi</strong></div></td>
                        </tr>
                        <tr>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 5px;">1.</div></td>
                            <td style="vertical-align: top;">President Direktur</td>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">Ernawan Sukardi</td>
                        </tr>
                        <tr>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 5px;">2.</div></td>
                            <td style="vertical-align: top;">Direktur Kepatuhan</td>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">Ilham Sukmana, SH</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="vertical-align: top;"><div style="margin:0px 3px;"><strong>Dewan Komisaris</strong></div></td>
                        </tr>
                        <tr>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 5px;">1.</div></td>
                            <td style="vertical-align: top;">Komisaris Utama</td>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">Budiman Wijaya</td>
                        </tr>
                        <tr>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 5px;">2.</div></td>
                            <td style="vertical-align: top;">Komisaris</td>
                            <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 3px;">:</div></td>
                            <td style="vertical-align: top;">A. Mufti Mardian</td>
                        </tr>
                    </table>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Susunan Pemegang Saham Perusahaan :</strong><br>
                        <ol>
                            <li>Budiman Wijaya</li>
                            <li>A. Mufti Mardian</li>
                        </ol>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nomor dan Tanggal Izin Usaha Dari Bappebti :</strong><br>
                        <table width="100%" style="margin:0 20px;">
                            <tr>
                                <td width="40%">No. 912/BAPPEBTI/SI/8/2006</td>
                                <td width="10%">&nbsp;</td>
                                <td>Tanggal : 25 Agustus 2006</td>
                            </tr>
                        </table>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nomor dan Tanggal Keanggotaan Bursa Berjangka</strong><br>
                        <table width="100%" style="margin:0 20px;">
                            <tr>
                                <td width="40%">No. SPAB - 142/BBJ/08/05</td>
                                <td width="10%">&nbsp;</td>
                                <td>Tanggal : 31 Agustus 2005</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <br>
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
                <div style="border:1px solid black;padding:5px;margin-top:45px;">
                    <div style="text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nomor dan Tanggal Keanggotaan Lembaga Kliring Berjangka</strong><br>
                        <table width="100%" style="margin:0 20px;">
                            <tr>
                                <td width="40%">No. 70/AK-KBI/I/2011</td>
                                <td width="10%">&nbsp;</td>
                                <td>Tanggal : 28 Januari 2011</td>
                            </tr>
                        </table>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nomor dan Tanggal Persetujuan Sebagai Peserta Sistem Perdagangan Alternatif</strong><br>
                        <table width="100%" style="margin:0 20px;">
                            <tr>
                                <td width="40%">No. 22/BAPPEBTI/SP/04/2011</td>
                                <td width="10%">&nbsp;</td>
                                <td>Tanggal : 21 April 2011</td>
                            </tr>
                        </table>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nama Penyelenggara Sistem Perdagangan Alternatif</strong><br>
                        <div style="margin:0 23px;">PT. Real Time Forex Indonesia</div>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Kontrak Berjangka Yang Diperdagangkan *)</strong><br>
                        <div style="margin:0 23px;">Kontrak Gulir Index Emas (KIE),Kontrak Berjangka Emas Gold 100, Kontrak Berjangka Emas Gold 250, Kontrak Berjangka Emas Gold</div>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Kontrak Derivatif Syariah Yang Diperdagangkan *)</strong><br>
                        <div style="margin:0 23px;">-</div>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Kontrak Derivatif dalam Sistem Perdagangan Alternatif *)</strong><br>
                        <div style="margin:0 23px;">CFD Mata Uang Asing ( EUR/USD, GBP/USD, AUD/USD, USD/JPY, USD/CHF ), CFD Indeks Saham ( Hangseng, Nikkei, Kospi), CFD Komoditi Emas ( XAU/USD )</div>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Kontrak Derivatif dalam Sistem Perdagangan Alternatif dengan volume minimum 0,1 (nol koma satu) lot Yang Ddiperdagangkan *)</strong><br>
                        <div style="margin:0 23px;">CFD Mata Uang Asing ( EUR/USD, GBP/USD, AUD/USD, USD/JPY, USD/CHF ), CFD Indeks Saham ( Hangseng, Nikkei, Kospi), CFD Komoditi Emas ( XAU/USD )</div>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Biaya Secara Rinci yang Di Bebankan Pada Nasabah</strong>
                        <div style="margin:0 23px;">Trading Rules (Spesifikasi Kontrak)</div>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nomor atau alamat email jika terjadi keluhan :</strong><br>
                        <div style="margin:0 23px;">(022) 86061125 / Support@ibftrader.com</div>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Sarana Penyelesaian perselisihan yang dipergunakan apabila terjadi perselisihan :</strong><br>
                        <div style="margin:0 23px;">Penyelesaian Perselisihan Mempergunakan Sarana Melalui Prosedur Sebagai Berikut.</div>
                        <ol>
                            <li>Musyawarah Mufakat/deliberation</li>
                            <li>Pengadilan Negeri/District Court</li>
                            <li>BAKTI/Commodity Futures Trading Arbitration</li>
                        </ol>
                    </div>
                </div>
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
                <div style="height:1px;"></div>
                <div style="border:1px solid black;padding:5px;margin-top:45px;">
                    <div style="text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nama-nama Wakil Pialang Berjangka yang Bekerja di Perusahaan Pialang Berjangka</strong><br>';
                        $ARR = array(
                            "1"     => "Ernawan Sukardi",
                            "2"     => "Febiyanti",
                            "3"     => "Pratika Devianti",
                            "4"     => "Agus Slamet Medya",
                            "5"     => "Tega Apria Abdi",
                            "6"     => "Nia Chusniatin",
                            "7"     => "Dinan Harjadinata",
                            "8"     => "Romi Hamdani",
                            "9"     => "Rai Anggawa",
                            "10"    => "Alvin Hilmansyah",
                            "11"    => "Evriliya Cyti Nurnaini",
                            "12"    => "Yuda Junendri R",
                            "13"    => "M. Meidy Fazria SH",
                            "14"    => "Fitri Kurnia Sari",
                            "15"    => "Soalae Rumapea",
                            "16"    => "Muhamad Ramdan Diniarsah",
                            "17"    => "Andreas Konanjaya",
                            "18"    => "Istin Selvia Ningsih",
                            "19"    => "Muhammat Aris",
                            "20"    => "Faisal Rahman",
                            "21"    => "Novi Asnuriani",
                            "22"    => "Margareth Tuasuun",
                            "23"    => "Dona Fadhillah",
                            "24"    => "Moch Ali Imron",
                            "25"    => "Rudi Pandapotan S",
                            "26"    => "Endang Yunanda",
                            "27"    => "Tetti Erlinda Gultom",
                            "28"    => "Erwin Ariyanto",
                            "29"    => "Helen Astri Kantinasari",
                            "30"    => "Vita Sari Patiska",
                            "31"    => "Adi Nugroho",
                            "32"    => "Susanti Hamzah",
                            "33"    => "Maikona",
                            "34"    => "Yoel Leonard",
                            "35"    => "Resti Ayu Wardhani",
                            "36"    => "Laraswati"
                        );

                        $content .= "<table cellPadding='5' border='0'>
                        <tbody style='vertical-align: baseline;'>
                            <tr>";
                            $no = 1;
                            foreach(array_chunk($ARR, 15) as $key => $val) :
                                $content .= "<td>";
                                foreach($val as $key2 => $val2) :
                                    $text = $no++ . ". " . $val2 . "</br>"; 
                                    $content .= $text;
                                endforeach;
                            endforeach;
                        
                        $content .="</tr></tbody></table>";
                    $content .=   '</div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nama – Nama Wakil Pialang Berjangka yang secara khusus ditunjuk oleh Pialang Berjangka untuk melakukanVerifikasi dalam rangka penerimaan Nasabah elektronik on- Line</strong><br>
                        <table width="100%" style="margin:0 20px;">
                            <tr>
                                <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 5px;">1.</div></td>
                                <td style="vertical-align: top;">Alvin Hilmansyah</td>
                            </tr>
                            <tr>
                                <td width="1%" style="vertical-align: top; text-align:center;"><div style="margin:0px 5px;">2.</div></td>
                                <td style="vertical-align: top;">Muhamad Ramdan Diniarsah</td>
                            </tr>
                        </table>
                    </div>
                    <div style="border-top:1px solid black;text-align:left;vertical-align: middle;padding: 10px 0 10px 0;">
                        <strong>Nomor Rekening Terpisah (Segregated Account) Perusahaan Pialang Berjangka:</strong><br>
                        <table width="100%" style="margin:0 20px;">
                            <tr>
                                <td style="vertical-align: top;">Bank Central Asia (Bank BCA)</td>
                                <td style="vertical-align: top;"><div style="margin:0px 5px;">IDR</div></td>
                                <td style="vertical-align: top;">008-3073966</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">Bank Central Asia (Bank BCA)</td>
                                <td style="vertical-align: top;"><div style="margin:0px 5px;">USD</div></td>
                                <td style="vertical-align: top;">008-4214210</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">Bank Mandiri</td>
                                <td style="vertical-align: top;"><div style="margin:0px 5px;">IDR</div></td>
                                <td style="vertical-align: top;">130-0088881779</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="text-align:center;margin-top:25px;">
                    <strong>PERNYATAAN TELAH MEMBACA PROFIL PERUSAHAAN PIALANG BERJANGKA</strong><br>
                    <p>Dengan mengisi kolom “YA” di bawah ini, saya menyatakan bahwa saya telah membaca dan menerima informasi
                    <strong>PROFIL PERUSAHAAN PIALANG BERJANGKA</strong>, mengerti dan memahami isinya.</p>
                </div>
                <div style="text-align:center;margin-top:25px;margin-left:25%">
                    <table>
                        <tr>
                            <td>Pernyataan Menerima</td>
                            <td style="vertical-align: top;"><div style="margin:0px 5px;">:</div></td>
                            <td><strong>YA</strong></td>
                        </tr>
                        <tr>
                            <td>Menyatakan pada tanggal</td>
                            <td style="vertical-align: top;"><div style="margin:0px 5px;">:</div></td>
                            <td><strong>'.date('Y-m-d H:i:s', strtotime($ACC_01_AGGDATE)).'</strong></td>
                        </tr>
                        <tr>
                            <td>IP Address</td>
                            <td style="vertical-align: top;"><div style="margin:0px 5px;">:</div></td>
                            <td><strong>'.$ACC_F_PROFILE_IP.'</strong></td>
                        </tr>
                    </table>
                </div>
            </body>
        </html>
    ';

    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("PT.International Business Futures - 107.PBK.01",array("Attachment"=>false));
    exit(0);
    
?>
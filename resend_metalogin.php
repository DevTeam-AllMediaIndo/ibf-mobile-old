<?php
    include_once('setting.php');
    require 'phpmailer/Exception.php';
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';
    
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    $password = '';
    $investor = '';
    $note     = 'Kirim Ulang Email';
    if(isset($_GET['x'])){
        $x = addslashes(mysqli_real_escape_string($db, stripslashes(strip_tags($_GET['x']))));

        $SQL_QUERY = mysqli_query($db,"
            SELECT
                tb_racc.ID_ACC,
                tb_racc.ACC_WPCHECK,
                (tb_acccond.ID_ACCCND) AS ID_ACCCND,
                tb_racc.ACC_TYPE,
                tb_racc.ACC_RATE,
                tb_racc.ACC_PRODUCT,
                tb_member.MBR_ID,
                tb_racc.ACC_F_APP_PRIBADI_NAMA AS MBR_NAME,
                tb_member.MBR_EMAIL,
                tb_racc.ACC_F_APP_PRIBADI_HP AS MBR_PHONE,
                tb_member.MBR_CITY,
                tb_member.MBR_IB_CODE,
                tb_ib.IB_NAME,
                tb_ib.IB_CODE,
                tb_ib.IB_CITY,
                tb_acccond.ACCCND_LOGIN,
                tb_acccond.ACCCND_AMOUNTMARGIN,
                tb_acccond.ACCCND_CASH_FOREX,
                tb_acccond.ACCCND_CASH_LOCO,
                tb_acccond.ACCCND_CASH_JPK50,
                tb_acccond.ACCCND_CASH_JPK30,
                tb_acccond.ACCCND_CASH_HK50,
                tb_acccond.ACCCND_CASH_KRJ35,
                tb_note.NOTE_NOTE,
                tb_dpwd.DPWD_AMOUNT,
                (tb_dpwd.ID_DPWD) AS ID_DPWD,
                tb_dpwd.DPWD_VOUCHER
            FROM tb_racc
            JOIN tb_member
            JOIN tb_acccond
            JOIN tb_dpwd
            JOIN tb_ib
            JOIN tb_note
            ON(tb_racc.ACC_MBR = tb_member.MBR_ID
            AND tb_member.MBR_ID = tb_acccond.ACCCND_MBR
            AND tb_racc.ID_ACC = tb_acccond.ACCCND_ACC
            AND tb_dpwd.DPWD_MBR = tb_member.MBR_ID
            AND tb_dpwd.DPWD_RACC = tb_racc.ID_ACC
            AND tb_ib.IB_ID = tb_acccond.ACCCND_IB
            AND tb_note.NOTE_MBR = tb_member.MBR_ID
            AND tb_note.NOTE_RACC = tb_racc.ID_ACC
            AND tb_note.NOTE_ACCDN = tb_acccond.ID_ACCCND
            AND tb_note.NOTE_DPWD = tb_dpwd.ID_DPWD)
            WHERE tb_racc.ACC_LOGIN = '".$x."'
            ORDER BY tb_dpwd.ID_DPWD DESC, tb_acccond.ID_ACCCND DESC
            LIMIT 1
        ") or die(mysqli_error($db));
    
        if(mysqli_num_rows($SQL_QUERY) > 0){
            $RESULT_QUERY  = mysqli_fetch_assoc($SQL_QUERY);
            // if($RESULT_QUERY["ACC_WPCHECK"] != 5){ die("<script>alert('Data Ini Telah Di Update');location.href='home.php?page=member_realacc'</script>"); }
            $MBR_NAME = $RESULT_QUERY['MBR_NAME'];
            $MBR_EMAIL = $RESULT_QUERY['MBR_EMAIL'];
            $MBR_PHONE = $RESULT_QUERY['MBR_PHONE'];
            $MBR_CITY = $RESULT_QUERY['MBR_CITY'];
            $ACCCND_LOGIN = $RESULT_QUERY['ACCCND_LOGIN'];
            $ACCCND_AMOUNTMARGIN = $RESULT_QUERY['ACCCND_AMOUNTMARGIN'];
            $ID_ACCCND = $RESULT_QUERY['ID_ACCCND'];
            $ID_DPWD = $RESULT_QUERY['ID_DPWD'];
            $ID_ACC = $RESULT_QUERY['ID_ACC'];
            $MBR_ID = $RESULT_QUERY['MBR_ID'];
            $MBR_IB_CODE = $RESULT_QUERY['MBR_IB_CODE'];
        } else {
            $MBR_NAME = '-';
            $MBR_EMAIL = '-';
            $MBR_PHONE = '-';
            $MBR_CITY = '-';
            $ACCCND_LOGIN = '0';
            $ACCCND_AMOUNTMARGIN = 0;
            $ID_ACCCND = 0;
            $ID_DPWD = 0;
            $ID_ACC = 0;
            $MBR_ID = 0;
            $MBR_IB_CODE = '';
            die("");
        };
        $TGL = getdate();
        if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('January')){ $date_month = 'Januari';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('February')){ $date_month = 'Februari';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('March')){ $date_month = 'Maret';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('April')){ $date_month = 'April';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('May')){ $date_month = 'Mai';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('June')){ $date_month = 'Juni';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('July')){ $date_month = 'Juli';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('August')){ $date_month = 'Agustus';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('September')){ $date_month = 'September';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('October')){ $date_month = 'Oktober';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('November')){ $date_month = 'November';
        } else if(strtolower(date('F', strtotime($TGL["month"]))) == strtolower('December')){ $date_month = 'Desember';
        };
    
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $setting_email_host_api;
            $mail->SMTPAuth   = true;
            $mail->Username   = $setting_email_support_name;
            $mail->Password   = $setting_email_support_password;
            $mail->SMTPSecure = $setting_email_port_encrypt;
            $mail->Port       = $setting_email_port_api;

            //Recipients
            $mail->setFrom($setting_email_support_name, $web_name);
            $mail->addAddress($MBR_EMAIL, $MBR_NAME);
            
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Real Account Information '.$web_name_full.' '.date('Y-m-d H:i:s');
            
            $mail->Body    = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html hola_ext_inject='disabled' xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>".$web_name_full."</title>
                    <style type='text/css'>
                        @media only screen and (min-device-width:600px) {
                            .content {width:600px!important;}
                        }
                        @media only screen and (max-device-width:480px) {
                            .text {font-size:12px!important;-webkit-text-size-adjust:100%!important;-moz-text-size-adjust:100%!important;-ms-text-size-adjust:100%!important;}
                            .button {font-size:16px!important;-webkit-text-size-adjust:100%!important;-moz-text-size-adjust:100%!important;-ms-text-size-adjust:100%!important;}
                        }
                    </style>
                </head>
                <body style='background-color:#cacaca'>
                    <div style='max-width: 1000px; margin: auto;padding: 20px'></div>
                    <div style='max-width: 600px; background-color:#ffffff;margin: auto;border: 1px solid #eaeaea;padding: 20px;border-radius: 5px;'>
                        <center><img src='".$setting_email_logo_linksrc."' style='height:50px'></center>

                        <div style='padding: 10px;text-align: justify;'>
                            <strong>Informasi Data Real Account</strong><br>

                            Hi <strong>".$MBR_NAME.", </strong><br>
                            
                            <ul>
                                <li>Login : ".$ACCCND_LOGIN."</li>
                                <li>Password Master : ".$password."</li>
                                <li>Password Investor : ".$investor."</li>
                            </ul>

                            Terima Kasih.


                            <br><br>
                            Dari Kami,<br>
                            ".$web_name_full." Team Support
                        </div>
                        <hr>
                        <p>
                            <small>
                                Anda menerima email ini karena Anda mendaftar di ".$setting_front_web_link." jika Anda memiliki<br>
                                pertanyaan, silahkan hubungi kami melalui email di ".$setting_email_support_name.". Anda juga dapat menghubungi<br>
                                nomor ".$setting_number_phone." 
                            </small>
                            <br>
                            <small>
                                <a href='".$setting_insta_link."'><img src='".$setting_insta_linksrc."'></a>
                                <a href='".$setting_facebook_link."'><img src='".$setting_facebook_linksrc."'></a>
                                <a href='".$setting_linkedin_link."'><img src='".$setting_linkedin_linksrc."'></a>
                            </small>
                        </p>
                        <hr>
                        <p>
                            <small>
                                <strong>Phone</strong> : <a href='tel:".$setting_office_number."'>".$setting_office_number."</a><br>
                                <strong>Support</strong> : <a href='mailto:".$setting_email_support_name."'>".$setting_email_support_name."</a><br>
                                <strong>Website</strong> : <a href='www.".$setting_front_web_link."'>".$setting_front_web_link."</a><br>
                                <strong>Address</strong> : ".$setting_central_office_address."<br>
                                <br>
                                Resmi dan diatur oleh Badan Pengawas Perdagangan Berjangka Komoditi. Nomor registrasi BAPPEBTI : 912/BAPPEBTI/SI/8/2006.
                            </small>
                        </p>
                        <hr>
                        <p style='text-align: justify;'>
                            <small>
                                <strong>PEMBERITAHUAN RESIKO:</strong><br>
                                Semua produk finansial yang ditransaksikan dalam sistem margin mempunyai resiko tinggi terhadap dana Anda. Produk finansial ini tidak diperuntukkan bagi semua investor dan Anda bisa saja kehilangan dana lebih dari deposit awal Anda. Pastikan bahwa Anda benar-benar mengerti resikonya, dan mintalah nasihat independen jika diperlukan. Lihat Pemberitahuan Resiko lengkap kami di Ketentuan Bisnis.
                            </small>
                        </p>
                    </div>
                    <div style='max-width: 1000px; margin: auto;padding: 20px'></div>
                </body>
            </html>
            ";
            $mail->send();
            //echo 'Message has been sent';

            // Message Telegram
            $mesg = 'Notif : Penetapan Akun Baru Diterima'.
            PHP_EOL.'Date : '.date("Y-m-d").
            PHP_EOL.'Time : '.date("H:i:s");
            // PHP_EOL.'======== Informasi Akun Baru =========='.
            // PHP_EOL.'Nama : '.$MBR_NAME.
            // PHP_EOL.'Email : '.$MBR_EMAIL.
            // PHP_EOL.'Voucher : '.$RESULT_QUERY['DPWD_VOUCHER'].
            // PHP_EOL.'Login : '.$RESULT_QUERY['ACCCND_LOGIN'].
            // PHP_EOL.'Margin : Rp. '.number_format($RESULT_QUERY['DPWD_AMOUNT'], 0).
            // PHP_EOL.'Rate : '.$RESULT_QUERY['ACC_RATE'].
            // PHP_EOL.'Status : Diterima'.
            // PHP_EOL.'Catatan : '.$note.
            // PHP_EOL.'By : '.$user1['ADM_NAME'].'';

            // Message Telegram
            $mesg_othr = 'Notif : Penetapan Akun Baru Diterima'.
            PHP_EOL.'Date : '.date("Y-m-d").
            PHP_EOL.'Time : '.date("H:i:s").
            PHP_EOL.'======================================='.
            PHP_EOL.'                        Informasi Akun Baru'.
            PHP_EOL.'======================================='.
            PHP_EOL.'Nama : '.$MBR_NAME.
            PHP_EOL.'Email : '.$MBR_EMAIL.
            PHP_EOL.'Voucher : '.$RESULT_QUERY['DPWD_VOUCHER'].
            PHP_EOL.'Login : '.$RESULT_QUERY['ACCCND_LOGIN'].
            PHP_EOL.'Margin : Rp. '.number_format($RESULT_QUERY['DPWD_AMOUNT'], 0).
            PHP_EOL.'Rate : '.$RESULT_QUERY['ACC_RATE'].
            PHP_EOL.'Status : Diterima'.
            PHP_EOL.'Catatan : '.$note.
            PHP_EOL.'By : '.$user1['ADM_NAME'].'';

            $request_params_dlr = [
                'chat_id' => $chat_id_dlr,
                'text' => $mesg
            ];
            http_request('https://api.telegram.org/bot'.$token_dlr.'/sendMessage?'.http_build_query($request_params_dlr));
            
            $request_params_all = [
                'chat_id' => $chat_id_all,
                'text' => $mesg
            ];
            http_request('https://api.telegram.org/bot'.$token_all.'/sendMessage?'.http_build_query($request_params_all));
            
            $request_params_othr = [
                'chat_id' => $chat_id_othr,
                'text' => $mesg_othr
            ];
            http_request('https://api.telegram.org/bot'.$token_othr.'/sendMessage?'.http_build_query($request_params_othr));
            echo "Login dan password account telah berhasil terkirim";die;
            // die("<script>alert('Login dan password account telah berhasil terkirim');location.href = 'home.php?page=member_realacc'</script>");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";die;
            // echo "Login dan password account telah berhasil terkirim";die;
            // die("<script>alert('Login dan password account tidak berhasil terkirim');location.href = 'home.php?page=member_realacc'</script>");
        }
        //die("<script>alert('Success accept');location.href = 'home.php?page=member_realacc'</script>");
    }else{ echo 1; };
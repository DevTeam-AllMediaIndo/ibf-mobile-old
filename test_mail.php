<?php
    include_once('setting.php');
    require 'phpmailer/Exception.php';
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';
    
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
                        

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = $setting_email_host_api;
        $mail->SMTPAuth   = true;
        $mail->Username   = $setting_email_support_name;
        $mail->Password   = $setting_email_support_password;
        $mail->SMTPSecure = $setting_email_port_encrypt;
        $mail->Port       = $setting_email_port_api;

        //Recipients
        $mail->setFrom($setting_email_support_name, 'PT.International Business Futures');
        $mail->addAddress('indooallmedia@gmail.com', "Anon");
        
        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmation | '.date("Y-m-d H:i:s");

        $mail->Body    = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html hola_ext_inject='disabled' xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <title>Registration Confirmation</title>
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
                <body style='background-color:#f9f9f9'>
                    <div style='max-width: 1000px; margin: auto;padding: 20px'>
                        <center><img src='https://ibftrader.allmediaindo.com/assets/img/logoibf.png' style='height:50px'></center>
                    </div>
                    <div style='max-width: 600px; background-color:#ffffff;margin: auto;border: 1px solid #eaeaea;padding: 20px;border-radius: 5px;'>
                        <div style='background-color:#f9f9f9;padding: 10px;border-radius: 5px;'>
                            <strong>Registration Info</strong>
                        </div>
                        <div style='padding: 10px;'>
                            Test
                        </div>
                    </div>
                </body>
            </html>
        ";
        $mail->send();
        echo 'Message has been sent';
        die ("<script>location.href = 'signin.php?notif=".base64_encode('check your email for OTP CODE.')."'</script>");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";die;
        // die ("<script>location.href = 'signin.php?notif=".base64_encode('check your email for OTP CODE..')."'</script>");
    }
?>
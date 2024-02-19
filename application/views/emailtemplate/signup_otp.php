
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <meta name='viewport' content='width=device-width'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title></title>
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <style>
    *{
        font-family: ' Lato', sans-serif;

    }
    p{
        color: #757575;
        line-height: 24px;
        font-size:14px
    }
    .backcolor {
      background-color: azure !important;
    }

    .brightwhite {
      background-color: white !important;
    }   
  </style>
</head>
    <body bgcolor='whitesmoke'>       
        <table  width="600px" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto; margin-right:auto; background-color: white; padding: 1%;">
            <tbody>                
                <tr>
                    <td align='center'>
                        <table  width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style="border-bottom: 1px solid #eae8e8;">
                            <tbody>
                                <tr>
                                    <td align='center' valign='top' style='background-size:cover; background-position:top; height:40px; padding-bottom: 15px;'>
                                        <table width='100%'  border='0' align='center' cellpadding='0' cellspacing='0'>
                                            <tbody>
                                                <tr>
                                                    <td align='center' style='line-height: 0px;'>
                                                        <img style='display:block; line-height:0px; font-size:0px; border:0px;' src='https://appbackend.bhooljao.com/template/admin/assets/images/dashboard/BHOOLJAO_logo.png' width='150px' height='auto' alt='logo'>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align='center'>
                        <table  width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style=' background-color: white; padding: 2%;'>
                            <tbody>
                                <tr>
                                    <td align='center' style="font-family: ' Lato', sans-serif; font-size:14px; color:#757575; line-height:24px; font-weight: 300;">
                                        <!-- <img style='display:block; line-height:0px; font-size:0px; border:0px; padding: 2%;' src='https://www.csnssoftwares.com/images/otechExp-img.png' width='350' height='auto' alt='logo'> -->
                                        <div align='center' style="font-family: ' Raleway', sans-serif; font-size:22px; font-weight: bold; color:#2a3a4b;">Welcome to Bhooljao</div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align='center'>
                        <table  width='100%' border='0' align='center' cellpadding='0' cellspacing='0' style='background-color: white; padding: 0.5% 2%;'>
                            <tbody>                            
                                <tr>
                                    <td align='left' style="font-family: ' Lato', sans-serif; font-size:14px; color:#757575; line-height:24px; font-weight: 300;">
                                        Hi <?php echo $fullname;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>                                        
                                        <p>Thank you for choosing Bhooljao. To complete your registration, please use the following OTP:</p>
                                        
                                        <div style="border: 1px solid #ccc; padding: 10px; font-size: 24px; text-align: center;">
                                            <?php echo $otp_code;?>
                                        </div>
                                        
                                        <p>Enter this OTP during the registration process to verify your email address. Please do not share this OTP with anyone for security reasons.</p>
                                        
                                        <p>If you didn't request this registration or have any concerns, please contact our support team immediately at panansathi@gmail.com.</p>
                                        
                                        <p>Thank you for choosing Bhooljao! We look forward to having you as a valued member of our community.</p>
                                        
                                        <p>Best regards,<br>Bhooljao</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align='center'>
                        <table  width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
                            <tbody>
                                <tr>
                                    <td align='center' valign='top' background='img/background.jpg' bgcolor='#032d71' style='background-size:cover; background-position:top;' >
                                        <table  width='100%' height='40' border='0' align='center' cellpadding='0' cellspacing='0'>
                                            <tbody>
                                                <tr>
                                                  <td align='center' style="font-family: ' Lato', sans-serif; line-height: 0px;color: #fff;">
                                                    Copyright <?php echo date('Y');?> Bhooljao - All Rights Reserved.
                                                  </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>        
    </body>
</html>
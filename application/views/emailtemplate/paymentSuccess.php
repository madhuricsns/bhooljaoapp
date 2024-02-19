
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <meta name='viewport' content='width=device-width'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Payment</title>
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <style>
    *{
        font-family: ' Lato', sans-serif;

    }
    ul li, ol li, p{
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
                                        <div align='center' style="font-family: ' Raleway', sans-serif; font-size:22px; font-weight: bold; color:#2a3a4b;">Payment Successful</div>
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
                                        Hello <?php echo $fullname;?>,
                                    </td>
                                </tr>
                                <tr>
                                    <td>                                        
                                        <p>We are delighted to inform you that your payment of <?php echo $paidamount;?> for <?php echo $category_name;?> has been successfully processed.</p>
                                        <p>Here are the payment details:</p>
                                        <ul>
                                            <li><strong>Transaction ID:</strong> <?php echo $transaction_id;?></li>
                                            <li><strong>Date and Time:</strong> <?php echo $date_time;?></li>
                                            <li><strong>Payment Amount:</strong> <?php echo $paidamount;?></li>
                                            <li><strong>Payment Method:</strong> <?php echo $payment_type;?></li>
                                        </ul>
                                        <p>Your purchase of <?php echo $category_name;?> is now complete, and you have access to <?php echo $category_name;?>.</p>
                                        <p>If you have any questions or concerns regarding this payment, please don't hesitate to contact our support team at panansathi@gmail.com.</p>
                                        <p>Thank you for choosing Bhooljao! We appreciate your business and look forward to serving you in the future.</p>
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
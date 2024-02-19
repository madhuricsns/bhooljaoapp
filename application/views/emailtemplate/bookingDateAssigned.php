
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <meta name='viewport' content='width=device-width'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Sign-In Verification</title>
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
                                         <img style='display:block; line-height:0px; font-size:0px; border:0px; padding: 2%;' src='https://www.csnssoftwares.com/images/otechExp-img.png' width='350' height='auto' alt='logo'> 
                                        <div align='center' style="font-family: ' Raleway', sans-serif; font-size:22px; font-weight: bold; color:#2a3a4b;">Service Details</div>
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
                                        <p>Thank you for your recent order with Bhooljao. Here are the details of your order:</p>    
                                        <h4>Order Information</h4>
                                        <ul>
                                            <li><strong>Booking Number:</strong> <?php echo $order_no;?></li>
                                            <li><strong>Order Date:</strong> <?php echo $booking_date;?></li>
                                            <li><strong>Expiry Date:</strong> <?php echo $expiry_date;?></li>
                                            <li><strong>Duration:</strong> <?php echo $duration;?></li>
                                            <li><strong>Service Name:</strong> <?php echo $category_name;?></li>
                                        </ul>
                                        <!-- <h4>Shipping Information</h4>
                                        <ul>
                                            <li><strong>Shipping Address:</strong> [Shipping Address]</li>
                                            <li><strong>Estimated Delivery Date:</strong> [Delivery Date]</li>
                                        </ul> -->
                                        <!-- <h4>Order Summary</h4>
                                        <table width="100%" cellspacing="0" cellpadding="5" border= "1px solid #eae8e8">
                                            <tr >
                                                <th >Item</th>
                                                <th >Quantity</th>
                                                <th >Price</th>
                                            </tr>
                                            <tr >
                                                <td >[Item 1 Name]</td>
                                                <td >[Item 1 Quantity]</td>
                                                <td >[Item 1 Price]</td>
                                            </tr>
                                            <tr >
                                                <td >[Item 2 Name]</td>
                                                <td >[Item 2 Quantity]</td>
                                                <td >[Item 2 Price]</td>
                                            </tr>
                                        </table> -->
                                        <p>If you have any questions or need assistance with your order, please contact our support team at panansathi@gmail.com.</p>
                                        <p>Thank you for choosing Bhooljao! We appreciate your business and hope you enjoy your purchase.</p>
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
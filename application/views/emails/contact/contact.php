<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Contact form</title>
</head>
<body>
<table style="width:600px; margin:0 auto; text-align:left; border:1px solid #d6d6d6;font-size: 15px;border-top: none;font-family: arial, sans-serif;" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <table style="width:100%; border-top: 4px solid #1e8ee2;" cellspacing="0" cellpadding="0">
                <tr>
                    <th style="padding: 5px; font-size: 30px;line-height: 21px; text-align:center;"><img src="<?php echo resize(getSession('settings')['logo'],90,50);?>" alt="<?php echo getSession('settings')['company_name'];?>" style="width:100px"></th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding:20px;">
            <table style="width:100%;">
                <tr>
                    <td style="padding-bottom: 15px;">Hello Admin,</td>
                </tr>
                <tr>
                    <td style="padding-bottom: 15px;">Name - <?php echo $firstname;?>&nbsp;<?php echo $lastname;?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 15px;">Email - <?php echo $email;?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 15px;">Website - <?php echo $website;?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 15px;">Text - <?php echo $message;?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="background:#1e8ee2; color:#fff; padding:13px; font-size:16px;" align="center">© 2020 adventuresofscubajack.com All rights reserved
        </td>
    </tr>

</table>
</body>
</html>

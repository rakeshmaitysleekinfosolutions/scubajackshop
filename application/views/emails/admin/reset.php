<!<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Reset Password</title>
</head>
<body>
<table style="width:800px;margin:0 auto;text-align:left;border:1px solid #d6d6d6;font-size:15px;border-top:none;font-family:arial,sans-serif" cellspacing="0" cellpadding="0">
    <tbody><tr>
        <td>
            <table style="background:#121212;color:#fff;width:100%;border-top:4px solid #ff0000" cellspacing="0" cellpadding="0">
                <tbody><tr>
                    <th style="padding:5px;font-size:30px;line-height:21px;text-align:center"><img src="<?php echo base_url();?>assets/theme/light/img/scuba-logo.png" alt="" style="width:100px" class="CToWUd"></th>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td style="padding:20px">
            <table style="width:100%">
                <tbody><tr>
                    <td style="padding-bottom:15px">
                        <h2>Hi,</h2>
                        <p>Your login credentials are as below.</p><p>
                        </p><p>Email : <a href="mailto:<?php echo ($email) ? $email : '';?>" target="_blank"><?php echo ($email) ? $email : '';?></a><br>Password : <?php echo ($password) ? $password : '';?></p>
                        <p>Please click on the below link to verify your account.</p>
                        <p><b>Click <a href="<?php base_url('admin');?>" target="_blank" >here</a></b></p>
                        <p></p><p></p></td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td style="background:#ff0000;color:#fff;padding:13px;font-size:16px" align="center">2020 Copyright Subajack</td>
    </tr>
    </tbody></table>
</body>
</html>
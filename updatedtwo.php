<?php
//Include required PHPMailer files
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Create instance of PHPMailer
$mail = new PHPMailer();
//Set mailer to use smtp
$mail->isSMTP();
//Define smtp host
$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
$mail->SMTPSecure = "tls";
//Port to connect smtp
$mail->Port = "587";
//Set gmail username
$mail->Username = "pulak2164@gmail.com";
//Set gmail password
$mail->Password = "pulak148157";
//Email subject
$mail->Subject = "Update Information from Vaccine Registration BD";
//Set sender email
$mail->setFrom("pulak2164@gmail.com");
//Enable HTML
$mail->isHTML(true);




$mysqli = new mysqli ('localhost', 'root', '', 'mydb');


    $otp = $mysqli->query("select * from `user_information` where `user_information`.`RegistrationNO` in (SELECT ID FROM MSG1)");

    while ($ll = $otp->fetch_assoc())
    {
        //Email body
        $mail->Body = "Your Vaccine DOSE 2 Date is Updated. Please Check.";

        //Add recipient
        $mail->addAddress($ll["Email"]);
        //Finally send email

        if ( $mail->send() ) 
        {
                Echo "Successfully send"."<br>";         
                            
        }
        else
        {
            Echo "Sorry, Mailer Error";

        }
    }
    $tt = $mysqli->query("truncate table msg1\n");
    if($tt)
    {
        echo "Truncated";
    }




    
?>
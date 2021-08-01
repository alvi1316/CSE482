<?php
    require 'mailer/PHPMailer.php';
    require 'mailer/SMTP.php';
    require 'mailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Helper{

        function sendNewPassword($to,$newPass){
            $mail = new PHPMailer();
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "StartTLS";
			$mail->Port = "587";
			$mail->Username = "299spring2020@gmail.com";
			$mail->Password = "cse299project";
			$mail->Subject = "Writter Portal reset password!";
			$mail->setFrom('299spring2020@gmail.com');
			$mail->isHTML(true);
			$mail->Body = "<h1 style=\"color: #20B2AA;\">Dear user!</h1><p>You have requested to change the password of the Writter account. "
							. "We have assigned a new password for your account.</p>"
							. "<p>The new password for your account is: <b>". $newPass ."</b></p>";

			$mail->addAddress($to);
			if($mail->send()){
                $mail->smtpClose();
				return true;
			}else{
                $mail->smtpClose();
				return false;
			}
        }

        function generateNewPassword(){
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $number = '0123456789';
            $s1 = substr(str_shuffle($chars), 0, 4);
            $s2 = substr(str_shuffle($number), 0, 4);
            return ($s1.$s2);
        }
    }

?>
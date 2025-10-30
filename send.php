<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";
require_once "PHPMailer/src/Exception.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $fleet = $_POST["fleet"] ?? '';
    $phone = $_POST["phone"] ?? '';
    $message = $_POST["message"] ?? '';

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'mail.travels.in'; // SMTP server for your domain
        $mail->SMTPAuth = true;
        $mail->Username = 'support@travels.in'; // your domain email
        $mail->Password = 'YOUR_EMAIL_PASSWORD'; // replace with your actual password
        $mail->SMTPSecure = 'ssl'; // use 'tls' if SSL fails
        $mail->Port = 465; // or 587 for TLS

        // Sender and Recipient
        $mail->setFrom('support@travels.in', ' Travels');
        $mail->addAddress('support@travels.in'); // you’ll receive message here
        $mail->addReplyTo($email, $name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Enquiry from $name";
        $mail->Body = "
            <h2>New Enquiry Details</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Fleet:</strong> $fleet</p>
            <p><strong>Message:</strong> $message</p>
        ";

        // Send Email
        $mail->send();
        echo "<h3 style='color:green;'>✅ Message sent successfully! We will contact you soon.</h3>";
    } catch (Exception $e) {
        echo "<h3 style='color:red;'>❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}</h3>";
    }
}
?>

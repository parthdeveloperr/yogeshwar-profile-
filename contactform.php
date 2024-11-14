<?php
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

header('Content-Type: application/json');
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';
require_once 'yogeshwar-all-config.php';
require_once 'yogeshwar-response-function.php';

// Get form data
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
$product = isset($_POST['product']) ? $_POST['product'] : '';
$form_name = isset($_POST['form_name']) ? $_POST['form_name'] : '';
$recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';


// Initialize an error array
$error = [];

// Validate form fields
validate($name, 'name');
validate($contact_number, 'contact_number');
validate($recaptchaResponse, 'g-recaptcha-response');


if ($form_name == 'quotationform') {
    validate($email, 'email');
    validate($message, 'message');
    validate($subject, 'subject');
    validate($product, 'product');
}

// Check if there are any errors
if (!empty($error)) {
    // Return error response and stop script execution
    echo errorResponse($error, 422);
    exit;  // Ensure the script stops after sending the response
}


// Verify the CAPTCHA response with Google
$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$verifyData = [
    'secret' => $RECAPTCHA_SECRET_KEY,
    'response' => $recaptchaResponse,
    'remoteip' => $_SERVER['REMOTE_ADDR']
];

$response = file_get_contents($verifyUrl . '?' . http_build_query($verifyData));
$responseKeys = json_decode($response, true);

if (intval($responseKeys['success']) !== 1 || $responseKeys['score'] < 0.7) {

    // reCAPTCHA failed, send error response
    echo successResponse(500, 'Recaptcha verification Failed! Please try again some time later');
    exit;
}


$emailMessage = "<tr>
                <td>Name</td>
                <td>: </td>
                <td>$name</td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td>: </td>
                <td>$contact_number</td>
            </tr>
";

if (!empty($email)) {
    $emailMessage .= "<tr>
                    <td>Email</td>
                    <td>: </td>
                    <td>$email</td>
                </tr>
    ";
}
if (!empty($subject)) {
    $emailMessage .= "<tr>
                    <td>Subject</td>
                    <td>: </td>
                    <td>$subject</td>
                </tr>
    ";
}
if (!empty($product)) {
    $emailMessage .= "<tr>
                    <td>Product</td>
                    <td>: </td>
                    <td>$product</td>
                </tr>";
}


if (!empty($message)) {
    $emailMessage .= "<tr>
                    <td>Requirements</td>
                    <td>: </td>
                    <td>$message</td>
                </tr>";
}






$emailbody = buildEmailBody($emailMessage);

 
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


//Server settings
$mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host = $MAIL_HOST;                     //Set the SMTP server to send through
$mail->SMTPAuth = true;                                   //Enable SMTP authentication
$mail->Username = $MAIL_USERNAME;                     //SMTP username
$mail->Password = $MAIL_PASSWORD;                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port = $MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//Recipients
$mail->setFrom($MAIL_FROM_ADDRESS);
$mail->addAddress("rj261197@gmail.com");
$mail->addBCC($MAIL_BCC);

//Attachments
// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments


//Content
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = ($form_name ==  'quotationform') ? 'Get A Quote' : 'CallBack';
$mail->Body = $emailbody;

if ($mail->send()) {
    echo successResponse(200, 'Thank You! Our representative will contact you soon.');
    exit;
} else {
    echo successResponse(500, 'Something Went wrong! please, try again after some time');
    exit;
}

}






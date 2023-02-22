
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once '/var/www/html/PHPMailer-master/src/Exception.php';
require_once '/var/www/html/PHPMailer-master/src/PHPMailer.php';
require_once '/var/www/html/PHPMailer-master/src/SMTP.php';


// Include the PHPMailer classes
// require("PHPMailer-master\src\Exception.php");
// require("PHPMailer-master\src\PHPMailer.php");
// require("PHPMailer-master\src\SMTP.php");

// Set headers for cross-origin requests and JSON response
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');
header('Access-Control-Max-Age: 1728000');
header('Content-Type: application/json');

// Create a new object to hold the response message
$response = new stdClass();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect values from input fields
  $receiver_email = $_POST['email'] ?? null; 
  $file_url = $_POST['url'] ?? null;
  // Check if required fields are set
  if ($receiver_email &&  $file_url) {
    // Set up email parameters
    $sender_name = "Spritle Train Agent";
    $sender_email = "noreply@mailer.org";
    $username = "canteentransaction@mountzion.ac.in";
    $password = "klrmqiqakqcyjbdo";
    $subject = "Ticket Booked.";

    $message = "Thanks for choosing Spritle Ticket Booking<br>" .
    "Have a safe Journey<br>" .
 
   "<br><br>" .
   "<br><br>" .
    
    "Best regards,<br>" .
    "Ramesh Kannan<br>" .
    "Spritle Ticket Booking Team";


    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Configure SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = $username;
    $mail->Password = $password;

    // Set email parameters
    $mail->setFrom($sender_email, $sender_name);
    $mail->addAddress($receiver_email);
    $mail->Subject = $subject;
    $mail->msgHTML($message);
    


    // Download the file contents from the URL
    $file_contents = file_get_contents($file_url);
    

    

    $mail->addStringAttachment($file_contents, 'Ticket.pdf');

    // Add the attachment to the email
    // $mail->addAttachment($file_path);

    // Send the email
    if ($mail->send()) {
      $response->message = "Email sent successfully.";
      $response->session_status = 200;
    } else {
      $response->error = "Unable to send email: " ;
      $response->session_status= 404;
    }
  } else {
    $response->error = "Email or file not set.";

  }
} else {
  $response->error = "Invalid request method.";
}

// Convert the response object to JSON format and send it to the client
echo json_encode($response);

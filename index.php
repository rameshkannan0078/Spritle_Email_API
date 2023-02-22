
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer classes
// require("PHPMailer-master\src\Exception.php");
// require("PHPMailer-master\src\PHPMailer.php");
// require("PHPMailer-master\src\SMTP.php");

require_once '/var/www/html/PHPMailer-master/src/Exception.php';
require_once '/var/www/html/PHPMailer-master/src/PHPMailer.php';
require_once '/var/www/html/PHPMailer-master/src/SMTP.php';


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
  $receiver_email = $_POST['email'] ?? null; // Use null coalescing operator to set default value if 'email' is not set
  $receiver_password= $_POST['password'] ?? null; // Use null coalescing operator to set default value if 'password' is not set

  // Check if required fields are set
  if ($receiver_email && $receiver_password) {
    // Set up email parameters
    $sender_name = "Spritle Train Agent";
    $sender_email = "noreply@mailer.org";
    $username = "canteentransaction@mountzion.ac.in";
    $password = "klrmqiqakqcyjbdo";
    $subject = "Account Approval.";

    $message = "User Credentials :<br>" .
    "Email: $receiver_email<br>" .
    "Password: $receiver_password<br><br>" .
    "Dear user,<br><br>" .
    "We're thrilled to welcome you to Spritle Ticket Booking! Our mission is to provide you with the best possible experience when it comes to booking tickets for your favorite events.<br><br>" .
    "With Spritle Train Ticket Booking, you'll be able to easily browse through a wide range of train schedules and routes, from local to long-distance trains. Our user-friendly interface makes it easy to find and book the tickets you need, and our dedicated customer support team is always available to answer any questions you may have regarding your train journey.<br><br>".
    "To get started, simply log in to your account using your email ($receiver_email) and password ($receiver_password), and browse through our tickets. Once you've found the event you're interested in, simply select the number of tickets you need and complete the checkout process. We'll send your tickets to your email address as soon as your purchase is complete.<br><br>" .
    "Thank you for choosing Spritle Ticket Booking, and we look forward to serving you in the future!<br><br>" .
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

    // Send the email
    if ($mail->send()) {
      $response->message = "Email sent successfully.";
      $response->session_status = 200;
    } else {
      $response->error = "Unable to send email: " ;
      $response->session_status= 404;
    }
  } else {
    $response->error = $receiver_email;

  }
} else {
  $response->error = "Invalid request method." . $receiver_email;
}

// Convert the response object to JSON format and send it to the client
echo json_encode($response);
?>
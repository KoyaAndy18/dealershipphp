<?php

session_start();

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    

   /*1st step formhandler , make sure to get all the column available from sql and basically 
     just make them a variable and use superglobal $_POST[''];*/
try {
    require_once "dbhandlerdealership.php";     //step 2 Linking database using require_once
    $query = "INSERT INTO messages (first_name, last_name, email, message) VALUES (:first_name, :last_name, :email, :message)"; 
    //in 
    $stmt = $pdo->prepare($query);   /*step 3 we are preparing the pdo from the database for execution
    meaning to say, we are using the variable query to */

     // Bind the parameters to the statement
     $stmt->bindParam(':first_name', $first_name);
     $stmt->bindParam(':last_name', $last_name);
     $stmt->bindParam(':email', $email);
     $stmt->bindParam(':message', $message);

     // Execute the query to insert data into the database
     $stmt->execute();
     $_SESSION['success'] = "Your message has been sent successfully!";

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'andydawsiya@gmail.com'; // Your Gmail address
    $mail->Password = 'rqpdwvlbnquvfawf'; // Your Gmail password or app-specific password
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email settings
    $mail->setFrom('andydawsiya@gmail.com', 'Andy'); // Sender email and name
    $mail->addAddress($email, "$first_name $last_name"); // Recipient email and name
    $mail->Subject = 'Message Received Confirmation';
    $mail->Body = "Hello $first_name $last_name,\n\nThank you for your message. We will get back to you soon.\n\nMessage:\n$message";
    $mail->isHTML(false); // Set to true if you want to use HTML email

    if ($mail->send()) {
        header("Location: index.html?success=true"); // Redirect on success
        exit();
    } else {
        throw new Exception('Mail could not be sent. Error: ' . $mail->ErrorInfo);
    }
} catch (PDOException $e) {
    // Store error in session if database operation fails
    $_SESSION['error'] = "Database query failed: " . $e->getMessage();
    header("Location: index.html");
    exit();
} catch (Exception $e) {
    // Store error in session if email sending fails
    $_SESSION['error'] = "Mail sending failed: " . $e->getMessage();
    header("Location: index.html");
    exit();
}
}
header("Location: index.html"); // Redirect if the request method is not POST
exit();


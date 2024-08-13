<?php
// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate form data
    $errors = [];
    if (empty($name) || strlen($name) < 4) {
        $errors[] = "Please enter at least 4 characters for your name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($subject) || strlen($subject) < 4) {
        $errors[] = "Please enter at least 4 characters for the subject.";
    }
    if (empty($message)) {
        $errors[] = "Please write something in the message.";
    }

    if (!empty($errors)) {
        // Return errors to the user
        echo "<div id='errormessage'>" . implode("<br>", $errors) . "</div>";
    } else {
        // Recipient email address
        $to = "kshitijsingh823@gmail.com"; // Replace with your email address

        // Email subject and body
        $email_subject = "Contact Form Submission: " . $subject;
        $email_body = "You have received a new message from the contact form on your website.\n\n";
        $email_body .= "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Subject: $subject\n";
        $email_body .= "Message:\n$message\n";

        // Email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send email
        if (mail($to, $email_subject, $email_body, $headers)) {
            echo "<div id='sendmessage'>Your message has been sent. Thank you!</div>";
        } else {
            echo "<div id='errormessage'>There was an error sending your message. Please try again later.</div>";
        }
    }
} else {
    echo "<div id='errormessage'>Invalid request.</div>";
}
?>

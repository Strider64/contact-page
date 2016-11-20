<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/connect/connect.php';
$message = NULL;
$submit = filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (isset($submit) && $submit === 'submit') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $subject = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $mail = new PHPMailer();
    $mail->Host = EMAIL_HOST; // You're email host (I'm using a constant using the define() function):

    if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
        $mail->isSmtp(); // Local Host:
        $mail->Port = EMAIL_PORT; // Local Host Port: (Usually 587)
    } else {
        $mail->isSendMail(); // Remote Host:
    }

    $mail->SMTPAuth = true;
    $mail->Username = EMAIL_ADDRESS; // SMTP username:
    $mail->Password = EMAIL_PASSWORD; // SMTP password:
    $mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted:   

    $mail->From = $email;
    $mail->FromName = $name;
    $mail->addAddress('sample@email.com');
    $mail->Subject = $subject;
    $mail->Body = '<p style="color:#3F4E70;font-family: Arial, Helvetica, sans-serif;font-size: 1.2rem; line-height: 1.5;">' . $comments . '</p><p style="color:#3F4E70;font-family: Arial, Helvetica, sans-serif;font-size: 1.2rem; line-height: 1.5;">' . $phone . '</p>';
    $mail->isHTML(true);

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;
    } else {
        $message = 'Data Successfully Sent!';
    }
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/stylesheet.css">
        <title>Contact Form Version 1.0</title>
    </head>
    <body>
        <div class="header">
            <h1>PHP Contact Form</h1>'
        </div>
        <form id="contact" action="index.php" method="post"  autocomplete="on">

            <fieldset>

                <legend><?php echo (isset($message)) ? $message : 'Contact Details'; ?></legend>

                <label for="name" accesskey="U">Your Name</label>
                <input name="name" type="text" id="name" placeholder="Enter your name" required="required" />

                <label for="email" accesskey="E">Email</label>
                <input name="email" type="email" id="email" placeholder="Enter your Email Address"  required="required" />

                <label for="phone" accesskey="P">Phone <small>(optional)</small></label>
                <input name="phone" type="tel" id="phone" size="30" placeholder="Enter your phone number" />

                <label for="website" accesskey="W">Website <small>(optional)</small></label>
                <input name="website" type="text" id="website" placeholder="Enter your website address" />

            </fieldset>

            <fieldset>

                <legend>Your Comments</legend>

                <div class="radioBlock">
                    <input type="radio" id="radio1" name="reason" value="support" checked>
                    <label class="radioStyle" for="radio1">support</label>
                    <input type="radio" id="radio2" name="reason" value="advertise">
                    <label class="radioStyle" for="radio2">advertise</label>  
                    <input type="radio" id="radio3" name="reason" value="error">
                    <label class="radioStyle" for="radio3">Report a Bug</label>    
                </div>

                <label class="textBox" for="comments">Comments</label>
                <textarea name="comments" id="comments" placeholder="Enter your comments" spellcheck="true" required="required"></textarea>             

            </fieldset>

            <input type="submit" name="submit" value="submit">

        </form>
    </body>
</html>

<?php
//files required for sending email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('Exception.php');
require('PHPMailer.php');
require('SMTP.php');

function sendEmail($email) {
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; // or 587
    $mail->IsHTML(true);
    $mail->Username = ""; // gmail username/email id
    $mail->Password = ""; // gmail account password
    $mail->SetFrom(""); // gmail email id from which email has to be send
    $mail->Subject = "Test";
    $mail->Body = "We welcome you to our community";
    $mail->AddAddress($email);
    $result = $mail->Send();
    return $result;
}

function connect() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        $msg = "Connection to database failed. Please try again later";
        return $msg;
    }
}
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once ("Methods/functions.php");
    include_once ("Methods/conn.php");
    global $conn;
    extract($_POST);

    $emailRegex = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    $nameRegex = '/^[a-zA-Z\s]{1,25}$/';
    $textAreaRegex = '/^[a-zA-Z0-9\s.,!?]{1,250}$/';

    $errors = [];

    if (!preg_match($emailRegex, $email)) {
        $errors[] = "Invalid email address";
    }

    if (!preg_match($nameRegex, $name)) {
        $errors[] = "Invalid name";
    }

    if (!preg_match($nameRegex, $surname)) {
        $errors[] = "Invalid surname";
    }

    if (!preg_match($nameRegex, $subject)) {
        $errors[] = "Invalid subject";
    }

    if (!preg_match($textAreaRegex, $message)) {
        $errors[] = "Invalid textarea content";
    }

    if (!empty($errors)) {
        $errorQueryString = http_build_query(['errors' => $errors]);
        header("Location: contact.php?$errorQueryString");
        exit();
    }else{
        $query="INSERT INTO contact (fname_contact,lname_contact,email_contact,subject,message)
                                VALUES(:name,:lname,:email,:subject,:message)";

        $stmt=$conn->prepare($query);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':lname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);

        $stmt->execute();
        redirect("contact.php?message=Your message has been recived");
    }
} else {
    redirect("404.php");
}

?>

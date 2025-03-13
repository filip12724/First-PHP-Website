<?php
session_start();

include_once("Methods/functions.php");

if (isPost()) {
    include_once("Methods/conn.php");

    try {
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];

        $Mistakes = [];
        $emailRegex = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

        if (!checkRegex($emailRegex, $email)) {
            $Mistakes["Email"] = "Invalid email format";
        }

        if (!empty($Mistakes)) {
            echo json_encode(["errors" => $Mistakes]);
            http_response_code(400);
        } else {
            $md5Passwd = md5($passwd);
            $user = checkLogin($email, $md5Passwd);

            if (!empty($user)) {
                $_SESSION['user'] = $user;
                echo json_encode(["role" => $user->role]);
                http_response_code(200);
            } else {
                echo json_encode(["error" => "Login failed. Please check your credentials."]);
                http_response_code(401);
            }
        }
    } catch (PDOException $exception) {
        error_log("Database error: " . $exception->getMessage());
        echo json_encode(["error" => "Internal Server Error"]);
        http_response_code(500);
    }
} else {
    echo json_encode(["error" => "Method Not Allowed"]);
    http_response_code(405);
}
?>

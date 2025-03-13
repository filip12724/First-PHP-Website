<?php
session_start();
header("Content-type: application/json");

include_once("Methods/functions.php");
if (isPost()) {
    include_once("Methods/conn.php");


    try{
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $passwd = $_POST['passwd'];

        $Mistakes=[];
        $nameRegex = "/^[A-Z][a-z]{1,24}$/";
        $emailRegex = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $phoneRegex = '/^(\d){8,30}$/';
        $addressRegex = '/^[A-Za-z0-9\s\.,#-]{1,35}$/';


        if(!checkRegex($nameRegex,$fname)){
            $Mistakes["First Name"]="Invalid name format";
        }

        if(!checkRegex($nameRegex, $lname)){
            $Mistakes["Last Name"] = "Invalid last name format";
        }

        if(!checkRegex($emailRegex, $email)){
            $Mistakes["Email"] = "Invalid email format";
        }

        if(!checkRegex($phoneRegex, $phone)){
            $Mistakes["Phone"] = "Invalid phone number format";
        }

        if(!checkRegex($addressRegex, $address)){
            $Mistakes["Address"] = "Invalid address format";
        }

        if(!empty($Mistakes)){
            $_SESSION['errors']=$Mistakes;
            header("Location: register.php");
        }
        else{
            $md5Passwd=md5($passwd);

            $insertCustomer=insertCustomer($fname,$lname,$email,$phone,$address,$md5Passwd,2);

            if($insertCustomer){
                $response = ["message" => "Your information has been successfully received."];
                echo json_encode($response);
                http_response_code(200);
            }
        }
    }
    catch (PDOException $exception){
        var_dump($exception);
        http_response_code(500);
    }

} else {

    http_response_code(404);

}
?>

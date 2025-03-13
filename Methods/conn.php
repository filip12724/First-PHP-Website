<?php


define("SERVER", "localhost");
define("DATABASE", "sajt");
define("USERNAME", "root");
define("PASSWORD", "");



try {
    $conn = new PDO("mysql:host=" . SERVER . ";dbname="
        . DATABASE . ";charset=utf8", USERNAME, PASSWORD);

    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}


?>
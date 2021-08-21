<?php
/*
Project Name: Live Chat Apllication
App Version: 1.0
Author: https://github.com/BusybrainDotNet
*/
//required files
  require __DIR__.'/../config/connect.php';
  require __DIR__.'/UserRegLog.php';
//open database connection
    $database = new dbConnect();
    $db = $database->openConnection();
//instantiate a new instance of UserRegLog Class
    $validate = new UserRegLog($db);


/*.................User Login...................................*/


if (isset($_POST['login'])) {
//Get form inputs
    $user = trim($_POST['user']);
    $password = trim($_POST['password']);
    $code = mt_rand(101010,900909);
    $lastlogin = date('Y-m-d H:i:s');
    $login_status = 'Logged_in';
    try {      // Login User...
        $data = $validate->loginUser($user, $password, $code, $login_status, $lastlogin);
            $response = array(
            "type" => "success",
            "message" => "Successful<br><br>You Will Be Redirected...<i class='fa fa-spinner fa-spin'></i>"
            );
        } catch (Exception $e) {
        $response = array(
        "type" => "error",
        "message" => $e->getMessage()
        );  
    }
}


try {
    
} catch (Exception $e) {
    
}

/*.................User Password Reset..................................*/


if (isset($_POST['pass'])) {
//Get form inputs
    $user = trim($_POST['user']);
    try {      // Login User...
        $data = $validate->passRequest($user);
            $response = array(
            "type" => "success",
            "message" => "Successful<br><br>Check Your Email For A Password Reset Link... <i class='fa fa-spinner fa-spin'></i>"
            );   
    } catch (Exception $e) {
        $response = array(
        "type" => "error",
        "message" => $e->getMessage()
        );  
    }
}



/*.................User Verification Code...............................*/


if (isset($_POST['verify'])) {
//Get form inputs
    $user = trim($_POST['user']);
    $code = trim($_POST['code']);
    try {      // Login User...
        $data = $validate->authenticate($user, $code);
            $response = array(
            "type" => "success",
            "message" => "Successful<br><br>You Will Be Redirected To Your Dashboard... <i class='fa fa-spinner fa-spin'></i>"
            );   
    } catch (Exception $e) {
        $response = array(
        "type" => "error",
        "message" => $e->getMessage()
        );  
    }
}

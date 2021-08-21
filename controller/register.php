<?php
/*
Project Name: Live Chat Apllication
App Version: 1.0
Author: https://github.com/BusybrainDotNet
*/
//mandatories files
  require __DIR__.'/../config/connect.php';
  require __DIR__.'/UserRegLog.php';

//open database connection
    $database = new dbConnect();
    $db = $database->openConnection();

//instantiate a new instance of UserRegLog Class
	$validate = new UserRegLog($db);

if (isset($_POST['join'])) {

//Get form inputs
	$user_id = trim($_POST['user_id']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$c_password = trim($_POST['c_password']);
// Derive the code by shuffle...
	$length = 6;
  $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$newcode = substr(str_shuffle($chars), 0, $length);
	$code = base64_encode($newcode);
	try {
		// Register A User And Send Confirmation Email...
		$data = $validate->validateUser($user_id, $email, $password, $c_password, $code);
		if ($data == true) {
			$response = array(
				"type" => "success",
				"message" => "Your Account Has Been Created<br><br>Check Your Email To Continue... <i class='fa fa-spinner fa-spin'></i>"
				);	
		}
	} catch (Exception $e) {
		$response = array(
		"type" => "error",
    	"message" => $e->getMessage()
        );	
	}
}

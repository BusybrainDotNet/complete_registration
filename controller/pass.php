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

if (isset($_POST['setpass'])) {

//Get URL inputs
	$email = trim($_POST['email']);
	$code = trim($_POST['code']);
	$password = trim($_POST['password']);

	try {
		$data = $validate->newPassReset($email, $code, $password);
		
		if ($data == true) {
			$response = array(
			"type" => "success",
			"message" => "Your Password Has Been Reset<br><br>You Can Login Now...<i class='fa fa-spinner fa-spin'></i>"
			);
			}
		}catch (Exception $e) {
		$response = array(
		"type" => "error",
    	"message" => $e->getMessage()
    );	
	}
}

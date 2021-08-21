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

if (isset($_GET['u_s']) && isset($_GET['p']) && isset($_GET['e']) && isset($_GET['c'])) {

//Get form inputs
	$user_status = trim($_GET['u_s']);
	$email = trim($_GET['e']);
	$profile = trim($_GET['p']);
	$code = trim($_GET['c']);

	try {
		// Register A User And Send Confirmation Email...
		$data = $validate->setUpUser($user_status, $email, $profile, $code);
		if ($data == true) {
			$response = array(
					"type" => "success",
					"message" => "Your Account Is Now Confirmed<br><br>You Can Login Now...<i class='fa fa-spinner fa-spin'></i>"
				);	
		}

	} catch (Exception $e) {
		$response = array(
		"type" => "error",
    	"message" => $e->getMessage()
        );	
	}
}

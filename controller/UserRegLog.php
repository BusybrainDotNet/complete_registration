<?php
/*
Project Name: Live Chat Apllication
App Version: 1.0
Author: https://github.com/BusybrainDotNet
*/
class UserRegLog
{
//Setting Environment Functionality
	//Declaring variables
	private $id;
	private $user_id;
	private $email;
	private $password;
	private $profile;
	private $code;
	private $user_status;
	private $login_status;
	private $lastlogin;
	private $created;

//Database Connection
	private $con;
	private $db_table = "chat_user";

//Function to construct pdo interface for connection
	public function __construct($db)
	{
		$this->con = $db;
		$this->lastlogin = date("y-m-d H:i:s");
		$this->created = date("y-m-d H:i:s");
	}

//ID 
	function setId($id)
	{
		$this->id = $id;
	}

	function getId()
	{
		return $this->id;
	}

//User ID
	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

//User Email
	function setUserEmail($email)
	{
		$this->email = $email;
	}

	function getUserEmail()
	{
		return $this->email;
	}

//User Password
	function setUserPassword($password)
	{
		$this->password = $password;
	}

	function getUserPassword()
	{
		return $this->password;
	}

//User Profile
	function setUserProfile($profile)
	{
		$this->profile = $profile;
	}

	function getUserProfile()
	{
		return $this->profile;
	}

//User code
	function setUsercode($code)
	{
		$this->code = $code;
	}

	function getUsercode()
	{
		return $this->code;
	}
//User Account Status
	function setUserStatus($user_status)
	{
		$this->user_status = $user_status;
	}

	function getUserStatus()
	{
		return $this->user_status;
	}

//User Current Login_Status
	function setUserLogin_Status($login_status)
	{
		$this->login_status = $login_status;
	}

	function getUserLogin_Status()
	{
		return $this->login_status;
	}

//Time Of User Last Login
	function setUserLast_Login($lastlogin)
	{
		$this->lastlogin = $lastlogin;
	}

	function getUserLast_Login()
	{
		return $this->lastlogin;
	}

//Time User Was Created
	function setUserCreated($created)
	{
		$this->created = $created;
	}

	function getUserCreated()
	{
		return $this->created;
	}


/*.................Form Validation ...............................*/

	public function validateUser($user_id, $email, $password, $c_password, $code)
    {  
//check User Name
       if (empty($user_id))
        {	// show user error
            throw new Exception ("Name Cannot Be Empty...<i class='fa fa-spinner fa-spin'></i>");    
        }elseif (strlen($user_id) < 5)
        {	// show user error
            throw new Exception ("User Name Too Short...<i class='fa fa-spinner fa-spin'></i>");    
        }elseif (strlen($user_id) > 50)
        {	// show user error
            throw new Exception ("User Name Too Long...<i class='fa fa-spinner fa-spin'></i>");    
        }
//check if Email is empty
       if (empty($email))
        {	// show user error
            throw new Exception ("Email Cannot Be Empty...<i class='fa fa-spinner fa-spin'></i>");    
        }
//check if Password
       if (empty($password))
        {	 // show user error
            throw new Exception ("Password Cannot Be Empty...<i class='fa fa-spinner fa-spin'></i>");    
        }elseif (empty($c_password))
        {	// show user error
           throw new Exception ("Password Cannot Be Empty...<i class='fa fa-spinner fa-spin'></i>");
        }elseif ($password != $c_password)
        {	// show user error
           throw new Exception ("Password Must Be Same...<i class='fa fa-spinner fa-spin'></i>");
        }
//check Email format
        $email = $this->validateEmail($email);
        if ($email == false) {
    // show user error
            throw new Exception("Invalid Email...<i class='fa fa-spinner fa-spin'></i>"); 
        }elseif ($this->sanitizeEmail($email) === false) {
    // show user error
            throw new Exception("Compromised Email...<i class='fa fa-spinner fa-spin'></i>"); 
        }
//check User Name format
        if ($this->sanitizeUser_id($user_id) === false) {
    // show user error
            throw new Exception("Compromised User Name...<i class='fa fa-spinner fa-spin'></i>"); 
        }
//Checking email in our records
        $user = $this->userExistsInDB($user_id, $email);
        if ($user == false) {    // code...
            $user = $this->insertUserInDB($user_id, $email, $password, $code);
        }
// Return result...
        return $user;
    }

//Function to validate Email
    protected function validateEmail($email){
// Return result...
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
//Function to Sanitize Fields
    protected function sanitizeEmail($email){
// Return result...
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
//Function to Sanitize Fields
    protected function sanitizeUser_id($user_id){
// Return result...
        return filter_var($user_id, FILTER_SANITIZE_STRING);
    }



//Function to check Email in our records
    protected function userExistsInDB($user_id, $email){
// Fetch and verify if the record already exists...
        $query = "SELECT * FROM " . $this->db_table ." WHERE user_id = :user_id || email = :email LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $RowCount = $stmt->rowCount();
// Checking all User credentials...
        if ($RowCount > 0) {    // code...
        	throw new Exception("User Already Exists, Login Instead...<i class='fa fa-spinner fa-spin'></i>");
        }
// Return result...
    return $user;
    }



/*.....User Registration And Email Verification Function ...........*/

//Function to save User Credentials into Database
    protected function insertUserInDB($user_id, $email, $password, $code)
    {	// Insert The Information...
        $query = "INSERT INTO " . $this->db_table . " 
        (user_id, email, password, code, created) VALUES 
        (:user_id, :email, :password, :code, :created)";
        $stmt = $this->con->prepare($query);
        $data = array(
	        "user_id" => $user_id,
	        "email" => $email,
	        "password" => password_hash($password, PASSWORD_DEFAULT),
	        "code" => $code,
	        "created" => $this->created
        );
        $stmt->execute($data);               
// Return result...
        $from = 'noreply@livechat.com';   
        $to = $email;
        $subject = 'Registration Confirmation';
        $message_body = '
		<html>
		<body style="background-color: #F4E0D7; font-weight: lighter;">
		<head>
		<img src="https://www.livechat.com/assets/images/icon/logo.png" alt="Logo" border="0"  style="margin: 50px; width:90px; height: 120px;"> 
		</head>
		<h3 style="margin: 50px;">Your Registration Is Almost Complete.</h3>
		<p style="margin: 50px;">
		Dear Valued '.$user_id.',
		<br><br>
		Click The Button Below To Set-Up Your Dashboard: 
		<br><br> 
		<a href="https://livechat.com/new-user/?u_s=Enabled&p=User&e='.$email.'&c='.$code.'">
		<button type="button" style="background-color: #FF4000; border: none;
		color: white;
		padding: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;">Confirm Your Account</button></a>
		<br><br> 
		Or Copy The Link Below Into Your Browser To Continue:
		<br><br> 
		https://livechat.com/new-user/?u_s=Enabled&p=User&e='.$email.'&c='.$code.'  
		<br><br> 
		Thank You '.$user_id.' For Joining Us.
		<br><br> 
		Security Team
		<br><br>
		Warm Regards!
		<br>
		Live Chat
		<br><br>
		</p>
		</body>
		</html>           '; 
// To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: Live Chat <noreply@livechat.com>';
// To send HTML mail, the Content-type header must be set
	    ini_set('display_errors', 1);
	    error_reporting( E_ALL );
       if (!mail($to, $subject, $message_body, implode("\r\n", $headers))) { 	// code...
        	throw new Exception("Error<br><br>Your Account Has Been Created<br><br>Email Not Sent...<i class='fa fa-spinner fa-spin'></i>");
        }
// Return result...
    return $data;
    }



/*................User Confirmation Function ........................*/

//Function to Confirm user record
	public function setUpUser($user_status, $email, $profile, $code)
    	{  //Checking email in our records
        $data = $this->checkUser($email);
        if ($data == true) {
          $this->userConfirm($user_status, $email, $profile, $code);
        }
// Return result...
        return $data;
    }

//Function to check Email in our records
    protected function checkUser($email){
// Fetch and verify if the record already exists...
        $query = "SELECT * FROM " . $this->db_table ." WHERE email = :email LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
// Checking all User credentials...
        if (!$user['user_status'] == NULL) {
        	throw new Exception("Account Was Previously Confirmed.<br><br>You May Login Or Contact Support...<i class='fa fa-spinner fa-spin'></i>");
        }
// Return result...
        return $user;
    }

//Function to Confirm user record
    protected function userConfirm($user_status, $email, $profile, $code){
	  $query = "UPDATE " . $this->db_table ." SET `code` = :code, `user_status` = :user_status, `profile` = :profile WHERE email = :email LIMIT 1";
	  $sql = $this->con->prepare($query);
	  $sql->bindParam(':user_status', $user_status);
	  $sql->bindParam(':email', $email);
	  $sql->bindParam(':profile', $profile);
	  $sql->bindParam(':code', $code);
	  $user = $sql->execute([':user_status' => $user_status, ':email' => $email, ':code' => $code, ':profile' => $profile ]);
	  if (!$user = $sql->execute()) {
	  	throw new Exception("Error Confirming User...<i class='fa fa-spinner fa-spin'></i>");	  	
	  }
// Return result...
	  return $user;  
	}



/*..................User Login Function ..........................*/

	public function loginUser($user, $password, $code, $login_status, $lastlogin)
    {  
    //check if User Name is empty
       if (empty($user))
        {	// show user error
            throw new Exception ("Name Or Email Is Required...<i class='fa fa-spinner fa-spin'></i>");    
        }elseif ($this->sanitizeUser_id($user) === false) {
            // show user error
            throw new Exception("Compromised User Name...<i class='fa fa-spinner fa-spin'></i>"); 
        }
    //check if Password is empty
       if (empty($password))
        {	 // show user error
            throw new Exception ("Password Cannot Be Empty...<i class='fa fa-spinner fa-spin'></i>");    
        } 
//Checking email in our records
        $data = $this->confirmUser($user, $password);
        if ($data == true) {
         $data = $this->updateUser($user, $code, $login_status, $lastlogin); 
          $this->redirectUser($user);
        }
// Return result...
        return $data;
    }



//Function to check Email in our records
    protected function confirmUser($user, $password){
// Fetch and verify if the record already exists...
        $query = "SELECT * FROM " . $this->db_table ." WHERE user_id = :user_id || email = :email LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':email', $user);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);    
      	$RowCount = $stmt->rowCount();
// Checking all User credentials...
        if ($RowCount === 0) {
        	throw new Exception("Unregistered Credentials, Register First...<i class='fa fa-spinner fa-spin'></i>");
        }elseif ($user['user_status'] != 'Enabled') {
			throw new Exception("Unactivated Or Disabled Account...<i class='fa fa-spinner fa-spin'></i>");
		}elseif (!password_verify($password, $user['password'])){
				throw new Exception("Incorrect Password...<i class='fa fa-spinner fa-spin'></i>");
		}
// Return result...
		return $user;
    }



//Function to update user record
    protected function updateUser($user, $code, $login_status, $lastlogin){
	  $query = "UPDATE " . $this->db_table ." SET `code` = :code, `login_status` = :login_status, `lastlogin` = :lastlogin WHERE user_id = :user_id || email = :email LIMIT 1";
	  $sql = $this->con->prepare($query);
	  $sql->bindParam(':user_id', $user);
	  $sql->bindParam(':email', $user);
	  $sql->bindParam(':code', $code);
	  $sql->bindParam(':login_status', $login_status);
	  $sql->bindParam(':lastlogin', $lastlogin);
	  $user = $sql->execute([':code' => $code, ':login_status' => $login_status, ':lastlogin' => date('Y-m-d H:i:s'), ':user_id' => $_POST['user'], ':email' => $_POST['user'] ]);
	  if (!$user = $sql->execute()) {
	  	throw new Exception("Error Updating Credentials...<i class='fa fa-spinner fa-spin'></i>");	  	
	  }
// Return result...
	  return $user;  
	}


//Function to redirect users
	protected function redirectUser($user){
	  $query = "SELECT * FROM " . $this->db_table ."  WHERE user_id = :user_id || email = :email LIMIT 1";
	  $sql = $this->con->prepare($query);
	  $sql->bindParam(':user_id', $user);
	  $sql->bindParam(':email', $user);
	  $sql->execute();
	  $user = $sql->fetch(PDO::FETCH_ASSOC);

	  if ($user['login_2fa'] == 'On'){
	  	// Send User Email If All Criteria Met...
        $from = 'noreply@livechat.com';   
        $to = $user['email'];
        $subject = 'Login Attempt';
        $message_body = '
		<html>
		<body style="background-color: #F4E0D7; font-weight: lighter;">
		<head>
		<img src="https://www.livechat.com/assets/images/icon/logo.png" alt="Logo" border="0"  style="margin: 50px; width:90px; height: 120px;"> 
		</head>
		<h3 style="margin: 50px;">2FA Login Authentication.</h3>
		<p style="margin: 50px;">
		Dear Valued '.$user['user_id'].',
		<br><br>
		Complete Your Login Process With The Code Below: 
		<br><br>
		<button type="button" style="background-color: #FF4000; border: none;
		color: white;
		padding: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;">'.$user['code'].'</button>
		<br><br> 
		'.$user['user_id'].', If This Action Was Not Initiated By You, Kindly Ignore This Email.
		<br><br> 
		Security Team
		<br><br>
		Warm Regards!
		<br>
		Live Chat
		<br><br>
		</p>
		</body>
		</html>           '; 
// To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: Live Chat <noreply@livechat.com>';
// To send HTML mail, the Content-type header must be set
	    ini_set('display_errors', 1);
	    error_reporting( E_ALL );
       mail($to, $subject, $message_body, implode("\r\n", $headers));

       session_start([$user['user_id'], $user['email'], $user['profile'], $user['user_status'], $user['login_status'], $user['lastlogin'], $user['created']]);
		echo '<meta http-equiv="refresh" content="5; URL=../login/verify?u_s=Enabled&u='.$user['user_id'].'&2fa='.$user['login_2fa'].'">';

        }elseif ($user['profile'] == 'Admin' && $user['login_2fa'] != 'On'){
    session_start([$user['user_id'], $user['email'], $user['profile'], $user['user_status'], $user['login_status'], $user['lastlogin'], $user['created']]);
	echo '<meta http-equiv="refresh" content="5; URL=../board/super/">'; 
		}elseif ($user['profile'] == 'Moderator' && $user['login_2fa'] != 'On') {
	session_start([$user['user_id'], $user['email'], $user['profile'], $user['user_status'], $user['login_status'], $user['lastlogin'], $user['created']]);
	echo '<meta http-equiv="refresh" content="5; URL=../board/mode/">'; 
		}elseif ($user['profile'] == 'User' && $user['login_2fa'] != 'On') {
	session_start([$user['user_id'], $user['email'], $user['profile'], $user['user_status'], $user['login_status'], $user['lastlogin'], $user['created']]);
	echo '<meta http-equiv="refresh" content="5; URL=../board/">'; 
		}
// Return result...
	return $user;
	}


/*.......................User Password Reset Function ................*/

//Function to Confirm user record
	public function passRequest($user)
    	{  //Checking user in our records
        $data = $this->userInfo($user);
// Return result...
        return $data;
    }

//Function to check Email in our records
    protected function userInfo($user){
// Fetch and verify if the record already exists...
        $query = "SELECT * FROM " . $this->db_table ." WHERE user_id = :user_id || email = :email LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':email', $user);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);    
      	$RowCount = $stmt->rowCount();
// Checking all User credentials...
        if ($RowCount === 0) {
        	throw new Exception("Unregistered Credentials, Register First...<i class='fa fa-spinner fa-spin'></i>");
        }elseif ($user['user_status'] != 'Enabled') {
			throw new Exception("Unactivated Or Disabled Account...<i class='fa fa-spinner fa-spin'></i>");
		}
		// Send User Email If All Criteria Met...
        $from = 'noreply@livechat.com';   
        $to = $user['email'];
        $subject = 'Password Reset';
        $message_body = '
		<html>
		<body style="background-color: #F4E0D7; font-weight: lighter;">
		<head>
		<img src="https://www.livechat.com/assets/images/icon/logo.png" alt="Logo" border="0"  style="margin: 50px; width:90px; height: 120px;"> 
		</head>
		<h3 style="margin: 50px;">You requested For A Password Reset.</h3>
		<p style="margin: 50px;">
		Dear Valued '.$user['user_id'].',
		<br><br>
		Click The Button Below To Reset Your Password: 
		<br><br> 
		<a href="https://livechat.com/login/p-reset?u_s=Enabled&e='.$user['email'].'&c='.$user['code'].'">
		<button type="button" style="background-color: #FF4000; border: none;
		color: white;
		padding: 15px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;">Reset Password</button></a>
		<br><br> 
		Or Copy The Link Below Into Your Browser To Continue:
		<br><br> 
		https://livechat.com/login/p-reset?u_s=Enabled&e='.$user['email'].'&c='.$user['code'].'  
		<br><br> 
		'.$user['user_id'].', If This Action Was Not Initiated By You, Kindly Ignore This Email.
		<br><br> 
		Security Team
		<br><br>
		Warm Regards!
		<br>
		Live Chat
		<br><br>
		</p>
		</body>
		</html>           '; 
// To send HTML mail, the Content-type header must be set
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: Live Chat <noreply@livechat.com>';
// To send HTML mail, the Content-type header must be set
	    ini_set('display_errors', 1);
	    error_reporting( E_ALL );
       if (!mail($to, $subject, $message_body, implode("\r\n", $headers))) { 	// code...
        	throw new Exception("Error<br><br>Password Cannot Be Reset At This Time...<i class='fa fa-spinner fa-spin'></i>");
        }
// Return result...
		return $user;
    }


/*.................Form Validation ...................................*/

	public function newPassReset($email, $code, $password)
    {	//Update Password in our records
        $user = $this->confCode($email, $code, $password);
        if ($user == true) {    // code...
           $user = $this->updatePass($email, $password);
        }
// Return result...
        return $user;
    }


//Function to check Email in our records
    protected function confCode($email, $code, $password){
// Fetch and verify if the record already exists...
        $query = "SELECT * FROM " . $this->db_table ." WHERE email = :email && code = :code LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);    
      	$RowCount = $stmt->rowCount();
// Checking all User credentials...
        if ($RowCount === 0) {
        	throw new Exception("Expired Or Incorrect Credentials...<i class='fa fa-spinner fa-spin'></i>");
        }elseif (password_verify($password, $user['password'])){
				throw new Exception("This Password Was Recently Used...<i class='fa fa-spinner fa-spin'></i>");
		}
        return $user;
	}


//Function to update user password
    protected function updatePass($email, $password){
	  $query = "UPDATE " . $this->db_table ." SET `password` = :password WHERE email = :email LIMIT 1";
	  $sql = $this->con->prepare($query);
	  $sql->bindParam(':password', $password);
	  $sql->bindParam(':email', $email);
	  $user = $sql->execute([':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT) ]);
	  if (!$user = $sql->execute()) {
	  	throw new Exception("Error Updating Password...<i class='fa fa-spinner fa-spin'></i>");	  	
	  }
// Return result...
	  return $user;  
	}



/*.................2FA User Login................................*/

	public function authenticate($user, $code)
    {	//Verify Code in our records
        $user = $this->verifyCode($user, $code);
// Return result...
        return $user;
    }


//Function to check Email in our records
    protected function verifyCode($user, $code){
// Fetch and verify if the record already exists...
        $query = "SELECT * FROM " . $this->db_table ." WHERE email = :email || user_id = :user_id AND code = :code LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':email', $user);
        $stmt->bindParam(':user_id', $user);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
// Checking all User credentials...
        if ($code != $user['code']) {
        	throw new Exception("Expired Or Incorrect Credentials...<i class='fa fa-spinner fa-spin'></i>");
        }elseif ($user['profile'] == 'Admin'){
    session_start([$user['user_id'], $user['email'], $user['profile'], $user['user_status'], $user['login_status'], $user['lastlogin'], $user['created']]);
	echo '<meta http-equiv="refresh" content="5; URL=../board/super/">'; 
		}elseif ($user['profile'] == 'Moderator') {
	session_start([$user['user_id'], $user['email'], $user['profile'], $user['user_status'], $user['login_status'], $user['lastlogin'], $user['created']]);
	echo '<meta http-equiv="refresh" content="5; URL=../board/mode/">'; 
		}elseif ($user['profile'] == 'User') {
	session_start([$user['user_id'], $user['email'], $user['profile'], $user['user_status'], $user['login_status'], $user['lastlogin'], $user['created']]);
	echo '<meta http-equiv="refresh" content="5; URL=../board/">'; 
		}
	return $user;
	}





//End of file
}
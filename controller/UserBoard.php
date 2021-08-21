<?php
/*
Project Name: Live Chat Apllication
App Version: 1.0
Author: https://github.com/BusybrainDotNet
*/
class UserBoard
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





















}
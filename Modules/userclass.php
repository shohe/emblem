<?php
// ** 
// Created by mkawai
// 2016/1/3 10:30
// **

	require 'config.php';

	// Get user information
	class GetUser{
	    private $id;
	    private $agent;
	    private $hostaddress;
	    private $ipaddress;

	    public function __construct(){
	    // Get User's env info
	        $this->id = $_GET['id'];
	        $this->agent = $_SERVER['HTTP_USER_AGENT'];
	        $this->hostaddress = $_SERVER['REMOTE_HOST'];
	        $this->ipaddress = $_SERVER['REMOTE_ADDR'];
		    // echo "ID:{$this->id}<br>Agent:{$this->agent}<br>Host:{$this->hostaddress}<br>IP:{$this->ipaddress}<br>";
	    }
	}




	// User login 
	class UserLogin{
		private $id;
		function __construct(){
			$this->id = $_GET['id'];
			$this->mysqli = new mysqli($db[host],$db[user],$db[pass],$db[dbname]);
			session_start();
			echo $this->id;
		}

		// public function login($this->id){
		// 	$stmt = $this->mysqli->prepare("SELECT * FROM eb_users WHERE id = ?");
		// 	$stmt->bind_param('s',$this->id);
		// 	$stmt->execute();

		// 	$stmt->store_result();
		// 	if($stmt->num_rows == 1){
		// 		$_SESSION['id'] = $this->id;
		// 		return true;
		// 	}			
		// 	return false;
		// }
	}

	new UserLogin();







/*	$mysqli = new mysqli($db[host],$db[user],$db[pass],$db[dbname]);
	if ($mysqli->connect_error){
		print("接続失敗：" . $mysqli->connect_error);
		exit();
	}else{
		print("Success!");
	}*/




	// After user logined, manage login session
	// Get user information from database

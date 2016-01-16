<?php
// **
// Created by mkawai

// 2016/1/3 10:30
// **

	require_once 'config.php';
	require_once 'User.model.php';

/***********************/
/*       ユーザークラス     */
/***********************/
	class User {
		private $uid;
		private $upass;
		private $agent;
		private $hostaddress;
		private $ipaddress;

		private $dbpass;
		private $uget;
		private $errorMessage;
		$errorMessage = "";

		/* 環境変数取得　*/
		function __construct(){
			// $this->uid = (isset($_GET['uid'])) ? $_GET['uid'] : null;
			$this->agent = $_SERVER['HTTP_USER_AGENT'];
			$this->hostaddress = $_SERVER['REMOTE_HOST'];
			$this->ipaddress = $_SERVER['REMOTE_ADDR'];
		}

		/* セッションセット　*/
		private function setSession() {
			session_start();
			$_SESSION['uid'] = $this->uid;
			$_SESSION['agent'] = $this->agent;
			$_SESSION['hostaddress'] = $this->hostaddress;
			$_SESSION['ipaddress'] = $this->ipaddress;
		}

		/* セッション削除 */
		public function destroySession(){
			$_SESSION = array();
			session_destroy();
		}

		/*　ユーザー登録　*/
		public function regist(){
				// データベース取得=>Insert 登録情報
		}

		/*　ユーザーログイン(Form)　*/
		public function formLogin(){
			if(isset($_POST["login"])){					
				//Form check
				$this->uid = (isset($_POST["id"])) ? $_POST["id"] : null;
				$this->upass = (isset($_POST["pass"])) ? $_POST["pass"] : null;
				$this->upass = $this->hash($upass);
				if(!$uid){
					$this->errorMessage = "Please enter ID.";
				}else if(!$upass){
					$this->errorMessage = "Please enter password.";
				}

				//Authentication
				$uget = new UserModel();
				$uget->fetchAll($this->uid);
				$dbpass = $uget->pass();
				if (password_verify($upass, $dbpass)) {
					// Success
					session_regenerate_id(true);
					$this->setSession();
					// header("Location: index.php");
					exit;
				} else {
					// Failed
					$this->errorMessage = "Authentication failed. Please try again. If you have forgotten your password, you can reset it."
				}
			} else {
				// Do nothing if form were empty.
			}
		}

		/*　ユーザーログアウト　*/
		public function logout(){
			session_start();
			if (isset($_SESSION["id"])) {
				$this->errorMessage = "Logout";
			} else {
				$this->errorMessage = "Session Timeout";
			}
			$this->destroySession();
		}

		/* ハッシュ化 */
		private function hash($password){
			return md5($password . SALT);
		}
	}
<?php
// ** 
// Created by mkawai
// 2016/1/3 10:30
// **

	require_once 'config.php';



/***********************/
/*    ユーザークラス    */
/***********************/
	class User {
		private $id;
		private $agent;
		private $hostaddress;
		private $ipaddress;

		function __construct(){
			$this->id = (isset($_GET['id'])) ? $_GET['id'] : null;
	        $this->agent = $_SERVER['HTTP_USER_AGENT'];
	        $this->hostaddress = $_SERVER['REMOTE_HOST'];
	        $this->ipaddress = $_SERVER['REMOTE_ADDR'];
		}

		public function setSession() {
			session_start();
			$_SESSION['id'] = $this->id;
	        $_SESSION['agent'] = $this->agent;
			$_SESSION['hostaddress'] = $this->hostaddress;
			$_SESSION['ipaddress'] = $this->ipaddress;
		}

		/* ログアウト（セッション削除） */
		public function destroySession(){
			if($_SESSION['id']){
				$_SESSION = array();
				session_destroy();
				echo "Logged out.";
		}

		/* ハッシュ化 */
		private function hash($password){
			return md5($password . SALT);
		}
	}


/***********************/
/*  データベースクラス  */
/***********************/
	class UserDatabase{
		public function __construct($sql){
			private $id;
			$id = $_SESSION['id'];
				if(isset($id)){
				try {
				    $pdo = new PDO(
				        sprintf('mysql:dbname=%s;host=%s;charset=%s',DBNAME,DBHOST,DBCHARSET),
				        DBUSER,
				        DBPASS,
				        array(
				            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				            PDO::ATTR_EMULATE_PREPARES => false,
				        )
				    );
				    $pdo->beginTransaction();
				    $sql_search_id = 'SELECT * FROM eb_users WHERE id = :id';
				    $stmt = $pdo->prepare($sql_search_id);
				    $stmt->bindParam(':id', $id);
				    $stmt->execute();
				    $count = $stmt->rowCount();
			    	//セッションIDがあれば引数のSQL文を実行する
				    if($count == 1){
					    $stmt = $pdo->prepare($sql);
					    $stmt->execute();
				    	// echo "Logged in";
				    	return true;
				    }else{
				    	// echo "Couldn't find your ID";
				    	return false;
				    }
			
				} catch (Exception $e) {
				    //var_dump($e->getMessage());
				    $export['code'] = 500;
				    //rollback when failed.
				    $pdo->rollBack();
				}
			}
		}else{
			exit;
		}
	}
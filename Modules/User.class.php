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
		private $uid;
		private $agent;
		private $hostaddress;
		private $ipaddress;

		function __construct(){
			$this->uid = (isset($_GET['uid'])) ? $_GET['uid'] : null;
			$this->agent = $_SERVER['HTTP_USER_AGENT'];
			$this->hostaddress = $_SERVER['REMOTE_HOST'];
			$this->ipaddress = $_SERVER['REMOTE_ADDR'];
		}

		public function setSession() {
			session_start();
			$_SESSION['uid'] = $this->uid;
			$_SESSION['agent'] = $this->agent;
			$_SESSION['hostaddress'] = $this->hostaddress;
			$_SESSION['ipaddress'] = $this->ipaddress;
		}

		/* ログアウト（セッション削除）*/
		public function destroySession(){
			if($_SESSION['uid']){
				$_SESSION = array();
				session_destroy();
				echo "Logged out.";
			}
		}

		/* ハッシュ化 */
		private function hash($password){
			return md5($password . SALT);
		}
	}


/***********************/
/*    チケットクラス    */
/***********************/
	class Ticket{
		private $tid;
	}


/***********************/
/*     ストアクラス     */
/***********************/

	class Store{
		private $sid;

	}



/***********************/
/*  データベースクラス  */
/***********************/

	class Database{
		public function statement($sql){
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
			    $stmt = $pdo->prepare($sql);
			    $stmt->execute();
			    $result = $stmt->fetchAll();
			    return $result;

			}catch (Exception $e) {
			    //var_dump($e->getMessage());
			    $export['code'] = 500;
			    //rollback when failed.
		    	$pdo->rollBack();
			}
		}
	}


/*	$test = new User();
	$test->setSession();
	$sql = 'SELECT * FROM eb_users WHERE id = ' . $_SESSION['uid'];
	$db = new Database;
	$dbs = $db->statement($sql);

	var_dump($dbs);*/
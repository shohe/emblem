<?php
// ** 
// Created by mkawai
// 2016/1/3 10:30
// **

	require 'config.php';

/***************************/
/* ユーザー環境変数取得クラス*/
/***************************/
	class GetUser{
	    private $id;
	    private $agent;
	    private $hostaddress;
	    private $ipaddress;

	    public function user_env(){
	        $this->id = $_GET['id'];
	        $this->agent = $_SERVER['HTTP_USER_AGENT'];
	        $this->hostaddress = $_SERVER['REMOTE_HOST'];
	        $this->ipaddress = $_SERVER['REMOTE_ADDR'];
		    // echo "ID:{$this->id}<br>Agent:{$this->agent}<br>Host:{$this->hostaddress}<br>IP:{$this->ipaddress}<br>";
	    }
	}

/***************************/
/*  ユーザーログインクラス  */
/***************************/
	class UserLogin{
		private $id;


	/* コンストラクタ */
		function __construct(){
				$this->id = $_GET['id'];
				session_start();
			}


	/* ログイン処理（データベースID照合＋セッション格納）*/
		public function user_login($id,$password){
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
			    $sql = 'SELECT * FROM eb_users WHERE id = :id';
			    $stmt = $pdo->prepare($sql);
			    $stmt->bindParam(':id', $id);
			    $stmt->execute();
			    $count = $stmt->rowCount();
			    if($count == 1){
			    	$_SESSION['id'] = $id;
			    	echo "Logged in";
			    	return true;
			    }else{
			    	echo "Couldn't find your ID";
			    	return false;
			    }
		
			} catch (Exception $e) {
			    //var_dump($e->getMessage());
			    $export['code'] = 500;
			    //rollback when failed.
			    $pdo->rollBack();
			}
		}


	/* ログアウト（セッション削除） */
		public function user_logout(){
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

	$a = new UserLogin();
	$a->user_login();




/****************************************/
/* 登録ユーザー情報をデータベースから取得  */
/****************************************/
	class UserDatabase{

	}
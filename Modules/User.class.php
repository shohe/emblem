<?php
// **
// Created by mkawai

// 2016/1/3 10:30
// **

	require_once 'config.php';
	// require_once 'User.model.php';
	require_once 'DB.class.php';

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
		// http://qiita.com/tabo_purify/items/7fb077ddeb06dbe427ff
		public function regist(){
			$error = "";
			if (isset($_POST["signup"])) {
				$mail = htmlspecialchars($_POST["mail"],ENT_QUOTES);
				$pass = htmlspecialchars($_POST["pass"],ENT_QUOTES);
				$password = hash($pass);
				//----------------------
				//空ならエラー
				//----------------------
				if ($mail == "" ) { $error = '<p class="error">メールアドレスが入っていません</p>'; }
				if ($pass == "" ) { $error = '<p class="error">パスワードが入っていません</p>'; }
				//----------------------
				//文字数確認
				//----------------------
				$spass = strlen($pass);
				if ($spass < 4) { $error ='<p class="error">パスワードは４文字以上で設定してください</p>';
			}
			//----------------------
			// プレグマッチ
			//----------------------
			if (preg_match("/^[a-zA-Z0-9]+$/", $pass)) { $pass = $pass; }else{
				$error = '<p class="error">パスワードは半角英数で登録してください。</p>'; }
			//---------------------
			//重複チェック
			//---------------------
				$sql = "SELECT * FROM eb_users";
				$db = new DB;
				$item = $db->fetch($sql);
				while($item) {
					if($item['mail'] == $mail){
						$error = '<p class="error">ご希望のメールアドレスは既に使用されています。</p>';
					}else{
						$mail = $mail;
					}
				}
			//-------------------
			//DBに登録
			//-------------------
				if ($error == "" ) {
					$sql = "INSERT INTO eb_users (type, pass, name, mail, join_date, birthday) VALUES ('user',:pass, :name, :mail, :join_date, :birthday)";
					$db = new DB;
					$regist = $db->execute($sql);
					$sql -> bindParam(':pass', $password, PDO::PARAM_STR);
					$sql -> bindParam(':mail', $mail, PDO::PARAM_STR);
					$sql -> bindParam(':name', 'test_user', PDO::PARAM_STR);
					$sql -> bindParam(':join_date', date("Y-m-d H:i:s") , PDO::PARAM_STR);
					$sql -> bindParam(':birthday', '20150104', PDO::PARAM_STR);
					$sql -> execute();
					// header('Location: login.php');
					exit;
				}
			}
		}

		/*　ユーザーログイン(Form)　*/
		public function formLogin(){
			$errorMessage = "";

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
				} else {
				// Do nothing if form were empty.
				}
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

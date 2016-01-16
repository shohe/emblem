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
			if (isset($_POST["up"])) {
				$id = htmlspecialchars($_POST["id"],ENT_QUOTES);
				$pass = htmlspecialchars($_POST["pass"],ENT_QUOTES);
				$password = hash($pass);
				//----------------------
				//空ならエラー
				//----------------------
				if ($id == "" ) { $error = '<p class="error">IDが入っていません</p>'; }
				if ($pass == "" ) { $error = '<p class="error">パスワードが入っていません</p>'; }
				//----------------------
				//文字数確認
				//----------------------
				$sid = strlen($id);
				$spass = strlen($pass);
				if ($sid < 4) {$error ='<p class="error">IDは４文字以上で設定してください</p>';}
				if ($spass < 4) { $error ='<p class="error">パスワードは４文字以上で設定してください</p>';
			}
			//----------------------
			// プレグマッチ
			//----------------------
			if (preg_match("/^[a-zA-Z0-9]+$/", $pass)) { $pass = $pass; }else{
				$error = '<p class="error">パスワードは半角英数で登録してください。</p>'; }
			if (preg_match("/^[a-zA-Z0-9]+$/", $id)) { $id = $id; }else{
				$error = '<p class="error">IDは半角英数で登録してください。</p>'; }
			//---------------------
			//重複チェック
			//---------------------
				$stmt = $pdo -> query("SELECT * FROM テーブル名");
				while($item = $stmt->fetch()) {
					if($item['id'] == $id){
						$error = '<p class="error">ご希望のメールアドレスは既に使用されています。</p>';
					}else{
						$id = $id;
					}
				}
			//-------------------
			//DBに登録
			//-------------------
				if ($error == "" ) {
					$stmt = $pdo -> prepare("INSERT INTO テーブル名 (dd,id,pass) VALUES ('', :id, :pass)");
					$stmt -> bindParam(':id', $id, PDO::PARAM_STR);
					$stmt -> bindParam(':pass', $password, PDO::PARAM_STR);
					$stmt -> execute();
					// header('Location: login.php');
					exit;
				}
			}
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
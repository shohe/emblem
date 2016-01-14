<?php
// **
// Created by mkawai
// 2016/1/3 10:30
// **

	require_once 'config.php';

/***********************/
/*       ユーザークラス     */
/***********************/
	class User {
		private $uid;
		private $agent;
		private $hostaddress;
		private $ipaddress;

		/* 環境変数取得　*/
		function __construct(){
			$this->uid = (isset($_GET['uid'])) ? $_GET['uid'] : null;
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
			if($_SESSION['uid']){
				$_SESSION = array();
				session_destroy();
			}
		}

		/*　ユーザー登録　*/
		public function regist(){
				// データベース取得=>Insert 登録情報
		}

		/*　ユーザーログイン　*/
		public function login(){
			$this->setSession();
		}

		/*　ユーザーログアウト　*/
		public function logout(){
			$this->destroySession();
		}

		/* ハッシュ化 */
		private function hash($password){
			return md5($password . SALT);
		}
	}
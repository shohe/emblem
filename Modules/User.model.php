<?php
// **
// Created by mkawai
// 2016/1/15 23:00
// **

	require_once 'config.php';
	require_once 'DB.class.php';

/***********************/
/       ユーザークラス     /
/***********************/

	/*
	///user_table
	- id
	name
	age

	*/
	class UserModel {

		private $id;
		private $pass;
		private $name;
		private $age;

		public static function fetchAll($id) {
			$fetch_data = DB->fetch("SELECT * FROM USER_TABLE WHERE id = '" . $id . "'");
			$model = new UserModel();
			$model->id = $model["id"];
			$model->pass = $model["pass"];
			$model->name = $model["name"];
			$model->age = $model["age"];
			return $model;
		}

		public function id() {
			return $this->id;
		}

		public function pass() {
			return $this->pass;
		}

		public function name() {
			return $this->name;
		}

		public function age() {
			return $this->age;
		}

	}

	$user = new UserModel();
	$user->name = "ohtani"
	$user->age = 22;
	$user->setDB();


	// $user_model = new UserModel->fetchAll();
	// $user_model->id();
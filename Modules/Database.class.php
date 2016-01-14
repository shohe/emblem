<?php
// **
// Created by mkawai
// 2016/1/14 13:00
// **

	require_once 'config.php';
/***********************/
/*     データベースクラス    */
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
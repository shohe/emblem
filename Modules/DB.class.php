<?php
// **
// Created by mkawai
// 2016/1/14 13:00
// **

    require_once 'config.php';
/***********************/
/*     データベースクラス    */
/***********************/
    class DB{

        function fetch($sql){
            try{
                $pdo = new PDO(
                    sprintf('mysql:dbname=%s;host=%s;charset=%s',DBNAME,DBHOST,DBCHARSET),
                    DBUSER,
                    DBPASS,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    )
                );
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $data;
                } catch(PDOException $ei) {
                    echo 'Connection failed:'.$e->getMessage();
                    exit();
            }
        }

        function execute ($sql){
                try{
                    $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $data = $pdo->lastInsertId();
                    return $data;
                } catch(PDOException $ei) {
                    echo 'Connection failed:'.$e->getMessage();
                    exit();
                }
            }
        }
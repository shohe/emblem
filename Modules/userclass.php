<?php
// ** 
// Created by mkawai
// 2016/1/3 10:30
// **


// Get user's information. 
class UserClass{
    public $id;
    public $agent;
    public $hostaddress;
    public $ipaddress;
    public function show(){
        echo "ID:{$this->id}<br>Agent:{$this->agent}<br>Host:{$this->hostaddress}<br>IP:{$this->ipaddress}<br>";
    }
}


// Get User's env info
    $user = new UserClass;
    $user->id = $_GET['id'];
    $user->agent = $_SERVER['HTTP_USER_AGENT'];
    $user->hostaddress = $_SERVER['REMOTE_HOST'];
    $user->ipaddress = $_SERVER['REMOTE_ADDR'];
    $user->show();


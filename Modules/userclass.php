<?php
// ** 
// Created by mkawai
// 2016/1/3 10:30
// **


// Get user's information. 
class UserClass{
    private $id;
    private $agent;
    private $hostaddress;
    private $ipaddress;

    public function __construct(){
    // Get User's env info
        $this->id = $_GET['id'];
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->hostaddress = $_SERVER['REMOTE_HOST'];
        $this->ipaddress = $_SERVER['REMOTE_ADDR'];
//        echo "ID:{$this->id}<br>Agent:{$this->agent}<br>Host:{$this->hostaddress}<br>IP:{$this->ipaddress}<br>";
    }
}


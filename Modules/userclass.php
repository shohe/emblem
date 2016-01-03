<?php
// ** 
// Created by mkawai
// 2016/1/3 10:30
// **


// Get user's information. 
class UserClass{
    public $user_id = $_GET['id'];
    public $user_agent = $_SERVER['HTTP_USER_AGENT'];
    public $hostaddress = $_SERVER['REMOTE_HOST'];
    public $ipaddress = $_SERVER['REMOTE_ADDR'];
}



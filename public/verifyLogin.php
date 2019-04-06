<?php
/* 登录验证
 * @Author: 于波 
 * @example  require 'verifyLogin.php'
 * @Date: 2019-02-17 15:45:24 
 * @Last Modified by: 于波
 * @Last Modified time: 2019-02-22 09:28:20
 */

if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['username'])) {
	header("location:adminController.php?flag=login");
	exit();
}
?>
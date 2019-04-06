<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../public/css/main.css">
	<script type="text/javascript" src="../../public/js/jquery-3.3.1.js"></script>
	<title>知识管理系统--登录</title>
	<script type="text/javascript">
		$(function(){
			//对用户名进行验证
			$("#username").blur(function(){
				checkUsername();
			});
			//对密码进行验证
			$("#password").blur(function(){
				checkPassword();
			});
			//对验证码进行验证
			$("#captcha").blur(function(){
				checkCaptcha();
			});
			//对验证码进行刷新
			$(".captcha").click(function () { 
				$(".captcha").attr("src", "../../public/img/captcha.php?t="+Math.random());
				return false;
			});
		});
		
		//用户名的相关验证
		function checkUsername() {
			//检测是否为空
			var username = $("#username").val();
			if (username.length == 0) {
				$("#tips").html("*&nbsp;输入账号，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			}
			
			var pattern = /^[a-z0-9_]{6,20}$/;
			if (!pattern.test(username)) {
				$("#tips").html("*&nbsp;输入账号，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			} else {
				$("#tips").html("");
				return true;
			}
		}
			
		//密码的相关验证
		function checkPassword() {
			//检测是否为空
			var password = $("#password").val();
			if (password.length == 0) {
				$("#tips").html("*&nbsp;输入密码，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			}
			
			var pattern = /^[a-z0-9_]{6,20}$/;
			if (!pattern.test(password)) {
				$("#tips").html("*&nbsp;输入密码，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			} else {
				$("#tips").html("");
				return true;
			}
		}
			
		//验证码的相关验证
		function checkCaptcha() {
			//检测是否为空
			var captcha = $("#captcha").val();
			if (captcha.length == 0) {
				$("#tips").html("*&nbsp;请输入4位验证码");
				$("#tips").removeClass('success').addClass('error');
				return false;
			}
			
			var pattern = /^[0-9]{4}$/;
			if (!pattern.test(captcha)) {
				$("#tips").html("*&nbsp;请输入4位验证码");
				$("#tips").removeClass('success').addClass('error');
				return false;
			} else {
				$("#tips").html("");
				return true;
			}
		}
	</script>
</head>
<body>
	<div class="container-fluid bg-body">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div id="head-logtitle" class="col-md-12 text-center">
						<h1>知识管理系统</h1>
					</div>
				</div>
				<div class="bg-box">
					<div class="row">
						<div class="col-md-6 login">
							<p class="title-log">
								<a href="adminController.php?flag=login" class="label-a">用户登录</a>
							</p>
						</div>
						<div class="col-md-6 login">
							<p class="title-reg">
								<a href="adminController.php?flag=register" class="label-a">用户注册</a>
							</p>
						</div>
					</div>
					<div class="sm-box">
						<form action="adminController.php?flag=login" method="post">
							<div class="form-group">
								<label for="username">请输入账号</label>
								<input type="text" name="username" id="username" class="form-control" placeholder="请输入账号"/>
							</div>
							<div class="form-group">
								<label for="password">请输入密码</label>
								<input type="password" name="password" id="password" class="form-control" placeholder="请输入密码"/>
							</div>
							<div class="form-group">
								<label for="captcha">请输入验证码</label>
								<div class="row">
									<div class="col-md-8">
										<input type="text" name="captcha" id="captcha" class="form-control" maxlength="4" placeholder="请输入验证码"/>
									</div>
									<div class="col-md-4">
										<img src="../../public/img/captcha.php" class="captcha" title="看不清,点我换一张">
									</div>
								</div>
							</div>
							<span id="tips"></span>
							<input type="submit" value="登录" class="btn btn-danger btn-lg btn-login"/>
							<a href="#" class="pull-left label-a">忘记密码</a>
							<a href="adminController.php?flag=register" class="pull-right label-a">快速注册</a>
						</form>
					</div>
				</div>
			</div>
		</div>		
	</div>

	<?php
	if (isset($_GET["errno"])) {
		$errno = $_GET["errno"];
		if ($errno == 1) {
			echo "<script type='text/javascript'>
					$(function(){
						$('#tips').html('*&nbsp;账号或密码错误');
						$('#tips').removeClass('success').addClass('error');
					});
					</script>";
		} elseif ($errno == 2) {
			echo "<script type='text/javascript'>
					$(function(){
						$('#tips').html('*&nbsp;验证码错误');
						$('#tips').removeClass('success').addClass('error');
					});
					</script>";
		}
	}
	?>
	
	<script type="text/javascript" src="../../public/js/bootstrap.js"></script>
</body>
</html>

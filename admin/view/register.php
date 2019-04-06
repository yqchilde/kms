<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../public/css/main.css">
	<script type="text/javascript" src="../../public/js/jquery-3.3.1.js"></script>
	<title>知识管理系统--注册</title>
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
			//对重复密码进行验证
			$("#confirmPassword").blur(function(){
				checkConfirmPassWord();
			});
		});
		
		//用户名的相关验证
		function checkUsername() {
			//检测是否为空
			var username = $("#username").val();
			if (username.length == 0) {
				$("#tips").html("*输入账号，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			}
			
			var pattern = /^[a-z0-9_]{6,20}$/;
			if (!pattern.test(username)) {
				$("#tips").html("*输入账号，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			} else {
				$("#tips").load("adminController.php?flag=checkUsername", {username:username});
			}
		}
			
		//密码的相关验证
		function checkPassword() {
			//检测是否为空
			var password = $("#password").val();
			if (password.length == 0) {
				$("#tips").html("*输入密码，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			}
			
			var pattern = /^[a-z0-9_]{6,20}$/;
			if (!pattern.test(password)) {
				$("#tips").html("*输入密码，6-20位小写字母，数字或下划线");
				$("#tips").removeClass('success').addClass('error');
				return false;
			} else {
				$("#tips").html("");
				return true;
			}
		}
			
		//重复密码的相关验证
		function checkConfirmPassWord() {
			//检测是否为空
			var confirmPassword = $("#confirmPassword").val();
			if (confirmPassword.length == 0) {
				$("#tips").html("*请输入确认密码");
				$("#tips").removeClass('success').addClass('error');
				return false;
			}
			//判断值是否相同
			if (!(confirmPassword == $("#password").val())) {
				$("#tips").html("*两次输入的密码不一致，请重新输入");
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
							<p class="title-reg">
								<a href="adminController.php?flag=login" class="label-a">用户登录</a>
							</p>
						</div>
						<div class="col-md-6 login">
							<p class="title-log">
								<a href="adminController.php?flag=register" class="label-a">用户注册</a>
							</p>
						</div>
					</div>
					<div class="sm-box">
						<form action="adminController.php?flag=register" method="post">
							<div class="form-group">
								<label for="username">请输入账号</label>
								<input type="text" name="username" id="username" class="form-control" placeholder="请输入账号"/>
							</div>
							<div class="form-group">
								<label for="password">请输入密码</label>
								<input type="password" name="password" id="password" class="form-control" placeholder="请输入密码"/>
							</div>
							<div class="form-group">
								<label for="confirmPassword">请再次输入密码</label>
								<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="请再次输入密码"/>
							</div>
							<span id="tips"></span>
							<input type="submit" value="注册" class="btn btn-danger btn-lg btn-login"/>
							<a href="adminController.php?flag=login" class="pull-right label-a">已有账号,直接登录</a>
						</form>
					</div>
				</div>
			</div>
		</div>		
	</div>
	
	<script type="text/javascript" src="../../public/js/bootstrap.js"></script>
</body>
</html>

<?php require("../../public/verifyLogin.php");?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>网站后台管理</title>
	<link rel="stylesheet" href="../../public/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../public/css/main.css"/>
	<link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
	  <!-- 顶部导航部分开始 -->
    <nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="userController.php?flag=user" class="navbar-brand">知识管理系统</a>
			</div>	
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="userController.php?flag=user"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;首页</a></li>
					<li><a href="userController.php?flag=user&src=k1"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;知识管理</a></li>
					<li class="active"><a href="userController.php?flag=user&src=u1"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;个人中心</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
    				<li class="dropdown">
    					<a id="dLabel" type="button" data-toggle="dropdown">
    						<?php echo $_SESSION["username"];?>
    						<span class="caret"></span>
    					</a>
    					<ul class="dropdown-menu">
							<li><a href=""><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $_SESSION["user_id"] ?></a></li>
							<li role="separator" class="divider"></li>
    						<li><a href=""><span class="glyphicon glyphicon-screenshot"></span>&nbsp;&nbsp;前台首页</a></li>
    						<li><a href="userController.php?flag=user&src=u1"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;&nbsp;个人主页</a></li>
    					</ul>
    				</li>
    				<li><a href="userController.php?flag=logout"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;退出</a></li>
    			</ul>
			</div>
		</div>
	</nav>
	<!-- 顶部导航部分结束 -->
	<!-- 主页面开始 -->
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<div class="list-group">
					<a href="userController.php?flag=user&src=u1" class="list-group-item active">个人设置</a>
					<a href="#" class="list-group-item">个人收藏</a>
				</div>
			</div>
			<div class="col-md-10">
				<div class="page-header"><h1>个人中心</h1></div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">资料设置</div>
							<div class="panel-body">
                                <?php foreach($userInfo as $user): ?>
                                <div class="form-group">
                                    <label for="realname">真实姓名</label>
                                    <input type="text" id="realname" class="form-control" value="<?php echo $user['user_realname']; ?>" disabled />
                                </div>
                                <div class="form-group">
                                    <label for="email">邮箱</label>
                                    <input type="email" id="email" class="form-control" value="<?php echo $user['user_email']; ?>" disabled />
                                </div>
                                <div class="form-group">
									<a href="" class="btn btn-info pull-right page-main-post" data-toggle="modal" data-target="#myInfo">编辑</a>
                                </div>
                                <?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">账号设置</div>
							<div class="panel-body">
								<form id="myPwdEdit" method="post" class="page-main-post">
									<div class="form-group">
										<label for="pwd1">原密码</label>
										<input type="password" id="pwd1" name="pwd1" class="form-control" placeholder="请输入要修改的密码" />
									</div>
									<div class="form-group">
										<label for="pwd2">修改密码</label>
										<input type="password" id="pwd2" class="form-control" placeholder="请输入要修改的密码" />
									</div>
									<div class="form-group">
										<label for="pwd3">确认密码</label>
										<input type="password" id="pwd3" name="pwd3" class="form-control" placeholder="请再次输入上面的密码" />
									</div>
									<div class="form-group">
										<button id="pwdEdit" class="btn btn-info pull-right page-main-post">修改</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 编辑自己信息模态框开始 -->
	<form action="" id="myInfoEdit">
		<div class="modal fade" id="myInfo" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">修改信息</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="editUser">用户名</label>
							<input type="text" id="editUser" class="form-control" disabled/>
						</div>
						<div class="form-group">
							<label for="editRealname">真实姓名</label>
							<input type="text" id="editRealname" name="editRealname" class="form-control"/>
						</div>
						<div class="form-group">
							<label for="editEamil">邮箱</label>
							<input type="email" id="editEamil" name="editEamil" class="form-control"/>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-primary" id="submit">修改</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- 编辑自己信息模态框结束 -->
	<!-- 主页面结束 -->
	<!-- footer开始 -->
	<?php
    include("../../public/footer.php");
    ?>
	<!-- footer结束 -->
	
	
	
	
	

    <script src="../../public/js/jquery-3.3.1.min.js"></script>
	<script src="../../public/js/bootstrap.min.js"></script>
	<script>
		$(function(){
			$('#myInfoEdit').on('show.bs.modal', function (event) {
				var btnThis = $(event.relatedTarget); //触发事件的按钮
				var modal = $(this);  //当前模态框
				var modalId = btnThis.data('id');   //解析出data-id的内容
				var userId = "<?php echo $_SESSION['user_id'];?>";
				//点击提交表单
				$("#submit").click(function(){
					var newUrl = 'userController.php?flag=user&src=u1&uuid=' + userId;    //设置新提交地址
					$("#myInfoEdit").attr('action',newUrl);    //通过jquery为action属性赋值
					$("#myInfoEdit").attr('method','post');    //通过jquery为action属性赋值
					$("#myInfoEdit").submit();    //提交ID为myform的表单
				});
				var username = "<?php echo $_SESSION['username'];?>";
				modal.find('#editUser').val(username);
				
				var realname = $("#realname").val();
				modal.find('#editRealname').val(realname);

				var email = $("#email").val();
				modal.find('#editEamil').val(email);
			});

			/*********************点击修改密码的事件********************/
			$("#pwdEdit").click(function() { 
				var newUrl = "userController.php?flag=user&src=u1&pwd";
				if (checkPassword() == true) {
					if (checkConfirmPassWord() == true) {
						$("#myPwdEdit").attr('action',newUrl);
						$("#myPwdEdit").submit();
					}
				}
			});
			//密码的相关验证
			function checkPassword() {
				//检测是否为空
				var pwd2 = $("#pwd2").val();
				if (pwd2.length == 0) {
					alert("输入密码，6-20位小写字母，数字或下划线");
					return false;
				}
				
				var pattern = /^[a-z0-9_]{6,20}$/;
				if (!pattern.test(pwd2)) {
					alert("输入密码，6-20位小写字母，数字或下划线");
					return false;
				} else {
					return true;
				}
			}
				
			//重复密码的相关验证
			function checkConfirmPassWord() {
				//检测是否为空
				var pwd3 = $("#pwd3").val();
				if (pwd3.length == 0) {
					alert("请输入确认密码");
					return false;
				}
				//判断值是否相同
				if (!(pwd3 == $("#pwd2").val())) {
					alert("两次输入的密码不一致，请重新输入");
					return false;
				} else {
					return true;
				}
			}
		});
	</script>
  </body>
</html>
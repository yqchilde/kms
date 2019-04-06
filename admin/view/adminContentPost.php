<?php require("../../public/verifyLogin.php");?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>网站后台管理</title>
		<link rel="stylesheet" href="../../public/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../public/css/main.css" />
		<link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
		<!-- 引入umeditor文件 -->
		<link rel="stylesheet" type="text/css" href="../../umeditor/themes/default/css/umeditor.css">
		<script src="../../public/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="../../umeditor/umeditor.config.js"></script>
		<script type="text/javascript" src="../../umeditor/umeditor.js"></script>
		<script type="text/javascript" src="../../umeditor/lang/zh-cn/zh-cn.js"></script>
	</head>
	<body>
		<!-- 顶部导航部分开始 -->
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="adminController.php?flag=admin" class="navbar-brand">YQAdmin</a>
				</div>
				<div class="navbar-collapse collapse" id="menu">
					<ul class="nav navbar-nav">
						<li><a href="adminController.php?flag=admin"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;后台首页</a></li>
						<li class="active"><a href="adminController.php?flag=admin&src=k1"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;知识管理</a></li>
						<li><a href="adminController.php?flag=admin&src=u1"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;用户管理</a></li>
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
								<li><a href="adminController.php?flag=admin&src=u1"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;用户管理</a></li>
							</ul>
						</li>
						<li><a href="adminController.php?flag=logout"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;退出</a></li>
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
						<a href="adminController.php?flag=admin&src=k1" class="list-group-item">知识管理</a>
						<a href="adminController.php?flag=admin&src=k2" class="list-group-item active">添加知识</a>
					</div>
				</div>
				<div class="col-md-10">
					<div class="page-header">
						<h1>知识管理</h1>
					</div>
					<ul class="nav nav-tabs">
						<li><a href="adminController.php?flag=admin&src=k1">知识管理</a></li>
						<li class="active"><a href="adminController.php?flag=admin&src=k2">添加知识</a></li>
					</ul>
					<form id="msgPost" method="post" class="page-main-post">
						<div class="form-group">
							<label for="type">知识类型</label>
							<select id="type" name="type" class="form-control">
								<option value="1">文章库</option>
								<option value="2">代码库</option>
								<option value="3">网址库</option>
								<option value="4">图片库</option>
								<option value="5">模板库</option>
							</select>
						</div>
						<div class="form-group">
							<label for="title">知识标题</label>
							<input type="text" id="title" name="title" class="form-control" placeholder="请输入文章标题" />
						</div>
						<div class="form-group">
							<label for="msg">知识内容</label>
							<script type="text/plain" id="myEditor" name="msg"></script>
						</div>
						<div class="form-group">
							<label for="file">上传附件</label>
							<input type="file" name="file">
						</div>
						<div class="form-group">
							<button id="submit" class="btn btn-info pull-right">发布</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- 主页面结束 -->
		<!-- footer开始 -->
		<?php
		include("../../public/footer.php");
		?>
		<!-- footer结束 -->


		<script type="text/javascript">
		    //实例化编辑器
		    var um = UM.getEditor('myEditor');
// 			function getContentTxt() {
// 			    var arr = [];
// 			    arr.push(UM.getEditor('myEditor').getContentTxt());
// 			    alert(arr.join("\n"));
// 			}
// 			
// 			var ue = UE.getEditor('myEditor', {
// 				textarea:'seed_descript',
// 			});
			$("#submit").click(function() { 
				var newUrl = "adminController.php?flag=admin&src=k2&post";
				$("#msgPost").attr('action',newUrl);
				$("#msgPost").submit();
			});
		</script>
		<script src="../../public/js/bootstrap.min.js"></script>
	</body>
</html>

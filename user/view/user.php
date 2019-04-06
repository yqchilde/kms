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
    			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
    			</button>
    			<a href="userController.php?flag=user" class="navbar-brand">知识管理系统</a>
    		</div>	
    		<div class="navbar-collapse collapse" id="menu">
    			<ul class="nav navbar-nav">
    				<li class="active"><a href="userController.php?flag=user"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;首页</a></li>
    				<li><a href="userController.php?flag=user&src=k1"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;知识管理</a></li>
					<li><a href="userController.php?flag=user&src=u1"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;个人中心</a></li>
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
    						<li><a href="userController.php?flag=user&src=u1"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;个人主页</a></li>
    					</ul>
    				</li>
    				<li><a href="userController.php?flag=logout"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;退出</a></li>
    			</ul>
    		</div>
    	</div>
    </nav>
	<!-- 顶部导航部分结束 -->
	<!-- 警告框开始 -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4>欢迎回来&nbsp;<?php echo $_SESSION["username"];?></h4>
					<p>当前版本为1.0版本</p>
					<p>
					<!-- <button type="button" class="btn btn-success">立刻修复</button>
					<button type="button" class="btn btn-default" data-dismiss="alert">不再提醒</button> -->
					</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
				<div class="panel-heading">
					最新知识
					<a href="#"><span class="glyphicon glyphicon-option-horizontal pull-right"></span></a>
				</div>
					<div class="list-group">
					<?php foreach($newInfo as $msg): ?>
						<li class="list-group-item">
							<a href="userController.php?flag=user&src=k3&view=<?php echo $msg['knowledge_id'] ?>">
								<span class="glyphicon glyphicon-list-alt"></span>
								&nbsp;&nbsp;<?php echo $msg['knowledge_title'] ?>
								<small class="pull-right"><?php echo date("Y-m-d",$msg['knowledge_date']) ?></small>
							</a>
						</li>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
				<div class="panel-heading">
					代码库
					<a href="#"><span class="glyphicon glyphicon-option-horizontal pull-right"></span></a>
				</div>
					<div class="list-group">
					<?php foreach($codeInfo as $msg): ?>
						<li class="list-group-item">
							<a href="userController.php?flag=user&src=k3&view=<?php echo $msg['knowledge_id'] ?>">
								<span class="glyphicon glyphicon-list-alt"></span>
								&nbsp;&nbsp;<?php echo $msg['knowledge_title'] ?>
								<small class="pull-right"><?php echo date("Y-m-d",$msg['knowledge_date']) ?></small>
							</a>
						</li>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
				<div class="panel-heading">
					网址库
					<a href="#"><span class="glyphicon glyphicon-option-horizontal pull-right"></span></a>
				</div>
					<div class="list-group">
					<?php foreach($webInfo as $msg): ?>
						<li class="list-group-item">
							<a href="userController.php?flag=user&src=k3&view=<?php echo $msg['knowledge_id'] ?>">
								<span class="glyphicon glyphicon-list-alt"></span>
								&nbsp;&nbsp;<?php echo $msg['knowledge_title'] ?>
								<small class="pull-right"><?php echo date("Y-m-d",$msg['knowledge_date']) ?></small>
							</a>
						</li>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
				<div class="panel-heading">
					图片库<a href="#"><span class="glyphicon glyphicon-option-horizontal pull-right"></span></a>
				</div>
					<div class="list-group">
					<?php foreach($imgInfo as $msg): ?>
						<li class="list-group-item">
							<a href="userController.php?flag=user&src=k3&view=<?php echo $msg['knowledge_id'] ?>">
								<span class="glyphicon glyphicon-list-alt"></span>
								&nbsp;&nbsp;<?php echo $msg['knowledge_title'] ?>
								<small class="pull-right"><?php echo date("Y-m-d",$msg['knowledge_date']) ?></small>
							</a>
						</li>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
				<div class="panel-heading">
					模板库
					<a href="#"><span class="glyphicon glyphicon-option-horizontal pull-right"></span></a>
				</div>
					<div class="list-group">
					<?php foreach($templateInfo as $msg): ?>
						<li class="list-group-item">
							<a href="userController.php?flag=user&src=k3&view=<?php echo $msg['knowledge_id'] ?>">
								<span class="glyphicon glyphicon-list-alt"></span>
								&nbsp;&nbsp;<?php echo $msg['knowledge_title'] ?>
								<small class="pull-right"><?php echo date("Y-m-d",$msg['knowledge_date']) ?></small>
							</a>
						</li>
					<?php endforeach; ?>
					</div>
				</div>
			</div>
			<!-- 这里是内容分界线 -->
		</div>
	</div>
	<!-- 警告框结束 -->
	
	<!-- footer开始 -->
    <?php
    include("../../public/footer.php");
    ?>
	<!-- footer结束 -->
	
	
	
	
	
	
	

    <script src="../../public/js/jquery-3.3.1.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
  </body>
</html>
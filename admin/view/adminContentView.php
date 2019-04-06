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
	<style>
		body{
			background-color: #ebebeb;
		}
	</style>
</head>
<body>
	<!-- 顶部导航部分开始 -->
	<nav class="navbar navbar-default" style="background-color: #fff;">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>	
			<div class="navbar-collapse collapse" id="menu">
				<ul class="nav navbar-nav">
    				<li style="font-weight: bold"><a href="adminController.php?flag=admin&src=k1"><i class="fa fa-hand-o-left" style="font-size:24px;"></i>&nbsp;返回知识列表</a></li>
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
	<div class="main-content">
		<div class="container">
			<div class="row">
				<?php foreach($msgInfo as $msg): ?>
				<main class="col-md-8">
					<article>
						<div class="content-block" style="min-height: 620px">
							<!-- author -->
							<div class="text-center">
								<h3><a href="#" class="label-a"><?php echo $msg['knowledge_title'] ?></a></h3><br />
								<p class="author">作者：<a href="#"><?php echo $msg['user_id'] ?></a><span>&nbsp;&bull;<?php echo date("Y-m-d", $msg['knowledge_date']) ?></span></p>
							</div>
							<!-- msg-content -->
							<div class="content-msg" style="margin-top: 20px">
								<?php echo $msg['knowledge_msg'] ?>
							</div>
							<?php
							if ($msg['knowledge_filename'] != null) {
								echo "
									<div class='content-download'>
										<a href='adminController.php?flag=admin&src=k3&filename={$msg['knowledge_filename']}' class='btn btn-default red-button'>下载附件</a>
									</div>
								";
							}
							?>
						</div>
					</article>
				</main>
				<!-- aside -->
				<aside class="col-md-4 aside-widget">
					<div class="widget">
						<h4 class="title">详情</h4>
						<div class="content-community">
							<strong>作者: </strong>&nbsp;<?php echo $msg['user_id'] ?><hr>
							<strong>类型: </strong>&nbsp;
							<?php
							switch ($msg['type_id']) {
                                    case '1':
                                        echo "文章库";
                                        break;
                                    case '2':
                                        echo "代码库";
                                        break;
                                    case '3':
                                        echo "网址库";
                                        break;
                                    case '4':
                                        echo "图片库";
                                        break;
                                    case '5':
                                        echo "模板库";
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
							?>
						</div>
					</div>

					<div class="widget">
						<h4 class="title">文章审核</h4>
						<a href="adminController.php?flag=admin&src=k1&view=<?php echo $_GET["view"] ?>" onclick="return confirm('确定审核通过吗?');" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;通过</a> 
						<a href="" data-toggle="modal" data-target="#returnCause" class="btn btn-danger pull-right"><i class="fa fa-remove"></i>&nbsp;不通过</a> 
					</div>
				</aside>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<!-- 审核文章模态框开始 -->
    <form action="adminController.php?flag=admin&src=k1&delete=<?php echo $_GET["view"] ?>" method="post">
		<div class="modal fade" id="returnCause" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">审核返回</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="censor">审核理由</label>
							<textarea name="censor" id="censor" cols="30" rows="10" class="form-control" placeholder="请详细说明审核原因,不超过50个字!"></textarea>
                        </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-primary">确定</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- 审核文章模态框结束 -->
	<!-- 主页面结束 -->
	<!-- footer开始 -->
	<?php
	include("../../public/footer.php");
	?>
	<!-- footer结束 -->
	
	
	
	
	

    <script src="../../public/js/jquery-3.3.1.min.js"></script>
    <script src="../../public/js/bootstrap.min.js"></script>
  </body>
</html>
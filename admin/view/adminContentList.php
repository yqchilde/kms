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
					<a href="adminController.php?flag=admin&src=k1" class="list-group-item active">知识管理</a>
					<a href="adminController.php?flag=admin&src=k2" class="list-group-item">添加知识</a>
				</div>
			</div>
			<div class="col-md-10">
				<div class="page-header"><h1>知识管理</h1></div>
				<ul class="nav nav-tabs">
					<li class="active"><a href="adminController.php?flag=admin&src=k1">知识管理</a></li>
					<li><a href="adminController.php?flag=admin&src=k2">添加知识</a></li>
				</ul>
				<div class="tablebox">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>文章类型</th>
								<th>文章标题</th>
								<th>作者</th>
								<th>发布时间</th>
								<th>发布状态</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($msgInfo as $msg): ?>
							<tr onclick="view(<?php echo $msg['knowledge_id'] ?>)">
								<td>
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
								</td>
								<td><?php echo $msg['knowledge_title'] ?></td>
								<td><?php echo $msg['user_id'] ?></td>
								<td><?php echo date("Y-m-d H:i:s", $msg['knowledge_date'])?></td>
								<td>
									<?php
									switch ($msg['state']) {
										case '0':
											echo "<strong style=color:#d9534f>未通过</strong>";
											break;
										case '1':
											echo "<strong style=color:#5cb85c>已发布</strong>";
											break;
										case '2':
											echo "<strong style=color:#f0ad4e>待审核</strong>";
											break;
										default:
											# code...
											break;
									}
									?>
								</td>
								<td>
									<a href="adminController.php?flag=admin&src=k3&view=<?php echo $msg['knowledge_id'] ?>" 
									class="btn btn-warning btn-operate"><i class="fa fa-eye"></i>&nbsp;预览</a>
									<a href="adminController.php?flag=admin&src=k1&edit=<?php echo $msg['knowledge_id'] ?>" 
									class="btn btn-info btn-operate"><i class="fa fa-pencil"></i>&nbsp;编辑</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- 分页开始 -->
				<nav aria-label="Page navigation" class="pull-right navigation";">
					<ul class="pagination">
						<li>
							<a href="<?php echo $page->gotoUrl . '&pageId=1' ?>" aria-label="Previous">
								<span>首页</span>
							</a>
						</li>
						<li><a href="<?php echo $page->gotoUrl . '&pageId=' . $page->prePage; ?>">上一页</a></li>
						<?php for ($pageid=1; $pageid <= $page->pageCount ; $pageid++) { 
							echo "<li><a href=\"{$page->gotoUrl}&pageId={$pageid}\">$pageid</a></li>";
						}?>
						<li><a href="<?php echo $page->gotoUrl . '&pageId=' . $page->nextPage ?>">下一页</a></li>
						<li>
						<a href="<?php echo $page->gotoUrl . '&pageId=' . $page->pageCount ?>" aria-label="Next">
							<span>尾页</span>
						</a>
						</li>
					</ul>
				</nav>
				<!-- 分页结束 -->
			</div>
		</div>
	</div>
	<!-- 主页面结束 -->
	<!-- footer开始 -->
	<?php
	include("../../public/footer.php");
	?>
	<!-- footer结束 -->
	
	
	
	
	

    <script src="../../public/js/jquery-3.3.1.min.js"></script>
	<script src="../../public/js/bootstrap.min.js"></script>
	<script>
		function view(id) {
			location.href = "adminController.php?flag=admin&src=k3&view="+id;
		}
	</script>
  </body>
</html>
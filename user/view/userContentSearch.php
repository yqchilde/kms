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
					<li class="active"><a href="userController.php?flag=user&src=k1"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;知识管理</a></li>
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
	<!-- 主页面开始 -->
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<div class="list-group">
					<a href="userController.php?flag=user&src=k1" class="list-group-item active">知识管理</a>
					<a href="userController.php?flag=user&src=k2" class="list-group-item">添加知识</a>
					<a href="" class="list-group-item" data-toggle="modal" data-target="#msgSearch">搜索知识</a>
				</div>
			</div>
			<div class="col-md-10">
				<div class="page-header"><h1>知识管理</h1></div>
				<ul class="nav nav-tabs">
					<li class="active"><a href="userController.php?flag=user&src=k1">知识管理</a></li>
					<li><a href="userController.php?flag=user&src=k2">添加知识</a></li>
					<li><a href="" data-toggle="modal" data-target="#msgSearch">搜索知识</a></li>
				</ul>
				<div class="tablebox">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>知识类型</th>
								<th>知识标题</th>
								<th>作者</th>
								<th>发布时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($msgInfo as $msg): ?>
							<tr onclick="view(<?php echo $msg['knowledge_id'] ?>)">
								<th>
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
								</th>
								<td><?php echo $msg['knowledge_title']; ?></td>
								<td><?php echo $msg['user_id'];?></td>
								<td>
									<?php 
									if ($msg['knowledge_date'] != null) {
										echo date('Y-m-d H:i:s',$msg['knowledge_date']);
									}
									?>
								</td>
								<td>
									<a href="" class="btn btn-info btn-operate">查看</a>
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
				<!-- 分页开始 -->
				<nav aria-label="Page navigation" class="pull-right";">
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
    <!-- 搜索知识模态框开始 -->
    <form action="userController.php">
	<input type="hidden" name="flag" value="user">
	<input type="hidden" name="src" value="k1">
		<div class="modal fade" id="msgSearch" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">搜索知识</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="searchTitle">知识关键词</label>
							<input type="text" id="searchTitle" name="wd" class="form-control" placeholder="支持模糊搜索"/>
                        </div>
                        <div class="form-group">
							<label for="searchGroup">知识类型</label>
							<select id="searchGroup" name="id" class="form-control">
								<option value="0">不限</option>
								<option value="1">文章库</option>
								<option value="2">代码库</option>
								<option value="3">网址库</option>
								<option value="4">图片库</option>
								<option value="5">模板库</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						<button type="submit" class="btn btn-primary">搜索</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- 搜索知识模态框结束 -->
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
			location.href = "userController.php?flag=user&src=k3&view="+id;
		}
	</script>
  </body>
</html>
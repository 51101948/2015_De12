<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	<link rel="shortcut icon" href="http://ibin.co/1xpodWkLcyA9" type="image/x-icon">
	<title>MyCloudsMng</title>
	<!-- Latest compiled and minified CSS -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<?php echo HTML::style('css/bootstrap.min.css'); ?>
	<!-- Optional theme -->
	<?php echo HTML::style('css/bootstrap-theme.min.css'); ?>
	<?php echo HTML::style('css/style.css'); ?>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	
</head>
<body>
	<div class="pagesite">
		<div class="container-fluid">
			<div class="header">
				<div class="logo">
					<img id="myLogo" src="http://ibin.co/1xpodWkLcyA9">
					<div id="slogan">
						<blockquote>Drop Everything</blockquote>
						<blockquote>Keep Everything, Share Everything</blockquote>
					</div>
				</div>
			</div>
			<div class="menu">
				<nav class="navbar navbar-default">
					  <div class="container-fluid" id="navi">
					    <!-- Brand and toggle get grouped for better mobile display -->
					    <div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					      <a class="navbar-brand" href="/">GDManager</a>
					    </div>

					    <!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					      <ul class="nav navbar-nav">			        
					        <li class="dropdown">
					          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Manage<span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="#">Dropbox</a></li>
					            <li class="divider"></li>
					            <li><a href="#">Google Drive</a></li>
					          </ul>
					        </li>
					        <li><a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
					      </ul>
					      <form class="navbar-form navbar-left" role="search">
					        <div class="form-group">
					          <input type="text" class="form-control" placeholder="Search">
					        </div>
					        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					      </form>
					      <ul class="nav navbar-nav navbar-right">
					        <li><a href="#">Profile</a></li>					   
					        <li><a href="/logout">Sign out</a></li>
					        
					        
					      </ul>
					    </div><!-- /.navbar-collapse -->
					  </div><!-- /.container-fluid -->
					</nav>
			</div>
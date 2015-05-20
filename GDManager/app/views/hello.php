<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Google Dropbox MNG</title>
	<!-- Latest compiled and minified CSS -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.pagesite {
			background-image: url("http://www.freevector.com/site_media/preview_images/FreeVector-Diamond-Blur-Background-Image.jpg");
			background-size: 100% 100%;
		}
		.logo {
			text-align: left;
			padding: 20px;
		}
		#myLogo {
			width: 150px;
			height: 80px;
			float: left;
		}
		#slogan {
			margin-left: 20px;
			display: inline-block;
			width: 500px;
			height: 100px;
			clear: both;
		}
		#navi {
			background-color: #4386fc;
			color: white;
		}
		a {
			text-decoration-color: black; 
		}
		.navbar-brand {
			color: black;
		}
		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
		.pagesite, .container, .menu, .content, .section, .gManager, .dManager, .preview {
			border: solid 1px;	x
		}
		.content {
			width: 100%;
		}
		.section {
			width: 29%;
			display: inline-block;
		}
		.gManager, .dManager {
			height: 200px;
			-webkit-filter: blur(5px);
			-moz-filter: blur(5px);
			-o-filter: blur(5px);
			-ms-filter: blur(5px);
			filter: blur(5px);
		}
		.gManager {
			background-image: url("http://www.blogcdn.com/www.engadget.com/media/2013/03/google-drive-masthead-620.jpg");
			background-size: 100% 100%; 
		}
		.dManager {
			background-image: url("http://www.maximumpc.com/files/u160391/dropbox.png");
			background-size: 100% 100%; 
		}
		.preview {
			width: 69%;
			display: inline-block;
		}
		.footer {
			height: 50px;
			background-color: #333333;
		}
	</style>
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
					      <a class="navbar-brand" href="#">GDManager</a>
					    </div>

					    <!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					      <ul class="nav navbar-nav">
					        <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
					        <li class="dropdown">
					          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Manage<span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="#">Dropbox</a></li>
					            <li class="divider"></li>
					            <li><a href="#">Google Drive</a></li>
					          </ul>
					        </li>
					      </ul>
					      <form class="navbar-form navbar-left" role="search">
					        <div class="form-group">
					          <input type="text" class="form-control" placeholder="Search">
					        </div>
					        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					      </form>
					      <ul class="nav navbar-nav navbar-right">
					        <li><a href="#">Profile</a></li>
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Option<span class="caret"></span></a>
					          <ul class="dropdown-menu" role="menu">
					            <li><a href="#">Profile</a></li>
					            <li><a href="#">Sharing</a></li>
					            <li><a href="#">Setting</a></li>
					            <li class="divider"></li>
					            <li><a href="#">Logout</a></li>
					          </ul>
					        </li>
					      </ul>
					    </div><!-- /.navbar-collapse -->
					  </div><!-- /.container-fluid -->
					</nav>
			</div>
			<div class="content">
				<div class="section">
					<div class="gManager">						
					</div>
					<div class="dManager">
					</div>					
				</div>
				<div class="preview">
						<iframe src="http://docs.google.com/gview?url=http://example.com/mypdf.pdf&embedded=true" style="width:718px; height:700px;" frameborder="0"></iframe>
				</div>
			</div>
			<div class="footer">
				<p>Team Infomation</p>
			</div>
		</div>
	</div>
</body>
</html>

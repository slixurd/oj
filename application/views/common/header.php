<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="zh-cn">
<head>
		<title><?php if(isset($page_title)) echo $page_title ?></title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
		<meta name="description" content=""/>
		<meta name="author" content="slixurd"/>
		<link rel="stylesheet" type="text/css" href="/scutoj/assets/css/scut2.css">
		<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<script src="/scutoj/assets/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="/scutoj/assets/js/main.js"></script>
</head>
<body>
<div class="header">
	<div class="container">
		<div id="log-reg">
			<div>
				<button id="login" href="">登录</button>
				<div class="login-popup">
					<form>
						<input placeholder="请输入登录邮箱" />
						<input type="password" placeholder="请输入密码"/>
						<button type="submit">确认</button>
						<div>
							<span class="remember-pass"><input type="checkbox" name="remember"/>记住密码</span>
							<span class="forget-pass"><a href="">忘记密码?</a></span>
						</div>	
					</form>

				</div>
			</div>
			<div style="font-size:20px;">|</div>
			<div><a href="">注册</a></div>
		</div>
		<ul class="main-nav">
			<li><a href="">主页</a></li>
			
			<li>
				<a href="">
					<span>题集</span>
					<img src="/scutoj/assets/img/list_button.png">
				</a>
				<ul class="sub-nav">
					<li><a href="">课程</a></li>
					<li><a href="">比赛</a></li>
					<li><a href="">全部</a></li>
				</ul>
			</li>
			
			<li>
				<a href="">
					<span>课程</span>
					<img src="/scutoj/assets/img/list_button.png">
				</a>
				<ul class="sub-nav">
					<li><a href="">课程</a></li>
					<li><a href="">比赛</a></li>
					<li><a href="">全部</a></li>
				</ul>
			</li>
			<li><a href="">帮助</a></li>
		</ul>
	</div>
</div>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="zh-cn">
<head>
		<title><?php if(isset($page_title)) echo $page_title ?></title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
		<meta name="description" content=""/>
		<meta name="author" content="slixurd"/>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets") ?>/css/scut2.css">
		<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<script src="<?php echo base_url("assets") ?>/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url("assets") ?>/js/main.js"></script>
		<script type="text/javascript" src="<?php echo base_url("assets") ?>/js/bootstrap.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".login-popup #login-submit").on("click",function(){
					$.post("<?php echo site_url("login") ?>",
						{"username":$(".login-popup input[name='username']").val(),
						"pa":$(".login-popup input[name='pa']").val(),
						"remember":$(".login-popup input[name='remember']").val()},
						function(data){

							data=$.parseJSON(data);
							//-1用户被冻结，0密码用户名不匹配，1登录成功，2用户已经登录，3长度不符合
							if(data.result==0){
								$(".login-popup input[name='pa']").attr('data-original-title',"密码或用户名错误").tooltip("show");
							}else if(data.result==-1){
								$(".login-popup input[name='username']").attr('data-original-title',"您的登录次数过多").tooltip("show");
							}else if(data.result==2){
								$(".login-popup input[name='username']").attr('data-original-title',"您已经登录").tooltip("show");
							}else if(data.result==3){
								$(".login-popup input[name='pa']").attr('data-original-title',"用户名/密码长度不符").tooltip("show");
							}else if(data.result==1){
								window.location.reload();
							}
					});
				});

				var base="<?php echo site_url("") ?>";

			//表格的超链接
				$("#problem-list tbody tr").on("click",function(){
					window.location.href = '<?php echo site_url("problem/get_problem") ?>/'+$(this).find("td:first-child").text();
				});
			//表格的超链接
				$("#contest-list tbody tr").on("click",function(){
					window.location.href = '<?php echo site_url("contest/get_contest") ?>/'+$(this).find("td:first-child").text();
				});
			//页面高度
				//54 for header's outerHeight,58for footer's .the 40 is margin of wrapper.
				if(54+58+40+$(".wrapper").height()+$(".footer").height()<document.body.clientHeight){
					$(".wrapper").css({height:document.body.clientHeight-54-$(".wrapper").height()-58-40+parseFloat($(".wrapper").css("height"))+"px"});
				}

			});
		</script>
		<!--[if gte IE 6]>

		<script type="text/javascript">
			//===================================
			//==========placeholer-fix===========
			//===================================
			var fillPlaceholder = function(element) {
			    var placeholder = '';
			    if (element && !("placeholder" in document.createElement("input")) && (placeholder = element.getAttribute("placeholder"))) {
			        element.onfocus = function() {
			            if (this.value === placeholder) {
			                this.value = "";
			            }
			            this.style.color = '';
			        };
			        element.onblur = function() {
			            if (this.value === "") {
			                this.value = placeholder;
			                this.style.color = 'graytext';    
			            }
			        };
			        
			        //样式初始化
			        if (element.value === "") {
			            element.value = placeholder;
			            element.style.color = 'graytext';    
			        }
			    }
			};
			fillPlaceholder(document.getElementById("log-name"));
			fillPlaceholder(document.getElementById("log-pass"));	
		</script>
		<![endif]-->
</head>
<body>
<div class="header">
	<div class="container" style="height:54px;">

		<div class="i-c">
		<ul class="main-nav clearfix">
			<span style="float:left;margin-top: 8px;display:inline-block;width:66px;"><img src="<?php echo base_url("assets") ?>/img/logo.png"></span>
			<li class='<?php if(preg_match("/\/$|index\.php\/?$|scutoj\/$/",$_SERVER["REQUEST_URI"])) echo "active"; ?> slide' ><a href="<?php echo site_url("/"); ?>">主页</a></li>
			
			<li class='<?php if(preg_match("/contest|problem/",uri_string())) echo "active" ?> slide' >
				<a href="<?php echo site_url("problem"); ?>">
					<span>题集</span>
					<img src="<?php echo base_url("assets") ?>/img/list_button.png">
				</a>
				<ul class="sub-nav">
					<li><a href="<?php echo site_url("problem"); ?>">题目</a></li>
					<li><a href="<?php echo site_url("contest"); ?>">比赛</a></li>
					<li><a href="">全部</a></li>
				</ul>
			</li>
			
			<li class='<?php if(preg_match("/class/",uri_string())) echo "active" ?> slide'>
				<a href="">
					<span>课程</span>
					<img src="<?php echo base_url("assets") ?>/img/list_button.png">
				</a>
				<ul class="sub-nav">
					<li><a href="">课程</a></li>
					<li><a href="">比赛</a></li>
					<li><a href="">全部</a></li>
				</ul>
			</li>
			<li class='<?php if(preg_match("/help/",uri_string())) echo "active" ?> slide'><a href="">帮助</a></li>
		</ul>
		<hr class="i-b">
		</div>
		<div id="log-reg">
			<?php if(!isset($is_login)||$is_login==FALSE) {
				echo '
				<div>
					<button id="login" href="" style="margin-right:15px;">登录</button>
					<div class="login-popup">
						<div>
							<input id="log-name" name="username" placeholder="请输入登录账户" data-placement="bottom" data-toggle="tooltip" data-trigger="manual"/>
							<input id="log-pass" name="pa" type="password" placeholder="请输入密码" data-placement="top" data-toggle="tooltip" data-trigger="manual"/>
							<button id="login-submit" type="submit">确认</button>
							<div>
								<span class="remember-pass"><input type="checkbox" name="remember"/>记住密码</span>
								<span class="forget-pass"><a href="">忘记密码?</a></span>
							</div>	
						</div>

					</div>
				</div>
				<div><a href="'.site_url("user/register").'">注册</a></div>';

	//heredoc,需要置顶标注符

				}else if(isset($is_login) && $is_login==TRUE){
					echo $user["name"];
					echo '<div><a href='.site_url("logout").'>登出</a></div>';
				}
			?>
		</div>
	</div>
</div>
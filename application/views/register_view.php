<?php echo validation_errors(); ?>

<div class="wrapper">
	<div class="container">
		<div class="sub-header">
			<h3>注册</h3>
		</div>
		<div class="reg-indicator">
			<span>这里是注册提示啊提示.这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示</span>
		</div>
		<form class="register" method="post" action="<?php echo site_url("user/register_submit"); ?>">
			<!-- div>
				<span>ID</span>
				<input name="id"/>
			</div -->
			<div>
				<span>昵称</span>
				<input name="username"/>
			</div>
			<div>
				<span>密码</span>
				<input name="pa" type="password"/>
			</div>
			<div>
				<span>确认密码</span>
				<input name="paconf" type="password"/>
			</div>
			<div>
				<span>邮箱</span>
				<input name="email" type="email"/>
			</div>
			<div>
				<span>学校</span>
				<input />
			</div>
			<div>
				<span></span>
				<button type="submit" class="common-button">提交注册</button>
			</div>
		</form>

	</div>
</div>
